<?php 
	include 'common.php';
	include 'php_modules/auth.php';
	include 'html_modules/header.php'; 
?>
 
 <body>
	 <div class="container">
		<div class="val">
			<div class="hal">
				<div style="width: 600px; height:400px">	
					<?php include_once 'menu.php';?>	
					
					<p style='text-align:center;'><?php echo $lang['WELCOME_MESSAGE']; echo $_SESSION["username"]?>.</p>
				</div>	
			</div>
		</div>
	</div>
</body>
</html>