<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Plant;
use App\Model\Aquarium;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class PlantController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $plants = Plant::findAllOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('plant/index.html.php', [
            'plants' => $plants,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPlant, ?array $uploadedFile, Templating $templating, Router $router): ?string
    {
        $msg = array();

        if ($requestPlant) {
            $validationMsg = array();
            
            
            // @todo missing validation





            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                $imageName = 'plant' . $plantId;            
                $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                $imgValidationResult = Validator::validateImg($uploadedFile);

                if( $imgValidationResult == 1) {
                    $userName = $_SESSION['username'];
                    $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
        
                    if ( ! is_dir($imagePath)) {
                        mkdir($imagePath);
                    }
                    
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                } else{
                    $validationMsg['image'] = $imgValidationResult;
                }
                
                $imagePathToDatabase = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
                $requestPlant['plant_image'] = $imagePathToDatabase;
            }

            if(empty($validationMsg)){
                $msg['actionFeedback'] = 'Created successfully';
            } else {
                $msg['actionFeedback'] = 'Created unsuccessfully';
                $msg['validation'] = $validationMsg;
            }


            $plant = Plant::fromArray($requestPlant);
            $plant->save();

            $path = $router->generatePath('plant-index');
            $router->redirect($path);
            return null;
        } else {
            $plant = new Plant();
            $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        }

        $html = $templating->render('plant/create.html.php', [
            'plant' => $plant,
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $plantId, ?array $requestPlant, ?array $uploadedFile, Templating $templating, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);

        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        if ($requestPlant) {
            $validationMsg = array();



            //@todo missing validation

          
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                $imageName = 'plant' . $plantId;            
                $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                $imgValidationResult = Validator::validateImg($uploadedFile);

                if( $imgValidationResult == 1) {
                    $userName = $_SESSION['username'];
                    $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
        
                    if ( ! is_dir($imagePath)) {
                        mkdir($imagePath);
                    }
                    
                    move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension);
                } else{
                    $validationMsg['image'] = $imgValidationResult;
                }
                
                $imagePathToDatabase = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
                $requestPlant['plant_image'] = $imagePathToDatabase;
            }

            //@todo missing validation
            
            
            if(empty($validationMsg)){
                $msg['actionFeedback'] = 'Edited successfully';
            } else {
                $msg['actionFeedback'] = 'Edition failed';
                $msg['validation'] = $validationMsg;
            }
            
            $plant->fill($requestPlant);
            $plant->save();

            $path = $router->generatePath('plant-show', ['plant_id' => $plantId]);
            $router->redirect($path);
            return null;
        }
        $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('plant/edit.html.php', [
            'plant' => $plant,
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $plantId, Templating $templating, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        $html = $templating->render('plant/show.html.php', [
            'plant' => $plant,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $plantId, Router $router): ?string
    {
        $plant = Plant::find($plantId);
        if (! $plant) {
            throw new NotFoundException("Missing plant with id $plantId");
        }

        $msg['actionFeedback'] = 'Deleted successfully';
        unlink(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $plant->getPlantImage());
        $plant->delete();
        $path = $router->generatePath('plant-index');
        $router->redirect($path);
        return null;
    }
}
