<?php
    /** @var $aquarium ?\App\Model\Aquarium */
?>

<div class="form-group">
    <label for="aquarium_name">Name</label>
    <input type="text" required id="aquarium_name" name="aquarium[aquarium_name]" value="<?=$_SESSION['request']['aquarium_name']?>">
</div>

<div class="form-group">
    <label for="aquarium_length">Length</label>
    <input type="number" required id="aquarium_length" name="aquarium[aquarium_length]" value="<?=$_SESSION['request']['aquarium_length']?>">
</div>

<div class="form-group">
    <label for="aquarium_width">Width</label>
    <input type="number" required id="aquarium_width" name="aquarium[aquarium_width]" value="<?=$_SESSION['request']['aquarium_width']?>">
</div>

<div class="form-group">
    <label for="aquarium_height">Height</label>
    <input type="number" required id="aquarium_height" name="aquarium[aquarium_height]" value="<?=$_SESSION['request']['aquarium_height']?>">
</div>

<div class="form-group">
    <label for="aquarium_volume">Volume</label>
    <input type="number" required id="aquarium_volume" name="aquarium[aquarium_volume]" value="<?=$_SESSION['request']['aquarium_volume']?>">
</div>

<div class="form-group">
    <label for="ip">IP</label>
    <input type="text" required id="ip" name="aquarium[ip]"  value="<?=$_SESSION['request']['ip']?>">
</div>



<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
