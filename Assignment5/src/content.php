<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Context-Type: text/plain');

session_start();
if($_SERVER['REQUEST_METHOD'] != 'POST'){
  session_destroy();   
  $filePath = explode('/',$_SERVER['PHP_SELF'], -1);
  $filePath = implode('/',$filePath); 
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/login.php", true);
}

if(session_status() == PHP_SESSION_ACTIVE){
  if(isset($_POST['username'])){
    $_SESSION['name'] = $_POST['username'];
  }
  
  if(!isset($_SESSION['visits'])){
    $_SESSION['visits'] = 0;
  }

  $_SESSION['visits']++;

  if(!(empty($_SESSION['name']))){
    echo "Hello $_SESSION[name], you have visited this page " . ($_SESSION['visits'] - 1) . " times. <br> 
    Click <a href='login.php?action=logout'>here</a> to logout.";
  }
}

?>
