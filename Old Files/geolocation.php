<!--Google API key AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o-->
<?php $pincode=$_REQUEST["pincode"]; ?>
<html>
<head>
  <title>Solar Solutions</title>
</head>

<body>

  longitude_json_data <p id="longitude_json_data"></p>
  latitude_json_data <p id="latitude_json_data"></p>

</body>

<script>

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        myObj = JSON.parse(this.responseText);
        document.getElementById("longitude_json_data").innerHTML = myObj.results[0].geometry.location.lng;
        document.getElementById("latitude_json_data").innerHTML = myObj.results[0].geometry.location.lat;
    }
};
xmlhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?address=<?php echo $pincode; ?>+400605&key=AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o", true);
xmlhttp.send();

</script>

</html>
