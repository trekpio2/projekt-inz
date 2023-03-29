<?php
namespace App\Controller;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use App\Exception\NotFoundException;
use App\Model\Plant;
use App\Model\Aquarium;
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
        if ($requestPlant) {
            $plant = Plant::fromArray($requestPlant);
            // @todo missing validation
            $plant->save();
            echo $uploadedFile['tmp_name'];

            $userName = $_SESSION['username'];
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'plant' . $plant->getPlantId();
            
            
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            //Stores the tempname as it is given by the host when uploaded.
            $imagetemp = $uploadedFile['tmp_name'];

            if(is_uploaded_file($imagetemp)) {
                if(move_uploaded_file($imagetemp, $imagePath . $imageName . "." . $extension)) {
                    echo "Succesfully uploaded your image.";
                }
                else {
                    echo "Failed to move your image.";
                }
            }
            else {
                echo "Failed to upload your image.";
            }

            $toDatabase = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;
            $plant->setPlantImage($toDatabase);
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
            $userName = $_SESSION['username'];
            $imagePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

            if ( ! is_dir($imagePath)) {
                mkdir($imagePath);
            }

            $imageName = 'plant' . $plantId;
            
            
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

            $requestPlant['plant_image'] = DIRECTORY_SEPARATOR . "userImages" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR . $imageName . "." . $extension;

            $plant->fill($requestPlant);
            //@todo missing validation
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

        $plant->delete();
        $path = $router->generatePath('plant-index');
        $router->redirect($path);
        return null;
    }
}
