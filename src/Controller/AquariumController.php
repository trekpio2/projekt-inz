<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\Aquarium;
use App\Model\Animal;
use App\Model\Activity;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class AquariumController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('aquarium/index.html.php', [
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestAquarium, Templating $templating, Router $router): ?string
    {
        $msg = array();
        if ($requestAquarium) {
            
            
            foreach($requestAquarium as $aquariumDataKey => $aquariumDataValue){
                $aquariumDataValue = Validator::testInput($aquariumDataValue);
                $requestAquarium[$aquariumDataKey] = $aquariumDataValue;
            }

            if(Aquarium::isAquariumNameInDatabase($requestAquarium['aquarium_name'], $_SESSION['user_id']) != 0) {
                $msg[] = 'aquarium name is already in database';
            }

            $requestAquarium['aquarium_length'] = floatval($requestAquarium['aquarium_length']);
            $lengthValidationResult = Validator::isNumeric($requestAquarium['aquarium_length']);
            if($lengthValidationResult != 1){
                $msg[] = "Wrong aquarium length";
            }
            
            $requestAquarium['aquarium_width'] = floatval($requestAquarium['aquarium_width']);
            $widthValidationResult = Validator::isNumeric($requestAquarium['aquarium_width']);
            if($widthValidationResult != 1){
                $msg[] = "Wrong aquarium width";
            }
            
            $requestAquarium['aquarium_height'] = floatval($requestAquarium['aquarium_height']);
            $HeightValidationResult = Validator::isNumeric($requestAquarium['aquarium_height']);
            if($HeightValidationResult != 1){
                $msg[] = "Wrong aquarium height";
            }
            
            $requestAquarium['aquarium_volume'] = floatval($requestAquarium['aquarium_volume']);
            $volumeValidationResult = Validator::isNumeric($requestAquarium['aquarium_volume']);
            if($volumeValidationResult != 1){
                $msg[] = "Wrong aquarium volume";
            }


            if(empty($msg)){
                $msg[] = 'Aquarium created successfully';
            } else {
                $_SESSION['request'] = $requestAquarium;

                flash("aquarium", $msg);
                $path = $router->generatePath('aquarium-create');
                $router->redirect($path);
                return null;
            }
            unset($_SESSION['request']);
            $aquarium = Aquarium::fromArray($requestAquarium);

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

    public function editAction(int $aquarium_id, ?array $requestAquarium, Templating $templating, Router $router): ?string
    {
        $msg = array();
        
        $aquarium = Aquarium::find($aquarium_id);
        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquarium_id");
        }

        if ($requestAquarium) {
            
            foreach($requestAquarium as $aquariumDataKey => $aquariumDataValue) {
                $aquariumDataValue = Validator::testInput($aquariumDataValue);
                $requestAquarium[$aquariumDataKey] = $aquariumDataValue;
            }

            if(Aquarium::isAquariumNameInDatabase($requestAquarium['aquarium_name'], $_SESSION['user_id'], $aquarium_id) != 0) {
                $msg[] = 'aquarium name is already in database';
            }
            
            $requestAquarium['aquarium_length'] = floatval($requestAquarium['aquarium_length']);
            $lengthValidationResult = Validator::isNumeric($requestAquarium['aquarium_length']);
            if($lengthValidationResult != 1){
                $msg[] = "Wrong aquarium length";
            }
            
            $requestAquarium['aquarium_width'] = floatval($requestAquarium['aquarium_width']);
            $widthValidationResult = Validator::isNumeric($requestAquarium['aquarium_width']);
            if($widthValidationResult != 1){
                $msg[] = "Wrong aquarium width";
            }
            
            $requestAquarium['aquarium_height'] = floatval($requestAquarium['aquarium_height']);
            $HeightValidationResult = Validator::isNumeric($requestAquarium['aquarium_height']);
            if($HeightValidationResult != 1){
                $msg[] = "Wrong aquarium height";
            }
            
            $requestAquarium['aquarium_volume'] = floatval($requestAquarium['aquarium_volume']);
            $volumeValidationResult = Validator::isNumeric($requestAquarium['aquarium_volume']);
            if($volumeValidationResult != 1){
                $msg[] = "Wrong aquarium volume";
            }

            if(empty($msg)){
                $msg[] = 'Aquarium edited successfully';
            } else {
                $_SESSION['request'] = $requestAquarium;

                flash("aquarium", $msg);
                $path = $router->generatePath('aquarium-edit', ['aquarium_id' => $aquarium_id]);
                $router->redirect($path);
                return null;
            }
            unset($_SESSION['request']);

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

    public function showAction(int $aquarium_id, Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $aquarium = Aquarium::find($aquarium_id);
        $animals= Animal::findAllInAquarium($aquarium_id);
        $notPlannedActivities = Activity::findAllNotPlannedAssignedToAquarium($aquarium_id);
        $plannedActivities = Activity::findAllPlannedAssignedToAquarium($aquarium_id);

        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquarium_id");
        }

        $html = $templating->render('aquarium/show.html.php', [
            'aquarium' => $aquarium,
            'animals' => $animals,
            'notPlannedActivities' => $notPlannedActivities,
            'plannedActivities' => $plannedActivities,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $aquarium_id, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $aquarium = Aquarium::find($aquarium_id);
        if (! $aquarium) {
            throw new NotFoundException("Missing aquarium with id $aquarium_id");
        }
        
        $msg['actionFeedback'] = 'Deleted successfully';
        $aquarium->delete();
        $path = $router->generatePath('aquarium-index');
        $router->redirect($path);
        return null;
    }
}
