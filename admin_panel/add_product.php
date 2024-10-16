<?php 
include 'header.php';
// Method dosyasını dahil etme
include "baglanti.php";
error_reporting(0);

if (isset($_POST["save"])) {
    // Hazırlıklı ifade (prepared statement) kullanarak SQL sorgusu
    $sql = "INSERT INTO product (product_id, product_name, product_img, product_stock, product_price, unit_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);

    if ($stmt) {
        // Parametreleri bağla ve veri türlerini kontrol et
        $stmt->bind_param('ssssdi', 
            $_POST["product_id"], 
            $_POST["product_name"], 
            $_POST["product_img"], 
            $_POST["product_stock"], 
            $_POST["product_price"], 
            $_POST["unit_id"]
        );

        // Sorguyu çalıştır
        if ($stmt->execute()) {
            echo "<script>alert('Registration is successful!');</script>";
        } else {
            echo "<script>alert('an error has occurred: " . $stmt->error . "');</script>";
        }

        // Hazırlanan ifadeyi kapat
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $db->error;
    }
} else {
    echo " ";
}




// Dosya yükleme işlemini gerçekleştir
$target_dir = "uploads/"; // Yüklenen dosyaların kaydedileceği klasör
$target_file = $target_dir . basename($_FILES["product_img"]["name"]); // Yüklenen dosyanın hedef yolu
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Dosyayı belirtilen klasöre kaydet
if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
    echo "Dosya " . htmlspecialchars(basename($_FILES["product_img"]["name"])) . " başarıyla yüklendi.";
    // Dosya yolu veritabanına kaydedilir
    $product_img_path = $target_file;
} else {
    echo " ";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Barış Eren Turgut</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

	<section class = "container-fluid p-0 menu bg-dark">
		<?php include 'left_sidebar.php'; ?>
	</section>

	<!-- ########### BAŞVURU LİSTESİ TABLO ############## -->

	<div class = "container listeler d-flex justify-content-center" enctype="multipart/form-data">
		<div class = "row">
			<div class = "col-12 m-4">
				<div class ="baslik_kabul bg-secondary p-4 mt-4" style="width: 135%;">
					<h4 class = "baslik text-center text-white">ADD NEW PRODUCT</h4>
				</div>
				<br>
				<div class = "row">
					<div class = "col-md-8 text-center">
						<form class = "justify-content-center text-center" method="POST" action="#">
							<div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="number" name="product_id" placeholder="Product ID">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="product_name" placeholder="Product Name">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class="form-control" type="file" name="product_img" accept="image/*">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="product_stock" placeholder="Product Stock">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="product_price" placeholder="Product Price">
		            </div>
		             <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="unit_id" placeholder="Unit ID">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="category_id" placeholder="Category ID">
		            </div>
		            <br>
		            <div class = "buton ml-4 justify-content-center" style="width: 200%;">
						<button type="submit" name="save" class="btn btn-primary arama p-4" style="font-size: 16px;">Submit</button>
					</div>
	            </form>
					</div>
					
					<br>
				
				</div>
	       <br>
				
			</div>
		</div>

	</div>
	<br>
	<br>
	<br>
	<br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php include 'footer.php'; ?>

	<script src="popper.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</body>
</html>