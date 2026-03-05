<?php
$params = $_GET;
unset($params['r']);
unset($params['err']);
/*----------------------------------------------------------------------------*/
$params['a'] = 'theme';
$url_theme = http_build_query($params);

$params['a'] = 'account_login';
$url_login = http_build_query($params);

$params['a'] = 'account_logout';
$url_logout = http_build_query($params);

$isAdminpage = str_contains($_SERVER['REQUEST_URI'],"admin");


$login_err =     (($_GET['r'] ?? null) === 'account_login') ? $_GET['err'] : '';
$login_checked = (($_GET['r'] ?? null) === 'account_login') ? 'checked' : '';


?>

<header class='vcenter' style='z-index:+1;'>
<input class='hidden' type='radio' id='nil_btn' name='header_btns'/>

<a href='/foxstore/browse.php'>browse</a>

<?php if (!$isAdminpage): ?>

<!-- Search Button -->
<input class='hidden tgl' type='radio' id='search_btn' name='header_btns'/>
<p class='rel'>
	<label for='search_btn'>search</label>
	<label class='invis overlay' for='nil_btn'>search</label>
</p>
<!-- Search Drop Down -->
<div class='dd tgl_on'>
	<form action='/foxstore/browse.php' method='get' id='search' style='left:0.5ch'>
	<input type='search' id='search' name='s' placeholder='search'>
	<select name="sort" id="sort">
	<option value="">sort</option>
	<option value="priceu">price ↑</option>
	<option value="priced">price ↓</option>
	<option value="rateu">rating ↑</option>
	<option value="rated">rating ↓</option>
	</select>
	</form>
	<button form='search' type='submit'>apply</button>
</div>


<?php if ($_SERVER['PHP_SELF'] !== '/foxstore/order.php'): ?>
<!-- Cart Button -->
<input class='hidden tgl' type='radio' id='cart_btn' name='header_btns'/>
<p class='rel'>
	<label for='cart_btn'>cart</label>
	<label class='invis overlay' for='nil_btn'>cart</label>
</p>
<!-- Cart Drop Down -->
<iframe class='dd cart tgl_on' style='left:1ch' src='cart.php' name='ifCart'></iframe>
<?php endif; ?>
<?php endif; ?>

<!-- Admin link -->
 <?php if (isset($_SESSION["admin"])): ?>
<a href="/foxstore/admin/">admin page</a>
<?php endif; ?>

<!-- Theme Button -->
<input class='hidden tgl' type='radio' id='theme_btn' name='header_btns'/>
<p class='rel' style='margin-left:auto'>
	<label for='theme_btn'>☼</label>
	<label class='invis overlay' for='nil_btn'>☼</label>
</p>
<!-- Theme Drop Down -->
<form class='dd tgl_on' action='?<?=$url_theme?>' method='post' id='theme' style='right:0.5ch'>
	<li><input type=color id='input_fg' name='fg' value=<?=$_SESSION['fg']?> />
	<label for='input_fg'>foreground</label></li>
	<li><input type=color id='input_br' name='br' value=<?=$_SESSION['br']?> />
	<label for='input_br'>border</label></li>
	<li><input type=color id='input_bg' name='bg' value=<?=$_SESSION['bg']?> />
	<label for='input_bg'>background</label></li>
	<button type='submit'>apply</button>
</form>



<?php if (!isset($_SESSION['user_id'])): ?>
<!-- Login Button -->
<input class='hidden tgl' type='radio' id='login_btn' name='header_btns' <?=$login_checked?>/>
<p class='rel'>
	<label for='login_btn'>login</label>
	<label class='invis overlay' for='nil_btn'>login</label>
</p>
<!-- Login Drop Down -->
<div class='dd tgl_on'  style='right:0.5ch'>
<form action='?<?=$url_login?>' method='post' id='login'>
	<input type='text'     name='user' placeholder='username'>
	<input type='password' name='pass' placeholder='password'>
	<b style='font-size:16px'><?=$login_err?></b>
</form>
	<button form='login' type='submit'>login</button>
	<a href='signup.php' style='margin-left:auto' target='_top'>signup</a>
</div>



<?php else: ?>
<!-- Profile Button -->
<input class='hidden tgl' type='radio' id='BtnProfile' name='header_btns' <?=$login_checked?> />
<p class='rel'>
	<label for='BtnProfile' ><?=htmlspecialchars($_SESSION['username'])?></label>
	<label class='invis overlay' for='nil_btn'><?=$_SESSION['username']?></label>
</p>
<!-- Profile Drop Down -->
<form class='dd tgl_on' action='?<?=$url_logout?>' method='post' id='logout'
style='right:-0.5ch'>
	<button form='logout' type='submit'>logout</button>
</form>



<?php endif; ?>
</header>

