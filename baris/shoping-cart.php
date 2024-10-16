<?php 
// Method dosyasını dahil etme
include "baglanti.php";

if (isset($_POST["save"])) {
    // Kullanıcı bilgilerini al
    $product_id = $_POST["product_id"];
    $order_id = $_POST["order_id"];
    $user_id = $_POST["user_id"];
    $user_name = $_POST["user_name"];
    $address_id = $_POST["address_id"];
    $cargo_id = $_POST["cargo_id"];
    $pay_id = $_POST["pay_id"];
    $statu = $_POST["statu"];

    // Veritabanı işlemleri için hata kontrolü yap
    $db->begin_transaction();
    try {
        // Önce users tablosuna ekleme yapalım
        $sql_units = "INSERT INTO users (user_id, user_name, address_id) VALUES (?, ?, ?)";
        $stmt_units = $db->prepare($sql_units);
        $stmt_units->bind_param('isi', $user_id, $user_name, $address_id);
        $stmt_units->execute();
        $stmt_units->close();

        // orders tablosuna ekleme yapalım
        $sql_orders = "INSERT INTO orders (order_id, user_id, cargo_id, statu) VALUES (?, ?, ?, ?)";
        $stmt_orders = $db->prepare($sql_orders);
        $stmt_orders->bind_param('iiii', $order_id, $user_id, $cargo_id, $statu);
        $stmt_orders->execute();
        $stmt_orders->close();

        // order_pay tablosuna ekleme yapalım
        $sql_order_pay = "INSERT INTO order_pay (order_id, pay_id) VALUES (?, ?)";
        $stmt_order_pay = $db->prepare($sql_order_pay);
        $stmt_order_pay->bind_param('ii', $order_id, $pay_id);
        $stmt_order_pay->execute();
        $stmt_order_pay->close();

        // product_orders tablosuna ekleme yapalım
        $sql_product_orders = "INSERT INTO product_orders (product_id, order_id) VALUES (?, ?)";
        $stmt_product_orders = $db->prepare($sql_product_orders);
        $stmt_product_orders->bind_param('ii', $product_id, $order_id);
        $stmt_product_orders->execute();
        $stmt_product_orders->close();

        // Tüm sorgular başarılı olduğunda işlemi onayla
        $db->commit();
        echo "<script>alert('Registration is successful!');</script>";
    } catch (Exception $e) {
        // Hata durumunda işlemi geri al
        $db->rollback();
        echo "<script>alert('An error has occurred: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "Save button was not clicked.";
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoping Cart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='white'/><text x='50' y='50' font-size='80' text-anchor='middle' fill='black' dy='.3em'>Ⓑ</text></svg>">

<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<style>
    .logo {
        display: flex;
        align-items: center;
        text-decoration: none; /* Remove underline */
    }
    .logo-text {
        font-size: 24px; /* Adjust the font size as needed */
        font-weight: bold; /* Make the text bold */
        color: #000; /* Set the text color */
    }
</style>
</head>
<body class="animsition">
    
    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        WELCOME TO BET BOUTIQUE
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            Help & FAQs
                        </a>

                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            My Account
                        </a>

                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            EN
                        </a>

                        <a href="#" class="flex-c-m trans-04 p-lr-25">
                            USD
                        </a>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop how-shadow1">
                <nav class="limiter-menu-desktop container">
                    
                    <!-- Logo desktop -->
                    <a href="#" class="logo">
                        <span class="logo-text">ⒷⒺⓉ ⒷⓄⓊⓉⒾⓆⓊⒺ</span>
            </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li>
                                <a href="index.php">Home</a>
                                
                            </li>

                            <li>
                                <a href="product.php">Categories</a>
                                <ul class="sub-menu">
                                    <li><a href="women.php">Women</a></li>
                        <li><a href="men.php">Men</a></li>
                                </ul>
                            </li>

                            <li class="label1" data-label1="hot">
                                <a href="shoping-cart.php">Features</a>
                            </li>

                            

                            <li>
                                <a href="about.php">About</a>
                            </li>

                            <li>
                                <a href="contact.php">Contact</a>
                            </li>
                        </ul>
                    </div>  

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>

                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>

                        <a href="#" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
                            <i class="zmdi zmdi-favorite-outline"></i>
                        </a>
                    </div>
                </nav>
            </div>  
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
           <!-- Logo moblie -->     
		   <div class="logo-mobile">
			<a href="index.php" style="text-decoration: none;">
				<span style="font-family: Arial, sans-serif; font-size: 24px; color: #000;">ⒷⒺⓉ ⒷⓄⓊⓉⒾⓆⓊⒺ</span>
			</a>
		</div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>

                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>

                <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li>
                    <div class="left-top-bar">
                        WELCOME TO BET BOUTIQUE
                    </div>
                </li>

                <li>
                    <div class="right-top-bar flex-w h-full">
                        <a href="#" class="flex-c-m p-lr-10 trans-04">
                            Help & FAQs
                        </a>

                        <a href="#" class="flex-c-m p-lr-10 trans-04">
                            My Account
                        </a>

                        <a href="#" class="flex-c-m p-lr-10 trans-04">
                            EN
                        </a>

                        <a href="#" class="flex-c-m p-lr-10 trans-04">
                            USD
                        </a>
                    </div>
                </li>
            </ul>

            <ul class="main-menu-m">
                <li>
                    <a href="index.php">Home</a>
                    
                    <span class="arrow-main-menu-m">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                </li>

                <li>
                    <a href="product.php">Categories</a>
                    <ul class="sub-menu">
                        <li><a href="women.php">Women</a></li>
                        <li><a href="men.php">Men</a></li>
                    </ul>
                </li>

                <li>
                    <a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Features</a>
                </li>

            

                <li>
                    <a href="about.php">About</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>
            </ul>
        </div>

        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="images/icons/icon-close2.png" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div>
    </header>

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>
            
            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-01.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                White Shirt Pleat
                            </a>

                            <span class="header-cart-item-info">
                                1 x $19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-02.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x $39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-03.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x $17.00
                            </span>
                        </div>
                    </li>
                </ul>
                
                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shoping Cart
            </span>
        </div>
    </div>
        

   <!-- ########### BAŞVURU LİSTESİ TABLO ############## -->

    <div class = "container listeler d-flex justify-content-center">
        <div class = "row">
            <div class = "col-12 m-4">
                <div class ="baslik_kabul bg-secondary p-4 mt-4" style="width: 135%;">
                    <h4 class = "baslik text-center text-white">GIVE THE ORDER</h4>
                </div>
                <br>
                <div class = "row">
                    <div class = "col-md-8 text-center">
                        <form class = "justify-content-center text-center" method="POST" action="#">
                            <br>
                    
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="product_id" placeholder="Product ID">
                    </div>
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="order_id" placeholder="Order ID">
                    </div>
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="user_id" placeholder="User ID">
                    </div>                               
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="user_name" placeholder="User Name">
                    </div>
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="address_id" placeholder="address ID">
                    </div>
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="cargo_id" placeholder="cargo ID">
                    </div>
                     <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="pay_id" placeholder="Pay ID">
                    </div>
                    <br>
                    <div class = "kutu mx-2" style="width: 200%;">
                        <input class = "form-control" type="text" name="statu" placeholder="Statu">
                    </div>
                    <br>
                    <div class = "buton ml-4 justify-content-center" style="width: 200%;">
                        <button type="submit" name="save" class="btn btn-primary arama p-4" style="font-size: 16px;">Give the Order !</button>
                    </div>
                </form>
                    </div>
                    
                    <br>
                
                </div>
           <br>
                
            </div>
        </div>

    </div>
    
        

    <!-- Footer -->
<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="row w-100" style="padding: 0 20px;">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Categories
                    </h4>
                    <ul>
                        <li class="p-b-10">
                            <a href="women.php" class="stext-107 cl7 hov-cl1 trans-04">
                                Women
                            </a>
                        </li>
                        <li class="p-b-10">
                            <a href="men.php" class="stext-107 cl7 hov-cl1 trans-04">
                                Men
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <!-- Empty column for spacing -->
                </div>
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        CONTACT
                    </h4>
                    <p class="stext-107 cl7 size-201">
                        Any questions?    
                        Let us know
                        <br>
                        ADDRESS: 123, LA, US
                        <br>
                        MAIL: beturgut05@gmail.com
                        <br>
                        PHONE: +905306330656 
                    </p>
                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <!-- Empty column for spacing -->
                </div>
            </div>
        </div>
        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
                </a>
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
                </a>
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
                </a>
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
                </a>
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
                </a>
            </div>
            <p class="stext-107 cl6 txt-center">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>
    </div>
</footer>




    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

<!--===============================================================================================-->  
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function(){
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
<!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function(){
            $(this).css('position','relative');
            $(this).css('overflow','hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function(){
                ps.update();
            })
        });
    </script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>
