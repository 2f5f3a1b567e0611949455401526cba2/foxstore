<?php
    
    require "../include/helper.php";
    $error = "";
    
    if (post_contains(["username","password","password2"])) {
        require "../include/db.php";
    
        $username = $_POST["username"];
        if ($_POST["password"] == $_POST["password2"]) {
            $password = password_hash($_POST["password"],PASSWORD_BCRYPT);
            $statement = $db->prepare('INSERT INTO users (username,password) VALUES (:username, :password)');
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            try {
                if ($statement->execute()) {
                    // Sucess!
                    session_start();
                    $_SESSION["username"] = $username;
                    $_SESSION["logged_in"] = true;
                    $_SESSION["user_id"] = $db->lastInsertId();
                    redirect("../"); // redirect to main page
                } else {
                    $error = "An error occured while creating the account";
                }
            }
            catch (Exception $e) {
                $error = "An error occured while creating the account";
            }
            
        } else {
            $error = "Missmatching passwords";
        }
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/default.css">
</head>
<body>
    <?php
        require '../include/header.php';
    ?>
    <div>
        <form action="./signup.php" method="post" class="login vform">
            <h1>Store signup</h1>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="password">Confirm Password</label>
                <input type="password" name="password2" id="password2">
            </div>
            <button type="submit">Sign up</button>
            <p>Already have an account? <a href="./">Log in</a>!</p>
            <p class="error"><?=$error?></p>
        </form>
    </div>
</body>
</html>
