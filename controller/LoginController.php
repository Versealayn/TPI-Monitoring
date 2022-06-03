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

    // Ajoute 'Action' afin d'appeller les fonctions
    public function display() {

        $action = $_GET['action'] . 'Action';

        return call_user_func(array($this, $action));
    }

    // Affiche la page de login
    private function indexAction() {

        $view = file_get_contents('view/page/login/login.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Permet l'authentification de l'utilisateur
    private function loginAction() {

        // Recolte les données insérées par l'utilisateur
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Envoi des informations au repository afin de se connecter et réception de la réponse
        $loginRepository = new LoginRepository();
        $result = $loginRepository->login($email, $password);

        // Si la réponse est True, c'est-à-dire que l'utilisateur a rentré le bonnes valeurs :
        if($result == true){
            // On annonce dans la section qu'il est connecté et on le redirige sur sa dashboard
            session_start();
            $_SESSION['loggedin'] = true;
            header('Location: index.php?controller=dashboard&action=list');

            $view = file_get_contents('view/page/dashboard/dashboard.php');
            ob_start();
            eval('?>' . $view);
            $content = ob_get_clean();
    
            return $content;
        }
        // Sinon, retour à l'accueil
        else {
            header('Location: index.php?controller=login&action=index');
        }
    }

    // Deconnexion de l'utilisateur
    private function logoutAction() {
        
        // Destruction de la session et redirection sur la page d'accueil
        session_destroy();
        $view = file_get_contents('view/page/dashboard/dashboard.php');
        header('location:index.php');
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;

    }

}