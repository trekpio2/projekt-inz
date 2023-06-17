<?php
    /** @var $animal ?\App\Model\Animal */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="animal_name">Name</label>
    <input type="text" required id="animal_name" name="animal[animal_name]" value="<?=$_SESSION['request']['animal_name']?>">
</div>

<div class="form-group">
    <label for="animal_gender">Gender</label>
    <input type="text" required id="animal_gender" name="animal[animal_gender]" value="<?=$_SESSION['request']['animal_gender']?>">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" required id="color" name="animal[color]" value="<?=$_SESSION['request']['color']?>">
</div>

<div class="form-group">
    <label for="species_name">Species</label>
    <input type="text" required id="species_name" name="animal[species_name]"value="<?=$_SESSION['request']['species_name']?>">
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="animal[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $_SESSION['request']['aquarium_id'] == $aquarium->getAquariumId() ? 'selected' : '' ?>>
                <?= $aquarium->getAquariumName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="animal_image">image</label>
    <div class="animalPhoto">
        <img id="imagePreview" src="public/assets/dist/img/paw.png" alt="current animal image" style="max-width: 288px; max-height: 137px; object-fit: cover; border-radius: 47px">
    </div>
    <input type="file" id="animal_image" name="animal_image" accept="image/png, image/jpeg">
</div>



<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
