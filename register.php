<?php
	
	//includes
	include_once ('common.php');
	include_once ('php_modules/db_connection.php');

	include_once 'html_modules/header.php';
	include_once 'html_modules/javascripts.php';
	
	//generals
	$username = "";
	$message = $lang['REGISTER_WELCOME_MESSAGE'];
		
	//login form send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    $passwordR = $_POST['passwordR'];
	    
	    //redirect
	    $hostname = $_SERVER['HTTP_HOST'];
	    $path = dirname($_SERVER['PHP_SELF']);
	
	    //some verifications
	    $sql_user_exists = "SELECT * FROM ".$mysql_table_users." WHERE user='".$username."'";
	    $user_exists = $mysqli->query($sql_user_exists);
	    if ($username=="" || $password=="" || $passwordR=="" || $password != $passwordR){
	    	$message = "<font style='color: red;'>".$lang['REGISTER_INVALID_MESSAGE']."</font>";
	    } else if ($user_exists->num_rows > 0){
	    	$message = "<font style='color: red;'>".str_replace("%s", $username, $lang['REGISTER_USER_ALREADY_EXISTS_MESSAGE'])."</font>";
	    	$username = "";
	    } else {
	    	//create tables if not exist
	    	$sql_create_table = "CREATE TABLE IF NOT EXISTS ".$mysql_table_users." (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user VARCHAR(30) NOT NULL,
				password VARCHAR(40) NOT NULL,
				reg_date TIMESTAMP,
	    		unique key (user))";
	    	if (!$mysqli->query($sql_create_table)) {
	    		//TODO improve error handling (separate page?)
	    		die("Error creating database table: " . mysqli_error());
	    	}
	    	$passwordHash = sha1($password);
	    	$sql_insert_new_user = "INSERT INTO ".$mysql_table_users." (user, password) VALUES ('".$username."','".$passwordHash."')";
	    	if (!$mysqli->query($sql_insert_new_user)) {
	    		//TODO improve error handling (separate page?)
	    		die("Error inserting new user into database: " . mysqli_error());
	    	}	 
	       	if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
	        	if (php_sapi_name() == 'cgi') {
	         		header('Status: 303 See Other');
	         	}
	        	else {
	        		header('HTTP/1.1 303 See Other');
	        	}
	     	}
	     	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php?message='.$lang['REGISTER_SUCCESS_MESSAGE'].'');
	    }	
     }
?>

<div class="container">
	<div class="val">
		<div class="hal">
			<div>
				<p class="pheader"><?php echo $lang['PAGE_TITLE']; ?></p>
				<p id="message_text"><?php echo $message?></p>
				<form action="register.php" method="post">
	   				<table spacing="10" style="margin:auto;">
	   				  <tr>
   				  		<td align="right"><?php echo $lang['REGISTER_USERNAME'];?>:</td><td align="left"><input type="text" id="reg_benutzername" name="username" value="<?php echo $username?>" size="25" onclick="setHeaderMessage('<?php echo $lang['REGISTER_WELCOME_MESSAGE']?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right"><?php echo $lang['REGISTER_PASSWORD'];?>:</td><td align="left"><input type="password" id="reg_passwort" name="password" value="" size="25" onclick="setHeaderMessage('<?php echo $lang['REGISTER_WELCOME_MESSAGE']?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right"><?php echo $lang['REGISTER_PASSWORD_REPEAT']?>:</td><td align="left"><input type="password" id="reg_passwortWdh" name="passwordR" value="" size="25" onclick="setHeaderMessage('<?php echo $lang['REGISTER_WELCOME_MESSAGE']?>')"/></td>
	   				  </tr>
	   				</table>
	   				<p align="center"><input type="submit" value="Registrieren" /></p>
	  			</form>
	  			<p align="center" style="font-size:smaller;"><?php echo $lang['REGISTER_ALREADY_REGISTERED_MESSAGE']?> <a href="login.php">login</a>.</p>
			</div>
		</div>
	</div>
</div>
<?php 
	include_once 'html_modules/bottom.php';
?>