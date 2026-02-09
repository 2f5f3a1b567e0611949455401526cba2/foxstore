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
<!--<div class="images">
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
</div>-->