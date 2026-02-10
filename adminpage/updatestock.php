<?php
    require './includes/db.php';
    if (isset($_POST["pid"]) && (isset($_POST["stock"]))) {
        $pid = $_POST["pid"];
        $newStock = $_POST["stock"];
        if (isset($_POST["change"])) {
            $newStock += $_POST["change"];
        }
        
        $statement = $db->prepare("UPDATE products SET stock = :stock WHERE product_id = :product_id");
        $statement->bindParam(':stock', $newStock);
        $statement->bindParam(':product_id', $pid);
        $statement->execute();
        
    }
    header('Location: ./')
?>