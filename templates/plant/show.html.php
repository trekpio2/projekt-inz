<?php

/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */

$title = "{$plant->getPlantName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $plant->getPlantName() ?></h1>
    <article>
        <p>Gatunek: <?= $plant->getSpeciesName();?></p>
        <p>Height: <?= $plant->getPlantHeight();?></p>
        <img src="<?= $plant->getPlantImage() ?>" alt="">
        <!-- reszta dotyczaca rosliny -->
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('plant-index') ?>">Back to plant list</a></li>
        <li><a href="<?= $router->generatePath('plant-edit', ['plant_id'=> $plant->getPlantId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';