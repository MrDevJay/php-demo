<?php
	include_once 'db_config.php';
	include_once 'db_connection.php';
	include_once 'db_session.php';     

	new Session($mysqli, MYSQL_TABLE_SESSIONS);
   
	$hostname = $_SERVER['HTTP_HOST'];
	$path = dirname($_SERVER['PHP_SELF']);

	if (!isset($_SESSION['registered']) || !$_SESSION['registered']) {
		header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php');
		exit;
	}
?>