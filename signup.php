<?php 
require_once __DIR__ . '/include/init.php';
$signup_err = (($_GET['r'] === 'account_login') ? $_GET['err'] : '');
?>

<!DOCTYPE html>
<html lang="en">
<?php init_head('index'); ?>
<body id='body' style='color:var(--fg);background:var(--bg);'>
<main class='noscript page'>
    <?php include 'include/header.php'?>
	<div class='vcenter' style='justify-content:center;height:calc(100vh - 2em);'>
	<form action="browse.php?a=account_signup" method="post" style='display: flex;flex-direction:column;'>
		<input type="text" name="user" id="user" placeholder="username">
		<input type="password" name="pass"  id="pass" placeholder="password">
        
		<b style='font-size:16px;height:1em;'><?=$signup_err?></b>
		<button type="submit">sign up</button>
	</form>
	</div>
</main>
<?php init_script(); ?>
</html>




