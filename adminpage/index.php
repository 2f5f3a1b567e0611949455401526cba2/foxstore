<?php
    require '../include/db.php';
    require '../include/helper.php';
    require '../include/checkadmin.php';
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affär admin</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/default.css">
</head>
<body>
    <main>
        <h1>Admin</h1>
        <p><a href="../login/?logout=1">Log out</a></p>
        <table>
            <tr>
                <td>ProductID</td>
                <td>Product Name</td>
                <td>Price</td>
                <td>Stock</td>
                <td></td>
            </tr>
            <?php 
                $query = $db->query('SELECT product_id, name, stock, price FROM products');
                while(($row = $query->fetch())) {
                    $pname = htmlspecialchars($row["name"]);
                    $id = $row["product_id"];
                    $price = $row["price"];
                    $stock = $row["stock"];
                    $disabled = $stock == 0 ? "disabled" : "";
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$pname</td>";
                    echo "<td>$$price</td>";
                    echo "<td>";
                    echo "<form class='stock' action='updatestock.php' method='post'>";
                    echo "<input type='submit' style='display:none;'><button name='change' value='-1' $disabled>-</button><input type='text' name='stock' value='$stock'><button name='change' value='1'>+</button><input type='hidden' name='pid' value='$id'></form>";
                    echo "</td>";
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