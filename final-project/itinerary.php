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

$mysqli=new mysqli("oniddb.cws.oregonstate.edu", "negashe-db", "$myPassword", "negashe-db");
if($mysqli-> connect_errno){
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}
$problem = "";
//user submits form on this page
if($_POST){
  //Makes sure that the values from the submit have been set
  if((isset($_POST['country'], $_POST['tmethod'], $_POST['lang'], $_POST['daysStayed']))){
    $country = $_POST['country'];
	$tmethod = $_POST['tmethod'];
	$lang = $_POST['lang'];
	$daysStayed = $_POST['daysStayed'];
	//Makes sure that the values are not empty 
	if((!(empty($country)))&&(!(empty($tmethod)))&&(!(empty($lang)))&&(!(empty($daysStayed)))){
	  if(is_numeric($daysStayed)){
        if(!($stmt=$mysqli->prepare("UPDATE travel_world SET country=?, tmethod=?, lang=?, daysStayed=? WHERE username=?")))
		{
		  echo "PRepare FAiled: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param('sssis', $country, $tmethod, $lang, $daysStayed, $name))){
		  echo "BInding PArameters: " . $stmt->errno . " " . $stmt->error;
		}
		if(!$stmt->execute()){
		  echo "EXecute: " . $stmt->errno . " " . $stmt->error;
		}
		//Will send you to the elementsMaps.php page that will output a map of the country you wish to attend
		$_SESSION['loggedin'] = "YES";
        $_SESSION['name'] = $name;
		$_SESSION['country'] = $country;
        $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/elementsMaps.php";
        header($url);
      exit;
	  }
	  //If value for daysStayed is not a numeric will send a message through url 
	  else{
        $problem = "useAInteger";
	    $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/itinerary.php?problem=$problem";
        header($url);
		exit;
      }
    }
	//If values are empty informs the user sending a message through url.
    else{
      $problem = "BlankField";
	  $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/itinerary.php?problem=$problem";
      header($url);
      exit;    
    }  
  }
}


?>

<!DOCTYPE html>
<html>
<body>
	<head>
		<title>Itinerary</title>
		<link href="travel.css" rel="stylesheet" type="text/css">
<!-- NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE  -->
		<link rel="stylesheet" href="http://openlayers.org/en/v3.0.0/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="http://openlayers.org/en/v3.0.0/build/ol.js" type="text/javascript"></script>
<!-- NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE  -->
	</head>
	<p class="two">Hello <?php echo $name;?></p>
	<p><b>Future Travels</b><br> Now where would you like to travel today? Cause this map is the closest your gonna get!</p>

	<form class="one" action="" method="post">
		<fieldset>
			<fieldset>
				Country of Travel: <input type="text" name="country">
			</fieldset>
			<fieldset>
				Travel Method: <input type="text" name="tmethod">
			</fieldset>
			<fieldset>
				Primary Language of Country: <input type="text" name="lang">
			</fieldset>
			<fieldset>
				Days you will stay: <input type="text" name="daysStayed">
			</fieldset>
		</fieldset>
		<p><input type="submit" value="Add Elements"></p>
	</form>
	<?php
	//Uses $_GET to inform the user the type of error that occurred with his/her input
	$problem = $_GET['problem'];
	$errormsg= "<font color='red'> ERROR: ";
	//User leaves one of the fields blank
	if($problem == "BlankField"){
	  $errormsg = $errormsg . " No BLANK FIELDS!";
	}
	//User attempts to input a string for an integer.
	if($problem == "useAInteger"){
	  $errormsg = $errormsg . " You MUST ENTER AN INTEGER VALUE for days you will stay";
	}
	//Will print the error messages if problem isn't empty
	if($problem != ""){
	  print($errormsg);
	}
	?>
<!-- NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE  -->	
    <div id="map" class="map"></div>
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.MapQuest({layer: 'sat'})
          })
        ],
        view: new ol.View({
          center: ol.proj.transform([37.41, 8.82], 'EPSG:4326', 'EPSG:3857'),
          zoom: 4
        })
      });
    </script>
<!-- NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE NEW CODE  -->
	<!--Button will sign out user by sending them to loggedout.php web page -->
	<form class="one" method="post" action="loggedout.php">
		<p><input type="submit" value="Sign Out"></p>
	</form>
</body>
</html>
