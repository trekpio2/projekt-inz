<?php
/** @var $router \App\Service\Router */

?>
<ul>
    <!-- zmienic na strone glowna jak bedzie -->
    <li><a href="<?= $router->generatePath('animal-index') ?>">Home</a></li>
    <li><a href="<?= $router->generatePath('animal-index') ?>">Animals</a></li>
    <li><a href="<?= $router->generatePath('aquarium-index') ?>">Aquariums</a></li>
    <li><a href="<?= $router->generatePath('activity-index') ?>">Activities</a></li>
</ul>

<?php
if($_SESSION['username']){
    echo "zalogowano jako: " . $_SESSION['username'];
?>
    <a href="<?= $router->generatePath('login-logout') ?>">Log out</a>
<?php
}