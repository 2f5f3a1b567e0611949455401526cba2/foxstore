<?php
    require '../include/checkadmin.php';
    require '../include/db.php';
    if (post_contains(["oid","status"])) {
        
        $statement = $db->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id;");

        $oid = $_POST["oid"];
        $status = $_POST["status"];
        $statement->bindParam(':order_id', $oid);
        $statement->bindParam(':status', $status);
        
        $statement->execute();
        
    }
    header('Location: ./');
?>