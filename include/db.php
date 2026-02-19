<?php
	$host = "localhost";
	$dbinfo = "store";
	$dbuser = "root";
	$dbpass = "";
	$dbinfo = "mysql:host=$host;dbname=store;charset=UTF8";

	if (file_exists("../../config.php")) {
		include "../../config.php";
	}
	$db = new PDO($dbinfo,$dbuser,$dbpass);
?>
