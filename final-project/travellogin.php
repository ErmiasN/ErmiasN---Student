<!DOCTYPE HTML>
<html>
<body>
	<head>
		<meta charset="UTF-8">
		<title>Travel LogIN</title>
		<link href="travel.css" rel="stylesheet" type="text/css">
	</head>
	<h1>Lets Travel the World</h1>
	<!--Form to login an existing user in the database-->
	<form class="one" method="post" action="homepage.php">
		<fieldset>
		<fieldset>
			Username:<input type="text" name="username">
		</fieldset>
		<fieldset> 
			Password:<input type="password" name="password">
		</fieldset>
		<p><input type="submit" value="Sign In"></p>
		</fieldset>
	</form>
	<!--Form to add a user to the database-->
	<form class="one" method="post" action="useraccount.php">
		<p><input type="submit" value="New User"></p>
	</form>
	<h5>OR Just Make Plans to...</h5>
	<?php
	//Uses $_GET to inform the user the type of error that occurred with his/her input
	$problem = $_GET['problem'];
	$errormsg= "<font color='red'> ERROR: ";
	//User uses a user name not in the database
	if($problem == "IncorrectUserName") {
	  $errormsg = $errormsg . " Incorrect User Name! ";
	}
	//User uses a password that doesn't match a user name
	if($problem == "IncorrectPassword"){
	  $errormsg = $errormsg . " Incorrect Password!";
	}
	//User leaves one of the fields blank
	if($problem == "BlankField"){
	  $errormsg = $errormsg . " No BLANK FIELDS!";
	}
	//User attempts to go to a page that required user to be logged in
	if($problem == "notLoggedIn"){
	  $errormsg = $errormsg . " You MUST FIRST LOGIN";
	}
	//Will print the error messages if problem isn't empty
	if($problem != ""){
	  print($errormsg);
	}
	?>
</body>
</html>
