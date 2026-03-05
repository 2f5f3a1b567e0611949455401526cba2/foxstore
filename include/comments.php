<?php require './include/db.php'; ?>

<head> 
 <link rel="stylesheet" href="./css/comments.css">   
</head>

        <?php

        $prod_id =$_GET["id"];

        $query = $db->prepare("SELECT * FROM comments c 
        inner join users 
        on c.user_id =users.user_id 
        WHERE product_id=:prod_id");
        $query->bindParam(':prod_id', $prod_id);
        $query->execute();
        while($row = $query->fetch()){
            echo 
            "
            <hr>
            {$row["username"]} - Rating: {$row["rating"]}
            <hr>
            {$row["comment_desc"]}   
            <hr>
            ";
        };

        ?>
