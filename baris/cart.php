<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-ticaret_boutique";

// Veritabanı bağlantısı
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8");

// Ürün sepete eklendiğinde
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Sepet tablosuna ürünü ekleyin (örnek sepet tablosu: cart)
    $sql = "INSERT INTO cart (product_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
}

// Sepet tablosundaki ürünleri çekme
$sql = "SELECT p.product_name, p.product_price FROM cart c JOIN product p ON c.product_id = p.product_id";
$result = mysqli_query($conn, $sql);
if ($result === false) {
    die("Query failed: " . htmlspecialchars($conn->error));
}

$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

// Tüm ürünleri seçme
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
if ($result === false) {
    die("Query failed: " . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Listesi ve Sepet</title>
</head>
<body>
    <div class="product-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-sm-6 col-md-12 col-lg-3 p-b-35 isotope-item women">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <div class="product">
                                <img src="<?php echo $row["product_img"]; ?>" alt="<?php echo $row["product_name"]; ?>">
                                <a href="cart.php?product_id=<?php echo $row["product_id"]; ?>">
                                    <br><br>
                                    <?php echo $row["product_name"]; ?><br>
                                </a>
                                <?php echo $row["product_price"]; ?> ₺
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <h2>Sepetiniz</h2>
    <ul>
        <?php foreach ($cart_items as $item): ?>
            <li><?php echo $item['product_name'] . " - " . $item['product_price'] . " ₺"; ?></li>
        <?php endforeach; ?>
    </ul>

    <form action="x.php" method="post">
        <button type="submit">İleri</button>
    </form>
</body>
</html>
