<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$filePath = explode('/', $_SERVER['HTTP_REFERER']);

if(!($path[count($path)-1] == "login.php") && $_SESSION['VISITS'] < 1){
  session_destroy();   /*destroys the session  id assisgned to the cookie*/
  $filePath = explode('/',$_SERVER['PHP_SELF'], -1);
  $filePath = implode('/',$filePath); 
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/login.php", true);
  die(); 
}

if($_POST['username'] == null){
  echo 'A username must be entered.';
  echo 'Click here <a href="login.php"> here </a> to return the login screen.';
}
else{
  if(session_status() == PHP_SESSION_ACTIVE){
    if(isset($_POST['username'])){
      $_SESSION['name'] = $_POST['username'];
    }
    if(!isset($_SESSION['visits'])){
      $_SESSION['visits'] = 0;
    }    

    $_SESSION['visits']++;
    echo "Hi $_SESSION[username], you have visited this site $_SESSION[]visits times. \n";

    echo "Click here <a href="login.php?action=end"> here </a> to logout."
  }
}

?>
