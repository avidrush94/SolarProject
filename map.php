<?php
$latitude=$_REQUEST["latitude"];
$longitude=$_REQUEST["longitude"];
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
    body{
      margin:0;
      padding:0;
    }
       #map {
        height: 400px;
        width: 100%;
        margin:0;
        padding:0;
       }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $latitude; ?>, lng: <?php  echo $longitude; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFHFn2yDfzTTXYlHKOoC1UYB96qGELP3o&callback=initMap">
    </script>
  </body>
</html>
