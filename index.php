<?php 
	include_once 'php_modules/db_connection.php';
	include_once 'common.php';
	include_once 'php_modules/auth.php';
	include_once 'php_modules/show_logged_in.php';
	include_once 'html_modules/header.php'; 
?>
 
	 <div class="container">
		<div class="val">
			<div class="hal">
				<div style="width: 600px; height:400px">	
					<?php include_once 'menu.php';?>	
					
					<p style='text-align:center;'><?php echo $lang['WELCOME_MESSAGE']; echo $_SESSION["username"]?>.</p>
					<p style='text-align:center;'>
						<?php 
							echo $lang['ONLINE_USERS'].":<br>";
							$online_users=get_online_users($mysqli);
							for($i=0; $i<sizeof($online_users); $i++){
								echo $online_users[$i]."<br>";
							}
						?>
					</p>
				</div>	
			</div>
		</div>
	</div>
<?php 
	include_once 'html_modules/bottom.php';
?>