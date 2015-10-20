<?php
     session_start();

     $hostname = $_SERVER['HTTP_HOST'];
     $path = dirname($_SERVER['PHP_SELF']);

     if (!isset($_SESSION['registered']) || !$_SESSION['registered']) {
     	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/login.php');
     	exit;
     }
?>