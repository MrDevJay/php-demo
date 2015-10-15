<?php

include_once ('db_config.php');

$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);

if (mysqli_connect_errno($mysqli)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	break;
}


?>