<?php
date_default_timezone_set('Asia/Kolkata');

$server="mysql.hostinger.in";
$username="u691610309_admin";
$password="uvc-Z2d-hGo-3NG";
$dbname="u691610309_solar";

$conn = mysqli_connect($server,$username,$password,$dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
 ?>
