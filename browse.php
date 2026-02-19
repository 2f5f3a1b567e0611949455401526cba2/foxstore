<?php
    require '/include/db.php';
//  require '/include/helper.php';
// require '/include/checklogin.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/header.css">
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
	$query = $db->prepare("SELECT product_id,name,price,stock,description FROM products ORDER BY $sortmode");
	$query->execute();
	
	echo "<div class='gallery'>";
	while($row = $query->fetch()){
			$product_ids=$row["product_id"];
			$names=$row["name"];
			$prices=$row["price"];
			$stocks=$row["stock"];
			$description=$row["description"];
			echo "<figure class='polaroid'>";
			echo "<div class='photo-area'> <a href=../product_page.php?id=$product_ids> <img src='Foxes/Fox5.jpg' alt='Arctic fox | WWF'> </a> </div>";
			echo "<figcaption>$names - $prices  - $stocks</figcaption>";
			echo"</figure>";
	};
	$db = null;
	$query = null;
	?>
	</div>
</body>
</html>
