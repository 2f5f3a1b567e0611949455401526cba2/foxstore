<?php 
require_once __DIR__ . '/include/init.php';
?>
<?php 
	if (!isset($_GET['pID'])){header("Location: browse.php"); exit;}

	$pID = $_GET['pID'];
	include 'include/db.php';

	$st = $db->prepare('SELECT * FROM products WHERE product_id=:pID');

	$st->bindParam(':pID', $pID);
	$st->execute();
	$row = $st->fetch();
	if (!$row) { header("Location: browse.php"); exit; }
	$pname = $row['name'];
	$pdesc = $row['description'];

	include 'methods.php'; // handles login requires $db
	ob_start();
	// Needs db and pID to be set
	include 'include/reel.php';
	$ImgReel = ob_get_clean();
	$ImgReel = htmlspecialchars($ImgReel, ENT_QUOTES, 'UTF-8');
?>


<!DOCTYPE html>
<html lang="en">
<?php init_head('prod'); ?>
<body id='body' style='color:var(--fg);background:var(--bg);'>
<main class='noscript page'>
<?php include 'include/header.php'?>
		<div id='prod-main'>
			<iframe id='ifreel' title='Image Reel' srcdoc='<?php echo $ImgReel; ?>' ></iframe>
			<?php include 'opt/tmpl.php' ?>
			<div class='border-top' style='grid-area: desc'>
			<h1>description</h1>
			<?=$pdesc?>
			</div>
			<div class='border-top' style='grid-area: comm'>
			<h1>comments</h1>
				
			</div>
		</div>
</main>
<?php init_script(); ?>
</html>




