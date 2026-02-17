<?php
    require './includes/db.php';
    require './includes/helper.php';
    require './includes/checklogin.php';

    // Upload an image and return the file name or an empty string if there was an error
    function upload_image() {
        $imgDir = "./userimg/";
        $imgfile = $_FILES["image"];
        $targetPath = $imgDir . basename($imgfile["name"]);
        
        // TODO: Check that the file really is an image

        if ($imgfile["size"] > 2000000) {
            // File was to big (> 2MB)
            return "";
        }
        
        // Upload the image
        if (move_uploaded_file($imgfile["tmp_name"], $targetPath)) {
            // It worked!
            return htmlspecialchars($imgfile["name"]);
        } else {
            return "";
        }
    }

    function handle_image($pid) {
        global $db;
        $path = upload_image();
        if ($path == "") {
            return; // An error occured
        }

        // Now add the path in the database
        $statement = $db->prepare("INSERT INTO images (product_id, image_path) VALUES (:product_id, :path)");
        $statement->bindParam(':product_id',$pid);
        $statement->bindParam(':path',$path);
        $statement->execute();

    }

    // Main function
    function handle_update() {
        global $db;
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
        
        if ($_FILES["image"]) {
            handle_image($_POST["pid"]); // Add image to db and filesystem
        }
        
    
        if ($createNew) {
            redirect('./');
        } else {
            redirect("./edit.php?edit_id=$pid");
        }

    }

    handle_update();

    
?>