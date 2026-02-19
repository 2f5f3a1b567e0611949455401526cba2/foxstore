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
	<!-- <header id="main-header" > -->
	<!-- </header> -->
	
	<div>
	<?php include './include/header.php';?>
	</div>


		<!-- Start of Page header-->
		<!-- Start of Page Content -->
		<?php
	$sortmode = $_GET["sort"];
	if ($sortmode != "price") {
		$sortmode = "product_id";
	};
	$query = $db->prepare("SELECT product_id,name,price,stock FROM products ORDER BY $sortmode");
	$query->execute();
	
	echo "<div class='gallery'>";
	while($row = $query->fetch()){
			$product_ids=$row["product_id"];
			$names=$row["name"];
			$prices=$row["price"];
			$stocks=$row["stock"];
			$description=$row["description"];
			echo "<a href=./product.php?id=$product_ids>";
			echo "<figure class='polaroid'>";
			echo "<div class='photo-area'><img src='./img/Fox5.jpg' alt='Arctic fox | WWF'></div>";
			echo "<figcaption>$names - $prices - $stocks</figcaption>";
			echo "</figure>";
			echo "</a>";
	};
	$db = null;
	$query = null;
	?>
	</div>
</body>
</html>
