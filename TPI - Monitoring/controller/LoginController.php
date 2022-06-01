<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 12.05.2022
 * Projet : TPI - Monitoring
 * Page Name : LoginController.php
 * Description : page controller de la page de login
 */

include_once 'model/LoginRepository.php';

class LoginController extends Controller {

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display() {

        $action = $_GET['action'] . "Action";

        return call_user_func(array($this, $action));
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function indexAction() {

        $view = file_get_contents('view/page/login/login.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display Login Action
     *
     * @return string
     */
    private function loginAction() {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginRepository = new LoginRepository();
        $result = $loginRepository->login($email, $password);

        if($result == true){
            session_start();
            $_SESSION['loggedin'] = true;
            header('Location: index.php?controller=dashboard&action=list');

            $view = file_get_contents('view/page/dashboard/dashboard.php');
            ob_start();
            eval('?>' . $view);
            $content = ob_get_clean();
    
            return $content;
        }
        else {
            header("Location: index.php?controller=login&action=index");
        }
    }

    /**
     * Diplay Logout Action
     * 
     * @return string
     */
    private function logoutAction() {
        
        session_destroy();
        $view = file_get_contents('view/page/dashboard/dashboard.php');
        header('location:index.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;

    }

}