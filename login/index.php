<?php
    
    require "../include/helper.php";
    $error = "";
    if (isset($_GET["logout"])) {
        session_start();
        session_destroy();
    }
    if (post_contains(["username","password"])) {
        require "../include/db.php";
    
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $statement = $db->prepare('SELECT * FROM users WHERE username=:username');
        //$statement = $db->prepare('INSERT INTO admins (username, password) VALUES (:username, :password);');
        $statement->bindParam(':username', $username);
        $statement->execute();
        if ($row = $statement->fetch()) {
            // Found matching user
            if (password_verify($password,$row["password"])) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row["user_id"];
                if ($row["user_type"] == "admin") {
                    $_SESSION['admin'] = true;
                    redirect("../adminpage");
                } else {
                    unset($_SESSION['admin']);
                    redirect("../");
                }
                
            }
        }
        $error = "Invalid username/password";
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store login</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <div>
        <form action="./" method="post" class="login vform">
            <h1>Store login</h1>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit">Log in</button>
            <p>Don't have an account? <a href="./signup.php">Sign up</a>!</p>
            <p class="error"><?=$error?></p>
        </form>
    </div>
</body>
</html>
