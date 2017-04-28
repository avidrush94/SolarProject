<?php
include "config.php";

$client_id=$_REQUEST["client_id"];
$arduino_id=$_REQUEST["arduino_id"];
$voltage=$_REQUEST["voltage"];
$current=$_REQUEST["current"];
$date=date("Y-m-d");
$date.=" ";
$date.=date("h:i:sa");
$current=$current/1000;
$sql = "INSERT INTO arduino_$client_id (date_log,voltage,current)
      VALUES ('$date','$voltage','$current')";

if($conn->query($sql)){

  $sql2 = "SELECT x_servo,y_servo FROM arduino_info where arduino_id=$arduino_id";
  $result = $conn->query($sql2);

  if ($result->num_rows == 1) {
    while($row = $result->fetch_assoc()) {
      $x_servo = (int)$row["x_servo"];
      $y_servo = (int)$row["y_servo"];
      if($x_servo<100 && $x_servo>=10){
        (string)$x_servo = "0".(string)$x_servo;
      }else if($x_servo<10){
        (string)$x_servo = "00".(string)$x_servo;
      }else{
      }

      if($y_servo<100 && $y_servo>=10){
        (string)$y_servo = "0".(string)$y_servo;
      }else if($y_servo<10){
        (string)$y_servo = "00".(string)$y_servo;
      }else{
      }

      echo "" .$x_servo. "<br>" .$y_servo;
    }
  } else {
    echo "0 results";
  }

} else {
  echo $conn->err;
}

$conn->close();
 ?>
