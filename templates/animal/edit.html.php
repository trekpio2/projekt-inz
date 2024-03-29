<?php 


/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */
require_once 'src/Helpers/flash.php';

$title = "Edit Animal {$animal->getAnimalName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <?php flash('animal'); ?>
    <form action="<?= $router->generatePath('animal-edit') ?>" method="post" enctype="multipart/form-data" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="animal-edit">
        <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
    </form>
    
    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        </ul>
        
<?php $main = ob_get_clean();
ob_start();
echo "
<script src='public/assets/src/js/previewImage.js'></script>
";

$scripts = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
