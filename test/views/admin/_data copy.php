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

        $request = borrowEquipments($selectedEquipment, $studentName, $studentId, $expectedReturn);

        if ($request == true) {
            header("location: equipments?note=borrow");
        } else {
            header("location: equipments?note=error");
        }
    }

    //--------------------BORROW PHP----------------------//


    if ($form == "returnData") {

        if ($form == "returnData") {
            $returnId = $_POST["selectedid"];
            $selectedEquipment = $_POST['selectedEquipmentReturn'];
            $studentName = $_POST['studentId'];
            $studentId = $_POST['studentId'];
            $dateBorrow = $_POST['dateBorrow'];
            $expReturn = $_POST['expReturn'];

            if (!empty($selectedEquipment)) {
                $selectedEquipment = json_decode($selectedEquipment, true);

                $conn = dbConnection();
                $conn->beginTransaction();

                try {
                    $formattedEquipment = [];

                    foreach ($selectedEquipment as $equipment) {
                        list($equipmentName1, $stock) = explode('-', $equipment['option']);
                        $quantity1 = (int) $equipment['quantity'];

                        $formattedEquipment[] = "$equipmentName1 - $quantity1";


                        $statement = $conn->prepare("SELECT smi_borrowed_id, smi_borrowed_equipmentName FROM smi_borrowed_tbl WHERE smi_borrowed_id = $returnId");
                        $statement->execute();

                        // Fetch all results as an associative array
                        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $inputEquipmentName = $equipmentName1;

                        foreach ($results as &$result) {
                            $borrowedId = $result['smi_borrowed_id'];
                            $equipmentName = $result['smi_borrowed_equipmentName'];
                            $myBorrow = explode(PHP_EOL, $equipmentName);

                            // Iterate over selected equipment
                            foreach ($myBorrow as $myBorrows) {
                                list($equipe, $qty) = explode('-', $myBorrows);
                                $qty = (int) $qty;

                                // Input values
                                $inputEquipmentName = $equipmentName1;
                                $inputQuantity = $quantity1;

                                $newquantity = $qty - $inputQuantity;

                                // echo $inputEquipmentName."<br>";
                                echo $inputEquipmentName.":".$qty ."-".$inputQuantity." = " .$newquantity."<br>";
                                


                                // $newquantity = $qty - $inputQuantity;
                                
                                // echo $newquantity."<br>";


                                // Debugging: Print out values for inspection
                                // echo "Input Equipment: " . $inputEquipmentName . "<br>";
                                // echo "Input Quantity: " . $inputQuantity . "<br>";

                                // // Iterate over borrowed items
                                // foreach ($myBorrow as &$myBorrows) {
                                //     list($dbEquipmentName, $quantity) = explode(' - ', $myBorrows);

                                //     // Debugging: Print out values for inspection
                                //     echo "DB Equipment Name: " . $dbEquipmentName . '<br>';
                                //     echo "Input Equipment Name: " . $inputEquipmentName . '<br>';

                                //     if (trim($inputEquipmentName) === trim($dbEquipmentName)) {
                                //         $newquantity = $quantity - $inputQuantity;
                                //         echo "New Quantity: " . $newquantity . "<br>";

                                //         // Update myBorrows directly in the array
                                //         $myBorrows = $inputEquipmentName . " - " . $newquantity;
                                //         echo "Updated Equipment Name: " . $myBorrows . "<br>";
                                //     } else {
                                //         echo "false";
                                //     }
                                // }
                            }
                        }


                    }

                    $conn->commit();
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


        // $request = returnsEquipments($returnId, $selectedEquipment, $studentName, $studentId, $dateBorrow, $expReturn);

        // if ($request == true) {
        //     header("location: borrowed?note=return");
        // } else {
        //     header("location: borrowed?note=error");
        // }

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








foreach ($selectedEquipment as $equipment) {
    $iterationCount++;

    $test = list($equipmentName1, $stock) = explode('-', $equipment['option']);
    $quantity1 = (int) $equipment['quantity'];

    $formattedEquipment[] = "$equipmentName1 - $quantity1";
    $statement = $conn->prepare("SELECT smi_borrowed_id, smi_borrowed_equipmentName FROM smi_borrowed_tbl WHERE smi_borrowed_id = :returnId");
    $statement->bindParam(':returnId', $returnId, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the first result as an associative array
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $equipmentName = $result['smi_borrowed_equipmentName'];

    $equip = explode("\n", $equipmentName);

    // echo $equip[0]."<br>";
    // echo $equip[1]."<br>";
}

?>