<?php 


/** @var \App\Model\Animal $animal */
/** @var \App\Service\Router $router */

$title = "{$animal->getAnimalName()}";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $animal->getAnimalName() ?></h1>
    <article>
        <img src="<?= $animal->getAnimalImage() ?>" alt="Animal" style="width: 100%; height: 200px; border-radius: 15px; object-fit: contain;">
        <p>Gatunek: <?= $animal->getSpeciesName();?></p>
        <p>Płeć: <?= $animal->getAnimalGender();?></p>
        <!-- reszta dotyczaca zwierzecia -->
    </article>

    <a href="<?= $router->generatePath('aquarium-show', ['aquarium_id' => $animal->getAquariumId()]) ?>" >
        <div class="sendToAq">Akwarium</div>
    </a>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('animal-index') ?>">Back to animal list</a></li>
        <li><a href="<?= $router->generatePath('animal-edit', ['animal_id'=> $animal->getAnimalId()]) ?>">Edit</a></li>
        <li>
                <form action="<?= $router->generatePath('animal-delete') ?>" method="post">
                    <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                    <input type="hidden" name="action" value="animal-delete">
                    <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
                </form>
            </li>
    </ul>

    <?php echo($animal->getColor());?>
    <script>
        alert("<?= $animal->getColor() ?>")
        
    </script>
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php'; 
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';