<?php
namespace App\Controller;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


use App\Exception\NotFoundException;
use App\Model\User;
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
            // @todo missing validation
            $user = User::login($requestUser['username'], $requestUser['user_password']);
            $_SESSION['user_id'] = $user->getUserId();
            $_SESSION['username'] = $user->getUsername();
            
            //zmienic na strone glowna jak bedzie
            $path = $router->generatePath('animal-index');
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
