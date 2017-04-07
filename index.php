<?php include "config.php"; ?>
<html>
<head>
  <title>Solar Solutions</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="resources/ss-css.css">
  <link rel="stylesheet" href="resources/ss-theme-css.css">
  <script src="https://use.fontawesome.com/04dafedc6e.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
function unhideSignUp(){
  var x = document.getElementById('signup');
  if (x.style.display === 'none') {
    x.style.display = 'block';
  } else {
    x.style.display = 'none';
  }
};
</script>
<!--<script>
function unhideMap(){
  var y = document.getElementById('mapFrame');
  if (y.style.display === 'none') {
    y.style.display = 'block';
  } else {
    y.style.display = 'none';
  }
  var c = document.getElementById('city');
  var s = document.getElementById('state');
  var p = document.getElementById('pincode');
  var url = "/map.php?city="+c+"&sate="+s+"&pincode="+p;
  document.getElementById('mapFrame').src = url;
};
</script>-->
<script>
function getLocation(){
  var p = document.getElementById('pincode').value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          myObj = JSON.parse(this.responseText);
          document.getElementById("longitude_show").value = myObj.results[0].geometry.location.lng;
          document.getElementById("longitude_show").placeholder = "";
          document.getElementById("latitude_show").value = myObj.results[0].geometry.location.lat;
          document.getElementById("latitude_show").placeholder = "";
      }
  };
  xmlhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?address="+p+"&key=AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o", true);
  xmlhttp.send();

  setTimeout(dummy,1000);
}

function dummy() {
  var y = document.getElementById('mapFrame');
  if (y.style.display === 'none') {
    y.style.display = 'block';
  } else {
    y.style.display = 'none';
  }
  var long = document.getElementById("longitude_show").value;
  var lat = document.getElementById("latitude_show").value;
  var url = "/map.php?latitude="+lat+"&longitude="+long;
  document.getElementById('mapFrame').src = url;
  document.getElementById("submitBtn").disabled = false;
  setTimeout(generateData,2000);
}
</script>
<script>
  function generateData() {
    var mac_addr=generate_mac();
    var ip_addr=generate_ip();
    document.getElementById('mac_addr').value=mac_addr;
    document.getElementById('ip_addr').value=ip_addr;
  }
  //Used to generate random MAC address
  function generate_mac(){
      var hexDigits = "0123456789ABCDEF";
      var macAddress = "";
      for (var i = 0; i < 6; i++) {
          macAddress+=hexDigits.charAt(Math.round(Math.random() * 15));
          macAddress+=hexDigits.charAt(Math.round(Math.random() * 15));
          if (i != 5) macAddress += ":";
      }

      return showMacStatus(macAddress);
  }

  function showMacStatus(str) {
      if (str.length == 0) {
        return;
      } else {
         $.ajax({
          type:"GET",
          url:"getMacStatus.php",
          data:"q=" + str,
          success: function(result){
            if(result == "False"){
              generate_mac();
            } else {
              $("#mac_addr").val(""+str);
              //writeFile("#mac_addr".value , "#ip_addr".value) ;
            }
          }
        });
      }
    }

  function randomByte() {
    return Math.round(Math.random()*256);
  }

  function generate_ip() {
    var ip = randomByte() +'.' +
             randomByte() +'.' +
             randomByte() +'.' +
             randomByte();
    if (isPrivate(ip)) return generate_ip();
    return ip;
  }

  function isPrivate(ip) {
    return /^10\.|^192\.168\.|^172\.16\.|^172\.17\.|^172\.18\.|^172\.19\.|^172\.20\.|^172\.21\.|^172\.22\.|^172\.23\.|^172\.24\.|^172\.25\.|^172\.26\.|^172\.27\.|^172\.28\.|^172\.29\.|^172\.30\.|^172\.31\./.test(ip);
  }


  privateIps = [
    '10.0.0.0',
    '10.255.255.255',
    '172.16.0.0',
    '172.31.255.255',
    '192.168.0.0',
    '192.168.255.255'
  ];

  publicIps = [
    '0.0.0.0',
    '255.255.255.255',
  ];
</script>
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
</head>
<body>

<!--Navigation bar-->
<div class="w3-topnav">
  <a href="#myHeader"><i class="fa fa-home w3-text-theme w3-left" style="font-size:30px;"></i></a>
  <a href="#login"><i class="fa fa-sign-in w3-text-theme w3-right" style="font-size:30px"></i></a>
</div>

<!-- Header -->
<header class="w3-container w3-padding-64 w3-center w3-theme" id="myHeader">
  <h3 class="w3-jumbo w3-animate-bottom w3-padding-top">SOLAR SOLUTIONS</h3>
</header>

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
    <p id="status">
      <?php
      $status= $_REQUEST["status"];
      if ($status == "registered") {
        echo "User Registered Successfully.";
      } elseif ($status == "failed") {
        echo "Invalid Login ID or password.";
      }
      ?>
    </p>
    <form action="login.php" method="post">
      <input type="text" class="my-inputs" name="login_id" placeholder="ID" /><br>
      <input type="password" class="my-inputs" name="login_password" placeholder="Password" /><br>
      <input type="submit" class="w3-btn w3-margin w3-theme" />
    </form>
    <a href="/forgot.php"><i class="fa fa-question-circle w3-text-theme" style="font-size:12px"> Forgot password</i></a>
    &emsp;&emsp;
    <a href="#signup" onclick="unhideSignUp()"><i class="fa fa-user-plus w3-text-theme" style="font-size:12px;"> Create New Account</i></a>
  </div>
</div>

<div class="w3-container w3-margin" id="signup" style="display:none;">
  <div class="w3-center w3-padding-24 w3-card-24 w3-text-theme">
    <h1><i class="fa fa-user-plus w3-text-theme" style="font-size:48px;"></i>&emsp;Registeration</h1>
    <h6>Enter all the details to register yourself</h6><br>
    <form method="post" action="register.php">
      <div class="w3-half">
        <p style="font-size:24px">Personal Details</p><br>
        <input type="text" class="my-inputs" name="client_id" placeholder="Login Id" /><br>
        <input type="password" class="my-inputs" name="password" placeholder="Password" /><br>
        <input type="text" class="my-inputs" name="name" placeholder="Full Name" /><br>
        <input type="text" class="my-inputs" name="email" placeholder="Valid Email" /><br>
        <input type="text" class="my-inputs" name="contact_1" placeholder="Contact Number"><br>
        <input type="text" name="longitude_show" placeholder="Longitude Coordinate" id="longitude_show" style="display:none;"><br>
        <input type="text" value="MAC address" id="mac_addr" name="mac_addr" style="display:none;"><br>
      </div>
      <div class="w3-half">
        <p style="font-size:24px">Residential Information</p><br>
        <input type="text" class="my-inputs" name="address1" placeholder="House/flat name/number" /><br>
        <input type="text" class="my-inputs" name="address2" placeholder="Street,area"><br>
        <input type="text" class="my-inputs" name="city" placeholder="City" id="city"><br>
        <input type="text" class="my-inputs" name="state" placeholder="State" id="state"><br>
        <input type="text" class="my-inputs" name="pincode" placeholder="Pincode" id="pincode" onchange="getLocation()"><br>
        <input type="text" name="latitude_show" placeholder="Latitude Coordinate" id="latitude_show" style="display:none;"><br>
        <input type="text" value="IP address" id="ip_addr" name="ip_addr" style="display:none;"><br>
      </div>
      <iframe id="mapFrame" style="display:none; border:0px;" width="100%" height="420px" ></iframe>
      <input type="submit" class="w3-btn w3-margin w3-theme" id="submitBtn" disabled />
      <!--<p id="longitude_show" style="display:none;"></p>&emsp;<p id="latitude_show" style="display:none;"></p><br>-->

    </form>
  </div>
</div>

<!-- Footer -->
<footer class="w3-container w3-theme-dark w3-padding-16 w3-margin-top">
  <p class="w3-center">Designed with care @ <a href="www.kccoe.org">KCCOE</a>. Special thanks to <b>Prof. Sonal Balpande</b></p>
</footer>

</body>
</html>
