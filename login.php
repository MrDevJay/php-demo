<?php
	
	include_once ('php_modules/config.php');
	include_once ('php_modules/db_connection.php');
	include_once ('php_modules/db_session.php');

	include_once 'html_modules/header.php';
	include_once 'html_modules/javascripts.php';

	//generals
	if (isset($_GET["message"]) && $_GET["message"]!="")
		$message = $_GET["message"]; 
	else 
		$message = $welcome_message;
	
	//login form send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	    $benutzername = $_POST['benutzername'];
	    $passwort = $_POST['passwort'];
	    //redirect
	    $hostname = $_SERVER['HTTP_HOST'];
	    $path = dirname($_SERVER['PHP_SELF']);
	
	    //some verifications
	    $sql_get_user = "SELECT id, user, password FROM ".$mysql_table_users." WHERE user='".$benutzername."'";
	    $result = $mysqli->query($sql_get_user);
	    if ($benutzername!="" && $passwort!="" && $result->num_rows==1){
	    	$row = $result->fetch_assoc();
	    	if ($row["password"] == sha1($passwort)){
	    		new Session($mysqli);
	    		$_SESSION['id'] = $row["id"];
	    		$_SESSION['user'] = $row["user"];
	    		$_SESSION['registered'] = true;
	    		// Weiterleitung zur geschützten Startseite
	    		if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
	    			if (php_sapi_name() == 'cgi') {
	    				header('Status: 303 See Other');
	    			}
	    			else {
	    				header('HTTP/1.1 303 See Other');
	    			}
	    		}
	    		header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
	    		exit;
	    	} else {
	    		$message = "<font style='color: red;'>".$auth_failed_message."</font>";
	    	}
	    } else {
	    	$message = "<font style='color: red;'>".$auth_failed_message."</font>";
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
				<form action="login.php" method="post">
	   				<table spacing="10" style="margin:auto;">
	   				  <tr>
   				  		<td align="right">Benutzername:</td><td align="left"><input type="text" name="benutzername" size="25" onclick="setHeaderMessage('<?php echo $welcome_message?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right">Passwort:</td><td align="left"><input type="password" name="passwort" size="25" onclick="setHeaderMessage('<?php echo $welcome_message?>')"/></td>
	   				  </tr>
	   				</table>
	   				<p align="center"><input type="submit" value="Anmelden" /></p>
	  			</form>
				<p align="center" style="font-size:smaller;">Noch nicht registriert? Sofort <a href="register.php">hier</a> nachholen.</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>