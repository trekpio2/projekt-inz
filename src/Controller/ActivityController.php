<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Activity;
use App\Model\Aquarium;
use App\Model\User;
use App\Service\Router;
use App\Service\Templating;

class ActivityController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        // narazie id uzytkownika na sztywno
        $activities = Activity::findAllAssignedToUser(1);
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
            $activity = Activity::fromArray($requestActivity);
            $activity->save();
            
            $path = $router->generatePath('activity-index');
            $router->redirect($path);
            return null;
        } else {
            $activity = new Activity();
        }

        $html = $templating->render('activity/create.html.php', [
            'activity' => $activity,
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
            $activity->fill($requestActivity);
             $activity->save();

            $path = $router->generatePath('activity-show', ['activity_id' => $activityId]);
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('activity/edit.html.php', [
            'activity' => $activity,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $activityId, Templating $templating, Router $router): ?string
    {
        $activity = Activity::find($activityId);
        $aquarium = Aquarium::find($activity->getAquariumId());
        
        if (! $activity) {
            throw new NotFoundException("Missing activity with id $activityId");
        }

        $html = $templating->render('activity/show.html.php', [
            'activity' => $activity,
            'aquarium' => $aquarium,
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
