<?php

/** @var \App\Model\Aquarium $aquarium */
/** @var \App\Model\Animal[] $animals */
/** @var \App\Model\Species $species */
/** @var \App\Model\Acitity $activity */
/** @var \App\Service\Router $router */

// zawartosc do ustalenia narazie wypis zwierzat, pozniej tez czynnosci

$title = "{$aquarium->getAquariumName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $aquarium->getAquariumName() ?></h1>
    <h2>Animals in aquarium</h2>
    <ul class="index-list">
        <?php foreach ($animals as $animal): ?>
            <!-- dodac zdjecie? -->
            <li>
                <a href="<?= $router->generatePath('animal-show', ['animalId' => $animal->getAnimalId()]) ?>"><h3><?= $animal->getAnimalName(); ?></h3></a>
            </li>
            <?php endforeach; ?>
        </ul>
    
    <h2>Activities</h2>
    TODO
        
    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('aquarium-index') ?>">Back to aquarium list</a></li>
        <li><a href="<?= $router->generatePath('aquarium-edit', ['aquariumId'=> $aquarium->getAquariumId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
