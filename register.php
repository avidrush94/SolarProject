<?php
include 'config.php';

$client_id= $_REQUEST["client_id"];
$password= md5($_REQUEST["password"]);
$name= $_REQUEST["name"];
$email= $_REQUEST["email"];
$contact_1= $_REQUEST["contact_1"];
$address1= $_REQUEST["address1"];
$address2=$_REQUEST["address2"];
$city= $_REQUEST["city"];
$state= $_REQUEST["state"];
$pincode= $_REQUEST["pincode"];
$latitude=$_REQUEST["latitude_show"];
$longitude=$_REQUEST["longitude_show"];
$ip_address=$_REQUEST["ip_addr"];
$mac_address=$_REQUEST["mac_addr"];
$date=date("Y-m-d");

$sql="INSERT into client_info (client_id,client_pass,client_name,address,address2,city,state,email,contact_1,pincode,longitude,latitude)
    VALUES ('$client_id','$password','$name','$address1','$address2','$city','$state','$email','$contact_1','$pincode','$longitude','$latitude');";

$sql .="INSERT into location_info (name,pincode,longitude,latitude)
    VALUES ('$city','$pincode','$logitude','$latitude');";

$sql .="CREATE TABLE weatherAt_$pincode (
	id INT(10) NOT NULL auto_increment,
  date_log date,
  sunrise varchar(20),
  sunset varchar(20),
  high_temp varchar(20),
  low_temp varchar(20),
  humidity varchar(20),
  wind_direction varchar(20),
  wind_speed varchar(20),
  clouds varchar(20),
  rain_percentage varchar(20),
  PRIMARY KEY (id)
);";

$sql .="INSERT into arduino_info (client_id,mac_addr,ip_addr,reg_detail,curr_status)
    VALUES ('$client_id','$mac_address','$ip_address','$date','A','0','0');";

$sql .="CREATE TABLE arduino_$client_id (
  id INT(10) NOT NULL auto_increment,
  date_log varchar(20) UNIQUE,
  voltage varchar(20),
  current varchar(20),
  PRIMARY KEY (id)
)";

if ($conn->multi_query($sql)) {
    echo "New records created successfully";
    header("location:http://solarsolutions.esy.es/index.php?status=registered#login");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error ." " ;
}

$conn->close();
?>
