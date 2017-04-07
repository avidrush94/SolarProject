<!--*<!DOCTYPE html>
<html>
<title>Solar Solutions</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-navbar,h1,button {font-family: "Montserrat", sans-serif}
</style>
<body>
-->
<!-- Header
<header class="w3-container w3-blue w3-center w3-padding-128">
  <h1 class="w3-margin w3-jumbo">Arduino Registration</h1>
  <p class="w3-xlarge">Recieve system generated Arduino registration details</p>
</header>
-->
<!-- First Grid
<div class="w3-row-padding w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-twothird">
      <form class="w3-container w3-center" action="registeration_complete.php/?id='arduino'">
        <input class="w3-input w3-center" type="text" value="MAC address" readonly="readonly" id="mac_addr"><br>
        <input class="w3-input w3-center" type="text" value="IP address" readonly="readonly" id="ip_addr"><br>
        <input class="w3-btn w3-padding-16 w3-large w3-margin-top" type="button" onclick="generate_info()" value="Generate">
    </div>

    <div class="w3-third w3-center">
      <div class="w3-padding-32 w3-text-blue w3-margin-left w3-jumbo" style="font-size:200em"></div>
    </div>
  </div>
</div>
-->
<!-- Second Grid
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-third w3-center">
      <div class="w3-padding-32 w3-text-blue w3-margin-right w3-jumbo" style="font-size:200em"></div>
    </div>

    <div class="w3-twothird">
      <h1>Install A.S.U.S.</h1>
      <h5 class="">Arduino Sketch Upload Software</h5>

      <p class="w3-text-grey">Click on the button and Run the "Assign.jar" file from your computer.
        The file has an automated system that will setup your arduino to be connecting eassily with our servers and will be ready to use once assigned with to the respective client.
        Make sure that you download from this OFFICIAL & SAFE download only.</p>
        <h1 id="downloadBtn" onClick="download()">Dwonload</h1>
       <span id="download_status"></span>
    </div>
  </div>
</div>
-->

<!-- Footer
<footer class="w3-container w3-padding-64 w3-center w3-opacity">
  <div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
      <h1 class="w3-margin w3-xlarge">Developed with resposibility @ <a href="www.kccoe.org">KCCOE</a></h1>
  </div>
</footer>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

// Used to generate the mac address and ip address value
function generate_info(){
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
//	alert(macAddress);
    return showMacStatus(macAddress);
}
function showMacStatus(str) {
    if (str.length == 0) {
//        document.getElementById("mac_addr").innerHTML = "";
        return;
    } else {
       /* var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				if(this.responseText=="False"){
					generate_mac();
					}
            }
        };
        xmlhttp.open("GET", "getMacStatus.php?q=" + str, true);
        xmlhttp.send();*/

		$.ajax({
			type:"GET",
			url:"getMacStatus.php",
			data:"q=" + str,
			success: function(result){
				if(result == "False"){
				generate_mac();
				} else {
					$("#mac_addr").val(""+str);
					downloadFile("#mac_addr".value , "#ip_addr".value) ;
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
var strClient="j4585";
function downloadFile(strMac,strIp) {
  /*  if (strMac.length == 0 || strIp.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("download_status").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "write_file.php?file=" + str +""+ str2, true);
        xmlhttp.send();
    }
	*/

	$.ajax({
			type:"POST",
			url:"write_file.php",
			data:"mac=" + strMac + "&ip=" +strIp +"&clientId="+strClient,
			success: function(result){
				strClient=result;
			}
			});
}

$("#downloadBtn").click(function(e){
    e.preventDefault();//this will prevent the link trying to navigate to another page
    var href = $(this).attr("http://solarsolutions.esy.es/register.php");//get the href so we can navigate later

    //do the update

    //when update has finished, navigate to the other page
    window.location = href;
});
function Download() {
    document.getElementById('downloadBtn').href = "http://solarsolutions.esy.es/j4585.text";
};
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</body>
</html>
-->
