<?php

/** @var \App\Model\Activity $activity */
/** @var \App\Service\Router $router */

$title = 'Create Activity';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Activity</h1>
    <form action="<?= $router->generatePath('activity-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_createForm.html.php'; ?>
        <input type="hidden" name="action" value="activity-create">
    </form>

    <a href="<?= $router->generatePath('activity-index') ?>">Back to activity list</a>
<?php $main = ob_get_clean();
ob_start();
echo "
    <script src='/assets/src/js/activityForm.js'></script>
";
?>
<?php
$scripts = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
