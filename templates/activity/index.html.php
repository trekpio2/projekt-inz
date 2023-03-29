<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = 'Activities List';
$bodyClass = 'index';

ob_start(); ?>
    <h1 class="acivityTitle">Activities List</h1>

        <?php foreach ($activities as $activity): ?>
            <a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>">
             <div class ="actionItem"><h3><?= $activity->getActivityName(); ?></h3>
                    <!-- <li><a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>">Details</a></li> -->
                    <!-- Usuwam przejście do edycji z tego widoku, ponieważ wystarczy że znajduje się on po  wejsciu w DETAILS-->
                    <!-- To samo z DETAILS zamiast napisu po kliknięciu boxa oznacza przejscie do DEATILS -->
                    <!-- <li><a href="<?= $router->generatePath('activity-edit', ['activity_id' => $activity->getActivityId()]) ?>">Edit</a></li> -->
                    <div class="forwardIcon">>></div> 
                </div>
                
                </a>
                
                
        <?php endforeach; ?>
    <a class="addActivity" href="<?= $router->generatePath('activity-create') ?>">Create new</a>

<?php

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
