<?php
/**
 * ETML
 * Date: 01.06.2017
 * Shop
 */

include_once 'model/AdminRepository.php';

class AdminController extends Controller {

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

        $adminRepository = new AdminRepository();
        $project = $adminRepository->findAll();

        $view = file_get_contents('view/page/admin/index.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    private function displayAddProjectAction(){
        $adminRepository = new AdminRepository();
        $project = $adminRepository->findAll();
        $classes = $adminRepository->findAllClasses();
        $groups = $adminRepository->findAllGroups();
        $view = file_get_contents('view/page/admin/formProjectAdd.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    
    private function displaymodifyProjectAction() {

        $adminRepository = new AdminRepository();
        $project = $adminRepository->findOne($_GET['id']);

        $view = file_get_contents('view/page/admin/formProjectUpdate.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

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

    private function addAction() {
        $adminRepository = new AdminRepository();
        $resultId = $adminRepository->getMaxValue('t_project','idProject');

        $count = $_POST['nmbClagro'];
        $proName = $_POST['proName'];
        $proStart = $_POST['proStart'];
        $proEnd = $_POST['proEnd'];
        $proUser = $_POST['useEmail'];

        $idProject = (int)$resultId[0]['MAX(idProject)'] + 1;

        $resultProject = $adminRepository->createProject($idProject, $proName, $proStart, $proEnd);

        for($i = 0; $i < $count; ++$i){
            if (str_contains($_POST[$i.'clagro'], 'cla'))
            {
                $classId = explode('cla', $_POST[$i.'clagro']);
                $adminRepository->createLierCla($classId[0], $idProject);
            }
            else
            {
                $groupId = explode('gro', $_POST[$i.'clagro']);
                $adminRepository->createLierGro($groupId[0], $idProject);
            }
            
        }

        header('location:index.php?controller=dashboard&action=list');
    }
}
?>