<?php


/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = 'Activities List';
$bodyClass = 'index';

ob_start(); ?>
    <h1 class="acivityTitle">Activities List</h1>
    
    <a class="addActivity" href="<?= $router->generatePath('activity-create') ?>">Create new</a>
    <?php foreach ($activities as $activity): ?>
        
        <div class ="actionItem">
            <a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>">
                <h3><?= $activity->getActivityName(); ?></h3>
                <div class="forwardIcon">>></div> 
            </a>
        </div>                
        <?php endforeach; ?>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
