<?php

$currentArray = array();

$correct = 0

if(isset($_GET['min-multiplicand'])){
  $currentArray = ($_GET['min-multiplicand']);
}
else{
  echo "min-multiplicand parameter missing. <br>";
  $correct++;
}
if(isset($_GET['max-multiplicand'])){
  $currentArray = ($_GET['max-multiplicand']);
}
else{
  echo "max-multiplicand parameter missing. <br>";
  $correct++;
}
if(isset($_GET['min-multiplier'])){
  $currentArray = ($_GET['min-multiplier']);
}
else{
  echo "min-multiplier parameter missing. <br>";
  $correct++;
}
if(isset($_GET['max-multiplier'])){
  $currentArray = ($_GET['max-multiplier']);
}
else{
  echo "max-multiplier parameter missing. <br>";
  $correct++;
}

foreach($currentArray as $key => $value){
  if(!(ctype_digit($currentArray[$key]))){
    echo $key . " must be an integer. <br>";
    $correct++;
  }
}

if($currentArray['min-multiplicand'] > $currentArray['max-multiplicand']){
  echo 'Minimum multiplicand is larger than the maximum multiplicand.';
}
if($currentArray['min-multiplier'] > $currentArray['max-multiplier']){
  echo 'Minimum multiplier is larger than the maximum multiplier.';
}



if($correct == 0){

  $Tall = ($currentArray['max-multiplicand'] - $currentArray['min-multiplicand']) + 2;
  $Wide = ($currentArray['max-multiplier'] - $currentArray['min-multiplier'])+2;

  echo '<p><h3>Multtable Table<h3>
  <p>
  <table border = "1">
  <tr><th></th>';

  for($i = 0; $i < $WIDE; $i++){
    for($j = 0; $j < $Tall; $j++){
      if($i == 0 && $j == 0){
        echo "<thead><th></th>";
      }
      else if($i = 0){
        echo "<th>" . ($currentArray['max-multiplicand']) . "</th>";
      }
    }
  }
    
echo '<table>';
}

?>
