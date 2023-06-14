<?php 


/** @var \App\Model\Activity $activity */
/** @var \App\Model\Aquarium $aquarium */
/** @var array $executeData */
/** @var \App\Service\Router $router */


$title = "{$activity->getActivityName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1 class="acivityTitle"><?= $activity->getActivityName() ?></h1>
    <article>
        <p>Lights level: <?= $activity->getLightsLevel();?></p>
        <p>Temperature: <?= $activity->getTemperature();?></p>
        <p>Feed: <?= $activity->getFeed();?></p>
        <p>Filter: <?= $activity->getFilter();?></p>
        <p>Pump: <?= $activity->getPump() ? : 0;?></p>
        <p>Planned: <?= $activity->getIsPlanned() ? $activity->getStartTime() : "Not planned";?></p>
        <p>Assigned to: <?= $aquarium->getAquariumName();?></p>
        <button class="addActivity" id="executeBtn">Execute activity</button>
        <ul class="action-list">
            <li class="selfButton"> <a href="<?= $router->generatePath('activity-index') ?>"><<</a></li>
            <li class="selfButton"><a href="<?= $router->generatePath('activity-edit', ['activity_id'=> $activity->getActivityId()]) ?>">Edit</a></li>
                <form action="<?= $router->generatePath('activity-delete') ?>" method="post">
                    <input class="DeleteB" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                    <input type="hidden" name="action" value="activity-delete">
                    <input type="hidden" name="activity_id" value="<?= $activity->getActivityId() ?>">
                </form>
        </ul>
    </article>
    
    
    <?php $main = ob_get_clean();
echo "
<script>
let executeData = '" . $executeData . "';
let ip = '" . $aquarium->getIP() . "';
let userName = '" . $_SESSION['username'] . "'
let activityName = '" . $activity->getActivityName() . "'
</script>
<script src='public/assets/src/js/activityExecute.js'></script>
";

$scripts = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
