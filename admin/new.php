<?php
require '../include/checkadmin.php';
require_once '../include/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php init_head('new product'); ?>
<body>
    <main class="page">
        <?php include '../include/header.php'?>
        <h1>creating new product</h1>
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