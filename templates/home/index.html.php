<?php 

/** @var \App\Model\Animal[] $animals */
/** @var \App\Model\Plant[] $plants */
/** @var \App\Service\Router $router */

$title = 'Animal List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Hello, <span class="name"><?php echo $_SESSION['username']?>!</span></h1>
    <h2 class="homeAnimalTitle">My Animals</h2>

        <div id="carousel" class="carsu">

        </div>
    <?php $i =0; foreach ($animals as $animal): ?>
                <div class="Baza" hidden>
                <a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>"><img src="<?= $animal->getAnimalImage(); ?>" style='height: 155px; width: 85px; object-fit: cover; border-radius: 20%'>
                </a></div>
                <?php $i = $i +1; ?>
        <?php endforeach; ?>
        <div class ="buttons">
            <button class="changeDirAnimal" onclick="goRight()"><</button>
            <button class="changeDirAnimal" onclick="goLeft()">></button>
        </div>
    <h2 class="homeAnimalTitle">My Plants</h2>

    <div id="carouselPlant"  class="carsu">

    </div>
    <?php $j =0; foreach ($plants as $plant):  ?>
                <div class="BazaFlower" hidden>
                    
                <a href="<?= $router->generatePath('plant-show', ['plant_id' => $plant->getPlantId()]) ?>"><img src="<?= $plant->getPlantImage(); ?>" style='height: 155px; width: 85px; object-fit: cover; border-radius: 20%'>
                </a></div>
                <?php $j = $j +1; ?>
        <?php endforeach; ?>
        <div class ="buttons">
            <button class="changeDirAnimal" onclick="goRightF()"><</button>
            <button class="changeDirAnimal" onclick="goLeftF()">></button>
        </div>

<?php $main = ob_get_clean();
ob_start();
    echo '<script type="text/javascript">';
        require_once("carusel.js");
    echo '</script>';
$scripts = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';

