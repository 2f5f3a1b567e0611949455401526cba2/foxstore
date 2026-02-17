<?php
    require './includes/db_mod.php';
//  require './includes/helper.php';
// require './includes/checklogin.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="header.css">
	<link rel="stylesheet" href="polaroid2.css">
	<link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
</head>
<body>
	<!-- <header id="main-header" > -->
	<!-- </header> -->
	
	<div>
	<?php include 'header.php';?>
	</div>


		<!-- Start of Page header-->
		<!-- Start of Page Content -->
		<?php
/*
		echo "<div class='sortmenu'>";
		echo "<button onclick >";
		echo "";
		echo "<\div>";
			switch($_GET["sort"]) {
			//Ordering is done in the query
			case "price":
			 $sortmode ='price';
			default:
			 $sortmode ="product_id";
	};*/
	$sortmode = $_GET["sort"];
	if ($sortmode != "price") {
		$sortmode = "product_id";
	};

	echo "$sortmode";
	$query = $db->prepare("SELECT product_id,name,price,stock FROM products ORDER BY $sortmode");
	$query->execute();
	
	echo "<div class='gallery'>";
	echo"please say somtehing";
	while($row = $query->fetch()){
			$product_ids=$row["product_id"];
			$names=$row["name"];
			$prices=$row["price"];
			$stocks=$row["stock"];
			echo "<figure class='polaroid'>";
			echo "<div class='photo-area'> <img src='Foxes/Fox5.jpg' alt='Arctic fox | WWF'> </div>";
			echo "<figcaption>$names - $prices - $stocks</figcaption>";
			echo"</figure>";
	};
	
	$db = null;
	$query = null;
	?>
	</div>
</body>
</html>