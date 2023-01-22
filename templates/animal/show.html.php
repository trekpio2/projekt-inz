<?php

/** @var \App\Model\Animal $animal */
/** @var \App\Model\Species $species */
/** @var \App\Service\Router $router */

$title = "{$animal->getAnimalName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $animal->getAnimalName() ?></h1>
    <article>
        <p>Gatunek: <?= $species->getSpeciesName();?></p>
        <p>Płeć: <?= $animal->getAnimalGender();?></p>
        <!-- do zrobienia  -->
        <!-- <img src="<?= $animal->getAnimalImage() ?>" alt=""> -->
        <!-- reszta dotyczaca zwierzecia -->
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        <li><a href="<?= $router->generatePath('animal-edit', ['animalId'=> $animal->getAnimalId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
