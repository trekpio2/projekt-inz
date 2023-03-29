<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Activity $activity */
/** @var \App\Service\Router $router */

$title = 'Create Activity';
$bodyClass = "edit";

ob_start(); ?>
    <h1 class="acivityTitle">Create Activity</h1>
    <div class="formContainer">
        <form action="<?= $router->generatePath('activity-create') ?>" method="post" class="edit-form">
            <?php require __DIR__ . DIRECTORY_SEPARATOR . '_createForm.html.php'; ?>
            <input type="hidden" name="action" value="activity-create">
            <input type="hidden" id="user_id" name="activity[user_id]" value="<?= $_SESSION['user_id'] ?>">
        </form>
    </div>
    <ul class="action-list">
        <li class="selfButton">
            <a href="<?= $router->generatePath('activity-index') ?>"><<</a></li>
        <li>
</ul>
<?php 
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
