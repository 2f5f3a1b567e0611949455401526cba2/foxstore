<?php
    require '../include/db.php';
    require '../include/checkadmin.php';
    require_once '../include/init.php';
    
    if (isset($_GET["edit_id"])) {
        $product_id = $_GET["edit_id"];
    } else {
        header('Location: ./');
        exit;
    }

    $statement = $db->prepare('SELECT * FROM products WHERE product_id=:product_id');
    $statement->bindParam(':product_id', $product_id);
    $statement->execute();
    $row = $statement->fetch();
    $product_name = htmlspecialchars($row["name"]);
    $product_desc = htmlspecialchars($row["description"]);
    $product_price = htmlspecialchars($row["price"]);

    $statement = $db->prepare('SELECT * FROM images WHERE product_id=:product_id');
    $statement->bindParam(':product_id', $product_id);
    $statement->execute();
    $images = []; // Associative array mapping image id to [imagepath, alttext, captext]
    while(($row = $statement->fetch())) {
        $images[$row["id"]] = ["path"=>htmlspecialchars($row["image_path"]),"alt"=>htmlspecialchars($row["image_alt"]),"cap"=>htmlspecialchars($row["image_cap"])];
    }


?>

<!DOCTYPE html>
<html lang="en">
<?php init_head("edit product $product_name"); ?>
<body>
    <main class="page">
        <?php include '../include/header.php'?>
        <div class="border-top">
            <h1 class="top" style="left:1ch">editing product ID <?=$product_id?> (<?=$product_name?>)</h1>
        </div>
        <form action="updateproduct.php" class="editform vform" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?=$product_id?>">
            <?php
                require "../include/editform.php";
            ?>
            <button>Update</button>
        </form>
        <form action="removeproduct.php" class="removeform" method="post">
            <input type="hidden" name="pid" value="<?=$product_id?>">
            <button class="removebutton">Remove product</button>
        </form>
    </main>
</body>
</html>