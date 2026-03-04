<?php 
require_once __DIR__ . '/include/init.php';
?>


<!DOCTYPE html>
<html lang="en">
<?php init_head('index'); ?>
<body id='body'>
<main class='noscript page'>
<?php include 'include/header.php'?>
<div style='display: flex;align-items: flex-start;'>

<?php
$sortmode = match($_GET["sort"] ?? null){
	"priced" => "p.price ASC",
	"priceu" => "p.price DESC",
	/* "rated"  => "p.rated ASC", */
	/* "rateu"  => "p.rateu DESC", */
	default  =>  "p.product_id",
};
// WARN: TODO: '%%' is a bad request
// But to be honest allowing arbitrary matching is kinda bad
$search = '%' . ($_GET["s"] ?? '') . '%';

$query = $db->prepare(
	"SELECT p.*, i.image_path, i.image_alt FROM products p
	LEFT JOIN images i ON i.id = (
		SELECT images.id 
		FROM images
		WHERE images.product_id = p.product_id 
		LIMIT 1
	) WHERE p.name LIKE :search ORDER BY $sortmode"
);
$query->execute([':search' => $search]);

while($row = $query->fetch()){
	$path = "/foxstore/img/products/{$row['image_path']}";
	echo "
		<a class='border-top' style='width: 20ch' href=./prod.php?pID={$row["product_id"]}>
			<h1 style='max-width:18ch;overflow:hidden;'>{$row["name"]}</h1>
			<figure style='position: relative;'>
			<img class='browseimg' src='{$path}' alt='{$row['image_alt']}'>
			<figcaption style='border-bottom:1px solid var(--br);margin-top:0.5em;'>{$row["price"]} - {$row["stock"]}</figcaption>
			</figure>
		</a>";
};
?>
</div>
</main>
<?php init_script(); ?>
</html>

