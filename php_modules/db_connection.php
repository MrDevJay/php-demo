<?php

include_once ('db_config.php');

//create database object
$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password);
if (mysqli_connect_errno($mysqli)) {
	die("Failed to connect to MySQL: " . mysqli_connect_error());
//if database not selectable (not exists), create it
} else if (!mysqli_select_db($mysqli, $mysql_database)){
	$sql_create_db = "CREATE DATABASE ".$mysql_database;
	if (!mysqli_query($mysqli, $sql_create_db)) {
		die("Error creating database: " . mysqli_error());
	}
}

?>