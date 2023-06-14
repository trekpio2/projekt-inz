<?php

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}



require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';


error_reporting(E_ERROR | E_PARSE); // DELETE on Production

$config = new \App\Service\Config();



$templating = new \App\Service\Templating();

$router = new \App\Service\Router();



$action = $_REQUEST['action'] ?? null;

switch ($action) {

    case null:

        //home page

        $controller = new \App\Controller\HomeController();

        $view = $controller->indexAction($templating, $router);

        break;

    //login

    case 'login-index':

        $controller = new \App\Controller\LoginController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'login-login':

        $controller = new \App\Controller\LoginController();

        $view = $controller->loginAction($_REQUEST['user'] ?? null, $templating, $router);

        break;

    case 'login-logout':

        $controller = new \App\Controller\LoginController();

        $view = $controller->logoutAction($templating, $router);

        break;

    //register

    case 'register-index':

        $controller = new \App\Controller\RegisterController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'register-register':

        $controller = new \App\Controller\RegisterController();

        $view = $controller->registerAction($_REQUEST['user'] ?? null, $templating, $router);

        break;

    //animal

    case 'animal-index':

        $controller = new \App\Controller\AnimalController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'animal-create':

        $controller = new \App\Controller\AnimalController();

        $view = $controller->createAction($_REQUEST['animal'] ?? null, $_FILES['animal_image'] ?? null, $templating, $router);

        break;

    case 'animal-edit':

        if (! $_REQUEST['animal_id']) {

            break;

        }

        $controller = new \App\Controller\AnimalController();

        $view = $controller->editAction($_REQUEST['animal_id'], $_REQUEST['animal'] ?? null, $_FILES['animal_image'] ?? null, $templating, $router);

        break;

    case 'animal-show':

        if (! $_REQUEST['animal_id']) {

            break;

        }

        $controller = new \App\Controller\AnimalController();

        $view = $controller->showAction($_REQUEST['animal_id'], $templating, $router);

        break;

    case 'animal-delete':

        if (! $_REQUEST['animal_id']) {

            break;

        }

        $controller = new \App\Controller\AnimalController();

        $view = $controller->deleteAction($_REQUEST['animal_id'], $router);

        break;

    //aquarium

    case 'aquarium-index':

        $controller = new \App\Controller\AquariumController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'aquarium-create':

        $controller = new \App\Controller\AquariumController();

        $view = $controller->createAction($_REQUEST['aquarium'] ?? null, $templating, $router);

        break;

    case 'aquarium-edit':

        if (! $_REQUEST['aquarium_id']) {

            break;

        }

        $controller = new \App\Controller\AquariumController();

        $view = $controller->editAction($_REQUEST['aquarium_id'], $_REQUEST['aquarium'] ?? null, $templating, $router);

        break;

    case 'aquarium-show':

        if (! $_REQUEST['aquarium_id']) {

            break;

        }

        $controller = new \App\Controller\AquariumController();

        $view = $controller->showAction($_REQUEST['aquarium_id'], $templating, $router);

        break;

    case 'aquarium-delete':

        if (! $_REQUEST['aquarium_id']) {

            break;

        }

        $controller = new \App\Controller\AquariumController();

        $view = $controller->deleteAction($_REQUEST['aquarium_id'], $router);

        break;

    //plant

    case 'plant-index':

        $controller = new \App\Controller\PlantController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'plant-create':

        $controller = new \App\Controller\PlantController();

        $view = $controller->createAction($_REQUEST['plant'] ?? null, $_FILES['plant_image'] ?? null, $templating, $router);

        break;

    case 'plant-edit':

        if (! $_REQUEST['plant_id']) {

            break;

        }

        $controller = new \App\Controller\PlantController();

        $view = $controller->editAction($_REQUEST['plant_id'], $_REQUEST['plant'] ?? null, $_FILES['plant_image'] ?? null, $templating, $router);

        break;

    case 'plant-show':

        if (! $_REQUEST['plant_id']) {

            break;

        }

        $controller = new \App\Controller\PlantController();

        $view = $controller->showAction($_REQUEST['plant_id'], $templating, $router);

        break;

    case 'plant-delete':

        if (! $_REQUEST['plant_id']) {

            break;

        }

        $controller = new \App\Controller\PlantController();

        $view = $controller->deleteAction($_REQUEST['plant_id'], $router);

        break;

    //activity

    case 'activity-index':

        $controller = new \App\Controller\ActivityController();

        $view = $controller->indexAction($templating, $router);

        break;

    case 'activity-create':

        $controller = new \App\Controller\ActivityController();

        $view = $controller->createAction($_REQUEST['activity'] ?? null, $templating, $router);

        break;

    case 'activity-edit':

        if (! $_REQUEST['activity_id']) {

            break;

        }

        $controller = new \App\Controller\ActivityController();

        $view = $controller->editAction($_REQUEST['activity_id'], $_REQUEST['activity'] ?? null, $templating, $router);

        break;

    case 'activity-show':

        if (! $_REQUEST['activity_id']) {

            break;

        }

        $controller = new \App\Controller\ActivityController();

        $view = $controller->showAction($_REQUEST['activity_id'], $templating, $router);

        break;

    case 'activity-delete':

        if (! $_REQUEST['activity_id']) {

            break;

        }

        $controller = new \App\Controller\ActivityController();

        $view = $controller->deleteAction($_REQUEST['activity_id'], $router);

        break;

    default:

        $view = 'Not found';

        break;

}



if ($view) {

    echo $view;

}

