<?php
require 'database_connection.php';

$display_query = "SELECT * FROM smi_borrowed_tbl";
$results = mysqli_query($con, $display_query);
$count = mysqli_num_rows($results);

if ($count > 0) {
    $data_arr = array();
    $i = 1;

    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[$i]['smi_borrowed_id'] = $data_row['smi_borrowed_id'];
        $data_arr[$i]['smi_borrowed_equipmentName'] = $data_row['smi_borrowed_equipmentName'];
        $data_arr[$i]['smi_borrowed_studentName'] = $data_row['smi_borrowed_studentName'];
        $data_arr[$i]['smi_borrowed_studentId'] = $data_row['smi_borrowed_studentId'];
        $data_arr[$i]['smi_borrowed_dateBorrow'] = $data_row['smi_borrowed_dateBorrow'];
        $data_arr[$i]['smi_borrowed_expReturn'] = $data_row['smi_borrowed_expReturn'];

        // Explode equipment names
        $equipmentNames = explode("\n", $data_row['smi_borrowed_equipmentName']);

        // Create a new array to store exploded data
        $explodedData = array();
        $totalQuantity = 0;

        foreach ($equipmentNames as $equipment) {
            // Extract quantity and equipment name
            $parts = explode('-', trim($equipment));
            $quantity = (int) trim(end($parts));
            $totalQuantity += $quantity;

            // Add to the exploded data array
            $explodedData[] = trim($equipment);
        }

        // Implode the exploded data and assign it to the equipment name
        $data_arr[$i]['smi_borrowed_equipmentName1'] = implode("\n", $explodedData);

        // Add total quantity to the response
        $data_arr[$i]['totalQuantity'] = $totalQuantity;

        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'
    );
}

echo json_encode($data);
?>