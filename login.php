<?php
include 'config.php';
session_start();

$username = $_POST["login_id"];
$password = md5($_POST["login_password"]);

//if Admin tries to login
if($username == "admin" && $password == "21232f297a57a5a743894a0e4a801fc3")
{
  echo "<body onload='redirect()'>Redirecting to Admin_Panel</body>";
  echo "<script>
        function redirect(){
          window.location='/admin_panel.php';
        }
        </script>";
}else //if client tries to login
{
  $loginQuery = "SELECT * FROM u691610309_solar.client_info WHERE client_id='".$username."' && client_pass='".$password."';";
  $loginResult = $conn->query($loginQuery);
  if ($loginResult->num_rows == 1) {
    echo "Redirecting to Client_Panel";
    header("location:http://solarsolutions.esy.es/client_panel.php?client_id=$username");
  } else {
    echo "Invalid Login. Redirecting to Index";
    header("location:http://solarsolutions.esy.es/index.php?status=failed#login");
  }
  //echo $count;
}
?>
