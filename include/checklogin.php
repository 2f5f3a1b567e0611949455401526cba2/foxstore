<?php
    require_once __DIR__.'/helper.php';
    if (session_status() == PHP_SESSION_NONE) {
        // Start a session if there is none
        session_start();
    }
    if (!isset($_SESSION["logged_in"])) {
        redirect('/foxstore/login/');
    }
?>