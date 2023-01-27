<?php

/** @var \App\Model\Animal[] $animals */
/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Animal List';
$bodyClass = 'index';

ob_start(); ?>
    <h2>My Animals</h2>

    <ul class="index-list">
        <?php foreach ($animals as $animal): ?>
            <li><h3><?= $animal->getAnimalName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>">Details</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <h2>My Plants</h2>
    <ul class="index-list">
        <?php foreach ($plants as $plant): ?>

            <li><h3><?= $plant->getPlantName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('plant-show', ['plant_id' => $plant->getPlantId()]) ?>">Details</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
