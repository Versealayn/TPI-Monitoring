<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : AdminController.php
 * Description : page controller de la section admin regroupant les action nécessitant des droits
 */

include_once 'model/AdminRepository.php';

class AdminController extends Controller {

    // Ajoute 'Action' afin d'appeller les fonctions
    public function display() {

        $action = $_GET['action'] . 'Action';

        return call_user_func(array($this, $action));
    }

    // Fonction permettant l'affichage des projets et des classes associées.
    // Elle n'affiche que les projets des classes dont l'utilisateur est associé
    private function displayAddProjectAction(){
        $adminRepository = new AdminRepository();
        $project = $adminRepository->findAll();
        $clagro = $adminRepository->findAllClagro();
        $view = file_get_contents('view/page/admin/formProjectAdd.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    
    // La fonction va chercher le projet que la personne aimerait modifier
    // Puis va répertorier toutes les classes et groupes du projet pour ensuite afficher le formulaire de modification de projet
    private function displaymodifyProjectAction() {

        $adminRepository = new AdminRepository();
        $project = $adminRepository->findOne($_GET['id']);
        $clagro = $adminRepository->findAllClagroOfPro($_GET['id']);

        $view = file_get_contents('view/page/admin/formProjectUpdate.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Va chercher toutes les tâches du projet et affiche le formulaire de création de tâche
    private function displayAddTaskAction(){
        $adminRepository = new AdminRepository();
        $task = $adminRepository->findAll();
        $view = file_get_contents('view/page/admin/formTaskAdd.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Prend les valeurs du formulaire de modification de projet et envoie les données au repository pour update la base de données avec les nouvelles valeurs
    private function updateAction() {
        $proName = $_POST['proName'];
        $proStart = $_POST['proStart'];
        $proEnd = $_POST['proEnd'];
        $idProject = $_GET['id'];

        $adminRepository = new AdminRepository();
        $result = $adminRepository->update($proName, $proStart, $proEnd, $idProject);

        header('location:index.php?controller=dashboard&action=list');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Fonction ajoutant un projet à la base de données
    private function addProjectAction() {
        $adminRepository = new AdminRepository();
        $resultId = $adminRepository->getMaxValue('t_project','idProject');

        // Count représente le nombre de classes et groupes à ajouter
        $count = $_POST['nmbClagro'];
        $proName = $_POST['proName'];
        $proStart = $_POST['proStart'];
        $proEnd = $_POST['proEnd'];

        $idProject = (int)$resultId[0]['MAX(idProject)'] + 1;

        // Envoie les données au repository pour créer un projet dans la base de données
        $resultProject = $adminRepository->createProject($idProject, $proName, $proStart, $proEnd);

        $clagroId = explode('cla', $_POST[$i.'clagro']);
        $adminRepository->createLierCla($classId[0], $idProject);
        // redirection sur la dashboard
        header('location:index.php?controller=dashboard&action=list');
    }

    // Ajouter une tâche à un projet
    private function addTaskAction() {
        $adminRepository = new AdminRepository();

        // récolte les données du formulaire d'ajout de tâche
        $tasName = $_POST['tasName'];
        $tasStart = $_POST['tasStart'];
        $tasEnd = $_POST['tasEnd'];
        $tasDescription = $_POST['tasDescription'];
        $tasFkProject = $_GET['id'];

        // envoi des données au repository afin de créer la tâche dans la base de données
        $resultProject = $adminRepository->createTask($tasName, $tasStart, $tasEnd, $tasDescription, $tasFkProject);
        // redirection sur la dashboard
        header('location:index.php?controller=dashboard&action=list');
    }

    // Affiche la page de monitoring pour les enseignants
    private function visualizeAction() {
        $adminRepository = new AdminRepository();
        // Récolte tous les utilisateurs des classes et des groupes associés au projet
        $students = $adminRepository->getUserFromClagro($_GET['id']);
        $DashboardRepository = new DashboardRepository();
        // Va chercher les tâches du projet
        $tasks = $DashboardRepository->findTasks($_GET['id']);
        // Affiche la page de monitoring
        $view = file_get_contents('view/page/admin/visualize.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}
?>