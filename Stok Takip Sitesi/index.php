<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']); ?>'in Stok Takip Sistemi - Anasayfa</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="index-container">
        <h1>Stok Takip Sistemi</h1>
        <p><?php echo htmlspecialchars($_SESSION['username']); ?>, Hoşgeldiniz!</p>
        
        <div class="navigation-buttons">
            <a href="orders.php" class="button">Siparişler</a>
            <a href="stock.php" class="button">Mevcut Stoklar</a>
            <a href="sales.php" class="button">Satışlar</a>
        </div>
    </div>
</body>
</html>
