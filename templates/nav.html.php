<?php
/** @var $router \App\Service\Router */

?>
<<<<<<< HEAD
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
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/dist/style.min.css">
    <title><?= $title ?? 'Custom Framework' ?></title>
</head>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- zmienic na strone glowna jak bedzie -->
    <?php
    if($_SESSION['username']){
        echo "zalogowano jako: " . $_SESSION['username'];
    }
    ?>
    <img src="assets\dist\img\home.png" alt="Home icon" width=35><a href="<?= $router->generatePath('') ?>">Home</a>
    <img src="assets\dist\img\lup.png" alt="Animals icon" width=35><a href="<?= $router->generatePath('animal-index') ?>">Animals</a>
    <img src="assets\dist\img\aq.png" alt="Aquarium icon" width=35><a href="<?= $router->generatePath('aquarium-index') ?>">Aquariums</a>
    <img src="assets\dist\img\home.png" alt="Activity icon" width=35><a href="<?= $router->generatePath('plant-index') ?>">Plants</a>
    <img src="assets\dist\img\info.png" alt=" icon" width=35><a href="<?= $router->generatePath('activity-index') ?>">Activities</a>
>>>>>>> css
    <a href="<?= $router->generatePath('login-logout') ?>">Log out</a>
</a></div>
<div id="darken"></div>
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "60%";
  document.getElementById("darken").style.width = "100%";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("darken").style.width = "0";
}
</script>