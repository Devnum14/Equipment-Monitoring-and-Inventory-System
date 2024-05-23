<?php

require '_config.php';

//------------------------equipment.php Function---------------------//

function selectEquipments()
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_equipment_tbl
                                            Order By
                                            equipment_id
                                            ASC");
    $statement->execute();

    return $statement;

}


function equipmentsList()
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_equipmentlist_tbl
                                            Order By
                                            smi_equipmentlist_id
                                            ASC");
    $statement->execute();

    return $statement;

}

function createEquipments($equipmentName, $equipmentStock)
{

    $statement = dbConnection()->prepare("INSERT INTO
                                            smi_equipment_tbl
                                            (
                                                equipment_name,
                                                equipment_stock,
                                                equipment_borrowed,
                                                equipment_dateadd,
                                                equipment_dateupdate
                                            )
                                            VALUES
                                            (
                                                :equipmentName,
                                                :equipmentStock,
                                                '0',
                                                NOW(),
                                                NOW()
                                            )");


    $statement->execute([
        'equipmentName' => $equipmentName,
        'equipmentStock' => $equipmentStock
    ]);

    //confirm if the query is executed properly
    if ($statement) {
        return true;
    } else {
        return false;
    }

}

function updateEquipments($selectedEquipment)
{


    if (!empty($selectedEquipment)) {
        $selectedEquipment = json_decode($selectedEquipment, true);


        $conn = dbConnection();
        $conn->beginTransaction();

        try {
            $formattedEquipment = [];


            foreach ($selectedEquipment as $equipment) {
                list($equipmentName, $stock) = explode('|', $equipment['option']);
                $quantity = (int) $equipment['quantity'];

                $formattedEquipment[] = "$equipmentName - $quantity";

                $statement = dbConnection()->prepare("UPDATE 
                                            smi_equipment_tbl 
                                            SET 
                                            equipment_stock = equipment_stock + ?
                                            WHERE 
                                            equipment_name = ?");

                $statement->execute([$quantity, $equipmentName]);
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

function deleteEquipments($selectedEquipment, $deleteReason)
{

    if (!empty($selectedEquipment)) {
        $selectedEquipment = json_decode($selectedEquipment, true);


        $conn = dbConnection();
        $conn->beginTransaction();

        try {
            $formattedEquipment = [];


            foreach ($selectedEquipment as $equipment) {
                list($equipmentName, $stock) = explode('|', $equipment['option']);
                $quantity = (int) $equipment['quantity'];

                $formattedEquipment[] = "$equipmentName - $quantity";

                $statement = dbConnection()->prepare("UPDATE 
                                            smi_equipment_tbl 
                                            SET 
                                            equipment_stock = equipment_stock - ?
                                            WHERE 
                                            equipment_name = ?");

                $statement->execute([$quantity, $equipmentName]);
            }

            $equipmentString = implode("\n", $formattedEquipment);



            $stmt = $conn->prepare("INSERT INTO smi_delete_tbl (smi_delete_equipmentName, smi_delete_reason, smi_delete_date) VALUES (?, ?, NOW())");
            $stmt->execute([$equipmentString, $deleteReason,]);

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





//--------------------------------Borrow Function----------------------------------//


function selectBorrows()
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_borrowed_tbl
                                            Order By
                                            smi_borrowed_id
                                            ASC");
    $statement->execute();

    return $statement;

}

function selectBorrows1($modalId)
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_borrowed_tbl
                                            WHERE
                                            smi_borrowed_id = :selectid
                                            ");
    $statement->execute([
        'selectid' => $modalId,
    ]);

    return $statement;

}

function showEquipment($transid)
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_borrowed_tbl
                                            WHERE
                                            smi_borrowed_transid = :transid
                                            ");
    $statement->execute([
        'transid' => $transid,
    ]);

    return $statement;

}
function borrowEquipments($selectedEquipment, $studentName, $studentId, $expectedReturn, $Department)
{
    if (!empty($selectedEquipment) && !empty($studentName) && !empty($studentId) && !empty($expectedReturn)) {
        $selectedEquipment = json_decode($selectedEquipment, true);

        $conn = dbConnection();
        $conn->beginTransaction();

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


                $stmt = $conn->prepare("INSERT INTO smi_borrowed_tbl (smi_borrowed_equipmentName, smi_borrowed_qty, smi_borrowed_studentName, smi_borrowed_studentId, smi_borrowed_department, smi_borrowed_dateBorrow, smi_borrowed_expReturn) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
                $stmt->execute([$equipmentName, $quantity, $studentName, $studentId, $Department, $expectedReturn,]);

                $conn->commit();
            }

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

//--------------------------------borrowed.php Function----------------------------------//

function returnsEquipments($returnId, $equipmentName)
{

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

function disposeEquipments($disposeId, $equipmentName, $equipmentQty, $studentName, $studentId, $disposeReason)
{
    $statement = dbConnection()->prepare("UPDATE 
                                            smi_borrowed_tbl
                                            SET  
                                            smi_borrow_equipment_qty = smi_borrow_equipment_qty - :equipmentQty
                                            WHERE
                                            smi_borrowed_id = :disposeId
                                            ");

    //instead of putting values directly to a query, we use PDO variables as security measures
    $statement->execute([
        'disposeId' => $disposeId,
        'equipmentQty' => $equipmentQty
    ]);




    $statement1 = dbConnection()->prepare("INSERT INTO 
                                            smi_dispose_tbl
                                            (
                                            smi_dispose_equipmentName,
                                            smi_dispose_equipmentQty,
                                            smi_dispose_studentName,
                                            smi_dispose_studentId,
                                            smi_dispose_reason,
                                            smi_dispose_date
                                            )
                                            VALUES
                                            (
                                                :equipmentName,
                                                :equipmentQty,
                                                :studentName,
                                                :studentId,
                                                :disposeReason,
                                                NOW()
                                            )");



    //instead of putting values directly to a query, we use PDO variables as security measures
    $statement1->execute([
        'equipmentName' => $equipmentName,
        'equipmentQty' => $equipmentQty,
        'studentName' => $studentName,
        'studentId' => $studentId,
        'disposeReason' => $disposeReason
    ]);


    $statement2 = dbConnection()->prepare("UPDATE 
                                            smi_equipment_tbl
                                            SET  
                                            equipment_borrowed = equipment_borrowed - :equipmentQty
                                            WHERE
                                            equipment_name = :equipmentName
                                            ");

    $statement2->execute([
        'equipmentName' => $equipmentName,
        'equipmentQty' => $equipmentQty,
    ]);


    if ($statement && $statement1 && $statement2) {
        return true;
    } else {
        return false;
    }
}

function disposeAllEquipments($disposeId, $equipmentName, $equipmentQty, $studentName, $studentId, $disposeReason)
{
    $statement = dbConnection()->prepare("DELETE FROM 
                                            smi_borrowed_tbl
                                            WHERE
                                            smi_borrowed_id = :disposeId
                                            ");

    //instead of putting values directly to a query, we use PDO variables as security measures
    $statement->execute([
        'disposeId' => $disposeId
    ]);




    $statement1 = dbConnection()->prepare("INSERT INTO 
                                            smi_dispose_tbl
                                            (
                                            smi_dispose_equipmentName,
                                            smi_dispose_equipmentQty,
                                            smi_dispose_studentName,
                                            smi_dispose_studentId,
                                            smi_dispose_reason,
                                            smi_dispose_date
                                            )
                                            VALUES
                                            (
                                                :equipmentName,
                                                :equipmentQty,
                                                :studentName,
                                                :studentId,
                                                :disposeReason,
                                                NOW()
                                            )");



    //instead of putting values directly to a query, we use PDO variables as security measures
    $statement1->execute([
        'equipmentName' => $equipmentName,
        'equipmentQty' => $equipmentQty,
        'studentName' => $studentName,
        'studentId' => $studentId,
        'disposeReason' => $disposeReason
    ]);


    $statement2 = dbConnection()->prepare("UPDATE 
                                            smi_equipment_tbl
                                            SET  
                                            equipment_borrowed = equipment_borrowed - :equipmentQty
                                            WHERE
                                            equipment_name = :equipmentName
                                            ");

    $statement2->execute([
        'equipmentName' => $equipmentName,
        'equipmentQty' => $equipmentQty,
    ]);


    if ($statement && $statement1 && $statement2) {
        return true;
    } else {
        return false;
    }
}


//-----------HISTORY----------//

function fetchDelete()
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_delete_tbl
                                            Order By
                                            smi_delete_id
                                            ASC");
    $statement->execute();

    return $statement;

}


function fetchDispose()
{

    $statement = dbConnection()->prepare("SELECT 
                                            * 
                                            FROM
                                            smi_dispose_tbl
                                            Order By
                                            smi_dispose_id
                                            ASC");
    $statement->execute();

    return $statement;

}





?>