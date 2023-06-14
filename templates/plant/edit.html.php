<?php 


/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */
require_once 'src/Helpers/flash.php';


$title = "Edit Plant {$plant->getPlantName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <?php flash('plant'); ?>
    <form action="<?= $router->generatePath('plant-edit') ?>" method="post" enctype="multipart/form-data" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="plant-edit">
        <input type="hidden" name="plant_id" value="<?= $plant->getPlantId() ?>">
    </form>
    
    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('plant-index') ?>">Back to plant list</a></li>
        </ul>
        
<?php $main = ob_get_clean();
ob_start();
echo "
<script src='public/assets/src/js/previewImage.js'></script>
";

$scripts = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
