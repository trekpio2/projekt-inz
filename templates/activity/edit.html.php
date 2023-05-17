<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Activity $activity */
/** @var \App\Service\Router $router */

$title = "Edit Activity {$activity->getActivityName()}";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('activity-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_editForm.html.php'; ?>
        <input type="hidden" name="action" value="activity-edit">
        <input type="hidden" name="activity_id" value="<?= $activity->getActivityId() ?>">
    </form>

    <ul class="action-list">
        <li class="selfButton">
            <a href="<?= $router->generatePath('activity-index') ?>"><<</a></li>
        <li>
            <form action="<?= $router->generatePath('activity-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="activity-delete">
                <input type="hidden" name="activity_id" value="<?= $activity->getActivityId() ?>">
            </form>
        </li>
    </ul>

<?php 
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
