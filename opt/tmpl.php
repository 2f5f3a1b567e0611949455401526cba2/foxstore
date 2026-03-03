<?php if (!isset($pID)){echo "No Such pID"; return; } ?>
<form class='border-top' style='grid-area:form;' action='cart.php?a=cart_add' method='post' target='ifCart'>
<h1><?=$pname?></h1>
<input type='hidden' name='pID' value='<?=$pID?>'>

<div style='display:flex; gap: 1ch;'>
<input class='num' type='number' min='0' max='99' name='cnt' value='1' style='width: 4ch'>

<?php
if (!isset($_SESSION['user_id'])){
	echo "<label for='BtnLogin'>add to cart</label>";}
else{echo "<button type='submit'>add to cart</button>";}
?>
</div>

</form>


