<?php
// if(isset($_POST["submit"])){
$address = $_POST["place"];
// $address = "thane";
$address=str_replace(" ", "+", $address);
if($address == ""){
$address = "mumbai";
}
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o&sensor=false";
$data = file_get_contents($url);
$output = json_decode($data);
// print_r($output);
$data = array();
        $data['latitude']  = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;
// echo "lat: ".$data['latitude'];
// echo "lng: ".$data['longitude'];
echo $data['latitude']." ".$data['longitude'];
// }
//}
?>
