<?php
/** @var $router \App\Service\Router */

?>
<ul>
    <li><a href="<?= $router->generatePath('') ?>">Home</a></li>
    <li><a href="<?= $router->generatePath('animal-index') ?>">Animals</a></li>
    <li><a href="<?= $router->generatePath('aquarium-index') ?>">Aquariums</a></li>
    <li><a href="<?= $router->generatePath('plant-index') ?>">Plants</a></li>
    <li><a href="<?= $router->generatePath('activity-index') ?>">Activities</a></li>
</ul>

<?php
if($_SESSION['username']){
    echo "zalogowano jako: " . $_SESSION['username'];
?>
    <a href="<?= $router->generatePath('login-logout') ?>">Log out</a>
<?php
}