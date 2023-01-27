<?php
//TODO
namespace App\Controller;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use App\Exception\NotFoundException;
use App\Model\Animal;
use App\Service\Router;
use App\Service\Templating;

class AnimalController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $animals = Animal::findAllOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('animal/index.html.php', [
            'animals' => $animals,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestAnimal, ?array $uploadedFile, Templating $templating, Router $router): ?string
    {
        if ($requestAnimal) {
            $animal = Animal::fromArray($requestAnimal);
            // @todo missing validation
            $animal->save();
            echo $uploadedFile['tmp_name'];

            //na sztywno narazie
            $userName = 'piotrek';
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'animal' . $animal->getAnimalId();
            
            
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            //Stores the tempname as it is given by the host when uploaded.
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                if(move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension)) {
                    echo "Sussecfully uploaded your image.";
                }
                else {
                    echo "Failed to move your image.";
                }
            }
            else {
                echo "Failed to upload your image.";
            }

            $toDatabase = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
            $animal->setAnimalImage($toDatabase);
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

    public function editAction(int $animalId, ?array $requestAnimal, ?array $uploadedFile, Templating $templating, Router $router): ?string
    {
        $animal = Animal::find($animalId);
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        if ($requestAnimal) {
            //na sztywno narazie
            $userName = 'piotrek';
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'animal' . $animalId;
            
            
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            //Stores the tempname as it is given by the host when uploaded.
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                if(move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension)) {
                    echo "Sussecfully uploaded your image.";
                }
                else {
                    echo "Failed to move your image.";
                }
            }
            else {
                echo "Failed to upload your image.";
            }

            $requestAnimal['animal_image'] = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;

            $animal->fill($requestAnimal);
            //@todo missing validation
             $animal->save();

            $path = $router->generatePath('animal-show', ['animal_id' => $animalId]);
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
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        $html = $templating->render('animal/show.html.php', [
            'animal' => $animal,
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
