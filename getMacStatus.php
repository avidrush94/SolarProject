<?php
$q = $_REQUEST["q"];

$hint = "True";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $len=strlen($q);
  include 'config.php';
  echo $hint === "" ? "no suggestion" : $hint;
  $sql = "SELECT mac_addr FROM arduino_info";
  $result = $conn->query($sql);
if ($result->num_rows > 0){
	$hint="False";
	}

}
echo $hint == "" ? "no suggestion" : $hint;

?>
