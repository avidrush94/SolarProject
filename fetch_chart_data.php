<?php
include 'config.php';

$user=$_REQUEST["client_id"];

$sql="SELECT * FROM arduino_$user ORDER BY date_log DESC limit 24";
$result=mysqli_query($conn,$sql);
$data=array();
if ($result->num_rows != 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data[]=$row;
    }
} else {
    echo "0 results";
}
$conn->close();
header("Content-type:application/json");
print json_encode($data);
?>
