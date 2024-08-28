<?php
    include "init.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['username']); ?>'in Stok Takip Sistemi</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Anasayfa</a></li>
            <li><a href="orders.php">Siparişler</a></li>
            <li><a href="stock.php">Stoklar</a></li>
            <li><a href="sales.php">Satışlar</a></li>
        </ul>
    </nav>
    <div class="container">
