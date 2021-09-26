<?php

session_start();

$current_file = substr($_SERVER['SCRIPT_NAME'], 25);

if ($current_file == 'index.php') {
    if (isset($_SESSION['ADMIN_USERNAME']) && !empty($_SESSION['ADMIN_USERNAME'])) {
        header('location:dashboard.php');
    }
} else {
    if (!isset($_SESSION['ADMIN_USERNAME']) || empty($_SESSION['ADMIN_USERNAME'])) {
        header('location:index.php');
    }
}
