<?php 
require_once __DIR__ . '/include/init.php';

$params = $_GET;
unset($params['r']);
unset($params['err']);
/*----------------------------------------------------------------------------*/
$params['a'] = 'cart_mod';
$url_cart_mod = http_build_query($params);


?>

<!DOCTYPE html>
<html lang="en">
<?php init_head('cart'); ?>
<body>
<main class='noscript box' id='ifcart-body'>
	<form class='table' style='grid-template-columns: 11ch auto 11ch 11ch;' 
		id='cart-mod' method='post'> 
<?php 
	$tot = 0;

	if (isset($_SESSION['user_id'])){
		$uID = (int)$_SESSION['user_id'];

		$st = $db->prepare('
			SELECT p.name, p.price, p.stock, c.product_id, c.amount 
			FROM cart c 
			INNER JOIN products p ON 
				p.product_id = c.product_id
			WHERE user_id=:uID
		');
		$st->execute([':uID' => $uID]); 
		while ($row = $st->fetch()){
			$sum = $row['amount'] * $row['price']; $tot = $tot + $sum;

			$price = number_format($row['price'], 2);
			$sum   = number_format($sum,          2);

			echo "
				<input class='num left' type='number' min='0' max='99' 
				 name='{$row['product_id']}' value='{$row['amount']}' style='width: 4ch'>
				<a class='str' href='./prod.php?pID={$row['product_id']}' 
					target='_parent'>{$row['name']}</a>
				<div class='num'>{$price}</div><div class='num'>{$sum}</div>";
		}
		$tot = number_format($tot, 2);
	}
	echo "<b>total</b><b></b><b></b><b class='num'>{$tot}</b>";
?>
	</form>
	<div style='display:flex; gap: 1ch; border-top: 1px solid var(--br)'>
	<button form='cart-mod' type='submit' formaction='?<?=$url_cart_mod?>'>apply</button>
	<?php if (!isset($_GET['order'])): ?>
	<button form='cart-mod' type='submit' formaction='order.php?<?=$url_cart_mod?>' formtarget='_top'>order</button>
	<?php endif; ?>
	</div>
</main>
<?php init_script(); ?>
</html>


