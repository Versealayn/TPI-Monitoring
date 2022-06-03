<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : DashboardController.php
 * Description : page controller de la page dashboard regroupant les projets
 */

include_once 'model/DashboardRepository.php';

class DashboardController extends Controller {

    // Ajoute 'Action' afin d'appeller les fonctions
    public function display() {

        $action = $_GET['action'] . 'Action';

        return call_user_func(array($this, $action));
    }

    // Affiche la dashboard
    private function indexAction() {

        $view = file_get_contents('view/page/dashboard/dashboard.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Affiche tous les projets de l'utilisateur selon ses classes ou groupes
    private function listAction() {

        $DashboardRepository = new DashboardRepository();
        $projectsClagro = $DashboardRepository->findProjectsClagro($_SESSION['user']['userId']);

        // Affiche la dashboard
        $view = file_get_contents('view/page/dashboard/dashboard.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Affiche les tâches d'un projet et redirige l'utilisateur sur la page du projet
    private function projectAction() {
        $DashboardRepository = new DashboardRepository();
        $project = $DashboardRepository->findTasks($_GET['id']);
        // Affichage des tâches
        $view = file_get_contents('view/page/dashboard/project.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Fonction permettant la modification des état des tâches
    // Quand l'utilisateur clique sur le bouton pour modifier le statut, les informations sont envoyées ici
    private function stateAction() {
        $DashboardRepository = new DashboardRepository();
        $project = $DashboardRepository->changeState($_GET['iduser'], $_GET['id'],$_GET['state']);
        // Rafraîchissement de page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}