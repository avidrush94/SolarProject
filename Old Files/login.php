<?php
include 'config.php';
session_start();

$username = $_POST["login_id"];
$password = md5($_POST["login_password"]);

//if Admin tries to login
if($username == "aadmin" && $password == "21232f297a57a5a743894a0e4a801fc3")
{
  echo "<body onload='redirect()'>Redirecting to Admin_Panel</body>";
  echo "<script>
        function redirect(){
          window.location='/admin_panel.php';
        }
        </script>";
}else //if client tries to login
{
  $result = $conn->query("SELECT * FROM u691610309_solar.client_info WHERE client_id='".$username."' && client_pass='".$password."';");
  //$count =$count[$result];
  while($row = mysqli_fetch_assoc($result)){
    echo "client_id: " . $row["client_id"]. " - Password: " . $row["client_pass"]. " <br>";
  }
  //echo $count;
}
 ?>
