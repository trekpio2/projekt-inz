<?php

/** @var \App\Service\Router $router */

$title = 'Log in';
$bodyClass = "edit";

ob_start(); ?>
    <form action="<?= $router->generatePath('login-login') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_loginForm.html.php'; ?>
        <input class="input" type="hidden" name="action" value="login-login">
    </form>
    <div class="registerClick">
    Don't have an account?
    <div class="button">
    <a href="<?= $router->generatePath('register-index') ?>">CREATE</a>
    </div></div>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'loginBase.html.php';
