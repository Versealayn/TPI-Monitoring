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

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display() {

        $action = $_GET['action'] . "Action";
        // return $this->$page();

        return call_user_func(array($this, $action));
    }

    private function indexAction() {

        $view = file_get_contents('view/page/dashboard/dashboard.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Display List Action
     *
     * @return string
     */
    private function listAction() {

        $DashboardRepository = new DashboardRepository();
        
        $class = $DashboardRepository->findUserClagro($_SESSION['user']['userId']);
        $projects = '';

        foreach ($class as $elem)
        {
            $projects.= $DashboardRepository->findProjectFromClagro($elem['idClass']);
        }
        //$projects = $DashboardRepository->findProjects($_SESSION['user']['userId']);
        //$class = $DashboardRepository->findAllClaGroOfUser($_SESSION['user']['userId']);
        $view = file_get_contents('view/page/dashboard/dashboard.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function projectAction() {
        $DashboardRepository = new DashboardRepository();
        $project = $DashboardRepository->findTasks($_GET['id']);

        $view = file_get_contents('view/page/dashboard/project.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        //session_unset($_SESSION);

        return $content;
    }

    private function stateAction() {
        $DashboardRepository = new DashboardRepository();
        $project = $DashboardRepository->changeState($_GET['id'],$_GET['state']);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    /**
     * Display Detail Action
     *
     * @return string
     
    private function detailAction() {

        $shopRepository = new ShopRepository();
        $product = $shopRepository->findOne($_GET['id']);

        $view = file_get_contents('view/page/shop/detail.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;

    }*/

    /**
     * Add a product to a cart Action
     *
     * @return string
     
    private function addCartAction() {

        $shopRepository = new ShopRepository();
        $product = $shopRepository->findOne($_GET['id']);

        if(isset($_SESSION["shopping_cart"]))
        {
            $product_array_id = array_column($_SESSION["shopping_cart"], "product_id");
            if(!in_array($_GET["id"], $product_array_id))
            {
                $count = $product[0]["idProduct"];
                $product_array = array(
                    'product_id'			=>	$product[0]["idProduct"],
                    'product_name'			=>	$product[0]["proName"],
                    'product_price'		    =>	$product[0]["proPrice"],
                    'product_stock'		    =>	$product[0]["proQuantity"],
                    'product_image'         =>  $product[0]["fkImages"],
                    'product_quantity'		=>	1

                );
                $_SESSION["shopping_cart"][$count] = $product_array;
            }
            else
            {
                //echo '<script>alert("Item Already Added")</script>';
                if($product[0]["proQuantity"] > $_SESSION["shopping_cart"][$product[0]["idProduct"]]["product_quantity"])
                {
                    $_SESSION["shopping_cart"][$product[0]["idProduct"]]["product_quantity"] += 1;
                }
            }
        }
        else
        {
            $product_array = array(
               'product_id'         => $product[0]["idProduct"],
               'product_name'       => $product[0]["proName"],
               'product_price'      => $product[0]["proPrice"],               
               'product_stock'		=> $product[0]["proQuantity"],
               'product_image'      => $product[0]["fkImages"],
               'product_quantity'   => 1
            );
            $_SESSION["shopping_cart"][$product[0]["idProduct"]] = $product_array;
        }
        $view = file_get_contents('view/page/shop/detail.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        header('Location: index.php?controller=shop&action=list');

        return $content;

    }*/


}