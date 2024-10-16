<?php
session_start();
error_reporting(0);
include "baglanti.php";

$total_price = 0;

// POST-Redirect-GET pattern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'] ?? null;
    $product_name = $_POST['product_name'] ?? null;
    $product_price = $_POST['product_price'] ?? null;
    $quantity = $_POST['quantity'] ?? 1; // Default quantity 1
    $product_img = $_POST['product_img'] ?? null;

    if ($product_id && $product_name && $product_price && $product_img) {
        // Check if product is already in the cart
        $found = false;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                $cart_item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // If not found, add new product to the cart
        if (!$found) {
            $new_cart_item = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_price' => $product_price,
                'quantity' => $quantity,
                'product_img' => $product_img
            );
            $_SESSION['cart'][] = $new_cart_item;
        }
    }

    // Redirect to the same page to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        // Add each product's price to the total price
        $total_price += ($cart_item['product_price'] * $cart_item['quantity']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iroszon</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="style.css">
    <script>
        function redirectToCheckout() {
            window.location.href = "cargo_det.php";
        }

        function updateQuantity(index, quantity) {
            // Send AJAX request to update the quantity
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.reload();
                    var response = JSON.parse(xhr.responseText);
                    // Update the total price on the page
                    document.getElementById('total-price').innerText = response.total_price;
                    document.getElementById('cart-subtotal').innerText = response.total_price;
                    document.getElementById('cart-total').innerText = response.total_price;
                }
            };
            xhr.send("index=" + index + "&quantity=" + quantity);
        }

        function removeFromCart(index) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "remove_from_cart.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page to reflect changes
                    window.location.reload();
                }
            };
            xhr.send("index=" + index);
        }
    </script>
</head>
<body>
    <?php include("includes/header.php"); ?>
    <br><br><br>
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each product in the cart
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                    foreach($_SESSION['cart'] as $key => $cart_item){
                        ?>
                        <tr>
                            <td><a href="#" onclick="removeFromCart(<?php echo $key; ?>)"><i class="far fa-times-circle"></i></a></td>
                            <td><img src="data:image/jpg;base64,<?php echo $cart_item['product_img']; ?>" alt=""></td>
                            <td><?php echo $cart_item['product_name']; ?></td>
                            <td><?php echo $cart_item['product_price']; ?></td>
                            <td>
                                <input type="number" name="quantity<?php echo $key; ?>" value="<?php echo $cart_item['quantity']; ?>" onchange="updateQuantity(<?php echo $key; ?>, this.value)">
                            </td>
                            <td><?php echo $cart_item['product_price'] * $cart_item['quantity']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td id="cart-subtotal"><?php echo $total_price; ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td id="cart-total"><strong><?php echo $total_price; ?></strong></td>
                </tr>
            </table>
            <button class="normal" onclick="redirectToCheckout()">Proceed To Checkout</button>
        </div>
    </section>
    <?php include("includes/footer.php"); ?>
</body>
</html>
