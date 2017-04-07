<?php
include 'config.php';
$data = $_GET["q"];

$sql="SELECT * FROM client_info WHERE client_id ='".$data."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "User ID unavailable.";
} else {
    echo "Available.";
}
$conn->close();
?>
