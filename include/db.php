<?php
	$host = "localhost";
	$dbinfo = "store";
	$dbuser = "root";
	$dbpass = "";
	$dbinfo = "mysql:host=$host;dbname=store;charset=UTF8";

	$db = new PDO($dbinfo,$dbuser,$dbpass);
?>
