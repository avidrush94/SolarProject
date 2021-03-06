<?php
include "config.php";
$user=$_REQUEST["client_id"];

//php code to get pincode
$sql = "SELECT * FROM client_info WHERE client_id='".$user."';";
$loginResult = $conn->query($sql);
if ($loginResult->num_rows == 1) {
  while($row = $loginResult->fetch_assoc()) {
    $pincode=$row["pincode"];
  }
}

$sql2 = "SELECT date_log,mac_addr,ip_addr FROM arduino_info WHERE client_id='".$user."';";
$loginResult2 = $conn->query($sql2);
if ($loginResult2->num_rows == 1) {
  while($row2 = $loginResult->fetch_assoc()) {
    $mac_addr=$row2["mac_addr"];
    $ip_addr=$row2["ip_addr"];
    $date_log=$row2["date_log"];
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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  <!--Script to load the Line Graph using ChartJS-->
  <!-- javascript -->
    <script src="resources/Chart.min.js"></script>
    <script>
    window.setInterval(function(){
    	$.ajax({
    		url : "fetch_chart_data.php?client_id=<?php echo $user; ?>",
    		type : "GET",
    		success : function(data){
    			console.log(data);

    			//var id = [];
    			var date_log = [];
    			var voltage = [];
    			var current = [];

    			for(var i in data) {
    				//id.push("id " + data[i].id);
    				date_log.push(data[i].date_log);
    				voltage.push(data[i].voltage);
    				current.push(data[i].current);
    			}

    			var chartdata = {
    				labels: date_log,
    				datasets: [
    					/*{
    						label: "Date_log",
    						fill: false,
    						lineTension: 0.1,
    						backgroundColor: "rgba(59, 89, 152, 0.75)",
    						borderColor: "rgba(59, 89, 152, 1)",
    						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
    						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
    						data: date_log
    					},*/
    					{
    						label: "Voltage",
    						fill: false,
    						lineTension: 0.1,
    						backgroundColor: "rgba(29, 202, 255, 0.75)",
    						borderColor: "rgba(29, 202, 255, 1)",
    						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
    						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
    						data: voltage
    					},
    					{
    						label: "Current",
    						fill: false,
    						lineTension: 0.1,
    						backgroundColor: "rgba(211, 72, 54, 0.75)",
    						borderColor: "rgba(211, 72, 54, 1)",
    						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
    						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
    						data: current
    					}
    				]
    			};

          var ctx = $("#mycanvas");

    			var LineGraph = new Chart(ctx, {
    				type: 'line',
    				data: chartdata
    			});
    		},
    		error : function(data) {

    		}
    	});
    },10000);
</script>

  <!--Script to continiously load the latest Voltage and Current values-->
  <script>
  window.setInterval(fetch_data, 10000);

  function fetch_data() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        myObj = JSON.parse(this.responseText);
        document.getElementById("volt_op").innerHTML = myObj.voltage;
        document.getElementById("curr_op").innerHTML = myObj.current;
        document.getElementById("time_op").innerHTML = myObj.date_log;
      }
    };
    xhttp.open("GET", "/fetch_info.php?client_id=<?php echo $user; ?>", true);
    xhttp.send();
  }
  </script>

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
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("arduino_download").style.display = "block";
          document.getElementById("arduino").style.display = "none";
          document.getElementById("arduino_download").href="http://solarsolutions.esy.es/"+strClient+".ino";
          document.getElementById("arduino_download").onclick="document.execCommand('SaveAs','1','"+strClient+".ino')";
        }
      };
      xhttp.open("GET", "/write_file.php?mac=<?php echo $mac_addr; ?>&ip=<?php echo $ip_addr; ?>&client_id=<?php echo $user; ?>", true);
      xhttp.send();
    }
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
    <div class="w3-half w3-border-theme w3-padding" style="background-color:#07889b;color:white">
      <div style="font-size:20px">
        <h3>Arduino</h3>
        <a id="arduino" class="w3-right" style="font-size:45px;" onclick="generate_info()">
          <i class="fa fa-download" aria-hidden="true" style="font-size:25px;"></i>
          Click
        </a>
        <a id="arduino_download" class="w3-right" style="display:none;font-size:45px;text-decoration:none;" download>
          Download
        </a>
      </div>
    </div>

    <!--Current Date and Time-->
    <div class="w3-half w3-border-theme w3-padding" style="background-color:#07889b;color:white">
      <div style="font-size:20px">
        <h3>Time & Date </h3>
        <span id="savings" class="w3-right" style="font-size:45px;">
          <i class="fa fa-calendar" aria-hidden="true" style="font-size:25px;"></i>
          <?php echo date("m-d-y");?>
        </span>
      </div>
    </div>

  </div>

  <!--Voltage Current Line Graph-->
    <div class="w3-container">
      <div class="w3-threequarter">
        <div class="chart-container" style="margin-right:40px;">
          <canvas id="mycanvas"></canvas>
        </div>

      </div>

      <div class="w3-quarter">
        <iframe id="mapFrame" style="height: 400px; border:0px; margin:0px; padding:0px;" alt="Loading MAP"></iframe>
      </div>
    </div>

    <div id="status_details">
      <div class="w3-third">Voltage :<span id="volt_op" /></div>
      <div class="w3-third">Current :<span id="curr_op" /></div>
      <div class="w3-third">Time :<span id="time_op" /></div>
    </div>
    <br>

  <!-- Footer -->
  <footer class=" w3-theme-dark w3-padding-16 w3-margin-top">
    <p class="w3-center">Designed with care @ <a href="www.kccoe.org">KCCOE</a>. Special thanks to <b>Prof. Sonal Balpande</b></p>
  </footer>

</body>
</html>
