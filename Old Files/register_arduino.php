<html>
<head>
  <title>Solar Solutions</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="resources/ss-css.css">
  <link rel="stylesheet" href="resources/ss-theme-css.css">
  <script src="https://use.fontawesome.com/04dafedc6e.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
  </header>


  <!-- First Grid -->
  <div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
      <div class="w3-half">
        <form class="w3-container w3-center" action="registeration_complete.php/?id='arduino'">
          <input class="w3-input w3-center" type="text" value="MAC address" readonly="readonly" id="mac_addr"><br>
          <input class="w3-input w3-center" type="text" value="IP address" readonly="readonly" id="ip_addr"><br>
        </form>
      </div>
      <div class="w3-half w3-center">
        <input class="w3-btn w3-padding-16 w3-large w3-margin-top" type="button" onclick="generate_info()" value="Generate">
        <a class="w3-btn w3-padding-16 w3-large w3-margin-top disabled" id="download" download>Download</a>
        <br><p> Right Click and "Download" the File</p>
      </div>
    </div>
  </div>

  <div class="w3-text-theme w3-padding-24 w3-center w3-xxlarge"><span id="notify">Generate Mac and IP first</span></div>

  <!-- Footer -->
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
            writeFile("#mac_addr".value , "#ip_addr".value) ;
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

var strClient="<?php $client_id=$_REQUEST["client_id"]; echo $client_id; ?>";
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
  document.getElementById("download").href="http://solarsolutions.esy.es/"+strClient+".ino";
}

</script>

</body>
</html>
