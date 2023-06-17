<?php
    /** @var $activity ?\App\Model\Activity */
    /** @var $aquariums ?\App\Model\Aquarium[] */
?>

<div class="form-group">
    <label for="activity_name">Name</label>
    <input type="text" required id="activity_name" name="activity[activity_name]" value="<?= $_SESSION['request']['activity_name'] ? $_SESSION['request']['activity_name'] : $activity->getActivityName() ?>">
</div>

<div class="form-group">
    <label for="lights_level">Lights level</label>
    <input type="number" required id="lights_level" name="activity[lights_level]" value="<?= $_SESSION['request']['lights_level'] ? $_SESSION['request']['lights_level'] : $activity->getLightsLevel() ?>">
</div>

<div class="form-group">
    <label for="temperature">Temperature</label>
    <input type="number" required id="temperature" name="activity[temperature]" value="<?= $_SESSION['request']['temperature'] ? $_SESSION['request']['temperature'] : $activity->getTemperature() ?>">
</div>

<div class="form-group">
    <label for="feed">Feed</label>
    <input type="checkbox" id="feed" name="activity[feed]" value="1" 
        <?php if ($_SESSION['request']['feed']) {
            echo ($_SESSION['request']['feed']) ? 'checked' : '';
            }else {
                echo ($activity->getFeed()) ? 'checked' : '';
            }
        ?>
    >
</div>

<div class="form-group">
    <label for="filter">Filter</label>
    <input type="checkbox" id="filter" name="activity[filter]" value="1" 
        <?php if ($_SESSION['request']['filter']) {
            echo ($_SESSION['request']['feed']) ? 'checked' : '';
            }else {
                echo ($activity->getFilter()) ? 'checked' : '';
            }
        ?>
    >
</div>

<div class="form-group">
    <label for="pump">Pump</label>
    <input type="checkbox" id="pump" name="activity[pump]" value="1" 
        <?php if ($_SESSION['request']['pump']) {
            echo ($_SESSION['request']['pump']) ? 'checked' : '';
            }else {
                echo ($activity->getPump()) ? 'checked' : '';
            }
        ?>
    >
</div>

<div class="form-group">
    <label for="is_planned">Plan activity</label>
    <input type="checkbox" id="is_planned" name="activity[is_planned]" value="1"
    <?php if ($_SESSION['request']['is_planned']) {
            echo $_SESSION['request']['is_planned'] ? 'checked' : '';
            }else {
                echo $activity->getIsPlanned() ? 'checked' : '';
            }
        ?>
    >
</div>

<div class="form-group">
    <label for="start_time">starting time</label>
    <input type="time" id="start_time" name="activity[start_time]" value="<?= $_SESSION['request']['start_time'] ? $_SESSION['request']['start_time'] : $activity->getStartTime() ?>"
        <?php if($_SESSION['request']['is_planned']) {
                echo $_SESSION['request']['is_planned'] ? 'required' : 'disabled';
            } else {
                echo $activity->getIsPlanned()? 'required' : 'disabled';
            }
        ?>
    >
</div>

<div class="form-group">
    <label for="start_date">starting date</label>
    <input type="date" id="start_date" name="activity[start_date]"  
    <?php if($_SESSION['request']['is_planned']) {
                echo $_SESSION['request']['is_planned'] ? 'required' : 'disabled';
            } else {
                echo $activity->getIsPlanned()? 'required' : 'disabled';
            }
        ?>
    value="<?= $_SESSION['request']['start_date'] ? $_SESSION['request']['start_date'] : $activity->getStartDate() ?>">
</div>

<div class="form-group">
    <label for="period">period</label>
    <input type="number"
    <?php if($_SESSION['request']['is_planned']) {
                echo $_SESSION['request']['is_planned'] ? 'required' : 'disabled';
            } else {
                echo $activity->getIsPlanned()? 'required' : 'disabled';
            }
        ?>
    value="<?= isset($_SESSION['request']['period_nr']) ? $_SESSION['request']['period_nr'] : $activity->getPeriodNr() ?>" min="1" id="period_nr" name="activity[period_nr]">
    
    <select id="period" name="activity[period]"
            <?php if($_SESSION['request']['is_planned']) {
                echo $_SESSION['request']['is_planned'] ? 'required' : 'disabled';
            } else {
                echo $activity->getIsPlanned()? 'required' : 'disabled';
            }
        ?>
    >
    <option value="days"
     <?php
        if($_SESSION['request']['period']) {
            echo ($_SESSION['request']['period'] == 'days') ? 'selected' : '';
        } else {
            echo ($activity->getPeriod() == 'days') ? 'selected' : '';
        }
        ?>
    >days</option>
        <option value="weeks"
         <?php
            if($_SESSION['request']['period']) {
                echo ($_SESSION['request']['period'] == 'weeks') ? 'selected' : '';
            } else {
                echo ($activity->getPeriod() == 'weeks') ? 'selected' : '';
            }
         ?>
        >weeks</option>
        <option value="months" 
            <?php
            if($_SESSION['request']['period']) {
                echo ($_SESSION['request']['period'] == 'months') ? 'selected' : '';
            } else {
                echo ($activity->getPeriod() == 'months') ? 'selected' : '';
            }
            ?>
        >months</option>
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