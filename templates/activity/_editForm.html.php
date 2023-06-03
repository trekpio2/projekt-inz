<?php
    /** @var $activity ?\App\Model\Activity */
    /** @var $aquariums ?\App\Model\Aquarium[] */
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

<div class="form-group">
    <label for="feed">Feed</label>
    <input type="checkbox" id="feed" name="activity[feed]" value="1" <?= $activity->getFeed() ? 'checked' : '' ?>>
</div>

<div class="form-group">
    <label for="filter">Filter</label>
    <input type="checkbox" id="filter" name="activity[filter]" value="1" <?= $activity->getFilter() ? 'checked' : '' ?>>
</div>

<div class="form-group">
    <label for="pump">Pump</label>
    <input type="checkbox" id="pump" name="activity[pump]" value="1" <?= $activity->getPump() ? 'checked' : '' ?>>
</div>

<div class="form-group">
    <label for="is_planned">Plan activity</label>
    <input type="checkbox" id="is_planned" name="activity[is_planned]" value="1" <?= $activity->getIsPlanned() ? 'checked' : '' ?>>
</div>

<div class="form-group">
    <label for="start_time">starting time</label>
    <input type="time" id="start_time" name="activity[start_time]" value="<?= $activity ? $activity->getStartTime() : '' ?>" <?= $activity->getIsPlanned()? 'required' : 'disabled' ?>>
</div>

<div class="form-group">
    <label for="start_date">starting date</label>
    <input type="date" id="start_date" name="activity[start_date]" value="<?= $activity ? $activity->getStartDate() : '' ?>" <?= $activity->getIsPlanned()? 'required' : 'disabled' ?>>
</div>

<div class="form-group">
    <label for="period">period</label>
    <input type="number" value="<?= $activity ? $activity->getPeriodNr() : '' ?>" min="1" id="period_nr" name="activity[period_nr]" <?= $activity->getIsPlanned()? 'required' : 'disabled' ?>>
    <select id="period" name="activity[period]" <?= $activity->getIsPlanned()? 'required' : 'disabled' ?>>
        <option value="days">days</option>
        <option value="weeks">weeks</option>
        <option value="months">months</option>
    </select>
</div>

<div class="form-group">
    <label for="aquarium_id">Aquarium</label>
    <select id="aquarium_id" name="activity[aquarium_id]">
        <?php foreach ($aquariums as $aquarium): ?>
            <option value="<?= $aquarium ? $aquarium->getAquariumId() : '' ?>"<?= $activity->getAquariumId() == $aquarium->getAquariumId() ? 'selected' : '' ?>>
                <?= $aquarium ? $aquarium->getAquariumName() : '' ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>