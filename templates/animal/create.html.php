<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = 'Create Animal';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Animal</h1>
    <form action="<?= $router->generatePath('animal-create') ?>" method="post" enctype="multipart/form-data" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_createForm.html.php'; ?>
        <input type="hidden" name="action" value="animal-create">
    </form>

    <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a>
    <?php
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';