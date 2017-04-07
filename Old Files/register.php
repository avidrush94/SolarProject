<?php
include 'config.php';

$client_id= $_REQUEST["client_id"];
$password= $_REQUEST["password"];
$name= $_REQUEST["name"];
$email= $_REQUEST["email"];
$contact_1= $_REQUEST["contact_1"];
$address1= $_REQUEST["address1"];
$address2=$_REQUEST["address2"];
$city= $_REQUEST["city"];
$state= $_REQUEST["state"];
$pincode= $_REQUEST["pincode"];

$sql="INSERT into client_info (client_id,client_pass,client_name,address,address2,city,state,email,contact_1,pincode)
    VALUES ('$client_id','$password','$name','$address1','$address2','$city','$state','$email',$contact_1,$pincode)";

if ($conn->query($sql)) {
    // output data of each row
    echo "New User Registered Successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
