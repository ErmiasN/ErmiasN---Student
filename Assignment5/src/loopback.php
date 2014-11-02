<?php
error_reporting(E_ALL);
ini_set('display_erros', 1);
header('Content-type: text/plain');

$ArrayKeys = array();

$ArrayKeys['Type'] = $_SERVER['REQUEST_METHOD'];

if($ArrayKeys['Type'] === 'GET'){
  foreach($_GET as $key=> $value){
    $ArrayKeys[$key] = $value; 
  }
}

if($ArrayKeys['Type'] === 'POST'){
  foreach($_POST as $key=> $value){
    $ArrayKeys[$key] = $value; 
  }
}

if(empty($_GET) && empty($_POST)){
  $input['parameters'] = null;
}

echo JSON_encode($ArrayKeys);

?>
