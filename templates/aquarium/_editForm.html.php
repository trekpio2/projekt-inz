<?php
    /** @var $aquarium ?\App\Model\Aquarium */
?>

<div class="form-group">
    <label for="aquarium_name">Name</label>
    <input type="text" id="aquarium_name" name="aquarium[aquarium_name]" value="<?= $aquarium ? $aquarium->getAquariumName() : '' ?>">
</div>

<div class="form-group">
    <label for="aquarium_length">Length</label>
    <input type="text" id="aquarium_length" name="aquarium[aquarium_length]" value="<?= $aquarium ? $aquarium->getAquariumLength() : '' ?>">
</div>

<div class="form-group">
    <label for="aquarium_width">Width</label>
    <input type="text" id="aquarium_width" name="aquarium[aquarium_width]" value="<?= $aquarium ? $aquarium->getAquariumWidth() : '' ?>">
</div>

<div class="form-group">
    <label for="aquarium_height">Height</label>
    <input type="text" id="aquarium_height" name="aquarium[aquarium_height]" value="<?= $aquarium ? $aquarium->getAquariumHeight() : '' ?>">
</div>

<div class="form-group">
    <label for="aquarium_volume">Volume</label>
    <input type="text" id="aquarium_volume" name="aquarium[aquarium_volume]" value="<?= $aquarium ? $aquarium->getAquariumVolume() : '' ?>">
</div>

<div class="form-group">
    <label for="ip">IP</label>
    <input type="text" id="ip" name="aquarium[ip]" value="<?= $aquarium ? $aquarium->getIP() : '' ?>">
</div>

<!--  jesli beda zdjecia akwarium
<div class="form-group">
    <label for="aquarium_image">Name</label>
    <input type="file" id="aquarium_image" name="aquarium[aquarium_image]">
</div> -->



<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
