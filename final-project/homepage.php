<?php
//Turn on error reporting
ini_set('diplay_errors', 'On');
include 'storedInfo.php';
//Connect to the database
//NEED TO COMPLETE NEED TO COMPLETE NEED TO COMPLETE NEED TO COMPLETE NEED TO COMPLETE NEED TO COMPLETE NEED TO COMPLETE 
session_start();

$mysqli=new mysqli("oniddb.cws.oregonstate.edu", "negashe-db", "$myPassword", "negashe-db");
if($mysqli-> connect_errno){
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}
$problem = "";
if((isset($_POST['username'], $_POST['password']))){
  //Information from the form travellogin inputted by the user
  $username = $_POST['username'];
  $password = $_POST['password'];
  if((!(empty($username))) && (!(empty($password)))){
	   //Now check to see if the user input (username and password) is located within the database 
    if(!($stmt = $mysqli->prepare("SELECT username, password FROM travel_world WHERE username=?"))){
	  echo "Select Prepare Statement Failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("s", $_POST['username']))){
	  echo "Binding Username Failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->execute()){
	  echo "Executing the Select Statement Failed: " . $mysqli->errno . " " . $mysqli->error; 
	}
	if(!($stmt->bind_result($dbusername, $dbpassword))){
	  echo "Binding Results Failed: " . $mysqli->errno . " " . $mysqli->error;
	}
	
	$stmt->fetch();
		
	//inputs' user name and password match the database user name and password
	if($username == $dbusername && $password == $dbpassword){
      $_SESSION['loggedin'] = "YES";
      $_SESSION['name'] = $dbusername;
      $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/itinerary.php";
      header($url);
      exit;
    }
	//INVALID password doesn't match the database password
    if($username == $dbusername && $password != $dbpassword){
      $problem = "IncorrectPassword";
	  $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/travellogin.php?problem=$problem";
      header($url);
      exit;
    }
	//INVALID user name used sets problem to incorrect user name
    if($username != $dbusername){
      $problem = "IncorrectUserName";
	  $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/travellogin.php?problem=$problem";
      header($url);
      exit;
    }
  }
  else{
    $problem = "BlankField";
	$url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/travellogin.php?problem=$problem";
    header($url);
    exit;
  }
}
?>
