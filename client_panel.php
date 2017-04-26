<?php
include "config.php";
$user=$_REQUEST["client_id"];

//php code to get pincode
$sql = "SELECT * FROM client_info WHERE client_id='".$user."';";
$loginResult = $conn->query($sql);
if ($loginResult->num_rows == 1) {
  while($row = $loginResult->fetch_assoc()) {
    $pincode=$row["pincode"];

    //echo $pincode;

  }
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="resources/ss-css.css">
  <link rel="stylesheet" href="resources/ss-theme-css.css">
  <script src="https://use.fontawesome.com/04dafedc6e.js"></script>

    <!--Script to load MAP-->
    <script>
    var longitude;
    var latitude;
    setTimeout(dummy,1000);
    function dummy(){
      var p = "<?php echo $pincode;?>";
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              myObj = JSON.parse(this.responseText);
              longitude = myObj.results[0].geometry.location.lng;
              latitude = myObj.results[0].geometry.location.lat;
          }
      };
      xmlhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?address="+p+"&key=AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o", true);
      xmlhttp.send();

      setTimeout(dummy2,2000);
    }
    function dummy2() {
      var url = "/map.php?latitude="+latitude+"&longitude="+longitude;
      document.getElementById('mapFrame').src = url;
    }
    </script>


    <!--Arduino Code Download genertion system-->
    <script>
    // Used to generate the mac address and ip address value
    function generate_info() {
      var strClient="<?php echo $user; ?>";
      var res;
      function writeFile(strMac,strIp) {
        $.ajax({
          type:"POST",
          url:"write_file.php",
          data:"mac=" + strMac + "&ip=" +strIp +"&clientId="+strClient,
          success: function(result){
            res=result;
          }
        });
        document.getElementById("arduino_download").style.display = "block";
        document.getElementById("arduino").style.display = "none";
        document.getElementById("arduino_download").href="http://solarsolutions.esy.es/"+strClient+".ino";
        document.getElementById("arduino_download").onclick="document.execCommand('SaveAs','1','"+strClient+".ino')";
      }
    }
    </script>

    <!--Manual Panel Control Mechanism-->
    <script>
    $("#manual_control_iframe").scroll( function() {
      var scrolled_val = $(document).scrollTop().valueOf();
      alert(scrolled_val+ ' = scroll value');
    });
    </script>
</head>
<body>
  <!--Navigation bar-->
  <div class="w3-topnav">
    <a href="#myHeader"><i class="fa fa-home w3-text-theme w3-left" style="font-size:30px;"></i></a>
    <a href="#myHeader" class="w3-text-theme w3-center" style="font-size:20px;"><?php echo $user; ?></a>
    <a href="logout.php"><i class="fa fa-sign-out w3-text-theme w3-right" style="font-size:30px"></i></a>
  </div>

  <div id="status">

    <!--Arduino Code Download-->
    <div class="w3-third w3-border-theme w3-padding" style="background-color:#07889b;color:white">
      <div style="font-size:20px">
        <h3>Arduino</h3>
        <span id="arduino" class="w3-right" style="font-size:45px;" onclick="generate_info()">
          <i class="fa fa-download" aria-hidden="true" style="font-size:25px;"></i>
          Click
        </span>
        <a id="arduino_download" class="w3-right" style="display:none;font-size:45px;text-decoration:none;" download>
          Download
        </a>
      </div>
    </div>


    <!--Current Total Savings-->
    <div class="w3-third w3-border-theme w3-padding" style="background-color:#07889b;color:white">
      <div style="font-size:20px">
        <h3>Savings</h3>
        <span id="savings" class="w3-right" style="font-size:45px;">
          <i class="fa fa-inr" aria-hidden="true" style="font-size:25px;"></i>
          53
        </span>
      </div>
    </div>


    <!--Current Date and Time-->
    <div class="w3-third w3-border-theme w3-padding" style="background-color:#07889b;color:white">
      <div style="font-size:20px">
        <h3>Time & Date </h3>
        <span id="savings" class="w3-right" style="font-size:45px;">
          <i class="fa fa-calendar" aria-hidden="true" style="font-size:25px;"></i>
          <?php echo date("m-d");?>
        </span>
      </div>
    </div>

  </div>

  <!--<div id="status">

    Pie Chart for efficiency level
    <div class="w3-third w3-border-theme w3-padding w3-text-theme" >
      <div style="font-size:20px">
        <h3>Efficiency</h3>
        <div id="piechart" style="height:300px;"></div>
      </div>
    </div>


    Manual Panel Controlls
    <div class="w3-third w3-border-theme w3-padding w3-text-theme" >
      <div style="font-size:20px">
        <h3>Controls</h3>
        <iframe id="manual_control_iframe" style="height:300px;width:400px;overflow:scroll;border:0;" src="manual_control.php"></iframe>
        </div>
      </div>


    Latest Voltage and Current Outputs & Panel Status
    <div class="w3-third w3-border-theme w3-padding w3-text-theme" >
      <div style="font-size:20px">
        <h3>Panel Stats</h3>
        <span id="stats" class="w3-right" style="font-size:45px;">
          <i class="fa fa-calendar" aria-hidden="true" style="font-size:25px;"></i>
          echo date("m-d");
        </span>
      </div>
    </div>

  </div>-->


  <!-- Footer -->
  <footer class=" w3-theme-dark w3-padding-16 w3-margin-top">
    <p class="w3-center">Designed with care @ <a href="www.kccoe.org">KCCOE</a>. Special thanks to <b>Prof. Sonal Balpande</b></p>
  </footer>

</body>
</html>
