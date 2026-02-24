<!DOCTYPE html>
<html>
<head>
</head>
<body>
	Hello world
</body>
</html>

<?php
	include "./include/db.php";
	include "./include/helper.php";
	// Get product ID
	if (!isset($_SESSION["user_id"]) or !post_contains(["id", "count"])){
		redirect("./browse.php?err=session_or_params_not_set");
	}

	$id  = $_POST["id"];
	$cnt = $_POST["count"];
	$user_id = $_SESSION["user_id"];

	$statement = $db->prepare('SELECT price stock FROM products WHERE product_id=:id');
	$statement->bindParam(':id', $id);
	$statement->execute();
	$row = $statement->fetch();
	if (!$row) { redirect("./product.php?id=$id&err=no_such_product"); }

	$statement = $db->prepare('
		INSERT INTO cart (user_id, product_id, amount) VALUES
		(:user_id, :id, :cnt)
	');
	$statement->bindParam(':id', $id);
	$statement->bindParam(':user_id', $user_id);
	$statement->bindParam(':cnt', $cnt);
	$statement->execute();
	redirect("./product.php?id=$id");
?>
