<?php
  echo" 
  		<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
		<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de' lang='de'>
  		<head>
  		<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
  		<title>".$page_title."</title>
  		<link rel='stylesheet' type='text/css' href='css/style.css'>
 		</head>
  		<body>";
  //redirect
  $hostname = $_SERVER['HTTP_HOST'];
  $path = $_SERVER['PHP_SELF'];
  echo "<div id='language_div'><a href='http://".$hostname.$path."?lang=de' class='img_link'><img src='images/Germany.png' alt='D' width='15px'></a>
  		<a href='http://".$hostname.$path."?lang=en' class='img_link'><img src='images/United States.png' alt='E' width='15px'></a></div>";
?>  