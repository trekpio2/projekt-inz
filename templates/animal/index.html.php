<?php 



$title = 'Animal List';
$bodyClass = 'index';

ob_start(); ?>

<div class="addAnimal">
    <a href="<?= $router->generatePath('animal-create') ?>">Create new</a>
</div>

<ul class="index-list">
    <?php foreach ($animals as $animal): ?>
        <div class="singleAnimal">
            <div class="animalPhoto">
                <img src="<?= $animal->getAnimalImage(); ?>" style='height: 137px; width: 288px; object-fit: cover; border-radius: 47px'>
            </div>
            <li><h3><?= $animal->getAnimalName(); ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('animal-show', ['animal_id' => $animal->getAnimalId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('animal-edit', ['animal_id' => $animal->getAnimalId()]) ?>">Edit</a></li>
                    <li>
                        <form action="<?= $router->generatePath('animal-delete') ?>" method="post">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                            <input type="hidden" name="action" value="animal-delete">
                            <input type="hidden" name="animal_id" value="<?= $animal->getAnimalId() ?>">
                        </form>
                    </li>
                </ul>
            </li>
        </div>
        <?php endforeach; ?>
    </ul>
    
    
    
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'footer.html.php';
