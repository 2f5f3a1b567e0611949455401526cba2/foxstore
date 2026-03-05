<?php
    require '../include/db.php';
    require '../include/helper.php';
    require '../include/checkadmin.php';

    function get_full_img_path($imgname) {
        $imgdir = "../img/products/";
        return $imgdir . $imgname;
    }

    // Upload an image and return the file name or an empty string if there was an error
    function upload_image() {
        $imgfile = $_FILES["image"];
        // Create a new unique filename, like backpack.png becomes backpack_3ab8213e.png
        $fileName =  "";
        $targetPath = "";
        // we keep on randomizing until the file doesn't exist already
        while($fileName == "" || file_exists($targetPath)) {
            $nameinfo =  pathinfo($imgfile["name"]);
            $randomStr = bin2hex(openssl_random_pseudo_bytes(4));
            $fileName = $nameinfo["filename"] . "_" . $randomStr . "." . $nameinfo["extension"];
            $targetPath = get_full_img_path($fileName);
        }

        
        // TODO: Check that the file really is an image

        if ($imgfile["size"] > 4000000) {
            // File was to big (> 4MB)
            return "";
        }
        
        // Upload the image
        if (move_uploaded_file($imgfile["tmp_name"], $targetPath)) {
            // It worked!
            return htmlspecialchars($fileName);
        } else {
            return "";
        }
    }

    function handle_alt_text($pid) {
        global $db;
        // First get all image ids for this product
        $statement = $db->prepare('SELECT * FROM images WHERE product_id=:product_id');
        $statement->bindParam(':product_id', $pid);
        $statement->execute();
        while(($row = $statement->fetch())) {
            $imgid = $row["id"];
            $alttext = "";
            $captext = "";
            if (isset($_POST["imgalt_$imgid"])) {
                $alttext = $_POST["imgalt_$imgid"];
            }
            if (isset($_POST["imgcap_$imgid"])) {
                $captext = $_POST["imgcap_$imgid"];
            }
            if ($alttext != "" || $captext != "") {
                // Update db
                $statement2 = $db->prepare("UPDATE images SET image_alt = :alttext, image_cap = :captext WHERE id = :img_id");
                $statement2->bindParam(":alttext",$alttext);
                $statement2->bindParam(":captext",$captext);
                $statement2->bindParam(":img_id",$imgid);
                $statement2->execute();
            }
        }

    }

    function delete_image($imgid) {
        global $db;
        // First get the image name that we need later
        $statement = $db->prepare("SELECT image_path FROM images WHERE id = :img_id;");
        $statement->bindParam(':img_id', $imgid);
        if (!$statement->execute()) {
            return; // An error, abort
        }
        $imgname = $statement->fetch()["image_path"];


        // Then delete the image path from the database
        $statement = $db->prepare("DELETE FROM images WHERE id = :img_id;");
        $statement->bindParam(':img_id', $imgid);
        if (!$statement->execute()) {
            return; // An error happend when deleting, abort
        }
        // Now delete it from the file system
        $imgpath = get_full_img_path($imgname);
        if (file_exists($imgpath)) {
            unlink($imgpath); // This deletes the file
        }
    }

    function handle_image($pid) {
        global $db;
        $path = upload_image();
        if ($path == "") {
            return; // An error occured
        }

        // Now add the path in the database
        $statement = $db->prepare("INSERT INTO images (product_id, image_path) VALUES (:product_id, :path);");
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
        $pid = 0;
        if (!$createNew) {
            $pid = $_POST["pid"];
            $statement->bindParam(':product_id', $pid);
        }
        $statement->execute();
        if ($createNew) {
            // Get the new pid
            $pid = $db->lastInsertId();
        }
        
        if ($_FILES["image"]) {
            handle_image($pid); // Add image to db and filesystem
        }
        handle_alt_text($pid);
        if (isset($_POST["deleteimg"])) {
            delete_image($_POST["deleteimg"]);
        }
        
        redirect("./edit.php?edit_id=$pid");
        

    }

    handle_update();

    
?>