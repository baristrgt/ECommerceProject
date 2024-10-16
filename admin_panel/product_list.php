<?php 
include 'header.php';
// Method dosyasını dahil etme
require_once 'method.php';

// Tüm ürünleri seçme
$product = selectData("product", "*");

if (isset($_POST['product_id'])) { // formdan "product_id" gönderildiyse
    $product_id = intval($_POST['product_id']); // id'yi bir değişkene atayalım ve int'e dönüştürelim
    // Verileri seçme işlemini gerçekleştirme
    $product = selectData("product", "*", "product_id = $product_id");
}

if (isset($_POST['listele'])) {
    // "listele" butonuna basıldığında product tablosundaki tüm verileri al
    $product = selectData("product", "*");
}

// Silme işlemi AJAX ile POST edildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $productId = intval($_POST['delete_id']);
    
    $sql = "DELETE FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    
    $response = [];
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    echo json_encode($response);
    exit; // Sonrasında HTML kodu çalışmasın diye exit
}

// Tüm ürünleri seçme
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
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
	<style>
		.left-sidebar {
			width: 20%;
			position: fixed;
			left: 0;
			top: 0;
			height: 100%;
			background-color: #343a40;
			color: white;
			padding: 20px;
		}
		.content {
			margin-left: 20%;
			padding: 20px;
			margin-bottom: 300px;
		}
	</style>

</head>
<body>

<section class="left-sidebar">

		<?php include 'left_sidebar.php'; ?>
	</section>

	<!-- ########### BAŞVURU LİSTESİ TABLO ############## -->

	<div class="content">
		<div class="container listeler">
			<div class="row">
				<div class="col d-felx justify-content-center">
					<div class="baslik_kabul bg-secondary p-2 mt-4">
						<h4 class="baslik text-center text-white">PRODUCT LIST</h4>
					</div>
					<br>
					<div class="row">
						<div class="col-md-8">
							<form class="d-flex justify-content-end" method="POST" action="#">
								<div class="kutu mx-2" style="width: 30%;">
			            			<input class="form-control" type="number" name="product_id" placeholder="Product ID">
			            		</div>
			            		<div class="buton">
									<button type="submit" class="btn btn-primary arama">Arama Yap</button>
								</div>
			            	</form>
						</div>
						<div class="col-md-4">
							<form method="POST" class="d-flex justify-content-start">
			            		<div class="buton">
									<button type="submit" class="btn btn-warning listele text-white">Tekrar Listele</button>
								</div>
			            	</form>
						</div>
					</div>
			        <br>
					<div class="table-responsive" style="height: 300px; overflow-y: scroll;">
						<table class="table basvuru_tablo">
						  	<thead>
						    	<tr>
						      		<th>ID</th>
						      		<th>Name</th>
						      		<th>IMG</th>
						      		<th>Stock</th>
						      		<th>Price</th>
						    	</tr>
						  	</thead>
						  	<tbody>
							  <?php foreach ($products as $product): ?>
				        <tr id="row-<?php echo $product['product_id']; ?>">
				          <td><?php echo $product['product_id']; ?></td>
				          <td><?php echo $product['product_name']; ?></td>
				          <td><img src="<?php echo $product['product_img']; ?>" alt="<?php echo $product['product_name']; ?>" width="100"></td>
				          <td><?php echo $product['product_stock']; ?></td>
				          <td><?php echo $product['product_price']; ?></td>
				          <td><button class="delete-button btn btn-danger" data-id="<?php echo $product['product_id']; ?>">X</button></td>
				        </tr>
				      <?php endforeach; ?>
				    </tbody>
				  </table>
				</div>
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
	<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(function(button) {
      button.addEventListener('click', function() {
        var productId = this.getAttribute('data-id');
        if (confirm('Bu ürünü silmek istediğinize emin misiniz?')) {
          fetch('', { // Aynı dosyaya gönderim yapacak
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'delete_id=' + productId
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              document.getElementById('row-' + productId).remove();
            } else {
              alert('Ürün silinirken bir hata oluştu.');
            }
          });
        }
      });
    });
  });
  </script>

</body>
</html>