<?php

/** @var \App\Service\Router $router */
/** @var \App\Util\Util $util */
require_once '../src/Helpers/flash.php';

$title = 'Register';
$bodyClass = "edit";

ob_start(); ?>
    <form action="<?= $router->generatePath('register-register') ?>" method="post" class="edit-form">
        <?php
        require __DIR__ . DIRECTORY_SEPARATOR . '_registerForm.html.php';
        ?>
        <input type="hidden" name="action" value="register-register">
    </form>
    <div class="registerClick">
    You've already have an account?
    <div class="button">
    <a href="<?= $router->generatePath('login-index') ?>">LOG IN HERE</a>
    </div></div>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'loginBase.html.php';
