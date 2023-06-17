<?php
    /** @var $plant ?\App\Model\Plant */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="plant_name">Name</label>
    <input type="text" required id="plant_name" name="plant[plant_name]"  value="<?=$_SESSION['request']['plant_name']?>">
</div>


<div class="form-group">
    <label for="species_name">Species</label>
    <input type="text" required id="species_name" name="plant[species_name]"  value="<?=$_SESSION['request']['species_name']?>">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" required id="color" name="plant[color]"  value="<?=$_SESSION['request']['color']?>">
</div>

<div class="form-group">
    <label for="plant_height">Height</label>
    <input type="number" required id="plant_height" name="plant[plant_height]"  value="<?=$_SESSION['request']['plant_height']?>">
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="plant[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $_SESSION['request']['aquarium_id'] == $aquarium->getAquariumId() ? 'selected' : '' ?>>
                <?= $aquarium->getAquariumName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="plant_image">image</label>
    <div class="animalPhoto">    
        <img id="imagePreview" src="public/assets/dist/img/leaves-of-a-plant.png" alt="current plant image" style="max-width: 288px; max-height: 137px; object-fit: cover; border-radius: 47px">
    </div>
    <input type="file" id="plant_image" name="plant_image" accept="image/png, image/jpeg">
</div>



<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
