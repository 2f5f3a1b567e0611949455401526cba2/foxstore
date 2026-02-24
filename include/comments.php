<?php require './include/db.php'; ?>

<head> 
 <link rel="stylesheet" href="./css/comments.css">   
</head>

<div class="profileinfo">
			
			<?php
				if (session_status() == PHP_SESSION_NONE) {
					// Start a session if there is none
					session_start();
				}
				if (isset($_SESSION["loggedin"])) {
					$user = $_SESSION["username"];
					echo "<p>You're logged in as <span class='username'>$user</span></p>";
					echo "<p><a href='login/?logout=1'>Log out</a></p>";
				} else {
					echo "<p>You are not logged in</p>";
					echo "<p><a href='login/'>Log in here</a></p>";
				}
			?>
		</div>

        <?php

        $prod_id =$_GET["id"];

        $query = $db->prepare("SELECT * FROM comments WHERE product_id=:prod_id");
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

        