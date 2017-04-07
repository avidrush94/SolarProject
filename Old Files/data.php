<?php
include "config.php";

$name=$_POST["name"];
$email=$_POST["email"];
$client_id=$_POST["client_id"];
$Password=$_POST["Password"];
$Address=$_POST["Address"];
$contact_1=$_POST["contact_1"];
//$contact_2 =$_POST['contact_2'];
$pincode=$_POST["pincode"];
$longitude=$_POST["longitude"];
$latitude=$_POST["latitude"];
/*echo $client_id;
echo $Password;
echo $Address;
*/
if($conn->connect_error){
	echo "connection fail";
}
if ($conn->query("INSERT INTO client_info (client_id, client_pass, client_name, address, email, contact_1, pincode, longitude, latitude) VALUES ('$client_id',  '$Password', '$name', '$Address', '$email', '$contact_1', '$pincode', '$longitude', '$latitude');")){
	echo "success";
}else{
	echo $conn->error;
}
/*
Password VALIDATION

function CheckPassword(inputtxt) 
{ 
var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
if(inputtxt.value.match(decimal)) 
{ 
alert('Correct, try another...')
return true;
}
else
{ 
alert('Wrong...!')
return false;
}
} 

*/


?>