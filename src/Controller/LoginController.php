<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\User;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class LoginController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $html = $templating->render('login/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function loginAction(?array $requestUser, Templating $templating, Router $router): ?string
    {
        if ($requestUser) {
            $msg = array();
            $validationMsg = array();
            // @todo missing validation


            if(!empty($validationMsg)){
                $msg['actionFeedback'] = 'Wrong login data';
                $msg['validation'] = $validationMsg;
            }


            $user = User::login($requestUser['username'], $requestUser['user_password']);
            $_SESSION['user_id'] = $user->getUserId();
            $_SESSION['username'] = $user->getUsername();
            
            $path = $router->generatePath('');
            $router->redirect($path);
            return null;
        } else {
            $html = $templating->render('login/index.html.php', [
                'router' => $router,
            ]);
            return $html;
        }
        
    }

    public function logoutAction(Templating $templating, Router $router): ?string
    {
        session_unset();
        session_destroy();

        $html = $templating->render('login/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }
}
