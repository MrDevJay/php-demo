<?php
	include_once 'common.php';
	include_once 'php_modules/db_config.php';
	include_once 'php_modules/db_connection.php';
	include_once 'php_modules/db_session.php';
	
	new Session($mysqli, MYSQL_TABLE_SESSIONS);
	
	session_destroy();

    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);

    header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php');
?>