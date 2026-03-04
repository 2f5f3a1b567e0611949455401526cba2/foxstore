<?php 
require_once __DIR__ . '/include/init.php';

$params = $_GET;
unset($params['r']);
unset($params['err']);
/*----------------------------------------------------------------------------*/
$params['a'] = 'comment';
$url_comment = http_build_query($params);
$comment_err =     ($_GET['r'] === 'comment') ? $_GET['err'] : '';
$comment_checked = ($_GET['r'] === 'comment') ? 'checked' : '';

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
			<h1 class='top' style='left:1ch'>description</h1>
			<?=$pdesc?>
			</div>
			<div class='border-top' style='grid-area: comm'>
			<h1 class='top' style='left:1ch'>comments</h1>

			<input class='hidden'       type='radio' id='nil_cmt_btn'    name='comment_btns'/>
			<input class='hidden tgl' type='radio' id='addcmt_btn' name='comment_btns' <?=$comment_checked?> />
			<p class='top' style='right:1ch'>
				<label for='addcmt_btn'>add comment</label>
				<label class='invis overlay' for='nil_cmt_btn'>add comment</label>
			</p>
			<!-- Add comment DropDown -->
			<div class='tgl_on' style='display:block'>
				<form action='?<?=$url_comment?>' method='post' id='commnet'>
				<textarea class='box' name="c" rows="5" cols="75" wrap="hard" placeholder='comment'></textarea>
				<p style='font-size:16px'><?=$comment_err?></p>
				<li>rating: <input type='number' min='0' max='5' name='r' value='3'><button form='commnet' type='submit'>send</button></li>
				</form>
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
				<h1 class='top' style='left:1ch'><?=htmlspecialchars($row["username"])?> - rating: <?=$row["rating"]?></h1>
				<pre><?=nl2br(htmlspecialchars($row["comment_desc"]))?></pre>
				</div>
			<?php endwhile; ?>
			</div>
		</div>
</main>
<?php init_script(); ?>
</html>




