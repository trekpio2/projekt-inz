<?php
namespace App\Controller;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        $activities = Activity::findAllAssignedToUser($_SESSION['user_id']);
        $html = $templating->render('activity/index.html.php', [
            'activities' => $activities,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestActivity, Templating $templating, Router $router): ?string
    {
        if ($requestActivity) {
            // @todo missing validation
            $userName = $_SESSION['username'];
            $taskName = $userName . '-' . $requestActivity['activity_name'];
            $requestActivity['task_name'] = $taskName;
            
            $activity = Activity::fromArray($requestActivity);
            $activity->save();
            
            if($requestActivity['is_planned'] == 1)
            {
                $scheduler = new Scheduler();
                $scriptFilePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "plannedActivities" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
                
                if ( ! is_dir($scriptFilePath)) {
                    mkdir($scriptFilePath);
                }
                
                $scriptFilePath .= $activity->getActivityName() . '.js';
                $executeData = $activity->getExecuteData();
                
                $aquarium = Aquarium::find($activity->getAquariumId());
                $scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData);
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime());
            }

            
            
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
            //@todo missing validation
            $previousTaskName = $activity->getTaskName();
            $previousActivityName = $activity->getActivityName();
            
            $userName = $_SESSION['username'];
            $taskName = $userName . '-' . $requestActivity['activity_name'];
            $requestActivity['task_name'] = $taskName;
            
            if(!isset($requestActivity['is_planned']))
            $requestActivity['is_planned'] = 0;
            
            $activity->fill($requestActivity);
            $activity->save();
            
            if($requestActivity['is_planned'] == 1)
            {
                $scheduler = new Scheduler();
                $scheduler->removeTask($previousTaskName);
                $scriptFilePath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "plannedActivities" . DIRECTORY_SEPARATOR . $userName . DIRECTORY_SEPARATOR;
                
                if ( ! is_dir($scriptFilePath)) {
                    mkdir($scriptFilePath);
                }
                
                $previousFilePath = $scriptFilePath . $previousActivityName . '.js';
                $scriptFilePath .= $activity->getActivityName() . '.js';
                $executeData = $activity->getExecuteData();
                $aquarium = Aquarium::find($activity->getAquariumId());
                
                $scheduler->deleteTaskFile($previousFilePath);
                $scheduler->createTaskFile($scriptFilePath, $aquarium->getIP(), $activity->getActivityName(), $executeData);
                
                $taskCommand = "node " . $scriptFilePath;
                // zakomentowane zeby nie smiecic w systemie
                //$scheduler->addTask($taskName, $taskCommand, $activity->getStartTime());
            }
            else
             {
                $scheduler = new Scheduler();
                $scheduler->turnOffTask($previousTaskName);
             }
             
             

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

        $activity->delete();
        $path = $router->generatePath('activity-index');
        $router->redirect($path);
        return null;
    }
}
