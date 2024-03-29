<?php 


/** @var \App\Model\Activity $activity */
/** @var \App\Service\Router $router */
require_once 'src/Helpers/flash.php';

$title = "Edit Activity {$activity->getActivityName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <?php flash('activity'); ?>
    <form action="<?= $router->generatePath('activity-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="activity-edit">
        <input type="hidden" name="activity_id" value="<?= $activity->getActivityId() ?>">
    </form>
    
    <ul class="action-list">
        <li class="selfButton">
            <a href="<?= $router->generatePath('activity-index') ?>"><<</a></li>
        </ul>
        
<?php $main = ob_get_clean();
ob_start();
echo "
<script src='public/assets/src/js/activityForm.js'></script>
";
$scripts = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
