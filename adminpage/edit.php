<?php
    require '../include/checklogin.php';
    
    if (isset($_GET["edit_id"])) {
        $product_id = $_GET["edit_id"];
    } else {
        header('Location: ./');
        exit;
    }

    require '../include/db.php';
    $statement = $db->prepare('SELECT * FROM products WHERE product_id=:product_id');
    $statement->bindParam(':product_id', $product_id);
    $statement->execute();
    $row = $statement->fetch();
    $product_name = $row["name"];
    $product_desc = $row["description"];
    $product_price = $row["price"];

    $statement = $db->prepare('SELECT * FROM images WHERE product_id=:product_id');
    $statement->bindParam(':product_id', $product_id);
    $statement->execute();
    $images = []; // Associative array mapping image id to image path
    while(($row = $statement->fetch())) {
        $images[$row["id"]] = $row["image_path"];
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product <?=$product_name?></title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <main>
        <h1>Editing product ID <?=$product_id?> (<?=$product_name?>)</h1>
        <a href="./">Back</a>
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