<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-ticaret_boutique";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Product tablosundan verileri al
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Verileri döngüyle al ve ekrana yazdır
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>" . $row["product_name"] . "<br>" . $row["product_price"] . "</div>";

    }
} else {
    echo "Hiç ürün bulunamadı.";
}
$conn->close();
?>