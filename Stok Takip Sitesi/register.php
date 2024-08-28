<?php
include 'database.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi hashle

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.html");
    } else {
        echo "Kayıt hatası: " . mysqli_error($conn);
    }
}
?>
