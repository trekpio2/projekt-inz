<?php
namespace App\Controller;
require_once 'src/Helpers/flash.php';

use App\Exception\NotFoundException;
use App\Model\User;
use App\Validator;
use App\Service\Router;
use App\Service\Templating;


class RegisterController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        if(isset($_SESSION['lrequest'])) {
            unset($_SESSION['lrequest']);
        }

        $html = $templating->render('register/index.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function registerAction(?array $requestUser, Templating $templating, Router $router): ?string
    {
        
        if ($requestUser) {
            $msg = array();
            
            if(User::isUsernameInDatabase($requestUser['username']) == 0) {
                $msg[] = 'Username is already taken';
            }

             if(!preg_match("/^[a-zA-Z0-9]{6,}$/", $requestUser['username'])){
                $msg[] = "Wrong username";
             }

            if(!preg_match("/^(?=.*[!@#$%^&*])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{6,}$/",$requestUser['user_password'])){
                $msg[] = 'Wrong password';
            }
            
            if(empty($msg)){
                $msg[] = 'Created successfully';
            } else {
                $_SESSION['rrequest'] = $requestUser;
                flash("register", $msg);
                $path = $router->generatePath('register-index');
                $router->redirect($path);
                return null;
            }
            if(isset($_SESSION['rrequest'])) {
                unset($_SESSION['rrequest']);
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
