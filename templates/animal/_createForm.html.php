<?php
    /** @var $animal ?\App\Model\Animal */
?>

<div class="form-group">
    <label for="animal_name">Name</label>
    <input type="text" id="animal_name" name="animal[animal_name]">
</div>

<div class="form-group">
    <label for="animal_gender">Gender</label>
    <input type="text" id="animal_gender" name="animal[animal_gender]">
</div>

<!-- jako select? -->
<div class="form-group">
    <label for="species_id">Species</label>
    <input type="text" id="species_id" name="animal[species_id]">
</div>

<!-- jako select? jesli zostaje tabela species i gatunki sa ustalone z gory albo tylko nazwa gatunku w tabeli animal i wtedy uzytkownik moze sobie dowolne gatunki wpisywac -->
<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <input type="text" id="aquarium_id" name="animal[aquarium_id]">
</div>
<!--  do zrobienia
<div class="form-group">
    <label for="animal_image">Image</label>
    <input type="file" id="animal_image" name="animal[animal_image]">
</div> -->




<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
