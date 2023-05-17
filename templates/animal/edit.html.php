<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = "Edit Animal {$animal->getAnimalName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('animal-edit') ?>" method="post" enctype="multipart/form-data" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="animal-edit">
        <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        <li>
            <form action="<?= $router->generatePath('animal-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="animal-delete">
                <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
            </form>
        </li>
    </ul>

    <?php

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
