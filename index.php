<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foxstore</title>
</head>
<body>
    This is a great main page
    <?php
        session_start();
        if (isset($_SESSION["loggedin"])) {
            $user = $_SESSION["username"];
            echo "<p>You're logged in as $user</p>";
            echo "<p><a href='login/?logout=1'>Log out</a></p>";
        } else {
            echo "<p>You are not logged in</p>";
            echo "<p><a href='login/'>Log in here</a></p>";
        }
    ?>
</body>
</html>