<?php
include 'config.php';

echo "Today is " . date("Y-m-d") . "<br>";
echo "The time is " . date("h:i:sa") ."<br>";
echo date_default_timezone_get();
$myfile = fopen("log_CRON.txt", "a") or die("Unable to open file!");
$txt = date("Y-m-d");
fwrite($myfile, $txt);
$txt = "\n";
fwrite($myfile, $txt);
$txt = date("h:i:sa");
fwrite($myfile, $txt);
$txt = "\n";
fwrite($myfile, $txt);
fclose($myfile);

$pincodeSql = "SELECT pincode FROM location_info";
$pincode = $conn->query($pincodeSql);
if ($pincode->num_rows > 0) {
    // output data of each row
    while($row = $pincode->fetch_assoc()) {
        echo "pincode: " . $row["pincode"]. "<br>";

$temp = $row["pincode"];
$url = "http://api.openweathermap.org/data/2.5/weather?zip=$temp,in&appid=9ad31e9f694ba74ca4c1042de1856add";
$data = file_get_contents($url);
$resultSet = json_decode($data,true);
$date_log = date("y/m/d", $resultSet['dt']);
$sunrise = date("H:i:s", $resultSet['sys']['sunrise']);
$sunset = date("H:i:s", $resultSet['sys']['sunset']);
$high_temp = $resultSet['main']['temp_max'];
$low_temp = $resultSet['main']['temp_min'];
$humidity = $resultSet['main']['humidity'];
$wind_direction = $resultSet['wind']['deg'];
$wind_speed = $resultSet['wind']['speed'];
$clouds = $resultSet['clouds']['all'];

echo "Date: ".$date_log."<br>";
echo "Sunrise: ".$sunrise."<br>";
echo "Sunset: ".$sunset."<br>";
echo "High Temperature: ".$high_temp."<br>";
echo "Low Temperature: ".$low_temp."<br>";
echo "Humidity: ".$humidity." % <br>";
echo "Wind Direction: ".$wind_direction."<br>";
echo "Wind Speed: ".$wind_speed."<br>";
echo "Clouds: ".$clouds."<br>";

$sql = "INSERT INTO weatherAt_$temp (
  `date_log`,
  `sunrise`,
  `sunset`,
  `high_temp`,
  `low_temp`,
  `humidity`,
  `wind_direction`,
  `wind_speed`,
  `clouds`
) VALUES (
    '{$date_log}',
    '{$sunrise}',
    '{$sunset}',
    '{$high_temp}',
    '{$low_temp}',
    '{$humidity}',
    '{$wind_direction}',
    '{$wind_speed}',
    '{$clouds}'
  )";

if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



}
} else {
echo "0 results";
}

//http://api.openweathermap.org/data/2.5/weather?zip=400615,in&appid=9ad31e9f694ba74ca4c1042de1856add
?>
