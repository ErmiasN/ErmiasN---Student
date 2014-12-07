<!DOCTYPE HTML>
<html>
<body>
	<head>
		<meta charset="UTF-8">
		<title>User Account Setup</title>
		<link href="travel.css" rel="stylesheet" type="text/css">
	</head>
	
	<h1>Create your Travel Account</h1>
	
	<form class="one" method="post" action="adduser">
		<fieldset>
			<fieldset>
				User Name: <input type="text" name="username">
			</fieldset>
			<fieldset>
				Password: <input type="password" name="password">
			</fieldset>	
		</fieldset>
		<input type="submit" value="Add User">
	</form>
	<?php
	//Uses $_GET to inform the user the type of error that occurred with his/her input
	$problem = $_GET['problem'];
	$errormsg= "<font color='red'> ERROR: ";
	//User uses a user name not in the database
	if($problem == "UserNameAlreadyExists") {
	  $errormsg = $errormsg . " User Name Already Exists! ";
	}
	//User leaves one of the fields blank
	if($problem == "BlankField"){
	  $errormsg = $errormsg . " No BLANK FIELDS!";
	}
	//Will print the error messages if problem isn't empty
	if($problem != ""){
	  print($errormsg);
	}
	?>
</body>
</html>
