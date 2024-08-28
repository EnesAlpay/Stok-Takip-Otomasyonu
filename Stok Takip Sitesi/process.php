<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

function executeQuery($conn, $query, $params = [], $types = "") {
    $stmt = $conn->prepare($query);
    if ($stmt) {
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    } else {
        throw new Exception("Database query failed: " . $conn->error);
    }
}


?>
