<?php 


/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */
/** @var \App\Model\Acitity[] $activities */

$title = "{$animal->getAnimalName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1 class="homeAnimalTitle"><?= $animal->getAnimalName() ?></h1>
    <article>
        <img  onerror="this.style.display='none'" src="<?= $animal->getAnimalImage() ?>" alt="Animal" style="width: 100%; height: 200px; border-radius: 25% !important; object-fit: contain;">
        <p>Species: <?= $animal->getSpeciesName();?></p>
        <p>Gender: <?= $animal->getAnimalGender();?></p>
        <!-- reszta dotyczaca zwierzecia -->
    </article>

    <a href="<?= $router->generatePath('aquarium-show', ['aquarium_id' => $animal->getAquariumId()]) ?>" >
        <div class="sendToAq">Aquarium</div>
    </a>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        <li><a href="<?= $router->generatePath('animal-edit', ['animal_id'=> $animal->getAnimalId()]) ?>">Edit</a></li>
        <li>
                <form action="<?= $router->generatePath('animal-delete') ?>" method="post">
                    <input type="submit" class="deleteButton" value="Delete" onclick="return confirm('Are you sure?')">
                    <input type="hidden" name="action" value="animal-delete">
                    <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
                </form>
            </li>
    </ul>

    <h2 class="homeAnimalTitle">Activities</h2>
    <ul class="index-list">
        <?php foreach ($activities as $activity): ?>
            <li>
                <a href="<?= $router->generatePath('activity-show', ['activity_id' => $activity->getActivityId()]) ?>"><h3><?= $activity->getActivityName(); ?></h3></a>
            </li>
            <?php endforeach; ?>
        </ul>
  
    <!-- <?php echo($animal->getColor());?>
    <script>
        alert("<?= $animal->getColor() ?>")
        
    </script> -->
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php'; 
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';