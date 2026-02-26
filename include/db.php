<?php
	$host = "localhost";
	$dbinfo = "store";
	$dbuser = "root";
	$dbpass = "";
	$dbinfo = "mysql:host=$host;dbname=store;charset=UTF8";
	if (file_exists(__DIR__."/../../config.php")) {
		include __DIR__."/../../config.php";
	}
	$db = new PDO($dbinfo,$dbuser,$dbpass);
?>
