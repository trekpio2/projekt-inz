<?php
    /** @var $plant ?\App\Model\Plant */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="plant_name">Name</label>
    <input type="text" required id="plant_name" name="plant[plant_name]" value="<?= $_SESSION['request']['plant_name'] ? $_SESSION['request']['plant_name'] : $plant->getPlantName() ?>">
</div>


<div class="form-group">
    <label for="species_name">Species</label>
    <input type="text" required id="species_name" name="plant[species_name]" value="<?= $_SESSION['request']['species_name'] ? $_SESSION['request']['species_name'] : $plant->getSpeciesName() ?>">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" required id="color" name="plant[color]" value="<?= $_SESSION['request']['color'] ? $_SESSION['request']['color'] : $plant->getColor() ?>">
</div>

<div class="form-group">
    <label for="plant_height">Height</label>
    <input type="number" required id="plant_height" name="plant[plant_height]" value="<?= $_SESSION['request']['plant_height'] ? $_SESSION['request']['plant_height'] : $plant->getPlantHeight() ?>">
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="plant[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"
                <?php
                    if($_SESSION['request']['aquarium_id']) {
                        echo ($_SESSION['request']['aquarium_id'] == $aquarium->getAquariumId()) ? 'selected' : '';
                    } else {
                        echo ($plant->getAquariumId() == $aquarium->getAquariumId()) ? 'selected' : '';
                    }
                ?>
            >
                <?= $aquarium->getAquariumName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="plant_image">image</label>
    
    <div class="animalPhoto">    
        <img id="imagePreview" src="<?= $plant ? $plant->getPlantImage() : 'public/assets/dist/img/leaves-of-a-plant.png' ?>" alt="current plant image" style="height: 137px; width: 288px; object-fit: cover; border-radius: 47px">
    </div>
    <input class="imageInput" type="file" id="plant_image" name="plant_image" accept="image/png, image/jpeg">
</div>




<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
