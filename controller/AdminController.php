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

    // Fonction permettant la création d'une classe (formulaire)
    private function displayAddClassAction(){
        $view = file_get_contents('view/page/admin/formClassAdd.php');

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

    // Va afficher le lien entre un élève et une classe
    private function displayLinkStudentAction(){
        $adminRepository = new AdminRepository();

        $students = $adminRepository->findAll();
        $clagro = $adminRepository->findAllClagro();

        $view = file_get_contents('view/page/admin/formStudentLink.php');

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

    // Fonction ajoutant une classe à la base de données
    private function addClassAction() {
        $adminRepository = new AdminRepository();

        // On récupére le nom de la classe entrée
        $claName = trim($_POST['claName']);

        // On regarde si le nom est vide
        if(empty($claName)){
            $errorMsg = 'Le nom est vide';
            $view = file_get_contents('view/page/admin/formClassAdd.php');
            ob_start();
            eval('?>' . $view);
            return ob_get_clean();
        }

        // On essaye de créer la classe
        $error = $adminRepository->createClaGro($claName);

        // Si il y a une erreur
        if($error == false) {
            $errorMsg = 'Le nom existe déjà';
            $view = file_get_contents('view/page/admin/formClassAdd.php');
            ob_start();
            eval('?>' . $view);
            return ob_get_clean();
        }

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

    // Va chercher toutes les tâches du projet et affiche le formulaire de modification de tâche
    private function displayEditTaskAction(){
        $adminRepository = new AdminRepository();
        $task = $adminRepository->findOneTask($_GET['id']);
        $view = file_get_contents('view/page/admin/formTaskEdit.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    // Modifie une tâche d'un projet
    private function editTaskAction() {
        $adminRepository = new AdminRepository();

        // récolte les données du formulaire d'ajout de tâche
        $tasName = $_POST['tasName'];
        $tasStart = $_POST['tasStart'];
        $tasEnd = $_POST['tasEnd'];
        $tasDescription = $_POST['tasDescription'];
        $tasId = $_GET['id'];

        // envoi des données au repository afin de créer la tâche dans la base de données
        $resultProject = $adminRepository->editTask($tasName, $tasStart, $tasEnd, $tasDescription, $tasId);
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
        // Va chercher le projet
        $project = $DashboardRepository->findOneProject($_GET['id'])[0];
        // Va chercher les infos sur la classe / groupe
        $clagro = $DashboardRepository->findClagro($_GET['id'])[0];
        // Affiche la page de monitoring
        $view = file_get_contents('view/page/admin/visualize.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function displayLinkStudentActionWithError($error) {
        $adminRepository = new AdminRepository();
        $students = $adminRepository->findAll();
        $clagro = $adminRepository->findAllClagro();
        $errorMsg = $error;

        $view = file_get_contents('view/page/admin/formStudentLink.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    public function linkUserAction() {

        // On récupére les valeurs
        $mail = $_POST['useEmail'];
        $idClass = $_POST['claName'];

        // Check si elles sont vident
        if(empty($mail) || empty($idClass)) {
            $errorMsg = 'Une donnée est vide';
            return $this->displayLinkStudentActionWithError($errorMsg);
        }

        // On essaye de récupérer la personne
        $adminRepository = new AdminRepository();
        $find = $adminRepository->findOneUser($mail);

        // Si l'email est introuvable
        if(!isset($find) || !is_array($find) || count($find) == 0) {
            $errorMsg = 'Email introuvable';
            return $this->displayLinkStudentActionWithError($errorMsg);
        }

        // On récupére l'id
        $idUser = $find[0]['idUser'];

        // On essaye de récupérer le lien
        $find = $adminRepository->findOneAppartenir($idUser, $idClass);
        if(isset($find) && is_array($find) && count($find) > 0) {
            $errorMsg = 'Lien déjà éxistant';
            return $this->displayLinkStudentActionWithError($errorMsg);
        }

        // On crée le lien
        $adminRepository->createAppartenirLink($idUser, $idClass);

        // redirection sur la dashboard
        header('location:index.php?controller=dashboard&action=list');
    }
}
?>