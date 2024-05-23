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
        $selectedEquipment = $_POST['selectedEquipmentBorrow'];
        $studentName = $_POST['studentName'];
        $studentId = $_POST['studentId'];
        $expectedReturn = $_POST['expectedReturn'];
        $Department = $_POST['Department'];

        $request = borrowEquipments($selectedEquipment, $studentName, $studentId, $expectedReturn, $Department);

        if ($request == true) {
            header("location: equipments?note=borrow");
        } else {
            header("location: equipments?note=error");
        }
    }

    //--------------------BORROW PHP----------------------//


    if ($form == "returnData") {
        $returnId = $_POST["selectedid"];
        $studentName = $_POST["studentName"];
        $studentId = $_POST["studentId"];
        $dateBorrow = $_POST["dateBorrow"];
        $expReturn = $_POST["expReturn"];
        $selectedEquipment = $_POST['selectedEquipmentReturn'];
    
        if (!empty($selectedEquipment)) {
            $selectedEquipment = json_decode($selectedEquipment, true);
    
            $conn = dbConnection();
            $conn->beginTransaction();
    
            try {
                $formattedEquipment = [];
    
                $statement = $conn->prepare("SELECT smi_borrowed_id, smi_borrowed_equipmentName FROM smi_borrowed_tbl WHERE smi_borrowed_id = :returnId");
                $statement->bindParam(':returnId', $returnId, PDO::PARAM_INT);
                $statement->execute();
    
                while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $borrowedId = $result['smi_borrowed_id'];
                    $equipmentName = $result['smi_borrowed_equipmentName'];
                    //echo $equipmentName . "<br>";
                    $myBorrow = explode("\n", $equipmentName);
    
                    foreach ($myBorrow as $myBorrows) {
                        list($equipe, $qty) = array_map('trim', explode('-', $myBorrows));
                        $qty = (int) $qty;
    
                        //echo $equipe . " - " . $qty . "<br>";
    
                        $deducted = false;
    
                        foreach ($selectedEquipment as $equipment) {
                            list($inequipmentName, $stock) = array_map('trim', explode('|', $equipment['option']));
                            $inquantity = (int) $equipment['quantity'];
                            $condition = $equipment['radioValue'];
    
                            $inputEquipmentName = $inequipmentName;
                            $inputQuantity = $inquantity;
    
                            if ($equipe === $inputEquipmentName) {
                                $newquantity = max(0, $qty - $inputQuantity);

                                $formattedEquipment[] = "$inputEquipmentName - $newquantity";
    
                                $stmt = $conn->prepare("INSERT INTO smi_return_tbl (smi_return_equipment, smi_return_qty, smi_return_borrower, smi_return_studentId, smi_return_condition, smi_return_dateBorrow, smi_return_dateReturn) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                                $stmt->execute([$equipe, $inputQuantity, $studentName, $studentId, $condition, $dateBorrow]);
    
                                if ($stmt) {
                                    $deducted = true;
                                } else {
                                    echo 'false';
                                    $conn->rollBack(); 
                                }
                            }
                        }
    
                        if (!$deducted) {
                            $formattedEquipment[] = "$equipe - $qty";
                        }
                    }
                }
    
                $conn->commit();
    
                try {
                    $formattedEquipmentString = implode(PHP_EOL, $formattedEquipment);
    
                    $updateStatement = $conn->prepare("UPDATE smi_borrowed_tbl SET smi_borrowed_equipmentName = :equipmentName WHERE smi_borrowed_id = :returnId");
                    $updateStatement->execute([
                        'equipmentName' => $formattedEquipmentString,
                        'returnId' => $returnId,
                    ]);
    
                    if ($updateStatement) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (\PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } catch (\Throwable $th) {
                $conn->rollBack();
            }
        }
    }
    



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