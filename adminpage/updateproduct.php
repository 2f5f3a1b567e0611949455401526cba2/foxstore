<?php
    require './includes/db.php';
    require './includes/helper.php';
    require './includes/checklogin.php';
    if (!post_contains(['name','desc','price'])) {
        redirect("./");
    }
        
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $price = $_POST["price"];
    $createNew = isset($_POST["new"]) && $_POST["new"] == "1";
    $statement = NULL;
    if ($createNew) {
        // INSERT query
        $statement = $db->prepare("INSERT INTO products (name, description, price) VALUES (:name, :desc, :price)");
    } else {
        // UPDATE query
        $statement = $db->prepare("UPDATE products SET name = :name, description = :desc, price = :price WHERE product_id = :product_id");
    }
    
    $statement->bindParam(':name', $name);
    $statement->bindParam(':desc', $desc);
    $statement->bindParam(':price', $price);
    if (!$createNew) {
        $pid = $_POST["pid"];
        $statement->bindParam(':product_id', $pid);
    }
    $statement->execute();
    if ($createNew) {
        header('Location: ./');
    } else {
        header("Location: ./edit.php?edit_id=$pid");
    }
    
?>