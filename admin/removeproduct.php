<?php
    require '../include/checkadmin.php';
    require '../include/db.php';
    if (isset($_POST["pid"])) {
        
        $statement = $db->prepare("DELETE FROM products WHERE product_id = :product_id");

        $pid = $_POST["pid"];
        $statement->bindParam(':product_id', $pid);
        
        $statement->execute();
        
    }
    header('Location: ./');
?>