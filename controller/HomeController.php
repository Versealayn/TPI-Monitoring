<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : HomeController.php
 * Description : page controller de la page d'accueil
 */

class HomeController extends Controller {

    // Ajoute 'Action' afin d'appeller les fonctions
    public function display() {

        $action = $_GET['action'] . 'Action';

        return call_user_func(array($this, $action));
    }

    // Affiche la page d'accueil
    private function indexAction() {
        // Si l'utilisateur n'est pas connecté, afficher la page lui demandant de se connecter
        if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
            $view = file_get_contents('view/page/home/notlogged.php');
        }
        // sinon afficher la dashboard de l'utilisateur
        else{
            $view = file_get_contents('view/page/dashboard/dashboard.php');
            header('location:index.php?controller=dashboard&action=list');
        }
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}