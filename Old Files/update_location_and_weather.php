<?php
include 'config.php';

$longitude=$_REQUEST["longitude"];
$latitude=$_REQUEST["latitude"];

$sql = "INSERT into location_info (location_id,name,longitude,latitude)
        VALUES('000000006','Mumbai',$longitude,$latitude)";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "the longitude is " . $longitude . " & latitude is " . $latitude . "<br>";

$conn->close();
 ?>
