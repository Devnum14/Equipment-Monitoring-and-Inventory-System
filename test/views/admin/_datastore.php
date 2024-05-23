<?php

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
                    echo $inputEquipmentName . ":" . $qty . "-" . $inputQuantity . " = " . $newquantity . "<br>";



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

                // Insert formatted equipment data into the database
                // $formattedEquipmentString = implode(PHP_EOL, $formattedEquipment);
                // $insertStatement = $conn->prepare("INSERT INTO testing (smi_borrowed_equipmentName) VALUES (:formattedEquipment)");
                // $insertStatement->bindParam(':formattedEquipment', $formattedEquipmentString);
                // $insertStatement->execute();

                // // Commit the transaction
                // $conn->commit();
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

///////////////

foreach ($selectedEquipment as $equipment) {
    list($inequipmentName, $stock) = explode('-', $equipment['option']);
    $inquantity = (int) $equipment['quantity'];
    
    

    $inputEquipmentName = $inequipmentName;
    $inputQuantity = $inquantity;

    $newquantity = $qty - $inputQuantity;

   // echo $inputEquipmentName . " - " . $newquantity ."<br>";

    // Store formatted equipment data
    $formattedEquipment[] = "$inputEquipmentName - $newquantity";
}
?>


<?


try {
    // Initialize an array to store formatted equipment data
    $formattedEquipment = [];

    $statement = $conn->prepare("SELECT smi_borrowed_id, smi_borrowed_equipmentName FROM smi_borrowed_tbl WHERE smi_borrowed_id = $returnId");
    $statement->execute();

    // Fetch all results as an associative array
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as &$result) {
        $borrowedId = $result['smi_borrowed_id'];
        $equipmentName = $result['smi_borrowed_equipmentName'];
        echo $equipmentName . "<br>";
        $myBorrow = explode("\n", $equipmentName); // Change to explode("\n")

        foreach ($myBorrow as $myBorrows) {
            list($equipe, $qty) = explode('-', $myBorrows);
            $qty = (int) $qty;

            echo $equipe . " - ". $qty. "<br>";

            print_r($selectedEquipment)."<br>";

            // Input values
            // foreach ($selectedEquipment as $equipment) {
            //     list($inequipmentName, $stock) = explode('-', $equipment['option']);
            //     $inquantity = (int) $equipment['quantity'];
                
                

            //     $inputEquipmentName = $inequipmentName;
            //     $inputQuantity = $inquantity;

            //     $newquantity = $qty - $inputQuantity;

            //    // echo $inputEquipmentName . " - " . $newquantity ."<br>";

            //     // Store formatted equipment data
            //     $formattedEquipment[] = "$inputEquipmentName - $newquantity";
            // }
        }
    }

    // Insert formatted equipment data into the database
    // $formattedEquipmentString = implode(PHP_EOL, $formattedEquipment);
    // $insertStatement = $conn->prepare("INSERT INTO testing (smi_borrowed_equipmentName) VALUES (:formattedEquipment)");
    // $insertStatement->bindParam(':formattedEquipment', $formattedEquipmentString);
    // $insertStatement->execute();

    // // Commit the transaction
    // $conn->commit();

} catch (\Throwable $th) {
    // Rollback the transaction in case of an exception
    $conn->rollBack();
    // Handle exceptions
}


?>