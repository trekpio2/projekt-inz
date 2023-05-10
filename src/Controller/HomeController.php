<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Animal;
use App\Model\Plant;
use App\Service\Router;
use App\Service\Templating;

class HomeController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $animals = Animal::findAllOwnedByUser($_SESSION['user_id']);
        $plants = Plant::findAllOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('home/index.html.php', [
            'animals' => $animals,
            'plants' => $plants,
            'router' => $router,
        ]);
        return $html;
    }
}
