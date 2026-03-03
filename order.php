<?php 
require_once __DIR__ . '/include/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php init_head('index'); ?>
<body id='body' style='color:var(--fg);background:var(--bg);'>
<main class='noscript page'>
<?php include 'include/header.php'?>
<div>
	<iframe class='cart' src='cart.php?order' name='ifCart'></iframe>

</div>
</main>
<?php init_script(); ?>
</html>
