<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$currentArray = array();
k
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
  $minMult = $currentArray['min-multiplier'];
  $maxMult = $currentArray['max-multiplier'];
  $minAnd = $currentArray['min-multiplicand'];
  $maxAnd = $currentArray['max-multiplicand'];
  $minimumMult = $currentArray['min-multiplier']

  echo '<p><h3>Multtable Table<h3>
  <p>
  <table border = "1">
  <tr><th></th>';

  for($i = 0; $i < $Wide; $i++){
    for($j = 0; $j < $Tall; $j++){
      if($i == 0 && $j == 0){
        //prints the empty upper left corner cell
        echo "<thead><th></th>";
      }
      else if($i == 0 && $j > 0){
        echo "<th>" . ($minMult++) . "</th>";
      }
      else if($j == 0  && $i > 0){
        echo "<tr>" . ($minAnd++) . "</tr>";
      }
      else if($i > 0 && $j > 0){
        $product = (($minimumMult + $i - 1) * $minAnd);
        echo "<tr><td>" . $product . "</td></tr>";
      }
      else{
        echo "<td></td>"
      }
    }
  }
    
  echo "</table>";
}

?>
