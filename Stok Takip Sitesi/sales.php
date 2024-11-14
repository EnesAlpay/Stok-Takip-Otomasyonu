<?php
include 'header.php';

if (isset($_POST['satis_ekle'])) {
    $firma_adi = $_POST['firma_adi_satis'];
    $urun_adi = $_POST['urun_adi_satis'];
    $urun_turu = $_POST['urun_turu_satis'];
    $urun_rengi = $_POST['urun_rengi_satis'];
    $adet = $_POST['adet_satis'];
    $satilma_tarihi = $_POST['satilma_tarihi'];
    $musteri_adi = $_POST['musteri_adi'];
    $musteri_adres = $_POST['musteri_adres'];
    $musteri_telefon = $_POST['musteri_telefon'];

    $query = "SELECT id, adet FROM products WHERE firma_adi=? AND urun_adi=? AND urun_turu=? AND urun_rengi=? AND user_id=?";
    $stmt = executeQuery($conn, $query, [$firma_adi, $urun_adi, $urun_turu, $urun_rengi, $_SESSION['user_id']], "ssssi");
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        if ($product['adet'] >= $adet) {
            $query = "INSERT INTO sales (user_id, firma_adi, urun_adi, urun_turu, urun_rengi, adet, satilma_tarihi, musteri_adi, musteri_adres, musteri_telefon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            executeQuery($conn, $query, [$_SESSION['user_id'], $firma_adi, $urun_adi, $urun_turu, $urun_rengi, $adet, $satilma_tarihi, $musteri_adi, $musteri_adres, $musteri_telefon], "issssissss");

            $query = "UPDATE products SET adet = adet - ? WHERE id=?";
            executeQuery($conn, $query, [$adet, $product['id']], "ii");

            header("Location: sales.php?success=Satış başarıyla eklendi.");
        } else {
            header("Location: sales.php?error=Yetersiz stok.");
        }
    } else {
        header("Location: sales.php?error=Ürün bulunamadı.");
    }
    exit;
}
   ?>
   <!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satış Ekle</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
        .sales-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .loading {
            text-align: center;
            padding: 10px;
        }
    </style>
<body>
    <div class="container">
        <h1>Satış Ekle</h1>
        <form action="sales.php" method="POST">
            <input type="text" name="firma_adi_satis" placeholder="Firma Adı" required>
            <input type="text" name="urun_adi_satis" placeholder="Ürün Adı" required>
            <input type="text" name="urun_turu_satis" placeholder="Ürün Türü" required>
            <input type="text" name="urun_rengi_satis" placeholder="Ürün Rengi" required>
            <input type="number" name="adet_satis" placeholder="Adet" required>
            <input type="date" name="satilma_tarihi" placeholder="Satılma Tarihi" required>
            <input type="text" name="musteri_adi" placeholder="Müşteri Adı" required>
            <input type="text" name="musteri_adres" placeholder="Müşteri Adresi" required>
            <input type="text" name="musteri_telefon" placeholder="Müşteri Telefonu" required>
            <button type="submit" name="satis_ekle">Satış Ekle</button>
        </form>

        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
    <div class="sales-container">
        <h1>Satışlar</h1>
        <table id="sales-table">
            <thead>
                <tr>
                    <th>Firma Adı</th>
                    <th>Ürün Adı</th>
                    <th>Ürün Türü</th>
                    <th>Ürün Rengi</th>
                    <th>Adet</th>
                    <th>Satılma Tarihi</th>
                    <th>Müşteri Adı</th>
                    <th>Müşteri Adresi</th>
                    <th>Müşteri Telefonu</th>
                </tr>
            </thead>
            <tbody id="sales-body">
                <!-- Satış verileri buraya eklenecek -->
            </tbody>
        </table>
        <div class="loading" id="loading">Yükleniyor...</div>
    </div>

    <script src="script.js"></script>
</body>
</html>
