<?php
include "config.php";
session_start();

if(session_destroy()) {
  echo "Logout Successful. Redirecting to Index.";
  header("location:http://solarsolutions.esy.es/index.php#login");
}
?>
