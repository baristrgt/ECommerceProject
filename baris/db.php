<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-ticaret boutique";

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Ürün bilgilerini çek
$sql = "SELECT product_name, product_price FROM product WHERE product_id = 1"; // Ürün ID'sine göre filtreleme
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Verileri al
    $row = $result->fetch_assoc();
    $product_name = $row["product_name"];
    $product_price = $row["product_price"];
} else {
    echo "Ürün bulunamadı";
}
$conn->close();
?>
