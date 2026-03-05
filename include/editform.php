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
    <div class="pricesetter">
        <span>$</span>
        <input type="number" name="price" id="price" value="<?=$product_price?>" min="0.99" step="0.01">
    </div>
</div>
<div>
    <span>Images</span>
    <div class="images">
        <?php
        foreach($images as $imageid => $imgdata) {
            $image_path = $imgdata["path"];
            $alttext = $imgdata["alt"];
            $captext = $imgdata["cap"];
            echo "<div>";
            echo "<div class='imgcontainer'>";
            echo "<img src='../img/products/$image_path'>";
            echo "</div>";
            echo "<div class='imginput'>";
            echo "<div>";
            echo "<label for='imgcap_$imageid'>Image caption</label>";
            echo "<input type='text' name='imgcap_$imageid' id='imgcap_$imageid' value='$captext'>";
            echo "</div>";
            echo "<div>";
            echo "<label for='imgalt_$imageid'>Image alt-text</label>";
            echo "<input type='text' name='imgalt_$imageid' id='imgalt_$imageid' value='$alttext'>";
            echo "</div>";
            echo "<button class='removebutton' value='$imageid' name='deleteimg'>Remove image</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>
        
<div>
    <label for="image">Upload new image</label>
    <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.svg,.webp">
    
</div>