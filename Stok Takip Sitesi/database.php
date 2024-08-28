<?php
$servername = "localhost";
$username = "root";  // Veritabanı kullanıcı adı
$password = "";  // Veritabanı şifresi
$database = "stok_takip";

// Bağlantıyı oluştur
$conn = mysqli_connect($servername, $username, $password, $database);

// Bağlantıyı kontrol et
if (!$conn) {
    die("Bağlantı başarısız: " . mysqli_connect_error());
}
?>
