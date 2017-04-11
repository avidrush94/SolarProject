<?php
include "config.php";

$client_id=$_REQUEST["client_id"];
$arduino_id=$_REQUEST["arduino_id"];
$voltage=$_REQUEST["voltage"];
$current=$_REQUEST["current"];
$date=date("Y-m-d");
$date.=" ";
$date.=date("h:i:sa");

$sql = "INSERT INTO arduino_$client_id (date_log,voltage,current)
      VALUES ('$date','$voltage','$current')";

if($conn->query($sql)){

  $sql2 = "SELECT x_servo,y_servo FROM arduino_info where arduino_id=$arduino_id";
  $result = $conn->query($sql2);

  if ($result->num_rows == 1) {
    while($row = $result->fetch_assoc()) {
      echo "" . $row["x_servo"]. "<br>" . $row["y_servo"]. "<br>";
    }
  } else {
    echo "0 results";
  }

} else {
  echo $conn->err;
}

$conn->close();
 ?>
