<?php
require '../include/checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new product</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <main>
        <h1>Creating new product</h1>
        <a href="./">Back</a>
        <form action="updateproduct.php" class="editform vform" method="post" enctype="multipart/form-data">
            <input type="hidden" name="new" value="1">
            <?php
                $product_name = "New product";
                $product_desc = "";
                $product_price = "4.99";
                $images = [];
                require "../include/editform.php";
            ?>
            <button>Create</button>
        </form>
    </main>
</body>
</html>