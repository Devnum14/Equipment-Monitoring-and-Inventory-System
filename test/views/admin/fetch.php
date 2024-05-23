<?php
if(isset($_POST['view'])){

$con = mysqli_connect("localhost", "root", "", "smi_database");

if($_POST["view"] != '')
{
    $update_query = "UPDATE smi_dispose_equipmentName SET smi_dispose_id = 0 WHERE smi_dispose_id = 12";
    mysqli_query($con, $update_query);
}
$query = "SELECT * FROM smi_dispose_tbl";
$result = mysqli_query($con, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
   $output .= '
   <li>
   <a href="#">
   <strong>'.$row["smi_dispose_equipmentName"].'</strong><br />
   <small><em>'.$row["smi_dispose_equipmentQty"].'</em></small>
   </a>
   </li>
   ';

 }
}
else{
     $output .= '
     <li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
}



$status_query = "SELECT * FROM smi_dispose_tbl WHERE smi_dispose_id = 1";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count
);

echo json_encode($data);

}

?>