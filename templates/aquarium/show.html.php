<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Aquarium $aquarium */
/** @var \App\Model\Animal[] $animals */
/** @var \App\Model\Species $species */
/** @var \App\Model\Acitity[] $activities */
/** @var \App\Service\Router $router */

// zawartosc do ustalenia narazie wypis zwierzat, pozniej tez czynnosci

$title = "{$aquarium->getAquariumName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $aquarium->getAquariumName() ?></h1>
    <h2 class="homeAnimalTitle">Animals in aquarium</h2>
    <ul class="index-list">
        <?php foreach ($animals as $animal): ?>
            <!-- dodac zdjecie? -->
            <li>
                <a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>"><h3><?= $animal->getAnimalName(); ?></h3></a>
            </li>
            <?php endforeach; ?>
        </ul>
    
    <h2 class="homeAnimalTitle">Activities</h2>
    <ul class="index-list">
        <?php foreach ($activities as $activity): ?>
            <li>
                <a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>"><h3><?= $activity->getActivityName(); ?></h3></a>
            </li>
            <?php endforeach; ?>
        </ul>
        
    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('aquarium-index') ?>">Back to aquarium list</a></li>
        <li><a href="<?= $router->generatePath('aquarium-edit', ['aquarium_id'=> $aquarium->getAquariumId()]) ?>">Edit</a></li>
    </ul>
    <?php

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
