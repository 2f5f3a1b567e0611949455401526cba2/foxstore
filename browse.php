<?php 
require_once __DIR__ . '/include/init.php';
?>


<!DOCTYPE html>
<html lang="en">
<?php init_head('index'); ?>
<body id='body' style='color:var(--fg);background:var(--bg);'>
<main class='noscript page'>
<?php include 'include/header.php'?>
<div style='display: flex;align-items: flex-start;'>

<?php
$sortmode = match($_GET["sort"] ?? null){
	"priceu" => "price ASC",
	"priced" => "price DESC",
	"rateu"  => "rating ASC",
	"rated"  => "rating DESC",
	default  =>  "product_id",
};
// WARN: TODO: '%%' is a bad request
// But to be honest allowing arbitrary matching is kinda bad
$search = '%' . ($_GET["s"] ?? '') . '%';

$query = $db->prepare("
	SELECT * FROM product_summary 
	WHERE name LIKE :search ORDER BY $sortmode
");

	/* product_id, */
	/* name, */
	/* price, */
	/* rating, */
	/* thumb */
	/* alt */

$query->execute([':search' => $search]);

while($row = $query->fetch()){
	$path = "/foxstore/img/products/" . htmlspecialchars($row['thumb']);
	$name = htmlspecialchars($row["name"]);
	$alt = htmlspecialchars($row['alt']);
	$rating = number_format($row['rating'] ?? 0, 1);
	echo "
		<a class='border-top' style='width: 20ch' href=./prod.php?pID={$row["product_id"]}>
			<h1 class='top' style='left:1ch;max-width:18ch;overflow:hidden'>{$name}</h1>
			<figure style='position: relative;'>
			<img class='browseimg' src='{$path}' alt='{$alt}'>
			<figcaption style='border-bottom:1px solid var(--br);margin-top:0.5em;'>{$row["price"]} - {$row["stock"]} - {$rating}</figcaption>
			</figure>
		</a>";
};
?>
</div>
</main>
<?php init_script(); ?>
</html>

