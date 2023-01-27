<?php

/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Plant List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Plant List</h1>

    <a href="<?= $router->generatePath('plant-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($plants as $plant): ?>
            <li><h3><?= $plant->getPlantName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('plant-show', ['plant_id' => $plant->getPlantId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('plant-edit', ['plant_id' => $plant->getPlantId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
