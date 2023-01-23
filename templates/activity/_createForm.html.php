<?php
    /** @var $animal ?\App\Model\Animal */
?>

<div class="form-group">
    <label for="activity_name">Name</label>
    <input type="text" id="activity_name" name="activity[activity_name]" value="<?= $activity ? $activity->getActivityName() : '' ?>">
</div>

<div class="form-group">
    <label for="lights_level">Lights level</label>
    <input type="text" id="lights_level" name="activity[lights_level]" value="<?= $activity ? $activity->getLightsLevel() : '' ?>">
</div>

<div class="form-group">
    <label for="temperature">Temperature</label>
    <input type="text" id="temperature" name="activity[temperature]" value="<?= $activity ? $activity->getTemperature() : '' ?>">
</div>

<!-- jako select? -->
<div class="form-group">
    <label for="aquarium_id">aquarium id</label>
    <input type="text" id="aquarium_id" name="activity[aquarium_id]" value="<?= $activity->getAquariumId() ?>">
</div>


<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
