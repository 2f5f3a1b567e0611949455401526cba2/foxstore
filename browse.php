<?php
    require './include/db.php';
//  require '/include/helper.php';
// require '/include/checklogin.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/polaroid.css">
	<link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
</head>
<body>
	<!-- Start of Page header-->
	<?php include './include/header.php';?>
	<div class='gallery'>
	<!-- Start of Page Content -->
	<?php
	if (isset($_GET["sort"])){
		$sortmode = $sortmode = $_GET["sort"];
	}
	else {
	 $sortmode ="product_id";
	};
	$search = "%%";
	//$search = $_Get["search"];

	$query = $db->prepare(
		"SELECT p.*, i.* FROM products p
		LEFT JOIN images i ON i.id = (
			SELECT images.id 
			FROM images
			WHERE images.product_id = p.product_id 
			LIMIT 1
		) WHERE p.name LIKE :search ORDER BY :sortmode"
	);
	$query->bindParam(':sortmode', $sortmode);
	$query->bindParam(':search', $search);
	$query->execute();
	
	while($row = $query->fetch()){
		$r0 = rand(-25, 25) / 10;
		$r1 = rand(-25, 25) / 10;
		$path = "/foxstore/img/products/{$row['image_path']}";
		echo "
			<a href=./product.php?id={$row["product_id"]}>
				<figure class='polaroid'  style='--rotation: {$r0}deg'>
				<div class='photo-area' style='--rotation: {$r1}deg'>
				<img src='{$path}' alt='{$row['image_alt']}'> </div>
				<figcaption>{$row["name"]} - {$row["price"]} - {$row["stock"]}</figcaption>
				</figure>
			</a>";
	};
	$db = null;
	$query = null;
	?>
	</div>
</body>
</html>

