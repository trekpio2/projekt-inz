<?php 



/** @var \App\Model\Aquarium $aquarium */
/** @var \App\Service\Router $router */
require_once 'src/Helpers/flash.php';

$title = "Edit Aquarium {$aquarium->getAquariumName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <?php flash('aquarium') ?>
    <form action="<?= $router->generatePath('aquarium-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="aquarium-edit">
        <input type="hidden" name="aquarium_id" value="<?= $aquarium->getAquariumId() ?>">
        <input type="hidden" id="user_id" name="aquarium[user_id]" value="<?= $aquarium->getUserId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('aquarium-index') ?>">Back to aquarium list</a>
        </li>
    </ul>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
