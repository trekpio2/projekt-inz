<?php

/** @var \App\Model\Activity $activity */
/** @var \App\Model\Aquarium $aquarium */
/** @var array $executeData */
/** @var \App\Service\Router $router */

$title = "{$activity->getActivityName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $activity->getActivityName() ?></h1>
    <article>
        <p>Lights level: <?= $activity->getLightsLevel();?></p>
        <p>Temperature: <?= $activity->getTemperature();?></p>
        <p>Feed: <?= $activity->getFeed();?></p>
        <p>Filter: <?= $activity->getFilter();?></p>
        <p>Pump: <?= $activity->getPump() ? : 0;?></p>
        <p>Planned: <?= $activity->getIsPlanned() ? $activity->getStartTime() : "Not planned";?></p>
        <p>Assigned to: <?= $aquarium->getAquariumName();?></p>
        <button id="executeBtn">Execute activity</button>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('activity-index') ?>">Back to activity list</a></li>
        <li><a href="<?= $router->generatePath('activity-edit', ['activity_id'=> $activity->getActivityId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();
ob_start();
echo "
    <script>
    let executeData = '" . $executeData . "';
    let ip = '" . $aquarium->getIP() . "';
    </script>
    <script src='/assets/dist/activity.js'></script>
";
?>
<?php
$scripts = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
