<?php
    /** @var $animal ?\App\Model\Animal */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="animal_name">Name</label>
    <input type="text" id="animal_name" name="animal[animal_name]">
</div>

<div class="form-group">
    <label for="animal_gender">Gender</label>
    <input type="text" id="animal_gender" name="animal[animal_gender]">
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" id="color" name="animal[color]" value="<?= $animal ? $animal->getColor() : '' ?>">
</div>

<div class="form-group">
    <label for="species_name">Species</label>
    <input type="text" id="species_name" name="animal[species_name]">
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="animal[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value=<?= $aquarium ? $aquarium->getAquariumId() : '' ?>><?= $aquarium ? $aquarium->getAquariumName() : '' ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="animal_image">image</label>
    <input type="file" id="animal_image" name="animal_image">
</div>



<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
