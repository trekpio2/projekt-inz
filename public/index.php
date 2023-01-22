<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    case 'animal-index':
    case null:
        $controller = new \App\Controller\AnimalController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'animal-create':
        $controller = new \App\Controller\AnimalController();
        $view = $controller->createAction($_REQUEST['animal'] ?? null, $templating, $router);
        break;
    case 'animal-edit':
        if (! $_REQUEST['animalId']) {
            break;
        }
        $controller = new \App\Controller\AnimalController();
        $view = $controller->editAction($_REQUEST['animalId'], $_REQUEST['animal'] ?? null, $templating, $router);
        break;
    case 'animal-show':
        if (! $_REQUEST['animalId']) {
            break;
        }
        $controller = new \App\Controller\AnimalController();
        $view = $controller->showAction($_REQUEST['animalId'], $templating, $router);
        break;
    case 'animal-delete':
        if (! $_REQUEST['animalId']) {
            break;
        }
        $controller = new \App\Controller\AnimalController();
        $view = $controller->deleteAction($_REQUEST['animalId'], $router);
        break;
    case 'aquarium-index':
        $controller = new \App\Controller\AquariumController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'aquarium-create':
        $controller = new \App\Controller\AquariumController();
        $view = $controller->createAction($_REQUEST['aquarium'] ?? null, $templating, $router);
        break;
    case 'aquarium-edit':
        if (! $_REQUEST['aquariumId']) {
            break;
        }
        $controller = new \App\Controller\AquariumController();
        $view = $controller->editAction($_REQUEST['aquariumId'], $_REQUEST['aquarium'] ?? null, $templating, $router);
        break;
    case 'aquarium-show':
        if (! $_REQUEST['aquariumId']) {
            break;
        }
        $controller = new \App\Controller\AquariumController();
        $view = $controller->showAction($_REQUEST['aquariumId'], $templating, $router);
        break;
    case 'aquarium-delete':
        if (! $_REQUEST['aquariumId']) {
            break;
        }
        $controller = new \App\Controller\AquariumController();
        $view = $controller->deleteAction($_REQUEST['aquariumId'], $router);
        break;
    default:
        $view = 'Not found';
        break;
}

if ($view) {
    echo $view;
}
