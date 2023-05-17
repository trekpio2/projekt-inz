<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Aquarium[] $aquariums */
/** @var \App\Service\Router $router */

$title = 'Aquarium List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Aquarium List</h1>

        <?php foreach ($aquariums as $aquarium): ?>


            <a href="<?= $router->generatePath('aquarium-show', ['aquarium_id' => $aquarium->getAquariumId()]) ?>">
             <div class ="actionItem"><h3><?= $aquarium->getAquariumName(); ?></h3>
                    <div class="forwardIcon">>></div> 
                </div>
                
                </a>
        <?php endforeach; ?>
    <div class="addAnimal">
        <a href="<?= $router->generatePath('aquarium-create') ?>">Create new</a>
        </div>
<?php

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
