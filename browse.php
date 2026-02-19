<?php
	use Random\Randomizer;
	$randomizer = new Randomizer();

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
	$sortmode = $_GET["sort"];
	if ($sortmode != "price") {
		$sortmode = "product_id";
	};

	$query = $db->prepare(
		"SELECT p.*, i.* FROM products p
		LEFT JOIN images i ON i.id = (
			SELECT images.id 
			FROM images
			WHERE images.product_id = p.product_id 
			LIMIT 1
		) ORDER BY :sortmode"
	);
	$query->bindParam(':sortmode', $sortmode);
	$query->execute();
	
	while($row = $query->fetch()){
		$r0 = $randomizer->getInt(-25, 25) / 10;
		$r1 = $randomizer->getInt(-25, 25) / 10;
		echo "
			<a href=./product.php?id={$row["product_id"]}>
				<figure class='polaroid'  style='--rotation: {$r0}deg'>
				<div class='photo-area' style='--rotation: {$r1}deg'>
				<img src='{$row["image_path"]}' alt='{$row["image_alt"]}'></div>
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
