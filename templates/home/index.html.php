<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

/** @var \App\Model\Animal[] $animals */
/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Animal List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Hello, <span class="name"><?php echo $_SESSION['username']?>!</span></h1>
    <h2 class="homeAnimalTitle">My Animals</h2>

        <div id="carousel">

        </div>
    <?php $i =0; foreach ($animals as $animal): ?>
                <div class="Baza" hidden>
                <a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>"><img src="<?= $animal->getAnimalImage(); ?>" style='height: 155px; width: 85px; object-fit: cover; border-radius: 20%'>
                </a></div>
                <?php $i = $i +1; ?>
        <?php endforeach; ?>
        <div class="ButtonHolder">
            <div class="Button" onclick="goRight()"> <<</div>
            <div class="Button" onclick="goLeft()"> >> </div>
        </div>
    <h2 class="homeAnimalTitle">My Plants</h2>
    <ul class="index-list">
        <?php foreach ($plants as $plant): ?>

            <li><h3><?= $plant->getPlantName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('plant-show', ['plant_id' => $plant->getPlantId()]) ?>">Details</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

    <script type="text/javascript">
        <?php require_once("carusel.js");?>
    </script>
<?php

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
