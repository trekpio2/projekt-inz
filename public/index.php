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
