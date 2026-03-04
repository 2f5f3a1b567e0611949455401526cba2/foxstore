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

	//include 'methods.php'; // handles login requires $db
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

			<input class='hidden'       type='radio' id='nil_cmt_btn'    name='comment_btns'/>
			<input class='hidden tgl' type='radio' id='addcmt_btn' name='comment_btns'/>
			<p style='position:absolute;top:-0.5em;right:1ch;background:var(--bg);padding:0 0.5ch'>
				<label for='addcmt_btn'>add comment</label>
				<label class='invis overlay' for='nil_cmt_btn'>add comment</label>
			</p>
			<!-- Add comment DropDown -->
			<div class='tgl_on' style='display:block'>
				FOO BAR
			</div>
	


			<?php
			$query = $db->prepare("
				SELECT * FROM comments c 
				INNER JOIN users 
				ON c.user_id = users.user_id 
				WHERE product_id=:prod_id"
			);
			$query->execute([':prod_id' => $pID]);
			while($row = $query->fetch()): ?>
				<div class='comment border-top'>
				<h1><?=$row["username"]?> - Rating: <?=$row["rating"]?></h1>
				<?=$row["comment_desc"]?>
				</div>
			<?php endwhile; ?>
			</div>
		</div>
</main>
<?php init_script(); ?>
</html>




