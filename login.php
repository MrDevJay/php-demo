<?php
	
	include_once ('modules/config.php');
	include_once ('modules/db_connection.php');

	//generals
	$message = $welcome_message;
	
	
	//login form send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	session_start();
	
	    $benutzername = $_POST['benutzername'];
	    $passwort = $_POST['passwort'];
	    $hostname = $_SERVER['HTTP_HOST'];
	    $path = dirname($_SERVER['PHP_SELF']);
	
	    // Benutzername und Passwort werden überprüft
	    if ($benutzername == 'jan' && $passwort == '123') {
	    	$_SESSION['nutzer_id'] = 1;
	    	$_SESSION['angemeldet'] = true;
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
	     
	     } else{
	     	$message = "<font style='color: red;'>".$auth_failed_message."</font>";
	     }
     }
 
	include_once 'html_modules/header.php';
	include_once 'html_modules/javascripts.php';
?>
 
<body>
<div class="container">
	<div class="val">
		<div class="hal">
			<div>
				<p class="pheader">Tippspiel</p>
				<p id="message_text"><?php echo $message?></p>
				<form action="login.php" method="post">
	   				<table spacing="10" style="margin:auto;">
	   				  <tr>
   				  		<td align="right">Benutzername:</td><td align="left"><input type="text" name="benutzername" size="25" onclick="setWelcomeMessage('<?php echo $welcome_message?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right">Passwort:</td><td align="left"><input type="password" name="passwort" size="25" onclick="setWelcomeMessage('<?php echo $welcome_message?>')"/></td>
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