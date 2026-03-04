<?php 
require_once __DIR__ . '/include/init.php';

$params = $_GET;
unset($params['r']);
unset($params['err']);
/*----------------------------------------------------------------------------*/
$params['a'] = 'order';
$url_order = http_build_query($params);


/*----------------------------------------------------------------------------*/
$order_err = ($_GET['r'] === 'order') ? $_GET['err'] ?? null : null;
?>

<!DOCTYPE html>
<html lang="en">
<?php init_head('order'); ?>
<body id='body' style='color:var(--fg);background:var(--bg);'>
<main class='noscript page'>
<?php include 'include/header.php'?>
<div style='display:grid; grid-template-columns:1fr 1fr;gap:1ch;'>
	<iframe class='cart' src='cart.php?order' name='ifCart'></iframe>
	<div class='border-top'>
		<h1>order info</h1>
		<form id='order' action='?<?=$url_order?>' method='post' style='padding-bottom: 1ch'>
			<li><input type='text' name='name' placeholder='name'></li>
			<li><input type='text' name='addr' placeholder='address'></li>
		</form>
		<p style='font-size:16px'><?=$order_err?></p>
		<button form='order'>order</button>
	</div>

</div>
</main>
<?php init_script(); ?>
</html>
