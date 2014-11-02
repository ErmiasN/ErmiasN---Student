<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if(isset($_GET['action']) && $_GET['action'] == 'end'){
  $_SESSION = array(); /*ends a session. Sets session to an empty array*/
  session_destroy();   /*destroys the session  id assisgned to the cookie*/
  /*Redirects user after ending the session*/
  $filePath = explode('/',$_SERVER['PHP_SELF'], -1);
  $filePath = implode('/',$filePath);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
  header("Location: {$redirect}/login.php", true);
  die();
}

echo'<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>WELCOME</title>
  </head>
  <body>
    <form action="content.php" method="POST">
      Username: <input type="text" name="username"><br>
      <input type="submit" value="Login">
     </form>
   </body>
</html>';

?>
