<?php

/** @var \App\Service\Router $router */

$title = 'Log in';
$bodyClass = "edit";

ob_start(); ?>
    <form action="<?= $router->generatePath('login-login') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_loginForm.html.php'; ?>
        <input type="hidden" name="action" value="login-login">
    </form>

    Don't have account?
    <a href="<?= $router->generatePath('register-index') ?>">Create</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'loginBase.html.php';
