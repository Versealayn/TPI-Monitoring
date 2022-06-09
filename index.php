<?php
session_start();
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : index.php
 * Description : Page d'index 
 */

$debug = false;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// Inclusion des pages controller à l'index
include 'controller/Controller.php';
include 'controller/AdminController.php';
include 'controller/HomeController.php';
include 'controller/LoginController.php';
include 'controller/DashboardController.php';


date_default_timezone_set('Europe/Zurich');

class MainController {

    // Si GET n'a pas de controller, attribue la fonction indexAction de la page HomeController
    public function dispatch() {

        if (!isset($_GET['controller'])) {
            $_GET['controller'] = 'home';
            $_GET['action'] = 'index';
        }

        $currentLink = $this->menuSelected($_GET['controller']);
        $this->viewBuild($currentLink);
    }

    // Créer une nouvelle classe selon le $_GET['controller]
    protected function menuSelected ($page) {

        switch($_GET['controller']){
            case 'home':
                $link = new HomeController();
                break;
            case 'login':
                $link = new LoginController();
                break;
            case 'dashboard':
                $link = new DashboardController();
                break;
            case 'admin':
                $link = new AdminController();
                break;
        }

        return $link;
    }

    // Construit la vue pour afficher le site web
    protected function viewBuild($currentPage) {
        $content = $currentPage->display();

        include(dirname(__FILE__) . '/view/head.html');

        #Si la personne n'est pas sur la page de login, afficher la barre de navigation
        if(get_class($currentPage) != 'LoginController')
        {
            include(dirname(__FILE__) . '/view/navbar.php');
        }
        echo $content;
        include(dirname(__FILE__) . '/view/footer.html');
    }
}

// Affichage
$controller = new MainController();
$controller->dispatch();