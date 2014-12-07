<?php
//Turn on error reporting
ini_set('diplay_errors', 'On');
include 'storedInfo.php';

session_start();

//Conects to the sql database
$mysqli=new mysqli("oniddb.cws.oregonstate.edu", "negashe-db", "$myPassword", "negashe-db");
if($mysqli-> connect_errno){
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

$problem = "";

if((isset($_POST['username'], $_POST['password']))){
  //Information from the form in useraccount.php to create a user
  $username = $_POST['username'];
  $password = $_POST['password'];
  if((!(empty($username))) && (!(empty($password)))){
	if(!($stmt2=$mysqli->prepare("SELECT username FROM travel_world WHERE username=?"))){
      echo "SELECT PREPARE failed: " . $stmt->errno . " " . $stmt->error;
    }
	if(!($stmt2->bind_param('s', $_POST['username']))){
	  echo "SELECT BIND PARAM failed: " . $stmt->errno . " " . $stmt->error;
	}
	//if the statement doesn't execute then we add new user
	if(!$stmt2->execute()){
	  echo "SELECT EXECUTE failed: " . $stmt->errno . " " . $stmt->error;	
    }
	if(!($stmt2->bind_result($dbusername))){
	  echo "Binding Results Failed: " . $mysqli->errno . " " . $mysqli->error;
	}
	$stmt2->fetch();
	if($username == $dbusername){
      $problem = "UserNameAlreadyExists";
	  $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/useraccount.php?problem=$problem";
      header($url);
      exit;	
	}
	else{
	  //Insert into the sql table a username and password. This will create an account.
      if(!($stmt1=$mysqli->prepare("INSERT INTO travel_world(username, password) VALUES (?,?)"))){
        echo "PREPARE FAILED: " . $stmt->errno . " " . $stmt->error;
      }
      //Binding the parameters to be used in the prepare statement
      if(!($stmt1->bind_param('ss', $_POST['username'], $_POST['password']))){
        echo "BINDING PARAMETERS FAILED: " . $stmt->errno . " " . $stmt->error;
      }
      //Execute the prepare statement
      if(!$stmt1->execute()){
        echo "EXECUTING FAILED: " . $stmt->errno . " " . $stmt->error;
      }
	  $_SESSION['loggedin'] = "YES";
      $_SESSION['name'] = $username;
      $url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/itinerary.php";
      header($url);
      exit;
	}
  }
  else{
    $problem = "BlankField";
	$url = "Location: http://web.engr.oregonstate.edu/~negashe/temp/Final%20Project/useraccount.php?problem=$problem";
    header($url);
    exit;  
  }
}
?>
