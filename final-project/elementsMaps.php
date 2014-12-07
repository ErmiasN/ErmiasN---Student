<?php
//Turn on error reporting
ini_set('diplay_errors', 'On');
include 'storedInfo.php';
//Connect to the database

//If user access web page without signing in we will send user back to login page: travellogin.php
session_start();
if(!$_SESSION['loggedin']){
  header("location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/travellogin.php?problem=notLoggedIn");
  exit;
}

$name = $_SESSION['name'];
$country = $_SESSION['country'];

$mysqli=new mysqli("oniddb.cws.oregonstate.edu", "negashe-db", "$myPassword", "negashe-db");
if($mysqli-> connect_errno){
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

echo "<!DOCTYPE html>
<html>
<body>
<head>
  <title>Travelling coordinates</title>
  <link href='travel.css' rel='stylesheet' type='text/css'>  
  <script src='http://openlayers.org/en/v3.0.0/build/ol.js' type='text/javascript'></script>
  <link rel=\"stylesheet\" href=\"http://openlayers.org/en/v3.0.0/css/ol.css\" type=\"text/css\">
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css\">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
	  body {
	    background-color: lightblue;
	  }
	  table {
	    border:ridge black 1px;
        background-color:white;
	  }
	  td{
        border:ridge black 1px;
      }
    </style>
</head>
<body>
  <h2>Travelling Map</h2>
  <br>";

$country = $_SESSION['country'];
$url = "http://api.openweathermap.org/data/2.5/weather?q=$country";

$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$data = json_decode(curl_exec ($curl));
curl_close ($curl);
$lat = $data->coord->lat;
$lon = $data->coord->lon;

echo "
<div id=\"map\" class=\"map\"></div>
<script type=\"text/javascript\">
var marker = new ol.Feature({ /**coords replaced by $lon,$lat**/
  geometry: new ol.geom.Point(ol.proj.transform([$lon, $lat], 'EPSG:4326', 'EPSG:3857'))
});

var markerStyle = new ol.style.Style({
  image: new ol.style.Icon(({
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    anchor: [0.5,512],
    opacity: 0.7,
    scale: 0.1,
    src: 'images/midIcon.png'
  }))
}); 

marker.setStyle(markerStyle);

var markerSource = new ol.source.Vector({
  features: [marker]
});

var markerLayer = new ol.layer.Vector({
  source: markerSource
});

var satelliteLayer = new ol.layer.Tile({
  source: new ol.source.MapQuest({layer: 'sat'})
});

var streetLayer = new ol.layer.Tile({
  source: new ol.source.MapQuest({layer: 'hyb'})
});

var map = new ol.Map({
  layers: [satelliteLayer, streetLayer, markerLayer],
  target: document.getElementById('map'),
  view: new ol.View({
    center: ol.proj.transform([$lon, $lat], 'EPSG:4326', 'EPSG:3857'), /**coords replaced by $lon,$lat**/
    zoom: 12
  })
});
</script>
	<table>
		<tr>
		  <td>Country</td>
		  <td>Travel Plans</td>
		  <td>Spoken Language</td>
		  <td>Number of Days</td>
		</tr>";
		if(!($stmt=$mysqli->prepare("SELECT country, tmethod, lang, daysStayed FROM travel_world WHERE username = ?"))){
		  echo "PREPARE DIDN'T WORK: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param('s', $name))){
		  echo "BIND_PARAM DIDN'T WORK: " . $stmt->errno . " " . $stmt->error;
		}
		if(!$stmt->execute()){
		  echo "EXECUTION DIDN'T WORK: " . $stmt->errno . " " . $stmt->error; 
		}
		if(!($stmt->bind_result($countries, $tmethod, $lang, $daysStayed))){
		  echo "BINDiNG RESULT DIDN'T WOrk: " . $stmt->errno . " " . $stmt->error;
		}
		while($stmt->fetch()){
		  echo "<tr>\n<td>\n" . $countries . "\n</td>\n<td>\n" . $tmethod . "\n</td>\n<td>\n" . $lang . "\n</td>\n<td>\n" . $daysStayed . "\n</td>\n</tr>";
		}
	echo "</table>
	<br>
	<p>Lets Go! LIKE RIGHT NOW! WHO cares if you have work or family?</p>
	<br>
	<form class='one' method='post' action='loggedout.php'>
		<p><input type='submit' value='Sign Out'></p>
	</form>
	<br>
</body>
</html>";
?>
