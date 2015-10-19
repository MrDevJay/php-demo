<?php
	
	//includes
	include_once ('php_modules/config.php');
	include_once ('php_modules/db_connection.php');

	include_once 'html_modules/header.php';
	include_once 'html_modules/javascripts.php';
	
	//generals
	$message = $register_message;
		
	//login form send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	    $benutzername = $_POST['benutzername'];
	    $passwort = $_POST['passwort'];
	    $passwortWdh = $_POST['passwortWdh'];
	    
	    //redirect
	    $hostname = $_SERVER['HTTP_HOST'];
	    $path = dirname($_SERVER['PHP_SELF']);
	
	    //some verifications
	    $sql_if_user_exists = "SELECT * from '".$mysql_table_users."' WHERE user='".$benutzername."'";
	    $user_exists = mysqli_query($mysqli, $sql_if_user_exists);
	    echo $user_exists;
	    if ($benutzername=="" || $passwort=="" || $passwortWdh=="" || $passwort != $passwortWdh){
	    	$message = "<font style='color: red;'>".$invalid_registration_message."</font>";
	    } else if (mysql_num_rows($user_exists) > 0){
	    	$message = "<font style='color: red;'>".str_replace("%s", $benutzername, $user_already_exists_message)."</font>";
	    } else {
	    	//create tables if not exist
	    	$sql_create_table = "CREATE TABLE IF NOT EXISTS ".$mysql_table_users." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user VARCHAR(30) NOT NULL,
				password VARCHAR(40) NOT NULL,
				reg_date TIMESTAMP,
	    		unique key (user))";
	    	if (!mysqli_query($mysqli, $sql_create_table)) {
	    		//TODO improve error handling (separate page?)
	    		die("Error creating database table: " . mysqli_error());
	    	}
	    	$passwordHash = sha1(passwort);
	    	$sql_insert_new_user = "INSERT INTO ".$mysql_table_users." (user, password) VALUES ('".$benutzername."','".$passwordHash."')";
	    	if (!mysqli_query($mysqli, $sql_insert_new_user)) {
	    		//TODO improve error handling (separate page?)
	    		die("Error inserting new user into database: " . mysqli_error());
	    	}	 
		    // Weiterleitung zur geschützten Startseite
	       	if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
	        	if (php_sapi_name() == 'cgi') {
	         		header('Status: 303 See Other');
	         	}
	        	else {
	        		header('HTTP/1.1 303 See Other');
	        	}
	     	}
	     	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php?message='.$registered_message.'');
	    }	
     }
?>
 
<body>
<div class="container">
	<div class="val">
		<div class="hal">
			<div>
				<p class="pheader"><?php echo $page_title?></p>
				<p id="message_text"><?php echo $message?></p>
				<form action="register.php" method="post">
	   				<table spacing="10" style="margin:auto;">
	   				  <tr>
   				  		<td align="right">Benutzername:</td><td align="left"><input type="text" id="reg_benutzername" name="benutzername" value="<?php echo $benutzername?>" size="25" onclick="setHeaderMessage('<?php echo $register_message?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right">Passwort:</td><td align="left"><input type="password" id="reg_passwort" name="passwort" value="" size="25" onclick="setHeaderMessage('<?php echo $register_message?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right">Passwort (Wdh.):</td><td align="left"><input type="password" id="reg_passwortWdh" name="passwortWdh" value="" size="25" onclick="setHeaderMessage('<?php echo $register_message?>')"/></td>
	   				  </tr>
	   				</table>
	   				<p align="center"><input type="submit" value="Registrieren" /></p>
	  			</form>
	  			<p align="center" style="font-size:smaller;">Bereits registriert? Zurück zum <a href="login.php">login</a>.</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>