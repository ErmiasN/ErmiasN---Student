<?php
echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Grocery List</title>
  <link href="styleS.css" rel="stylesheet" type="text/css">
</head>';

ini_set('display_errors', 'On');
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "negashe-db", "$myPassword", "negashe-db");
if($mysqli-> connect_errno){
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}
else{
  echo "Connection Worked!<br>";
}
$groceryArray = array();
//Form to add items was submitted
if($_POST){
  if((isset($_POST['name'], $_POST['category'], $_POST['price']))){
    $name = $_POST['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	  if((!(empty($name))) && (!(empty($category))) && (!(empty($price)))){
	    echo " ";
	    if(is_numeric($price) && $price < 1000){
		  echo " ";
		  if(!($stmt = $mysqli->prepare("INSERT INTO groceryList (name, category, price) VALUES (?, ?, ?)"))){
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		  }
          if(!$stmt->bind_param('ssd', $name, $category, $price)){
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		  }
          if(!$stmt->execute()){
		    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			if($mysqli->errno == 1062){
			  echo " Names are unique keys. You can not enter duplicate names.";
			}
		  }		  
		}
		else{
		  echo "Price is an invalid entry. Must be an integer value and less than $1000.";
		}		
	  }
	  else{
	    echo "All fields need to be filled to add to the Grocery List.";
	  }
  }
}
//Will delete a row using the string name 
if($_POST){
  if((isset($_POST['deleteId']))){
    $id = $_POST['deleteId'];
    $stmt = $mysqli->prepare("DELETE FROM groceryList WHERE name=(?)");
	$stmt->bind_param('s', $id);
	if(!($stmt->execute())){
	  echo "Execution of delete failed ";
	}
  }
}

//Query used to populate the html tables
$result = $mysqli->query("SELECT * FROM groceryList");

//DELETE the entire mySQL table
if($_POST){
  if(isset($_POST['deleteItAll'])){
	$stmt = $mysqli->prepare("DELETE FROM groceryList");
	if(!($stmt->execute())){
	  echo "Execution to delete entire table failed";
	}
  }
}

//Query used to populate the category drop down
$Categresult = $mysqli->query("SELECT DISTINCT category FROM groceryList");

//Changes the price of the chosen category
if($_POST){
  if((isset($_POST['change'])) && isset($_POST['dropDown'])){
    $change = (int)$_POST['change'];
	$dropD = $_POST['dropDown'];
	if(is_numeric($change)){
	  $newChange = ($change/100);
	  $newPrices = $mysqli->prepare("UPDATE groceryList SET price = (price * (?)) WHERE category = (?)");
	  $newPrices->bind_param('ds', $newChange, $dropD);
	  if(!($newPrices->execute())){
	    echo "Failed to change Prices";
	  }
	}
  }
}
?>
<div>
  <form action="" method="post">
	<fieldset>		<!--PRINTS a Table for user to input table attributes -->
	  <legend>Add to Grocery List</legend>
	  Product: <input type="text" name="name" id="name">
	  Category: <input type="text" name="category" id="category">
	  Price: <input type="text" name="price" id="price">
	</fieldset>
	<p><input type="submit" value="Add"/></p>
  </form>
</div>
<table>
  <thead>
    <tr> <!--Header of each column attribute -->
	  <th>ID</th>
	  <th>Name</th>
	  <th>Category</th>
	  <th>Price</th>
	  <th>Remove Row</th>
	</tr>
  </thead>
  <tbody>
    <?php
	  while($row = mysqli_fetch_array($result)){
	?>
	    <tr> <!-- Prints the mysql table to the html table -->
		  <td> <?php echo $row['id'];?> </td>
		  <td> <?php echo $row['name'];?> </td>
		  <td> <?php echo $row['category'];?> </td>
		  <td> <?php echo $row['price'];?> </td>
		  <td><form action="" method="post"> <!-- Form used to delete a single row by passing name attribute of sql table-->
		  <button type="submit" value="<?php echo $row['name'];?>" name="deleteId">Remove</button></td>
	    </tr>
    <?php		
	  }
	?>
  </tbody>
</table>
  <form action="" method="post">
    <table>
	  <p></p>
      <legend>PRESS TWICE TO DELETE ENTIRE TABLE?</legend>
      <button type="submit" value="deleteTable" name="deleteItAll">Delete All Products</button>
	  <p></p>
	</table>
  </form>
  <table>
    <form action="" method="post">
	  <fieldset>
	    <legend>Price Change</legend>
		<select name="dropDown">
		    <?php
		      while($Categ = mysqli_fetch_array($Categresult)){
		    ?>
		        <option value="<?php echo $Categ['category'];?>"><?php echo $Categ['category'];?></option>
		    <?php
		      }
		    ?>
	    </select>
		<label for="percent">Enter a Percent value</label>
		<input type="text" name="change">
		<input type="submit" name="Alter Price">
      </fieldset>
	</form>
  </table>
</html>
