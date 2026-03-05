<?php 
require_once __DIR__ . '/include/init.php';
require_once __DIR__ . '/include/helper.php';
if (!isset($_SESSION["user_id"])) {
    redirect("./browse.php");
}
$query = $db->prepare("
SELECT orders.order_id AS order_id, username, time, status, address, name AS ship_name, sum(amount) AS total_products, sum(price) as total_price
FROM orders INNER JOIN users ON orders.user_id = users.user_id INNER JOIN order_items ON orders.order_id = order_items.order_id WHERE orders.user_id = :user_id
GROUP BY orders.order_id ORDER BY time DESC;
");
$query->bindParam(":user_id",$_SESSION["user_id"]);

$query->execute();
?>

<!DOCTYPE html>
<html lang="en">
<?php init_head('order'); ?>
<body id='body'>
<main class='noscript page'>
<?php include 'include/header.php'?>
<div class="border-top">
    <h1 class="top" style="left:1ch">your orders</h1>
</div>
<?php include 'include/ordertable.php'?>

</main>
<?php init_script(); ?>
</html>
