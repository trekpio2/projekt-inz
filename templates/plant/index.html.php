<?php 


/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Plant List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Plant List</h1>
    <div class="addAnimal">
        <a href="<?= $router->generatePath('plant-create') ?>">Create new</a>
    </div>

    
    <ul class="index-list">
        <?php foreach ($plants as $plant): ?>
            <div class="animalPhoto">
                <img onerror="this.style.display='none'" src="<?= $plant->getPlantImage(); ?>" style='height: 137px; width: 288px; object-fit: cover; border-radius: 47px'>
            </div>
            <li><h3><?= $plant->getPlantName(); ?></h3>
            <ul class="action-list">
                <li><a href="<?= $router->generatePath('plant-show', ['plant_id' => $plant->getPlantId()]) ?>">Details</a></li>
                <li><a href="<?= $router->generatePath('plant-edit', ['plant_id' => $plant->getPlantId()]) ?>">Edit</a></li>
                <li>
                    <form action="<?= $router->generatePath('plant-delete') ?>" method="post">
                        <input type="submit" class="deleteButton" value="Delete" onclick="return confirm('Are you sure?')">
                        <input type="hidden" name="action" value="plant-delete">
                        <input type="hidden" name="plant_id" value="<?= $plant->getPlantId() ?>">
                    </form>
                </li>
            </ul>
        </li>
        <?php endforeach; ?>
    </ul>
    
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
