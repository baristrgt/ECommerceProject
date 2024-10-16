<?php 
include 'header.php';
// Method dosyasını dahil etme
include "baglanti.php";

if (isset($_POST["save"])) {
    $unit_id = $_POST["unit_id"];
    $unit_name = $_POST["unit_name"];
    $category_id = $_POST["category_id"];

    // Önce units tablosuna ekleme yapalım
    $sql_units = "INSERT INTO units (unit_id, unit_name) VALUES (?, ?)";
    $stmt_units = $db->prepare($sql_units);
    
    if ($stmt_units) {
        $stmt_units->bind_param('ss', $unit_id, $unit_name);
        if ($stmt_units->execute()) {
            // units tablosuna ekleme başarılı olduysa, category_unit tablosuna da ekleyelim
            $sql_category_unit = "INSERT INTO category_unit (unit_id, category_id) VALUES (?, ?)";
            $stmt_category_unit = $db->prepare($sql_category_unit);

            if ($stmt_category_unit) {
                $stmt_category_unit->bind_param('ss', $unit_id, $category_id);
                if ($stmt_category_unit->execute()) {
                    echo "<script>alert('Registration is successful!');</script>";
                } else {
                    echo "<script>alert('An error has occurred in category_unit: " . $stmt_category_unit->error . "');</script>";
                }
                $stmt_category_unit->close();
            } else {
                echo "Error preparing category_unit statement: " . $db->error;
            }
        } else {
            echo "<script>alert('An error has occurred in units: " . $stmt_units->error . "');</script>";
        }
        $stmt_units->close();
    } else {
        echo "Error preparing units statement: " . $db->error;
    }
} else {
    echo "Save button was not clicked.";
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
					<h4 class = "baslik text-center text-white">ADD NEW UNIT</h4>
				</div>
				<br>
				<div class = "row">
					<div class = "col-md-8 text-center">
						<form class = "justify-content-center text-center" method="POST" action="#">
							<div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="number" name="unit_id" placeholder="Unit ID">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="unit_name" placeholder="Unit Name">
		            </div>
		            <br>
		            <div class = "kutu mx-2" style="width: 200%;">
		            	<input class = "form-control" type="text" name="category_id" placeholder="Category ID">
		            </div>,
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