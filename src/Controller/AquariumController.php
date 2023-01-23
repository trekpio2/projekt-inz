<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Aquarium;
use App\Model\Animal;
use App\Model\Activity;
use App\Model\User;
use App\Service\Router;
use App\Service\Templating;

class AquariumController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        // narazie user id na sztywno
        $aquariums = Aquarium::findAquariumsOwnedByUser(1);
        $html = $templating->render('aquarium/index.html.php', [
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestAquarium, Templating $templating, Router $router): ?string
    {
        if ($requestAquarium) {
            $aquarium = Aquarium::fromArray($requestAquarium);
            // @todo missing validation
            $aquarium->save();

            $path = $router->generatePath('aquarium-index');
            $router->redirect($path);
            return null;
        } else {
            $aquarium = new Aquarium();
        }

        $html = $templating->render('aquarium/create.html.php', [
            'aquarium' => $aquarium,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $aquariumId, ?array $requestAquarium, Templating $templating, Router $router): ?string
    {
        $aquarium = Aquarium::find($aquariumId);
        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquariumId");
        }

        if ($requestAquarium) {
            // @todo missing validation
            $aquarium->fill($requestAquarium);
            $aquarium->save();

            $path = $router->generatePath('aquarium-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('aquarium/edit.html.php', [
            'aquarium' => $aquarium,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $aquariumId, Templating $templating, Router $router): ?string
    {
        $aquarium = Aquarium::find($aquariumId);
        $animals= Animal::findAllInAquarium($aquariumId);
        $activities = Activity::findAllAssignedToAquarium($aquariumId);

        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquariumId");
        }

        $html = $templating->render('aquarium/show.html.php', [
            'aquarium' => $aquarium,
            'animals' => $animals,
            'activities' => $activities,
            // 'species' => $species,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $aquariumId, Router $router): ?string
    {
        $aquarium = Aquarium::find($aquariumId);
        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquariumId");
        }

        $aquarium->delete();
        $path = $router->generatePath('aquarium-index');
        $router->redirect($path);
        return null;
    }
}
