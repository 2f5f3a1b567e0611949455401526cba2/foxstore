<?php
	$host = "localhost";
	$dbpass = "";
	$dbuser = "root";

  $dbinfo = "mysql:host=$host;dbname=store;charset=UTF8";
  /* $db = new PDO($dbinfo,$dbuser,$dbpass); */
  $db = new PDO($dbinfo,$dbuser);
?>
