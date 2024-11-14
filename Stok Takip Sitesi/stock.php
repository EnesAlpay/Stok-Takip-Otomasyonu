<?php

include 'header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $query = "SELECT * FROM orders WHERE id=? AND user_id=?";
    $stmt = executeQuery($conn, $query, [$order_id, $user_id], "ii");
    $order = $stmt->get_result()->fetch_assoc();

    if ($order && $order['status'] === 'confirmed') {
        $query = "SELECT * FROM products WHERE firma_adi=? AND urun_adi=? AND urun_turu=? AND urun_rengi=? AND user_id=?";
        $stmt = executeQuery($conn, $query, [$order['firma_adi'], $order['urun_adi'], $order['urun_turu'], $order['urun_rengi'], $user_id], "ssssi");
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            $query = "UPDATE products SET adet = adet + ? WHERE id=?";
            executeQuery($conn, $query, [$order['adet'], $product['id']], "ii");
        } else {
            $query = "INSERT INTO products (user_id, firma_adi, urun_adi, urun_turu, urun_rengi, adet) VALUES (?, ?, ?, ?, ?, ?)";
            executeQuery($conn, $query, [$user_id, $order['firma_adi'], $order['urun_adi'], $order['urun_turu'], $order['urun_rengi'], $order['adet']], "issssi");
        }

        $query = "DELETE FROM orders WHERE id=?";
        executeQuery($conn, $query, [$order_id], "i");

        header("Location: stock.php?success=Stok güncellendi.");
        exit;
    }
}

$query = "SELECT * FROM products WHERE user_id=?";
$stmt = executeQuery($conn, $query, [$user_id], "i");
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Stok</h1>
    <?php if (isset($_GET['success'])): ?>
        <p><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Firma Adı</th>
                <th>Ürün Adı</th>
                <th>Ürün Türü</th>
                <th>Ürün Rengi</th>
                <th>Adet</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($product['firma_adi']) ?></td>
                    <td><?= htmlspecialchars($product['urun_adi']) ?></td>
                    <td><?= htmlspecialchars($product['urun_turu']) ?></td>
                    <td><?= htmlspecialchars($product['urun_rengi']) ?></td>
                    <td><?= htmlspecialchars($product['adet']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
