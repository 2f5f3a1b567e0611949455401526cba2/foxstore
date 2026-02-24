<?php
	include "./include/db.php";
	// Get product ID
	$prod_id = $_GET["id"];
	echo " ";

	// This feels wrong as i don't know how many items would return
	// While it should and could only be one, i have no idea how to enforce it.
	$statement = $db->prepare('SELECT * FROM products WHERE product_id=:id');

	$statement->bindParam(':id', $prod_id);
	$statement->execute();
	$row = $statement->fetch();
	if (!$row) {
		// product not found
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/image_reel.css">
	<link rel="stylesheet" href="./css/polaroid.css">
</head>
<body>
	<?php include "./include/header.php";?>
	<div class="page">
	<div class="frame">
		<h1 id="product-title"><?=$row['name']?></h1>
		<div id="product-image"></div>
		<div id="product-desc"><?=$row['description']?></div>
		<div id="product-extra"></div>
		<form id="product-buy" action="cart.php" method="post">
		<input type="hidden" name="id" value="<?=$prod_id?>">
		<input id="count" type="number" name="count" value="1">
		<button type="submit">Add to Cart</button>
		</form>
	</div>
	<div class="reel">

<?php
$statement = $db->prepare('SELECT * FROM images WHERE product_id=:id');
$statement->bindParam(':id', $prod_id);
$statement->execute();
while ($row = $statement->fetch()){
	$r0 = rand(-25, 25) / 10;
	$r1 = rand(-25, 25) / 10;
	$path = "/foxstore/img/products/{$row['image_path']}";
	echo "
		<input type='radio' name='reel-select' id='{$row['id']}' class='reel-select' checked>
		<label for='{$row['id']}' class='images'>
			<figure class='polaroid'  style='--rotation: {$r0}deg;'>
				<div class='photo-area' style='--rotation: {$r1}deg;'>
				<img src='{$path}' alt='{$row['image_alt']}'> </div>
				<figcaption>{$row['image_cap']}</figcaption>
			</figure>
		</label> ";
};
?>	
	</div>
	</div>
</body>
</html> 

