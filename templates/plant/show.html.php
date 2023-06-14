<?php 


/** @var \App\Model\Plant $plant */
/** @var \App\Service\Router $router */

$title = "{$plant->getPlantName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $plant->getPlantName() ?></h1>
    <article>
        <p>Gatunek: <?= $plant->getSpeciesName();?></p>
        <p>Height: <?= $plant->getPlantHeight();?></p>
        <img src="<?= $plant->getPlantImage() ?>" alt="PlantImage" style="width: 100%; height: 200px; border-radius: 15px; object-fit: contain;">
        <!-- reszta dotyczaca rosliny -->
    </article>
    
    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('plant-index') ?>">Back to plant list</a></li>
        <li><a href="<?= $router->generatePath('plant-edit', ['plant_id'=> $plant->getPlantId()]) ?>">Edit</a></li>
        <li>
            <form action="<?= $router->generatePath('plant-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="plant-delete">
                <input type="hidden" name="plant_id" value="<?= $plant->getPlantId() ?>">
            </form>
        </li>
    </ul>

    <?php 
        $activities = $plant->findAllActivity();
    ?>
    <h2 class="homeAnimalTitle">Activities</h2>
    <ul class="index-list">
        <?php foreach ($activities as $activity): ?>
            <li>
                <a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>"><h3><?= $activity->getActivityName(); ?></h3></a>
            </li>
            <?php endforeach; ?>
        </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
