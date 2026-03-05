<?php
    require '../include/db.php';
    require '../include/helper.php';
    require '../include/checkadmin.php';
    require_once '../include/init.php';
    
    if (isset($_GET["order_id"])) {
        $order_id = $_GET["order_id"];
    } else {
        header('Location: ./');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="sv">
<?php init_head('admin page'); ?>
<body>
    <?php init_head('index'); ?>
    <main class="page">
        <?php include '../include/header.php'?>
        <div class="border-top">
            <h1 class="top" style="left:1ch">admin page</h1>
        </div>
        <table>
            <tr>
                <td>OrderID</td>
                <td>Customer</td>
                <td>Total products</td>
                <td>Total Price</td>
                <td>Time</td>
                <td>Status</td>
                <td></td>
            </tr>
            <?php 
                $query = $db->query('SELECT orders.order_id, username, time, status, sum(amount) AS total_items, sum(price) as total_price FROM orders INNER JOIN users ON orders.user_id = users.user_id INNER JOIN order_items ON orders.order_id = order_items.order_id;');
                while(($row = $query->fetch())) {
                    $order_id = htmlspecialchars($row["name"]);
                    $id = $row["product_id"];
                    $price = $row["price"];
                    $stock = $row["stock"];
                    $disabled = $stock == 0 ? "disabled" : "";
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$pname</td>";
                    echo "<td>$$price</td>";
                    echo "<td><a href='edit.php?edit_id=$id'>Edit</a></td>";
                    echo "</tr>";
                }
            ?>
            
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href='new.php'>Add new</a></td>
            </tr>
        </table>
        
    </main>
</body>
</html>