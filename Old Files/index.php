<html>
<title>Solar Solutions</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="resources/ss-css.css">
<link rel="stylesheet" href="resources/ss-theme-css.css">
<script src="https://use.fontawesome.com/04dafedc6e.js"></script>
<style>
.my-inputs {
  width:20em!important;
  height:3em;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom: 1px solid #07889b;
  text-decoration: none;
  outline: none;
  margin:10px;
}

.my-inputs:focus{
  border-bottom: 2px solid #055561;
}
</style>
<body>

<!--Navigation bar-->
<div class="w3-topnav">
  <a href="#myHeader"><i class="fa fa-home w3-text-theme w3-left" style="font-size:30px;"></i></a>
  <a href="#login"><i class="fa fa-sign-in w3-text-theme w3-right" style="font-size:30px"></i></a>
</div>

<!-- Header -->
<header class="w3-container w3-padding-64 w3-center w3-theme" id="myHeader">
  <h3 class="w3-jumbo w3-animate-bottom w3-padding-top">SOLAR SOLUTIONS</h3>
    <!--<div class="w3-padding-32">
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">LEARN W3.CSS</button>
    </div>-->
</header>

<!-- Modal -->
<div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-top">
      <header class="w3-container w3-theme-l1">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn">×</span>
        <h4>Oh snap! We just showed you a modal..</h4>
        <h5>Because we can <i class="fa fa-smile-o"></i></h5>
      </header>
      <div class="w3-padding">
        <p>Cool huh? Ok, enough teasing around..</p>
        <p>Go to our <a class="w3-btn" href="/w3css/default.asp">W3.CSS Tutorial</a> to learn more!</p>
      </div>
      <footer class="w3-container w3-theme-l1">
        <p>Modal footer</p>
      </footer>
    </div>
</div>

<div class="w3-row-padding w3-center w3-margin-top">

  <div class="w3-third">
    <div class="w3-card-2 w3-padding-top" style="min-height:460px">
      <h4>Globally Connected</h4><br>
      <i class="fa fa-globe w3-margin-bottom w3-text-theme" aria-hidden="true" style="font-size:120px"></i>
      <p class="w3-padding-xxlarge">Every module comes with with complete connection to our server over a local internet connection* which allows the systems and the clients to be updated with their data. Always.*</p>
    </div>
  </div>

  <div class="w3-third">
    <div class="w3-card-2 w3-padding-top" style="min-height:460px">
      <h4>Arduino Powered</h4><br>
      <i class="fa fa-microchip w3-margin-bottom w3-text-theme" aria-hidden="true" style="font-size:120px"></i>
      <p class="w3-padding-xxlarge">The inside of each power box is a Arduino Mega which is the mind and machine that works day and night to give you the best ever results. It comes with enoguh power and a larger space of memory which is recommended for such complex implementations.</p>
    </div>
  </div>

  <div class="w3-third">
    <div class="w3-card-2 w3-padding-top" style="min-height:460px">
      <h4>Eco Friendly</h4><br>
      <i class="fa fa-envira w3-margin-bottom w3-text-theme" aria-hidden="true" style="font-size:120px"></i>
      <p class="w3-padding-xxlarge">Solar energy is a renewable energy resource that needs more attention and development than ever. Solar Solutions works with an AIM to make the world an Eco Friendly place by harnesing the power of the Sun to its maximum.</p>
    </div>
  </div>

</div>

<div class="w3-container" id="login">
  <div class="w3-center w3-padding-24 w3-card-12 w3-text-theme">
    <i class="fa fa-user-circle-o w3-text-theme" aria-hidden="true" style="font-size:140px;"></i>
    <h2>Login</h2>
    <form action="login.php" method="post">
      <input type="text" class="my-inputs" name="login_id" placeholder="Name" /><br>
      <input type="password" class="my-inputs" name="login_password" placeholder="Password" /><br>
      <input type="submit" class="w3-btn w3-margin w3-theme" />
    </form>
    <a href="/forgot.php"><i class="fa fa-question-circle w3-text-theme" style="font-size:12px"> Forgot password</i></a>
    &emsp;&emsp;
    <a href="#signup" onclick="showSignUp()"><i class="fa fa-user-plus w3-text-theme" style="font-size:12px;"> Create New Account</i></a>
  </div>
</div>

<!-- Footer -->
<footer class="w3-container w3-theme-dark w3-padding-16 w3-margin-top">
  <p class="w3-center">Designed with care @ <a href="www.kccoe.org">KCCOE</a>. Special thanks to <b>Prof. Sonal Balpande</b></p>
</footer>

<script>
function showSignUp(){
  var x = document.getElementById('signup');
  if (x.style.display === 'none') {
    x.style.display = 'block';
  } else {
    x.style.display = 'none';
  }
}
</script>
</body>
</html>
<?php
include "config.php";

if(isset($_POST["submit"])){
  $client_id = mysqli_real_escape_string($conn,$_POST["client_id"]);
  $client_pass = md5(mysqli_real_escape_string($conn,$_POST["password"]));
  $client_name = mysqli_real_escape_string($conn,$_POST["client_name"]);
  $email = mysqli_real_escape_string($conn,$_POST["email"]);

  $address1=mysqli_real_escape_string($conn,$_POST["address1"]);
  $address2=mysqli_real_escape_string($conn,$_POST["address2"]);
  $city=mysqli_real_escape_string($conn,$_POST["city"]);
  $state=mysqli_real_escape_string($conn,$_POST["state"]);

  $address = $address1." ".$address2." ".$city." ".$state;

  $contact_1 = $_POST["contact_1"];
  $pincode=$_POST["pincode"];

  $query = mysqli_query($conn,"insert into client_info (client_id,client_pass,client_name,address,email,contact_1,pincode)
             values('{$client_id}','{$client_pass}','{$client_name}','{$address}','{$email}','{$contact_1}','{$pincode}')");

  if($conn->$query){
    echo "<script>
    alert('Account Created Successfully.');
    </script>";
  } else {
    echo mysqli_error($conn);
  }
}
mysqli_close($conn);
?>
