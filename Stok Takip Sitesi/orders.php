<?php

include 'header.php';  
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['siparis_ver'])) {
    $firma_adi = $_POST['firma_adi'];
    $urun_adi = $_POST['urun_adi'];
    $urun_turu = $_POST['urun_turu'];
    $urun_rengi = $_POST['urun_rengi'];
    $adet = $_POST['adet'];

    $query = "INSERT INTO orders (user_id, firma_adi, urun_adi, urun_turu, urun_rengi, adet, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    executeQuery($conn, $query, [$user_id, $firma_adi, $urun_adi, $urun_turu, $urun_rengi, $adet], "issssi");

    header("Location: orders.php");
    exit;
}

if (isset($_POST['siparis_onayla'])) {
    $siparis_id = $_POST['siparis_id'];

    $query = "UPDATE orders SET status='confirmed' WHERE id=? AND user_id=?";
    executeQuery($conn, $query, [$siparis_id, $user_id], "ii");

    header("Location: stock.php?order_id=" . $siparis_id);
    exit;
}

$query = "SELECT * FROM orders WHERE user_id=? AND status='pending'";
$stmt = executeQuery($conn, $query, [$user_id], "i");
$pending_orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişler</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Siparişler</h1>
    <form action="orders.php" method="POST">
        <input type="text" name="firma_adi" placeholder="Firma Adı" required>
        <input type="text" name="urun_adi" placeholder="Ürün Adı" required>
        <input type="text" name="urun_turu" placeholder="Ürün Türü" required>
        <input type="text" name="urun_rengi" placeholder="Ürün Rengi" required>
        <input type="number" name="adet" placeholder="Adet" required>
        <button type="submit" name="siparis_ver">Sipariş Ver</button>
    </form>

    <h2>Verilen Siparişler</h2>
    <table>
        <thead>
            <tr>
                <th>Firma Adı</th>
                <th>Ürün Adı</th>
                <th>Ürün Türü</th>
                <th>Ürün Rengi</th>
                <th>Adet</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $pending_orders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($order['firma_adi']) ?></td>
                    <td><?= htmlspecialchars($order['urun_adi']) ?></td>
                    <td><?= htmlspecialchars($order['urun_turu']) ?></td>
                    <td><?= htmlspecialchars($order['urun_rengi']) ?></td>
                    <td><?= htmlspecialchars($order['adet']) ?></td>
                    <td>
                        <form action="orders.php" method="POST">
                            <input type="hidden" name="siparis_id" value="<?= htmlspecialchars($order['id']) ?>">
                            <button type="submit" name="siparis_onayla">Onayla</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
