<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Animal;
use App\Model\Aquarium;
use App\Validator\Validator;
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
        $msg = array();
        
        if(!Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']))
        {
            $msg['actionFeedback'] = 'You need to create aquarium first';
            $path = $router->generatePath('aquarium-index');
            $router->redirect($path);
            return null;
        }

        if ($requestAnimal)
        {
            $validationMsg = array();
           
            foreach($requestAnimal as $animalDataKey => $animalDataValue) {
                $animalDataValue = Validator::testInput($animalDataValue);
                $requestAnimal[$animalDataKey] = $animalDataValue;
            }
            
            $colorValidationResult = Validator::isAlpha($requestAnimal['color']);
            if($colorValidationResult != 1) {
                $validationMsg[] = $colorValidationResult;
            }

            $speciesValidationResult = Validator::isAlpha($requestAnimal['species_name']);
            if($speciesValidationResult != 1) {
                $validationMsg[] = $speciesValidationResult;
            }
            
            if(empty($validationMsg)) {
                $msg['actionFeedback'] = 'Created successfully';
            } else {
                $msg['actionFeedback'] = 'Created unsuccessfully';
                $msg['validation'] = $validationMsg;
            }

            $animal = Animal::fromArray($requestAnimal);

            $animal->save();
            
            $userName = $_SESSION['username'];
            
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'animal' . $animal->getAnimalId();
                        
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            //Stores the tempname as it is given by the host when uploaded.
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp))
            {
                $imgValidationResult = Validator::validateImg($uploadedFile);
                if( $imgValidationResult == 1) {
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                } else{
                    $validationMsg[] = $imgValidationResult;
                }
                
                $toDatabase = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
                $animal->setAnimalImage($toDatabase);
                $animal->save();
            }

            $path = $router->generatePath('animal-index');
            $router->redirect($path);
            return null;
        } else {
            $animal = new Animal();
            $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        }

        $html = $templating->render('animal/create.html.php', [
            'animal' => $animal,
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $animalId, ?array $requestAnimal, ?array $uploadedFile, Templating $templating, Router $router): ?string
    {
        $msg = array();
        $animal = Animal::find($animalId);
        
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        if ($requestAnimal) {
            $validationMsg = array();
            
            foreach($requestAnimal as $animalDataKey => $animalDataValue)
            {
                $animalDataValue = Validator::testInput($animalDataValue);
                $requestAnimal[$animalDataKey] = $animalDataValue;
            }

            $colorValidationResult = Validator::isAlpha($requestAnimal['color']);
            if($colorValidationResult != 1)
            {
                $validationMsg[] = $colorValidationResult;
            }

            $speciesValidationResult = Validator::isAlpha($requestAnimal['species_name']);
            if($speciesValidationResult != 1)
            {
                $validationMsg[] = $speciesValidationResult;
            }

            $userName = $_SESSION['username'];
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'animal' . $animalId;
            
            
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            //Stores the tempname as it is given by the host when uploaded.
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp))
            {
                $imgValidationResult = Validator::validateImg($uploadedFile);
                if( $imgValidationResult == 1)
                {
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                }
                else
                {
                    $validationMsg[] = $imgValidationResult;
                }
            }

            if(empty($validationMsg)){
                $msg['actionFeedback'] = 'Edited successfully';
            } else {
                $msg['actionFeedback'] = 'Edited unsuccessfully';
                $msg['validation'] = $validationMsg;
            }

            $requestAnimal['animal_image'] = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
            
            $animal->fill($requestAnimal);
            $animal->save();
             
             $path = $router->generatePath('animal-show', ['animal_id' => $animalId]);
             $router->redirect($path);
             return null;
            }
            
            $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
            
            $html = $templating->render('animal/edit.html.php', [
            'animal' => $animal,
            'aquariums' => $aquariums,
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
        
        $msg['actionFeedback'] = 'Deleted successfully';
        $animal->delete();
        $path = $router->generatePath('animal-index');
        $router->redirect($path);
        return null;
    }
}