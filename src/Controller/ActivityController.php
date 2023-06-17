<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\Activity;
use App\Model\Aquarium;
use App\Model\Scheduler;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class ActivityController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $notPlannedActivities = Activity::findAllNotPlannedAssignedToUser($_SESSION['user_id']);
        $plannedActivities = Activity::findAllPlannedAssignedToUser($_SESSION['user_id']);
        $html = $templating->render('activity/index.html.php', [
            'notPlannedActivities' => $notPlannedActivities,
            'plannedActivities' => $plannedActivities,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestActivity, Templating $templating, Router $router): ?string
    {
        if ($requestActivity) {
            $msg = array();
            

            if(!isset($requestActivity['feed'])) {
                $requestActivity['feed'] = 0;
            }
            if(!isset($requestActivity['filter'])) {
                $requestActivity['filter'] = 0;
            }
            if(!isset($requestActivity['pump'])) {
                $requestActivity['pump'] = 0;
            }
            if(!isset($requestActivity['is_planned'])) {
                $requestActivity['is_planned'] = 0;
            }

            foreach($requestActivity as $activityDataKey => $activityDataValue) {
                $animalDataValue = Validator::testInput($activityDataValue);
                $requestActivity[$activityDataKey] = $activityDataValue;
            }

            if(Activity::isActivityNameInDatabase($requestActivity['activity_name']) != 0) {
                $msg[] = 'activity name is already in database';
            }
            $requestActivity['lights_level'] = intval($requestActivity['lights_level']);
            $lightsValidationResult = Validator::isNumeric($requestActivity['lights_level']);
            if($lightsValidationResult != 1){
                $msg[] = "Wrong lights level";
            }
            $requestActivity['temperature'] = intval($requestActivity['temperature']);
            $temperatureValidationResult = Validator::isNumeric($requestActivity['temperature']);
            if($temperatureValidationResult != 1){
                $msg[] = "Wrong temperature";
            }    

            $userName = $_SESSION['username'];
            $taskName = $userName . '-' . $requestActivity['activity_name'];
            $requestActivity['task_name'] = $taskName;
            
            

            $activity = Activity::fromArray($requestActivity);

            if($requestActivity['is_planned'] == 1)
            {
                if ($requestActivity['start_time'] == '') {
                    $msg[] = 'starting time must be set';
                }

                if ($requestActivity['start_date'] == '') {
                    $msg[] = 'starting date must be set';
                }

                if ($requestActivity['period_nr'] == '') {
                    $msg[] = 'period number must be set';
                }
                //$scheduler = new Scheduler();
                $scriptFilePath = "public" . DIRECTORY_SEPARATOR . "plannedActivities" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
                
                if ( !is_dir($scriptFilePath)) {
                    mkdir($scriptFilePath);
                }
                
                $scriptFilePath .= $activity->getActivityName() . '.js';
                $executeData = $activity->getExecuteData();
                $logData = array();
                $logData['userName'] = $_SESSION['username'];
                $logData['activityName'] = $activity->getActivityName();
                $logData = json_encode($activityData);
                
                $aquarium = Aquarium::find($activity->getAquariumId());
                //$scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData, $logData);
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie                
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime(), $activity->getStartDate(), $activity->getPeriod(), $activity->getPeriodNr());
            }
            
            if(empty($msg)){
                $msg[] = 'Activity created successfully';
            } else {
                $_SESSION['request'] = $requestActivity;
                flash("activity", $msg);
                $path = $router->generatePath('activity-create');
                $router->redirect($path);
                return null;
            }
            unset($_SESSION['request']);
            $activity->save();
            
            $path = $router->generatePath('activity-index');
            $router->redirect($path);
            return null;
        } else {
            $activity = new Activity();
            $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        }
        
        $html = $templating->render('activity/create.html.php', [
            'activity' => $activity,
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }
    
    public function editAction(int $activityId, ?array $requestActivity, Templating $templating, Router $router): ?string
    {
        $activity = Activity::find($activityId);
        if (! $activity) {
            throw new NotFoundException("Missing activity with id $activityId");
        }
        
        if ($requestActivity) {
            $msg = array();
            
            if(Activity::isActivityNameInDatabase($requestActivity['activity_name'], $activityId) != 0) {
                $msg[] = 'activity name is already in database';
            }
           
            $previousTaskName = $activity->getTaskName();
            $previousActivityName = $activity->getActivityName();
            
            $userName = $_SESSION['username'];
            $taskName = $userName . '-' . $requestActivity['activity_name'];
            $requestActivity['task_name'] = $taskName;
            
            if(!isset($requestActivity['feed'])) {
                $requestActivity['feed'] = 0;
            }
            if(!isset($requestActivity['filter'])) {
                $requestActivity['filter'] = 0;
            }
            if(!isset($requestActivity['pump'])) {
                $requestActivity['pump'] = 0;
            }
            if(!isset($requestActivity['is_planned'])) {
                $requestActivity['is_planned'] = 0;
            }
            
            foreach($requestActivity as $activityDataKey => $activityDataValue) {
                $animalDataValue = Validator::testInput($activityDataValue);
                $requestActivity[$activityDataKey] = $activityDataValue;
            }
            $requestActivity['lights_level'] = intval($requestActivity['lights_level']);
            $lightsValidationResult = Validator::isNumeric($requestActivity['lights_level']);
            if($lightsValidationResult != 1){
                $msg[] = "Wrong lights level";
            }
            $requestActivity['temperature'] = intval($requestActivity['temperature']);
            $temperatureValidationResult = Validator::isNumeric($requestActivity['temperature']);
            if($temperatureValidationResult != 1){
                $msg[] = "Wrong temperature";
            }            
            
            if($requestActivity['is_planned'] == 1)
            {
                if ($requestActivity['start_time'] == '') {
                    $msg[] = 'starting time must be set';
                }

                if ($requestActivity['start_date'] == '') {
                    $msg[] = 'starting date must be set';
                }

                if ($requestActivity['period_nr'] == '') {
                    $msg[] = 'period number must be set';
                }
                //$scheduler = new Scheduler();
                //$scheduler->removeTask($previousTaskName);
                $scriptFilePath = "public" . DIRECTORY_SEPARATOR . "plannedActivities" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

                
                if ( !is_dir($scriptFilePath)) {
                    mkdir($scriptFilePath);
                }
                
                $previousFilePath = $scriptFilePath . $previousActivityName . '.js';
                $scriptFilePath .= $requestActivity['activity_name'] . '.js';
                $activityData = [];
                if($requestActivity['lights_level'] != 0)
                    $activityData['lights_level'] = $requestActivity['lights_level'];
                if($requestActivity['temperature'] != 0)
                    $activityData['temperature'] = $requestActivity['temperature'];
                if($requestActivity['feed'] != 0)
                    $activityData['feed'] = $requestActivity['feed'];
                if($requestActivity['filter'] != 0)
                    $activityData['filter'] = $requestActivity['filter'];
                if($requestActivity['pump'] != 0)
                    $activityData['pump'] = $requestActivity['pump'];
        
                $executeData = json_encode($activityData);
                $logData = array();
                $logData['userName'] = $_SESSION['username'];
                $logData['activityName'] = $requestActivity['activity_name'];
                $logData = json_encode($activityData);
                
                $aquarium = Aquarium::find($requestActivity['aquarium_id']);
                
                //$scheduler->deleteTaskFile($previousFilePath);
                //$scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData, $logData);
                
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime(), $activity->getStartDate(), $activity->getPeriod(), $activity->getPeriodNr());
            } else {

             }
             
             if(empty($msg)){
                $msg[] = 'Activity edited successfully';
            } else {
                $_SESSION['request'] = $requestActivity;

                flash("activity", $msg);
                $path = $router->generatePath('activity-edit', ['activity_id' => $activityId]);
                $router->redirect($path);
                return null;
            }
            unset($_SESSION['request']);
            $activity->fill($requestActivity);
            $activity->save();
            
            $path = $router->generatePath('activity-show', ['activity_id' => $activityId]);
            $router->redirect($path);
            return null;
        }

        $aquariums = Aquarium::findAquariumsOwnedByUser($_SESSION['user_id']);
        $html = $templating->render('activity/edit.html.php', [
            'activity' => $activity,
            'aquariums' => $aquariums,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $activityId, Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $activity = Activity::find($activityId);
        $aquarium = Aquarium::find($activity->getAquariumId());
        $executeData = $activity->getExecuteData();

        if (! $activity) {
            throw new NotFoundException("Missing activity with id $activityId");
        }
        
        $html = $templating->render('activity/show.html.php', [
            'activity' => $activity,
            'aquarium' => $aquarium,
            'executeData' => $executeData,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $activityId, Router $router): ?string
    {
        if(isset($_SESSION['request'])) {
            unset($_SESSION['request']);
        }
        $activity = Activity::find($activityId);
        if (! $activity) {
            throw new NotFoundException("Missing activity with id $activityId");
        }

        if($activity->getIsPlanned()) {
            unlink("public" . DIRECTORY_SEPARATOR . "plannedActivities". DIRECTORY_SEPARATOR. $_SESSION['username'] . DIRECTORY_SEPARATOR . $activity->getActivityName() . ".js");
        }

        $activity->delete();
        
        $msg['actionFeedback'] = 'Deleted successfully';
        
        $path = $router->generatePath('activity-index');
        $router->redirect($path);
        return null;
    }
}
