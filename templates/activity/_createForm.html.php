<?php
    /** @var $activity ?\App\Model\Activity */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="activity_name">Name</label>
    <input type="text" class="formGreen" id="activity_name" name="activity[activity_name]" value="<?=$_SESSION['request']['activity_name']?>">
</div>

<div class="form-group">
    <label for="lights_level">Lights level</label>
    <input type="number" class="formGreen" id="lights_level" name="activity[lights_level]" value="<?=$_SESSION['request']['lights_level']?>">
</div>

<div class="form-group">
    <label for="temperature">Temperature</label>
    <input type="number"  class="formGreen" id="temperature" name="activity[temperature]" value="<?=$_SESSION['request']['temperature']?>">
</div>

<div class="form-group">
    <label for="feed">Feed</label>
    <input type="checkbox" id="feed" name="activity[feed]" value="1" <?= $_SESSION['request']['feed'] ? 'checked' : ''?>>
</div>

<div class="form-group">
    <label for="filter">Filter</label>
    <input type="checkbox" id="filter" name="activity[filter]" value="1" <?= $_SESSION['request']['filter'] ? 'checked' : ''?>>
</div>

<div class="form-group">
    <label for="pump">Pump</label>
    <input type="checkbox" id="pump" name="activity[pump]" value="1" <?= $_SESSION['request']['pump'] ? 'checked' : ''?>>
</div>

<div class="form-group">
    <label for="is_planned">Plan activity</label>
    <input type="checkbox" id="is_planned" name="activity[is_planned]" value="1" <?= $_SESSION['request']['is_planned'] ? 'checked' : ''?>>
</div>

<div class="form-group">
    <label for="start_time">starting time</label>
    <input type="time" id="start_time" name="activity[start_time]"  <?= $_SESSION['request']['is_planned'] ? 'required' : 'disabled' ?> value="<?=$_SESSION['request']['starting_time']?>">
</div>

<div class="form-group">
    <label for="start_date">starting date</label>
    <input type="date" id="start_date" name="activity[start_date]" value="<?=$_SESSION['request']['start_date']?>" <?= $_SESSION['request']['is_planned'] ? 'required' : 'disabled' ?>>
</div>

<div class="form-group">
    <label for="period">period</label>
    <input type="number" min="1" id="period_nr" name="activity[period_nr]" <?= $_SESSION['request']['is_planned'] ? 'required' : 'disabled' ?> value="<?=$_SESSION['request']['period_nr']?>">
    <select id="period" name="activity[period]" <?= $_SESSION['request']['is_planned'] ? 'required' : 'disabled' ?>>
        <option value="days" <?= $_SESSION['request']['period'] == 'days' ? 'selected' : '' ?>>days</option>
        <option value="weeks" <?= $_SESSION['request']['period'] == 'weeks' ? 'selected' : '' ?>>weeks</option>
        <option value="months" <?= $_SESSION['request']['period'] == 'months' ? 'selected' : '' ?>>months</option>
    </select>
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="activity[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $_SESSION['request']['aquarium_id'] == $aquarium->getAquariumId() ? 'selected' : '' ?>>
            <?= $aquarium->getAquariumName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
