<?php

/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = "{$animal->getAnimalName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $animal->getAnimalName() ?></h1>
    <article>
        <p>Gatunek: <?= $animal->getSpeciesName();?></p>
        <p>Płeć: <?= $animal->getAnimalGender();?></p>
        <img src="<?= $animal->getAnimalImage() ?>" alt="">
        <!-- reszta dotyczaca zwierzecia -->
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        <li><a href="<?= $router->generatePath('animal-edit', ['animal_id'=> $animal->getAnimalId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
