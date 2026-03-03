<?php 
if (!isset($pID)) { echo "Invalid Request; pID not set";       return; }
if (!isset($db))  { echo "Invalid Request; db not initilized"; return; }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>image reel</title>
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/reel.css">
	</head>
	<body>
	<div class='padd'></div>
	<div class='reel'>
<?php
$st = $db->prepare('SELECT * FROM images WHERE product_id=:id');
$st->bindParam(':id', $pID);
$st->execute();
$status = 'checked';
while ($row = $st->fetch()){
	$img = "./img/products/{$row['image_path']}";
	echo 
"<input type='radio' name='reel-select' id='{$row['id']}' class='reel-select' {$status}>
<label for='{$row['id']}' class='img'><img src='{$img}' loading='lazy' alt='{$row['alt']}'></label>";
	$status = "";
};
?>
	</div>
  </body>
</html>

