<?php
    if (isset($_GET["edit_id"])) {
        $productID = $_GET["edit_id"];
    } else {
        header('Location: ./');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Editing product ID <?=$productID?></h1>
        <a href="./">Back</a>
        
        <form action="" class="editform vform" method="post">
            <div>
                <label for="name">Product name</label>
                <input type="text" name="name" id="name" minlength="2" required value="Trampoline">
            </div>
            <div>
                <label for="desc">Product description</label>
                <textarea name="desc" id="desc" rows="6">It goes boing boing</textarea>
            </div>
            <div>
                <label for="price">Product price</label>
                <div>
                    <span>$</span>
                    <input type="number" name="price" id="price" value="9.99" min="0.99">
                </div>
            </div>
            <div class="images">
                <div>
                    <img src="img/trampoline.jpg" alt="trampoline">
                    <button class="deletebutton">X</button>
                </div>
                <div>
                    <button class="deletebutton">X</button>
                    <img src="img/trampoline2.jpg" alt="trampoline2">
                </div>

            </div>
            <div>
                <label for="image">Upload images</label>
                <input type="file" name="image" id="image">
            </div>
            <button >Update</button>
        </form>
    </main>
</body>
</html>