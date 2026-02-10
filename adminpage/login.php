<?php
    session_start();
    require "./includes/helper.php";

    if (!post_contains(["username","password"])) {
        return;
    }

    require "./includes/db.php";

    $username = $_POST["username"];
    $password = password_hash($_POST["password"]);

    $statement = $db->prepare('SELECT * FROM admins WHERE username=:username AND password=:password');
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->execute();
    if ($statement->fetch()) {
        // Found matching admin
        $_SESSION['admin'] = true;
        redirect("./");
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
        </form>
    </div>
</body>
</html>