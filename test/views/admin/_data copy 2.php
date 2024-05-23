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
        $selectedEquipment = $_POST['selectedEquipmentReturn'];

        if (!empty($selectedEquipment)) {
            $selectedEquipment = json_decode($selectedEquipment, true);

            $conn = dbConnection();
            $conn->beginTransaction();

            try {
                // Initialize an array to store formatted equipment data
                $formattedEquipment = [];

                // Use a prepared statement with a placeholder for :returnId
                $statement = $conn->prepare("SELECT smi_borrowed_id, smi_borrowed_equipmentName FROM smi_borrowed_tbl WHERE smi_borrowed_id = :returnId");
                $statement->bindParam(':returnId', $returnId, PDO::PARAM_INT);
                $statement->execute();

                // Fetch all results as an associative array
                while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $borrowedId = $result['smi_borrowed_id'];
                    $equipmentName = $result['smi_borrowed_equipmentName'];
                    echo $equipmentName . "<br>";
                    $myBorrow = explode("\n", $equipmentName);

                    foreach ($myBorrow as $myBorrows) {
                        list($equipe, $qty) = array_map('trim', explode('-', $myBorrows));
                        $qty = (int) $qty;

                        echo $equipe . " - " . $qty . "<br>";

                        $deducted = false;

                        // Input values
                        foreach ($selectedEquipment as $equipment) {
                            list($inequipmentName, $stock) = array_map('trim', explode('|', $equipment['option']));
                            $inquantity = (int) $equipment['quantity'];
                            $condition = $equipment['radioValue'];

                            $inputEquipmentName = $inequipmentName;
                            $inputQuantity = $inquantity;

                            // Deduct quantity only for specified items
                            if ($equipe === $inputEquipmentName) {
                                $newquantity = max(0, $qty - $inputQuantity); // Ensure quantity doesn't go negative

                                // Store formatted equipment data
                                $formattedEquipment[] = "$inputEquipmentName - $newquantity";
                                $deducted = true;
                            }
                        }

                        if (!$deducted) {
                            // If not deducted, preserve the original quantity
                            $formattedEquipment[] = "$equipe - $qty";
                        }
                    }
                }

                // Insert formatted equipment data into the database (move this outside the loop)
                try {
                    $formattedEquipmentString = implode(PHP_EOL, $formattedEquipment);

                    $statement = dbConnection()->prepare("UPDATE 
                                                            smi_borrowed_tbl
                                                            SET  
                                                            smi_borrowed_equipmentName = :equipmentName
                                                            WHERE
                                                            smi_borrowed_id = :returnId
                                                            ");

                    $statement->execute([
                        'equipmentName' => $formattedEquipmentString,
                        'returnId' => $returnId,
                    ]);

                    if ($statement) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (\PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                // Commit the transaction

            } catch (\Throwable $th) {
                // Rollback the transaction in case of an exception
                $conn->rollBack();
                // Handle exceptions
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