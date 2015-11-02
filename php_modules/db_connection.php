<?php

	include_once ('db_config.php');

	$mysql_host = MYSQL_HOST;
	$mysql_user = MYSQL_USER;
	$mysql_password = MYSQL_PASSWORD;
	$mysql_database = MYSQL_DATABASE;
	$mysql_table_users = MYSQL_TABLE_USERS;

	//create database object
	$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password);
	if (mysqli_connect_errno($mysqli)) {
		die("Failed to connect to MySQL: " . mysqli_connect_error());
	} 
	//if database not selectable (not exists), create it
	$database_exists =$mysqli->select_db($mysql_database);
	if (!$database_exists){
		$sql_create_db = "CREATE DATABASE ".$mysql_database;
		if (!$mysqli->query($sql_create_db)) {
			die("Error creating database: " . mysqli_error());
		}
	}

?>