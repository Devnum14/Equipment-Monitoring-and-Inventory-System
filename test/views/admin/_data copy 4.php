<?php

require '_function.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    header('Location: 404.php');
    exit;
}

//--------------------EQUIPMENT PHP----------------------//


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form = $_POST['form'];

    if ($form == 'insertData') {

        $equipmentName = $_POST['equipmentName'];
        $equipmentStock = $_POST['equipmentStock'];

        $request = createEquipments($equipmentName, $equipmentStock);

        if ($request == true) {
            header("location: equipments?note=added");
        } else {
            header("location: equipments?note=error");
        }

    }

    if ($form == 'deleteData') {

        $selectedEquipment = $_POST['selectedEquipmentDelete'];
        $deleteReason = $_POST['deleteReason'];

        $request = deleteEquipments($selectedEquipment, $deleteReason);

        if ($request == true) {
            header("location: equipments?note=delete");
        } else {
            header("location: equipments?note=error");
        }

    }

    if ($form == "updateData") {

        $selectedEquipment = $_POST['selectedEquipmentEdit'];

        $request = updateEquipments($selectedEquipment);

        if ($request == true) {
            header("location: equipments?note=update");
        } else {
            header("location: equipments?note=error");
        }

    }


    if ($form == 'borrowData') {
        $transvalue = $_POST['transvalue'];
        $selectedEquipment = $_POST['selectedEquipmentBorrow'];
        $studentName = $_POST['studentName'];
        $studentId = $_POST['studentId'];
        $expectedReturn = $_POST['expectedReturn'];
        $Department = $_POST['Department'];


        if (!empty($selectedEquipment) && !empty($studentName) && !empty($studentId) && !empty($expectedReturn)) {
            $selectedEquipment = json_decode($selectedEquipment, true);

            $conn = dbConnection();
            $conn->beginTransaction();

            echo $transvalue;



            try {

                $formattedEquipment = [];

                foreach ($selectedEquipment as $equipment) {
                    list($equipmentName, $stock) = explode('|', $equipment['option']);
                    $quantity = (int) $equipment['quantity'];

                    $formattedEquipment[] = "$equipmentName - $quantity";



                    $stmt = $conn->prepare("UPDATE smi_equipment_tbl SET equipment_stock = equipment_stock - ?, equipment_borrowed = equipment_borrowed + ? WHERE equipment_name = ?");
                    $stmt->execute([$quantity, $quantity, $equipmentName]);
                    $stmt = null;

                    $expectedReturn = date('Y-m-d 23:59:59', strtotime($expectedReturn));

                    echo $equipmentName;

                    if ($Department === '') {
                        $stmt = $conn->prepare("INSERT INTO smi_borrowed_tbl (smi_borrowed_transid, smi_borrowed_equipmentName, smi_borrowed_qty, smi_borrowed_studentName, smi_borrowed_studentId, smi_borrowed_department, smi_borrowed_dateBorrow, smi_borrowed_expReturn) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
                        $stmt->execute([$transvalue, $equipmentName, $quantity, $studentName, $studentId, 'None', $expectedReturn,]);
                    } else {
                        $stmt = $conn->prepare("INSERT INTO smi_borrowed_tbl (smi_borrowed_transid, smi_borrowed_equipmentName, smi_borrowed_qty, smi_borrowed_studentName, smi_borrowed_studentId, smi_borrowed_department, smi_borrowed_dateBorrow, smi_borrowed_expReturn) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
                        $stmt->execute([$transvalue, $equipmentName, $quantity, $studentName, $studentId, $Department, $expectedReturn,]);
                    }


                }

                $conn->commit();

                return true;
            } catch (Exception $e) {
                $conn->rollback();
                echo "Error: " . $e->getMessage();
                return false;
            }
        } else {
            echo "No options selected.";
            return false;
        }
    }


    //--------------------BORROW PHP----------------------//

    if ($form == "returnData") {
        $studentName = $_POST["studentName"];
        $studentId = $_POST["studentId"];
        $transid = $_POST["transid"];
        $dateBorrow = $_POST["dateBorrow"];
        $expReturn = $_POST["expReturn"];
        $selectedEquipment = $_POST['selectedEquipmentReturn'];

        if (!empty($selectedEquipment)) {
            $selectedEquipment = json_decode($selectedEquipment, true);

            $conn = dbConnection();
            $conn->beginTransaction();

            try {
                $formattedEquipment = [];

                $statement = $conn->prepare("SELECT smi_borrowed_equipmentName, smi_borrowed_qty FROM smi_borrowed_tbl WHERE smi_borrowed_transid = :transid");
                $statement->bindParam(':transid', $transid);
                $statement->execute();

                while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $dbEquipment = $result['smi_borrowed_equipmentName'];
                    $qty = $result['smi_borrowed_qty'];

                    echo $dbEquipment . ' ';
                    echo $qty . '<br>';

                    $deducted = false;

                    foreach ($selectedEquipment as $selected) {
                        $equipmentName = $selected['option'];
                        $inputQuantity = (int) $selected['quantity'];
                        $condition = $selected['radioValue'];

                        echo $equipmentName . ' ';
                        echo $inputQuantity . ' ';
                        echo $condition . '<br>';

                        if ($dbEquipment === $equipmentName) {
                            $newQuantity = max(0, $qty - $inputQuantity);


                            $stmt1 = $conn->prepare("UPDATE smi_equipment_tbl SET equipment_stock = equipment_stock + ?, equipment_borrowed = equipment_borrowed - ? WHERE equipment_name = ?");
                            $stmt1->execute([$inputQuantity, $inputQuantity, $equipmentName]);

                            $stmt1 = $conn->prepare("UPDATE smi_borrowed_tbl SET smi_borrowed_qty = smi_borrowed_qty - ? WHERE smi_borrowed_equipmentName = ? AND smi_borrowed_transid = ?");
                            $stmt1->execute([$inputQuantity, $equipmentName, $transid]);


                            $stmt = $conn->prepare("INSERT INTO smi_return_tbl (smi_return_equipment, smi_return_qty, smi_return_borrower, smi_return_studentId, smi_return_condition, smi_return_dateBorrow, smi_return_dateReturn) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                            $stmt->execute([$dbEquipment, $inputQuantity, $studentName, $studentId, $condition, $dateBorrow]);
                        }
                    }
                }

                $conn->commit();  // Commit the transaction if everything is successful

            } catch (\Throwable $th) {
                $conn->rollBack();
                // Handle the exception, e.g., log the error or provide an error message
                echo "Error: " . $th->getMessage();
            }
        }
    }  // Missing closing bracket for the if block




    if ($form == 'disposeData') {

        $disposeId = $_GET['dispose']; // Add this line
        $equipmentName = $_POST['equipmentName'];
        $equipmentQty = $_POST['equipmentQty'];
        $disposeReason = $_POST['disposeReason'];
        $studentName = $_POST['studentName'];
        $studentId = $_POST['studentId'];
        $exactQty = $_POST['exactQty'];

        if ($exactQty == $equipmentQty) {
            $request = disposeAllEquipments($disposeId, $equipmentName, $equipmentQty, $studentName, $studentId, $disposeReason);

            if ($request == true) {
                header("location: borrowed?note=dispose");
            } else {
                header("location: borrowed?note=error");
            }
        } else {
            $request = disposeEquipments($disposeId, $equipmentName, $equipmentQty, $studentName, $studentId, $disposeReason);

            if ($request == true) {
                header("location: borrowed?note=dispose");
            } else {
                header("location: borrowed?note=error");
            }
        }



    }

}

?>