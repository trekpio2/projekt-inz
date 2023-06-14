<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\Animal;
use App\Model\Aquarium;
use App\Model\Activity;
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
        
        if(!Aquarium::findAquariumsOwnedByUser($_SESSION['user_id'])) {
            $msg[] = 'You need to create aquarium first';
            flash("animal", $msg);
            $path = $router->generatePath('animal-create');
            $router->redirect($path);
            return null;
        }

        if ($requestAnimal)
        {
            foreach($requestAnimal as $animalDataKey => $animalDataValue) {
                $animalDataValue = Validator::testInput($animalDataValue);
                $requestAnimal[$animalDataKey] = $animalDataValue;
            }
            
            if (Animal::isAnimalNameInDatabase($requestAnimal['animal_name']) != 0) {
                $msg[] = "animal name already in database";
            }

            $colorValidationResult = Validator::isAlpha($requestAnimal['color']);
            if($colorValidationResult != 1){
                $msg[] = "Wrong animal color";
            }

            $genderValidationResult = Validator::isAlpha($requestAnimal['animal_gender']);
            if($genderValidationResult != 1){
                $msg[] = "Wrong animal gender";
            }

            $speciesValidationResult = Validator::isAlpha($requestAnimal['species_name']);
            if($speciesValidationResult != 1){
                $msg[] = "Wrong animal species";
            }

            
            $imagetemp = $uploadedFile['tmp_name'];
            
            if(is_uploaded_file($imagetemp))
            {
                $imageName = $requestAnimal['animal_name'];
                $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

                $imgValidationResult = Validator::validateImg($uploadedFile);
                if( $imgValidationResult == 1) {
                    $userName = $_SESSION['username'];
                    $imagePath = "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
        
                    if ( !is_dir($imagePath)) {
                        mkdir($imagePath);
                    }
                    
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                } else{
                    $msg[] = $imgValidationResult;
                }
                
                $imagePathToDatabase = 'public/userImages/' . $userName .'/' . $imageName . "." . $extension;
                $requestAnimal['animal_image'] = $imagePathToDatabase;
            }
            
            
            if(empty($msg)){
                $msg[] = 'Animal created successfully';
            } else {
                flash("animal", $msg);
                $path = $router->generatePath('animal-create');
                $router->redirect($path);
                return null;
            }
            
            $animal = Animal::fromArray($requestAnimal);
            $animal->save();
            
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
        $animal = Animal::find($animalId);
        
        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }
        
        if ($requestAnimal) {
            $msg = array();
            
            foreach($requestAnimal as $animalDataKey => $animalDataValue){
                $animalDataValue = Validator::testInput($animalDataValue);
                $requestAnimal[$animalDataKey] = $animalDataValue;
            }

            if (Animal::isAnimalNameInDatabase($requestAnimal['animal_name'], $animalId) != 0) {
                $msg[] = "animal name already in database";
            }

            $colorValidationResult = Validator::isAlpha($requestAnimal['color']);
            if($colorValidationResult != 1){
                $msg[] = "Wrong animal color";
            }

            $genderValidationResult = Validator::isAlpha($requestAnimal['animal_gender']);
            if($genderValidationResult != 1){
                $msg[] = "Wrong animal gender";
            }

            $speciesValidationResult = Validator::isAlpha($requestAnimal['species_name']);
            if($speciesValidationResult != 1){
                $msg[] = "Wrong animal species";
            }

            $colorValidationResult = Validator::isAlpha($requestAnimal['color']);
            if($colorValidationResult != 1){
                $msg[] = "Wrong animal color";
            }

            $speciesValidationResult = Validator::isAlpha($requestAnimal['species_name']);
            if($speciesValidationResult != 1){
                $msg[] = "Wrong animal species";
            }

            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                $imageName = $requestAnimal['animal_name'];
                $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

                $imgValidationResult = Validator::validateImg($uploadedFile);
                if( $imgValidationResult == 1) {
                    $userName = $_SESSION['username'];
                    $imagePath = "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
        
                    if ( !is_dir($imagePath)) {
                        mkdir($imagePath);
                    }
                    
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                } else{
                    $msg[] = $imgValidationResult;
                }
                
                $imagePathToDatabase = 'public/userImages/' . $userName .'/' . $imageName . "." . $extension;
                $requestAnimal['animal_image'] = $imagePathToDatabase;
            }

            if(empty($msg)){
                $msg[] = 'Animal edited successfully';
            } else {
                flash("animal", $msg);
                $path = $router->generatePath('animal-edit', ['animal_id' => $animalId]);
                $router->redirect($path);
                return null;
            }
            
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
        $activities = Activity::findAllAssignedToAquarium($animal->getAquariumId());

        if (! $animal) {
            throw new NotFoundException("Missing animal with id $animalId");
        }

        $html = $templating->render('animal/show.html.php', [
            'animal' => $animal,
            'activities' => $activities,
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
        unlink($animal->getAnimalImage());
        $animal->delete();


        $path = $router->generatePath('animal-index');
        $router->redirect($path);
        return null;
    }
}