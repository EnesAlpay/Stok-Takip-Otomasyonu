<?php
session_start();
include 'database.php';
include 'functions.php'; // Include the functions file here

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
?>