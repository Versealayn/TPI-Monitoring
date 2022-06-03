<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : controller.php
 * Description : page controller principale
 */
abstract class Controller {

    // Fonction permettant d'appeller l'action
    public function display() {

        $page = $_GET['action'] . 'Display';

        $this->$page();
    }
}