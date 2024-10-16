-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 06 Haz 2024, 22:33:53
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `e-ticaret_boutique`
--

DELIMITER $$
--
-- Yordamlar
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `basket_view` ()  CREATE VIEW product_view AS
SELECT p.product_id, p.product_name, p.product_img, p.product_stock, p.product_price, p.quantity
FROM product p
LEFT JOIN product_basket pb ON p.product_id = pb.product_id
LEFT JOIN basket b ON pb.basket_id = b.basket_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `category_unit` ()   SELECT units.unit_id, units.unit_name, category.category_id, category.category_name FROM units
LEFT JOIN 
category_unit ON category_unit.unit_id = units.unit_id 
LEFT JOIN category ON category_unit.category_id = category.category_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orders` ()   SELECT orders.order_id, orders.user_id, users.user_name, product.product_name, product.product_img, product.product_price, users.address_id, cargo.cargo_name, orders.statu FROM address, cargo LEFT JOIN orders ON cargo.cargo_id = orders.cargo_id LEFT JOIN users ON orders.user_id = users.user_id LEFT JOIN basket ON users.user_id = basket.user_id LEFT JOIN product_basket ON product_basket.product_id = product.product_id 
WHERE users.address_id = address.address_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Order_Product` ()   SELECT orders.order_id, orders.user_id, users.user_name, product.product_name, product.product_img, product.product_price, address.address_name, cargo.cargo_name, orders.statu 
FROM users, orders, product, address, cargo, product_orders
WHERE cargo.cargo_id = orders.cargo_id AND orders.user_id = users.user_id AND product_orders.order_id = orders.order_id AND product_orders.product_id = product.product_id AND users.address_id = address.address_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Order_Product_Update` (IN `order_id` INT, IN `new_statu` INT)   UPDATE orders SET statu = new_statu WHERE orders.order_id = order_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Product_name` ()   SELECT product.product_name FROM product$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `urun_ad` (IN `urun_id` INT(15))   SELECT urunler.urun_ad FROM urunler WHERE urun_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `urun_resim` (IN `urun_id` INT(15))   SELECT urunler.urun_resim FROM urunler WHERE urun_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `address`
--

CREATE TABLE `address` (
  `address_id` int(15) NOT NULL,
  `address_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `address`
--

INSERT INTO `address` (`address_id`, `address_name`) VALUES
(0, 'Bakırköy'),
(1, 'Maltepe'),
(2, 'Kadıköy'),
(3, 'Beşiktaş'),
(4, 'Şişli'),
(5, 'Beykoz'),
(88, 'Silivri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(15) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_surname` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `statu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_surname`, `admin_username`, `admin_pass`, `statu`) VALUES
(1, 'Barış Eren', 'Turgut', 'baris_turgut', '12345', 1),
(22, 'Umut', 'Koç', 'umut_koc', '123456', 1),
(44, 'Barış Eren', 'Turgut', 'baris_eren', '1234567', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_surname` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_surname`, `admin_username`, `admin_pass`, `admin_status`) VALUES
(1, 'Berk', 'Kanburlar', 'berkhoca', '121212', 1),
(2, 'Barış Eren', 'Turgut', 'BarisTurgut', '123456', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `basket`
--

CREATE TABLE `basket` (
  `basket_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `basket`
--

INSERT INTO `basket` (`basket_id`, `user_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cargo`
--

CREATE TABLE `cargo` (
  `cargo_id` int(15) NOT NULL,
  `cargo_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cargo`
--

INSERT INTO `cargo` (`cargo_id`, `cargo_name`) VALUES
(1, 'Aras Kargo'),
(2, 'Trendyol Kargo'),
(3, 'Kolay Gelsin Kargo'),
(4, 'Yurtiçi Kargo'),
(5, 'MNG Kargo');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `category_id` int(15) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Erkek'),
(2, 'Kadın'),
(3, 'Çocuk');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category_unit`
--

CREATE TABLE `category_unit` (
  `category_id` int(15) NOT NULL,
  `unit_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `category_unit`
--

INSERT INTO `category_unit` (`category_id`, `unit_id`) VALUES
(1, 1),
(2, 1),
(1, 55),
(2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `order_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `cargo_id` int(15) NOT NULL,
  `statu` int(11) NOT NULL,
  `product_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `cargo_id`, `statu`, `product_id`) VALUES
(0, 1, 2, 1, 0),
(1, 1, 1, 1, 0),
(2, 2, 4, 0, 0),
(8, 18, 3, 1, 0),
(45, 59, 4, 1, 0),
(7894, 4545654, 4, 0, 0),
(9999, 13, 3, 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_pay`
--

CREATE TABLE `order_pay` (
  `pay_id` int(15) NOT NULL,
  `order_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `order_pay`
--

INSERT INTO `order_pay` (`pay_id`, `order_id`) VALUES
(1, 1),
(3, 2),
(1, 45);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(15) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `payment`
--

INSERT INTO `payment` (`pay_id`, `pay_method`, `bank_name`) VALUES
(1, 'Kredi Kartı', 'Garanti'),
(2, 'Kredi Kartı', 'İş Bankası'),
(3, 'Kredi Kartı', 'Deniz Bank');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE `product` (
  `product_id` int(15) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_img` text NOT NULL,
  `product_stock` int(15) NOT NULL,
  `product_price` int(15) NOT NULL,
  `unit_id` int(15) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_img`, `product_stock`, `product_price`, `unit_id`, `quantity`) VALUES
(1, 'Lacoste Male T-Shirt', '/baris/images/product-detail-01.jpg', 50, 1990, 1, 0),
(21, 'Guess Female T-Shirt', '/baris/images/product-01.jpg', 56, 1299, 1, 0),
(111, 'U.S Polo Male T-Shirt', '/baris/images/product-detail-02.jpg', 50, 1600, 1, 0);

--
-- Tetikleyiciler `product`
--
DELIMITER $$
CREATE TRIGGER `file_path` BEFORE INSERT ON `product` FOR EACH ROW SET NEW.product_img = CONCAT('/baris/images/', NEW.product_img)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_basket`
--

CREATE TABLE `product_basket` (
  `product_id` int(15) NOT NULL,
  `basket_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `product_basket`
--

INSERT INTO `product_basket` (`product_id`, `basket_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_orders`
--

CREATE TABLE `product_orders` (
  `product_id` int(15) NOT NULL,
  `order_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `product_orders`
--

INSERT INTO `product_orders` (`product_id`, `order_id`) VALUES
(1, 0),
(111, 2),
(21, 9999),
(111, 45);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `product_view`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `product_view` (
`product_id` int(15)
,`product_name` varchar(200)
,`product_img` text
,`product_stock` int(15)
,`product_price` int(15)
,`quantity` int(11)
);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `units`
--

CREATE TABLE `units` (
  `unit_id` int(15) NOT NULL,
  `unit_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1, 'Tişört'),
(2, 'Pantalon'),
(3, 'Gömlek'),
(4, 'Saat'),
(5, 'Kemer'),
(33, 'Shoes'),
(44, 'Shoes'),
(55, 'Deneme');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(15) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `address_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `address_id`) VALUES
(1, 'Barış', 1),
(2, 'Umut', 4),
(13, 'Barış', 1),
(18, 'Barış Eren', 4),
(59, 'BarışTurgut', 1),
(100, 'Barışş', 1),
(4545654, 'BarışTurgut', 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `product_view`
--
DROP TABLE IF EXISTS `product_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_view`  AS SELECT `p`.`product_id` AS `product_id`, `p`.`product_name` AS `product_name`, `p`.`product_img` AS `product_img`, `p`.`product_stock` AS `product_stock`, `p`.`product_price` AS `product_price`, `p`.`quantity` AS `quantity` FROM ((`product` `p` left join `product_basket` `pb` on(`p`.`product_id` = `pb`.`product_id`)) left join `basket` `b` on(`pb`.`basket_id` = `b`.`basket_id`)) ;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Tablo için indeksler `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`) USING HASH,
  ADD KEY `admin_status` (`admin_status`);

--
-- Tablo için indeksler `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `kullanici_id` (`user_id`);

--
-- Tablo için indeksler `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`cargo_id`);

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Tablo için indeksler `category_unit`
--
ALTER TABLE `category_unit`
  ADD KEY `kategori` (`category_id`),
  ADD KEY `birim` (`unit_id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `kullanici` (`user_id`),
  ADD KEY `kargo` (`cargo_id`);

--
-- Tablo için indeksler `order_pay`
--
ALTER TABLE `order_pay`
  ADD KEY `siparis` (`order_id`),
  ADD KEY `odeme` (`pay_id`);

--
-- Tablo için indeksler `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Tablo için indeksler `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `birimler` (`unit_id`);

--
-- Tablo için indeksler `product_basket`
--
ALTER TABLE `product_basket`
  ADD KEY `urun` (`product_id`),
  ADD KEY `sepet` (`basket_id`);

--
-- Tablo için indeksler `product_orders`
--
ALTER TABLE `product_orders`
  ADD KEY `product` (`product_id`),
  ADD KEY `orders` (`order_id`);

--
-- Tablo için indeksler `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `adres` (`address_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `category_unit`
--
ALTER TABLE `category_unit`
  ADD CONSTRAINT `birim` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kategori` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `kargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`cargo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kullanici` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `order_pay`
--
ALTER TABLE `order_pay`
  ADD CONSTRAINT `odeme` FOREIGN KEY (`pay_id`) REFERENCES `payment` (`pay_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siparis` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `birimler` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_basket`
--
ALTER TABLE `product_basket`
  ADD CONSTRAINT `sepet` FOREIGN KEY (`basket_id`) REFERENCES `basket` (`basket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `urun` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_orders`
--
ALTER TABLE `product_orders`
  ADD CONSTRAINT `orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `adres` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
