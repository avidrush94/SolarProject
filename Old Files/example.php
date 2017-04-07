<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php

?>

<h2>Client Login</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="data.php">
client_id: <input type="text" name="client_id" value="<?php echo $client_id;?>">
  <span class="error">* <?php echo $clientErr;?></span>
  <br><br>
Password: <input type="pass" name="Password" value="<?php echo $Password;?>">
  <span class="error">* <?php echo $passErr;?></span>
  <br><br>



 Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Contact_1: <input type="text" name="contact_1" value="<?php echo $contact_1;?>">
  <span class="error"><?php echo $contErr;?></span>
  <br><br>
  Address: <textarea name="Address" rows="5" cols="40"><?php echo $Address;?></textarea>
  <br><br>
  pincode: <input type="text" name="pincode" value="<?php echo $pincode;?>">
  <span class="error">* <?php echo $pinErr;?></span>
  <br><br>
  Longitude: <input type="text" name="longitude" value="<?php echo $longitude;?>">
  <span class="error">* <?php echo $longErr;?></span>
  <br><br>
  latitude: <input type="text" name="latitude" value="<?php echo $latitude;?>">
  <span class="error">* <?php echo $latErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Submit">
</form>

</body>

</html>
