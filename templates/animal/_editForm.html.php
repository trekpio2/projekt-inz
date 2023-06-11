<?php
    /** @var $animal ?\App\Model\Animal */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group animal">
    <label for="animal_name">Name</label>
    <input type="text" id="animal_name" name="animal[animal_name]" value="<?= $animal ? $animal->getAnimalName() : '' ?>">
</div>

<div class="form-group animal">
    <label for="animal_gender">Gender</label>
    <input type="text" id="animal_gender" name="animal[animal_gender]" value="<?= $animal ? $animal->getAnimalGender() : '' ?>">
</div>

<div class="form-group animal">
    <label for="color">Color</label>
    <input type="text" id="color" name="animal[color]" value="<?= $animal ? $animal->getColor() : '' ?>">
</div>

<div class="form-group animal">
    <label for="species_name">Species</label>
    <input type="text" id="species_name" name="animal[species_name]" value="<?= $animal ? $animal->getSpeciesName() : '' ?>">
</div>

<div class="form-group animal">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="animal[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $animal->getAquariumId() == $aquarium->getAquariumId() ? 'selected' : '' ?>>
                <?= $aquarium ? $aquarium->getAquariumName() : '' ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group animal">
    <label for="animal_image">image</label>
    <div class="animalPhoto">
        <img id="imagePreview" src="<?= $animal ? $animal->getAnimalImage() : '' ?>" alt="current animal image" style="height: 137px; width: 288px; object-fit: cover; border-radius: 47px">
    </div>
    <input class="imageInput" type="file" id="animal_image" name="animal_image"  accept="image/png, image/jpeg">
</div>




<div class="form-group animal">
    <label></label>
    <input type="submit" value="Submit">
</div>
