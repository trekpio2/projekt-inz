<?php 



/** @var \App\Model\Aquarium $aquarium */
/** @var \App\Service\Router $router */
require_once 'src/Helpers/flash.php';

$title = 'Create Aquarium';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Aquarium</h1>
    <?php flash('aquarium') ?>
    <form action="<?= $router->generatePath('aquarium-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_createForm.html.php'; ?>
        <input type="hidden" name="action" value="aquarium-create">
        <input type="hidden" id="user_id" name="aquarium[user_id]" value="<?= $_SESSION['user_id'] ?>">
    </form>

    <a href="<?= $router->generatePath('aquarium-index') ?>">Back to aquarium list</a>

<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';