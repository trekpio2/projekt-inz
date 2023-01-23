<?php
    /** @var $animal ?\App\Model\Animal */
?>

<div class="form-group">
    <label for="animal_name">Name</label>
    <input type="text" id="animal_name" name="animal[animal_name]" value="<?= $animal ? $animal->getAnimalName() : '' ?>">
</div>

<div class="form-group">
    <label for="animal_gender">Gender</label>
    <input type="text" id="animal_gender" name="animal[animal_gender]" value="<?= $animal ? $animal->getAnimalGender() : '' ?>">
</div>

<!-- jako select? -->
<div class="form-group">
    <label for="species_id">Species</label>
    <input type="text" id="species_id" name="animal[species_id]" value="<?= $animal ? $animal->getSpeciesId() : '' ?>">
</div>

<div class="form-group">
    <label for="animal_image">image</label>
    <input type="file" id="animal_image" name="animal_image">
</div>




<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
