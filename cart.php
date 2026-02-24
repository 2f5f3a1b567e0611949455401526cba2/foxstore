<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	/* ini_set('display_errors', 1); */
	/* ini_set('display_startup_errors', 1); */
	/* error_reporting(E_ALL); */


	include "./include/db.php";
	include "./include/helper.php";

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	// Get product ID
	if (!post_contains(["id", "count"])){
		redirect("./browse.php?err=params_invalid");
	}
	$id  = $_POST["id"];
	$cnt = $_POST["count"];
	if (!isset($_SESSION["user_id"])){
		redirect("./product.php?id=$id&err=session_not_set");
	}

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
</body>
</html>
