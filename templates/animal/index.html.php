<?php

/** @var \App\Model\Animal[] $animals */
/** @var \App\Service\Router $router */

$title = 'Animal List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Animal List</h1>

    <a href="<?= $router->generatePath('animal-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($animals as $animal): ?>
             <!-- dodac zdjecie -->
            <li><h3><?= $animal->getAnimalName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('animal-edit', ['animal_id' => $animal->getAnimalId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
