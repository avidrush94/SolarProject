<html>
<head>
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

  .error{
    color:red;
  }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="w3-container w3-padding-64 w3-center w3-theme" id="myHeader">
    <h3 class="w3-jumbo w3-animate-bottom w3-padding-top">SOLAR SOLUTIONS</h3>
      <!--<div class="w3-padding-32">
        <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">LEARN W3.CSS</button>
      </div>-->
  </header>

  <div class="w3-container w3-margin" id="signup">
    <div class="w3-center w3-padding-24 w3-card-24 w3-text-theme">
      <h1><i class="fa fa-user-plus w3-text-theme" style="font-size:48px;"></i>&emsp;Registeration</h1>
      <h6>Enter all the details to register yourself</h6>
      <form method="post">
        <div class="w3-half">
          <p style="font-size:24px">Personal Details</p><br>
          <input type="text" class="my-inputs" id="client_id" name="client_id" placeholder="Login Id" onkeyup="checkId(this.value)"/><br>
          <span id="client_idErr" class="error"></span><br>
          <input type="password" class="my-inputs" id="password" name="password" placeholder="Password" onkeyup="checkPassword(this.value)"/><br>
          <span id="passwordErr" class="error"></span><br>
          <input type="text" class="my-inputs" id="client_name" name="client_name" placeholder="Full Name" /><br>
          <span id="client_nameErr" class="error"><br>
          <input type="text" class="my-inputs" id="email" name="email" placeholder="Valid Email" /><br>
          <span id="emailErr" class="error"></span><br>
          <input type="text" class="my-inputs" id="contact_1" name="contact_1" placeholder="Contact Number"><br>
          <span id="contact_1Err" class="error"></span><br>
        </div>
        <div class="w3-half">

          <p style="font-size:24px">Residential Information</p><br>
          <input type="text" class="my-inputs" id="address1" name="address1" placeholder="House/flat name/number" /><br>
          <span id="address1Err" class="error"></span><br>
          <input type="text" class="my-inputs" id="address2" name="address2" placeholder="Street,area"><br>
          <span id="address2Err" class="error"></span><br>
          <input type="text" class="my-inputs" id="city" name="city" placeholder="City"><br>
          <span id="cityErr" class="error"></span><br>
          <input type="text" class="my-inputs" id="state" name="state" placeholder="State"><br>
          <span id="stateErr" class="error"></span><br>
          <input type="text" class="my-inputs" id="pincode" name="pincode" placeholder="Pincode"><br>
          <span id="pincodeErr" class="error"></span><br>

        </div><br>
        <span id="warning"></span><br>
        <a href="#map_show"><input type="button" class="w3-btn w3-margin w3-theme" value="Submit"
          onclick="submitForm(
          client_id.value,
          password.value,
          client_name.value,
          email.value,
          contact_1.value,
          address1.value,
          address2.value,
          city.value,
          state.value,
          pincode.value
          )"/></a>
      </form>
    </div>
  </div>

  <iframe id="map_show" style="display:none;"></iframe><br>
  <div id="hidden" class="w3-padding-24 w3-center" onclick="arduinoRegister(client_id.value)" style="display:none;"><a class="w3-btn w3-margin w3-theme">NEXT</a></div>

  <!-- Footer -->
  <footer class="w3-container w3-theme-dark w3-padding-16 w3-margin-top">
    <p class="w3-center">Designed with care @ <a href="www.kccoe.org">KCCOE</a>. Special thanks to <b>Prof. Sonal Balpande</b></p>
  </footer>
  <script>
  function checkId(str) {
    if (str.length == 0) {
        document.getElementById("client_idErr").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var output = this.responseText;
              if(output == "User ID unavailable.") {
                document.getElementById("client_idErr").innerHTML = output
                document.getElementById("client_id").style.border="1px solid red";
              }else {
                document.getElementById("client_id").style.border="2px solid green";
              }
            }
        };
        xmlhttp.open("GET", "check.php?q=" + str, true);
        xmlhttp.send();
    }
  }


  function checkPassword(str){
    if(str.length == 0) {
      document.getElementById("passwordErr").innerHTML="";
    }else if(str.length > 8){
      document.getElementById("passwordErr").innerHTML="";
      document.getElementById("password").style.border="2px solid green";
    }else{
      document.getElementById("passwordErr").innerHTML="Minimum 8 characters long password required.";
      document.getElementById("password").style.border="1px solid red";
    }
  }

  var lat;
  var long;

  function generateLatLong(city,state,pincode){
    document.getElementById("map_show").style.display = "block";
    document.getElementById("hidden").style.display = "block";
    document.getElementById("map_show").style.overflow = "none";
    document.getElementById("map_show").style.border="none";
    document.getElementById("map_show").style.margin="0 10% 0 10%";
    document.getElementById("map_show").style.width="80%";
    document.getElementById("map_show").style.height="80%";
    document.getElementById("map_show").src ="map.php?city="+city+"&state="+state+"&pincode="+pincode;
  };


  function submitForm(id,pass,name,email,phone,addr1,addr2,city,state,pin){
    generateLatLong(city,state,pin);
    if(id.length == 0 || pass.lenght == 0 || name.length == 0 || email.length == 0 || phone.length == 0 || addr1.length == 0 || addr2.length == 0 || city.length == 0 || state.length == 0 || pin.length == 0) {
      document.getElementById("warning").innerHTML="Some field is left empty."
    }else{
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("warning").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "register.php?client_id="+id+"&password="+pass+"&name="+name+"&email="+email+"&contact_1="+phone+"&address1="+addr1+"&address2="+addr2+"&city="+city+"&state="+state+"&pincode="+pin+"", true);
      xmlhttp.send();
    }
  }

  function arduinoRegister(client_id) {
    window.location="register_arduino.php?client_id="+client_id;
  }
  </script>
</body>
</html>
