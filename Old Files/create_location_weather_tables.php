<input type="text" id="longitude_ip">
<input type="text" id="latitude_ip">
<input type="button" value="upload to DB" onclick="uploadThis(longitude_ip.value,latitude_ip.value)">
<p><span id="alert"></span></p>
<script>
function uploadThis(longi,lat){
  var xhttp;
  if(longi.length == 0 || lat.length == 0){
    document.getElementById("alert").innerHTML="Longitude or Latitude is Empty";
    return;
  }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("alert").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "update_location_and_weather.php?longitude="+longi+"&latitude="+lat , true);
    xhttp.send();
  }
</script>
