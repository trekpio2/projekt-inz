<?php
/** @var $router \App\Service\Router */

?>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- zmienic na strone glowna jak bedzie -->
    <?php
    if($_SESSION['username']){
        echo "zalogowano jako: " . $_SESSION['username'];
    }
    ?>
    <img src="public\assets\dist\img\home.png" alt="Home icon" width=35><a href="<?= $router->generatePath('') ?>">Home</a>
    <img src="public\assets\dist\img\lup.png" alt="Animals icon" width=35><a href="<?= $router->generatePath('animal-index') ?>">Animals</a>
    <img src="public\assets\dist\img\aq.png" alt="Aquarium icon" width=35><a href="<?= $router->generatePath('aquarium-index') ?>">Aquariums</a>
    <img src="public\assets\dist\img\home.png" alt="Activity icon" width=35><a href="<?= $router->generatePath('plant-index') ?>">Plants</a>
    <img src="public\assets\dist\img\info.png" alt=" icon" width=35><a href="<?= $router->generatePath('activity-index') ?>">Activities</a>
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