<div>
    <label for="name">Product name</label>
    <input type="text" name="name" id="name" minlength="2" required value="<?=$product_name?>">
</div>
<div>
    <label for="desc">Product description</label>
    <textarea name="desc" id="desc" rows="6"><?=$product_desc?></textarea>
</div>
<div>
    <label for="price">Product price</label>
    <div>
        <span>$</span>
        <input type="number" name="price" id="price" value="<?=$product_price?>" min="0.99" step="0.01">
    </div>
</div>
<div class="images">
    <?php
        foreach($images as $imageid => $image_path) {
            echo "<div>";
            echo "<img src='./userimg/$image_path'>";
            echo "<button class='deletebutton' value='$imageid' name='deleteimg'>X</button>";
            echo "</div>";
        }
    ?>

</div>
<div>
    <label for="image">Upload new image</label>
    <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.svg,.webp">
</div>
