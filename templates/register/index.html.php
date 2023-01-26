<?php

/** @var \App\Service\Router $router */

$title = 'Register';
$bodyClass = "edit";

ob_start(); ?>
    <form action="<?= $router->generatePath('register-register') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_registerForm.html.php'; ?>
        <input type="hidden" name="action" value="register-register">
    </form>

    You've already have an account?
    <a href="<?= $router->generatePath('login-index') ?>">Log in here</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'loginBase.html.php';
