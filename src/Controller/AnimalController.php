<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Animal;
use App\Model\User;
use App\Model\Species;
use App\Service\Router;
use App\Service\Templating;

class AnimalController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        // narazie id uzytkownika na sztywno
        $animals = Animal::findAllOwnedByUser(1);
        $html = $templating->render('animal/index.html.php', [
            'animals' => $animals,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestAnimal, Templating $templating, Router $router): ?string
    {
        if ($requestAnimal) {
            $animal = Animal::fromArray($requestAnimal);
            // @todo missing validation
            $animal->save();

            $path = $router->generatePath('animal-index');
            $router->redirect($path);
            return null;
        } else {
            $animal = new Animal();
        }

        $html = $templating->render('animal/create.html.php', [
            'animal' => $animal,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $animalId, ?array $requestAnimal, Templating $templating, Router $router): ?string
    {
        $animal = Animal::find($animalId);
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        if ($requestAnimal) {
            $animal->fill($requestAnimal);
            // @todo missing validation
            $animal->save();

            $path = $router->generatePath('animal-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('animal/edit.html.php', [
            'animal' => $animal,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $animalId, Templating $templating, Router $router): ?string
    {
        $animal = Animal::find($animalId);
        $species = Species::find($animal->getSpeciesId());
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        $html = $templating->render('animal/show.html.php', [
            'animal' => $animal,
            'species' => $species,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $animalId, Router $router): ?string
    {
        $animal = Animal::find($animalId);
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        $animal->delete();
        $path = $router->generatePath('animal-index');
        $router->redirect($path);
        return null;
    }
}
