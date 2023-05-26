<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\User;
use App\Validator;
use App\Service\Router;
use App\Service\Templating;

class RegisterController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $html = $templating->render('register/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function registerAction(?array $requestUser, Templating $templating, Router $router): ?string
    {
        
        if ($requestUser) {
            $msg = array();
            $validationMsg = array();
            // @todo missing validation


            if(empty($validationMsg)){
                $msg['actionFeedback'] = 'Created successfully';
            } else {
                $msg['actionFeedback'] = 'Created unsuccessfully';
                $msg['validation'] = $validationMsg;
            }
            
            $user = User::fromArray($requestUser);

            $user->save();

            $path = $router->generatePath('login-index');
            $router->redirect($path);
            
            return null;
        } else{
            $html = $templating->render('register/index.html.php', [
                'router' => $router,
            ]);
            return $html;
        }
    }
}
