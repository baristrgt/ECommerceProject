<?php 
include 'header.php';
// Method dosyasını dahil etme
require_once 'method.php';


if (isset($_POST['update'])) {
    // POST verilerini al ve güvenli hale getir
    if (isset($_POST['order_id']) && isset($_POST['statu'])) {
        $order_id = intval($_POST['order_id']); // order_id integer tipinde olmalı
        $statu = htmlspecialchars($_POST['statu']); // XSS saldırılarına karşı güvenlik

        // updateData fonksiyonunu çağırarak güncelleme yap
        $update = updateData("orders", "statu", "'$statu'", "order_id = $order_id");

        // Güncelleme sonucunu kontrol et ve kullanıcıya geri bildirimde bulun
        if ($update) {
            echo "Kayıt başarıyla güncellendi.";
        } else {
            echo "Güncelleme hatası.";
        }
    } else {
        echo "Gerekli veriler sağlanmadı.";
    }
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

	<div class = "container listeler d-flex justify-content-center">
		<div class = "row">
			<div class = "col-12 m-4">
				<div class ="baslik_kabul bg-secondary p-4 mt-4" style="width: 135%;">
					<h4 class = "baslik text-center text-white">UPDATE ORDER STATU</h4>
				</div>
				<br>
				<div class = "row">
					<div class = "col-md-8 text-center">
						<form class = "justify-content-center text-center" method="POST" action="#">
							<div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="number" name="order_id" placeholder="Order ID">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="statu" placeholder="Statu">
		            </div>
		            <br>
		            <div class = "buton ml-4 justify-content-center" style="width: 200%;">
						<button type="submit" name="update" class="btn btn-primary arama p-4" style="font-size: 16px;">Update</button>
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