<?php
include 'config.php';

$user=$_REQUEST["client_id"];

$sql="SELECT * FROM arduino_$user ORDER BY date_log DESC limit 1";
$result=mysqli_query($conn,$sql);

if ($result->num_rows != 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
} else {
    echo "0 results";
}
$conn->close();
?>
