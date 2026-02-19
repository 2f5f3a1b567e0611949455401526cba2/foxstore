<?php
    require_once './includes/helper.php';
    if (session_status() === PHP_SESSION_NONE) {
        // Start a session if there is none
        session_start();
    }
    if (!isset($_SESSION["admin"])) {
        redirect('./login.php');
    }
?>