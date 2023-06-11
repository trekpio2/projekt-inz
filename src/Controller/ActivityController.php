<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\Activity;
use App\Model\Aquarium;
use App\Model\Scheduler;
use App\Service\Router;
use App\Service\Templating;

class ActivityController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
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

            if(Activity::isActivityNameInDatabase($requestActivity['activity_name']) != 0) {
                $msg[] = 'activity name is already in database';
            }

            $lightsValidationResult = Validator::isNumeric($requestAquarium['lights_level']);
            if($lightsValidationResult != 1){
                $msg[] = "Wrong lights level";
            }

            $temperatureValidationResult = Validator::isNumeric($requestAquarium['temperature']);
            if($temperatureValidationResult != 1){
                $msg[] = "Wrong temperature";
            }    

            $userName = $_SESSION['username'];
            $taskName = $userName . '-' . $requestActivity['activity_name'];
            $requestActivity['task_name'] = $taskName;
            
 


            if($requestActivity['is_planned'] == 1)
            {
                $scheduler = new Scheduler();
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
                $scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData, $logData);
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie                
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime(), $activity->getStartDate(), $activity->getPeriod(), $activity->getPeriodNr());
            }
            
            if(empty($msg)){
                $msg[] = 'Activity created successfully';
            } else {
                flash("activity", $msg);
                $path = $router->generatePath('activity-create');
                $router->redirect($path);
                return null;
            }
            
            $activity = Activity::fromArray($requestActivity);
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
            
            if(Activity::isActivityNameInDatabase($requestAquarium['activity_name'], $activityId) != 0) {
                $msg[] = 'activity name is already in database';
            }
            //@todo missing validation
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
            
            $lightsValidationResult = Validator::isNumeric($requestAquarium['lights_level']);
            if($lightsValidationResult != 1){
                $msg[] = "Wrong lights level";
            }

            $temperatureValidationResult = Validator::isNumeric($requestAquarium['temperature']);
            if($temperatureValidationResult != 1){
                $msg[] = "Wrong temperature";
            }            
            
            if($requestActivity['is_planned'] == 1)
            {
                $scheduler = new Scheduler();
                $scheduler->removeTask($previousTaskName);
                $scriptFilePath = "public" . DIRECTORY_SEPARATOR . "plannedActivities" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;

                
                if ( !is_dir($scriptFilePath)) {
                    mkdir($scriptFilePath);
                }
                
                $previousFilePath = $scriptFilePath . $previousActivityName . '.js';
                $scriptFilePath .= $activity->getActivityName() . '.js';
                $executeData = $activity->getExecuteData();
                $logData = array();
                $logData['userName'] = $_SESSION['username'];
                $logData['activityName'] = $activity->getActivityName();
                $logData = json_encode($activityData);
                
                $aquarium = Aquarium::find($activity->getAquariumId());
                
                $scheduler->deleteTaskFile($previousFilePath);
                $scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData, $logData);
                
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime(), $activity->getStartDate(), $activity->getPeriod(), $activity->getPeriodNr());
            }
            else
            {
                $scheduler = new Scheduler();
                $scheduler->turnOffTask($previousTaskName);
             }
             
             if(empty($msg)){
                $msg[] = 'Activity edited successfully';
            } else {
                flash("activity", $msg);
                $path = $router->generatePath('activity-edit', ['activity_id' => $activityId]);
                $router->redirect($path);
                return null;
            }
            
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
