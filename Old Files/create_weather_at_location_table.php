<?php
include 'config.php';

$longitude= $_REQUEST["longi"];
$latitude= $_REQUEST["lati"];

$sql = "CREATE TABLE WeatherAt$longitude$latitude (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>
