<?php
    /** @var $plant ?\App\Model\Plant */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="plant_name">Name</label>
    <input type="text" id="plant_name" name="plant[plant_name]" value="<?= $plant ? $plant->getPlantName() : '' ?>">
</div>


<div class="form-group">
    <label for="species_name">Species</label>
    <input type="text" id="species_name" name="plant[species_name]" value="<?= $plant ? $plant->getSpeciesName() : '' ?>">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" id="color" name="plant[color]" value="<?= $plant ? $plant->getColor() : '' ?>">
</div>

<div class="form-group">
    <label for="plant_height">Height</label>
    <input type="text" id="plant_height" name="plant[plant_height]" value="<?= $plant ? $plant->getPlantHeight() : '' ?>">
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="plant[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $plant->getAquariumId() == $aquarium->getAquariumId() ? 'selected' : '' ?>><?= $aquarium ? $aquarium->getAquariumName() : '' ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="plant_image">image</label>
    
    <div class="animalPhoto">    
        <img id="imagePreview" src="<?= $plant ? $plant->getPlantImage() : '' ?>" alt="current plant image" style="max-width: 288px; max-height: 137px; object-fit: cover; border-radius: 47px">
    </div>
    <input class="imageInput" type="file" id="plant_image" name="plant_image" accept="image/png, image/jpeg">
</div>




<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
