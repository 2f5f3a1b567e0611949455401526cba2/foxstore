<?php
    
    require "./includes/helper.php";
    $error = "";
    if (post_contains(["username","password"])) {
        require "./includes/db.php";
    
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $statement = $db->prepare('SELECT * FROM admins WHERE username=:username');
        //$statement = $db->prepare('INSERT INTO admins (username, password) VALUES (:username, :password);');
        $statement->bindParam(':username', $username);
        $statement->execute();
        if ($row = $statement->fetch()) {
            // Found matching user
            if (password_verify($password,$row["password"])) {
                session_start();
                $_SESSION['admin'] = true;
                redirect("./");
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
    <title>Admin login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <form action="./login.php" method="post" class="login vform">
            <h1>Admin login</h1>
            <div>
                <label for="username">Användarnamn</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Lösenord</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit">Logga in</button>
            <p class="error"><?=$error?></p>
        </form>
    </div>
</body>
</html>
