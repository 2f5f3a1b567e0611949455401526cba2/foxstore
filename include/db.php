<?php
    require '../../config.php';
    $dbinfo = "mysql:host=$host;dbname=store;charset=UTF8";

    $db = new PDO($dbinfo,$dbuser,$dbpass);
?>