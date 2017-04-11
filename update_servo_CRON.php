<?php
include "config.php";
include "update_weather_info_CRON.php";

//Collect all the Client_id from arduino_info table
$sql1 = "SELECT client_id from arduino_info";
$result1 = $conn->query($sql1);

//if there is data available then get the pincode of that client
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        echo "Client_id: " . $row1["client_id"]. "<br>";

        //Collect the pincdo of the client_id which is currently selected
        $sql2 = "SELECT pincode from client_info where client_id='".$row1["client_id"]."'";
        $result2 = $conn->query($sql2);

        //Now if data is availabel, get the weather information like the date,sunrise,sunset using the pincode
        //Each client needs to have only 1 pincode, so the logic would break if there are more than one data available
        if ($result2->num_rows == 1) {
          while($row2 = $result2->fetch_assoc()) {
            echo "Pincode: " . $row2["pincode"]. "<br>";

            $curr_date = new DateTime();
            echo $curr_date->format('Y-m-d')."<br>";
            //Collect the necessary information from weather information table of the particular pincode
            $sql3 = "SELECT date_log,sunrise,sunset from weatherAt_".$row2["pincode"]." where date_log='".$curr_date->format('Y-m-d')."'";
            $result3 = $conn->query($sql3);

            if ($result3->num_rows > 0) {
              while($row3 = $result3->fetch_assoc()) {
                echo "date_log: ".$row3["date_log"]."<br>";
                echo "sunrise: ".$row3["sunrise"]."<br>";
                echo "sunset: ".$row3["sunset"]."<br>";

                $curr_time = strtotime(date("H:i:s"));
                $curr_date = strtotime(date("Y-m-d"));
                //echo $curr_time."<br>";
                //echo $curr_date."<br>";

                //---------------X_SERVO LOGIC---------------//

                //Now find the difference between the current time and sunrise to find how much to tilt
                $time1 = strtotime($row3["sunrise"]);
                $time2 = strtotime($row3["sunset"]);
                //since the current time is available in minutes so divide by 60 to get the Hour
                //At each hour the arms of the clock move at 0.25 degree so multiply with that
                $diffTime = round((abs($curr_time - $time1)/60)*0.25);
                echo $diffTime."<br>";

                //---------------Y_SERVO LOGIV---------------//

                //Now find the differnce between the longest date of year and current date_log
                $date1 = strtotime("2017-06-21");
                $date2 = strtotime("2017-12-21");
                //if the current date is positive it means that the current date is
                $diffDate = ((($date1 - $curr_date)/60)/60)/24;
                echo $diffDate."<br>";

                //Login to get angle for y_servo
                $y_servo = $diffDate*0.12;
                echo (int)$y_servo."<br>";

                //if day is increasing, then...
                if($diffDate > 0) {
                  echo "Day getting Longer<br>";

                  //Update the Y_servo information in the database
                  $sql4 = "UPDATE arduino_info set y_servo='".(int)$y_servo."' WHERE client_id='".$row1["client_id"]."';";

                  if($conn->query($sql4)) {
                    echo "Updated to ".(int)$y_servo."<br>";
                  }else{
                    echo "".$conn->err."<br>";
                  }
                //if night is increasing, then...
              }else if($diffDate < 0){
                  echo "Day getting Shorter<br>";

                  //Update the Y_servo information in the database
                  $diffDate = 23+$diffDate;
                  $sql4 = "UPDATE arduino_info set y_servo='".(int)$y_servo."' WHERE client_id='".$row1["client_id"]."';";

                  if($conn->query($sql4)) {
                    echo "Updated to ".$diffDate."<br>";
                  }else{
                    echo "".$conn->err."<br>";
                  }
                } else{
                  echo "Nothing<br>";
                }

                //if it is day, then...
                if($curr_time > $time1) {
                  echo "Beyond sunrise<br>";

                  //Update the X_servo information in the database
                  $sql5 = "UPDATE arduino_info set x_servo='".$diffTime."' WHERE client_id='".$row1["client_id"]."';";

                  if($conn->query($sql5)) {
                    echo "Updated to ".$diffTime."<br>";
                  }else{
                    echo "".$conn->err."<br>";
                  }
                //if it is Night, then...
                }else if($curr_time < $time2){
                  echo "Beyond sunset<br>";

                  //Update the X_servo information in the database
                  $sql5 = "UPDATE arduino_info set x_servo='0' WHERE client_id='".$row1["client_id"]."';";

                  if($conn->query($sql5)) {
                    echo "Updated to ".$diffTime."<br>";
                  }else{
                    echo "".$conn->err."<br>";
                  }
                } else{
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
