<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-type: text/plain');

session_start();
if(isset($_GET['action']) && $_GET['action'] == 'end'){
  $_SESSION = array(); /*ends a session. Sets session to an empty array*/
  session_destroy();   /*destroys the session  id assisgned to the cookie*/
  /*Redirects user after ending the session*/
  $filePath = explode('/',$_SERVER['PHP_SELF'], -1);
  $filePath = implode('/',$filePath);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/Logout.html", true);
}

if(session_status() == PHP_SESSION_ACTIVE){
  if(isset($_GET['min-multiplicand'])){
    $_SESSION['min-multiplicand'] = $_GET['min-multiplicand'];
  }
  else{
    echo "min-multiplicand parameter missing." . "<br>";
  }

  if(isset($_GET['max-multiplicand'])){
    $_SESSION['max-multiplicand'] = $_GET['max-multiplicand'];
  }
  else{
    echo "max-multiplicand parameter missing." . "<br>";
  }

  if(isset($_GET['min-multiplier'])){
    $_SESSION['min-multiplier'] = $_GET['min-multiplier'];
  }
  else{
    echo "min-multiplier parameter missing." . "<br>";
  }

  if(isset($_GET['max-multiplier'])){
    $_SESSION[max-multiplier] = $_GET['max-multiplier'];
  }
  else{
    echo "max-multiplier parameter missing." . "<br>";
  }

  foreach($_SESSION as $key => $value){
    if(!(ctype_digit($_SESSION[$key]))){
      echo $key . " must be an integer." . "<br>";
    }
  }

  if($_SESSION['min-multiplicand'] > $_SESSION['max-multiplicand']){
    echo 'Minimum multiplicand is larger than the maximum multiplicand.' . '<br>';
  }
  if($_SESSION['min-multiplier'] > $_SESSION['max-multiplier']){
    echo 'Minimum multiplier is larger than the maximum multiplier.' . '<br>';
  }


echo '<p><h3>Multtable Table</h3></p>';
echo '<table border = 1>';

  echo "<tr><th></th>";
  for($i = $_SESSION['min-multiplicand']; $i <= $_SESSION['max-multiplicand']; $i++){
    echo '<td>' . $i . '</td>';
  }

  for($i = $_SESSION['min-multiplier']; $i <= $_SESSION['max-multiplier']; $i++){
    echo '<tr><td>' . $i . '</td>';
    for($j = $_SESSION['min-multiplier']; $j <= $_SESSION['max-multiplier']; j++){
      echo '<td> . $j * $i . </td>'
    }
    echo '</tr>'
  }
echo '</table>';
}

?>
