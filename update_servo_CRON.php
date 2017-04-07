<?php
include "config.php";
include "update_weather_info_CRON.php";

$sql1 = "SELECT client_id from arduino_info";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        echo "Client_id: " . $row1["client_id"]. "<br>";

        $sql2 = "SELECT pincode from client_info where client_id='".$row1["client_id"]."'";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows == 1) {
          while($row2 = $result2->fetch_assoc()) {
            echo "Pincode: " . $row2["pincode"]. "<br>";

            $curr_date = new DateTime();
            echo $curr_date->format('Y-m-d')."<br>";
            $sql3 = "SELECT date_log,sunrise,sunset from weatherAt_".$row2["pincode"]." where date_log='".$curr_date->format('Y-m-d')."'";
            $result3 = $conn->query($sql3);

            if ($result3->num_rows > 0) {
              while($row3 = $result3->fetch_assoc()) {
                echo "date_log: ".$row3["date_log"]."<br>";
                echo "sunrise: ".$row3["sunrise"]."<br>";
                echo "sunset: ".$row3["sunset"]."<br>";

                $curr_time = strtotime(date("H:i:s"));
                //echo $curr_time."<br>";

                $date1 = strtotime($row3["sunrise"]);
                $date2 = strtotime($row3["sunset"]);
                $diff = round((abs($curr_time - $date1)/60)*0.25);
                echo $diff."<br>";
                if($curr_time > $date1) {
                  echo "Beyond sunrise<br>";

                  $sql4 = "UPDATE arduino_info set x_servo=".$diff." where arduino_id='".$row1["client_id"]."';";

                  if($conn->query($sql4)) {
                    echo "Updated to ".$diff."<br>";
                  }else{
                    echo "".$conn->err."<br>";
                  }

                }else if($curr_time < $date2){
                  echo "Beyond sunset<br>";
                }else{
                  echo "Nothing<br>";
                }
              }
            }
            else{
              echo "no date_log,sunrise,sunset<br>";
            }
          }
        } else {
          echo "no pincode";
        }
    }
} else {
    echo "0 results";
}
$conn->close();
?>
