<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\User;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class LoginController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['rrequest'])) {
            unset($_SESSION['rrequest']);
        }
        $html = $templating->render('login/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function loginAction(?array $requestUser, Templating $templating, Router $router): ?string
    {
        if ($requestUser) {
            $msg = array();
            

            $user = User::login($requestUser['username'], $requestUser['user_password']);
            if(is_null($user)) {
                $msg[] = 'wrong login data';
            }
            if(empty($msg)){
                $msg[] = 'Logged successfully';
            } else {
                $_SESSION['lrequest'] = $requestUser;
                flash("login", $msg);
                $path = $router->generatePath('login-index');
                $router->redirect($path);
                return null;
            }
            
            if(isset($_SESSION['lrequest'])) {
                unset($_SESSION['lrequest']);
            }
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
