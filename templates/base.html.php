<?php
    if(!isset($_SESSION['username'])){
        $path = $router->generatePath('login-index');
        $router->redirect($path);
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/assets/dist/style.min.css">
    <title><?= $title ?? 'Custom Framework' ?></title>
</head>
<body <?= isset($bodyClass) ? "class='$bodyClass'" : '' ?>>
    <nav><?php require(__DIR__ . DIRECTORY_SEPARATOR . 'nav.html.php') ?></nav>
    <main><?= $main ?? null ?></main>
