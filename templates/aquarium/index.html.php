<?php

/** @var \App\Model\Aquarium[] $aquariums */
/** @var \App\Service\Router $router */

$title = 'Aquarium List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Aquarium List</h1>

    <a href="<?= $router->generatePath('aquarium-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($aquariums as $aquarium): ?>
             <!-- dodac zdjecie? jesli tak to w bazie i modelu tez  -->
            <li><h3><?= $aquarium->getAquariumName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('aquarium-show', ['aquarium_id' => $aquarium->getAquariumId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('aquarium-edit', ['aquarium_id' => $aquarium->getAquariumId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
