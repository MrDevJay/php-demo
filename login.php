<?php
	include_once ('common.php');
	
	include_once ('php_modules/db_connection.php');
	include_once ('php_modules/db_session.php');

	include_once 'html_modules/header.php';
	include_once 'html_modules/javascripts.php';

	//generals
	if (isset($_GET["message"]) && $_GET["message"]!="")
		$message = $_GET["message"]; 
	else 
		$message = $lang['LOGIN_WELCOME_MESSAGE'];
	
	//login form send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    //redirect
	    $hostname = $_SERVER['HTTP_HOST'];
	    $path = dirname($_SERVER['PHP_SELF']);
	
	    $sql_get_user = "SELECT id, user, password FROM ".$mysql_table_users." WHERE user='".$username."'";
	    $result = $mysqli->query($sql_get_user);
	    if ($username!="" && $password!="" && $result->num_rows==1){
	    	$row = $result->fetch_assoc();
	    	if ($row["password"] == sha1($password)){
	    		new Session($mysqli);
	    		$_SESSION['id'] = $row["id"];
	    		$_SESSION['username'] = $row["user"];
	    		$_SESSION['registered'] = true;
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
	    		$message = "<font style='color: red;'>".$lang['LOGIN_ERROR_MESSAGE']."</font>";
	    	}
	    } else {
	    	$message = "<font style='color: red;'>".$lang['LOGIN_ERROR_MESSAGE']."</font>";
	    }
     }
?>
 
<div class="container">
	<div class="val">
		<div class="hal">
			<div>
				<p class="pheader"><?php echo $lang['PAGE_TITLE']; ?></p>
				<p id="message_text"><?php echo $message?></p>
				<form action="login.php" method="post">
	   				<table spacing="10" style="margin:auto;">
	   				  <tr>
   				  		<td align="right"><?php echo $lang['LOGIN_USERNAME']?>:</td><td align="left"><input type="text" name="username" size="25" onclick="setHeaderMessage('<?php echo $lang['LOGIN_WELCOME_MESSAGE'];?>')"/></td>
	   				  </tr>
	   				  <tr>
   				  		<td align="right"><?php echo $lang['LOGIN_PASSWORD']?>:</td><td align="left"><input type="password" name="password" size="25" onclick="setHeaderMessage('<?php echo $lang['LOGIN_WELCOME_MESSAGE'];?>')"/></td>
	   				  </tr>
	   				</table>
	   				<p align="center"><input type="submit" value="Anmelden" /></p>
	  			</form>
				<p align="center" style="font-size:smaller;"><?php echo str_replace("%s", "<a href='register.php'>".$lang['LOGIN_LINK_HERE']."</a>", $lang['LOGIN_LINK_NOT_YET_REGISTERED'])?>.</p>
			</div>
		</div>
	</div>
</div>
<?php 
	include_once 'bottom.php';
?>