<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 12.05.2022
 * Projet : TPI - Monitoring
 * Page Name : AdminRepository.php
 * Description : page repository de la section Admin
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';

class AdminRepository implements Entity {

   // Sélectionne tous les projets
    public function findAll() {

        $table = 't_project as p';
        $columns = 'idProject, proName, proStart, proEnd';

        $request =  new DataBaseQuery();

        return $request->select($table, $columns);

    }

    // Sélectionne un projet précis selon son ID
    public function findOne($idProject) {

        $table = 't_project as p';
        $columns = 'idProject, proName, proStart, proEnd';
        $where =  'p.idProject = ' . $idProject;

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where);

    }

    // Sélectionne un projet précis selon son ID
    public function findOneTask($idTask) {

        $table = 't_task as t';
        $columns = 'idTask, tasName, tasDescription, tasStart, tasEnd';
        $where =  't.idTask = ' . $idTask;

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where)[0];
    }

    // Permet de sélectionner tous les groupes et classes d'un projet
    public function findAllClagroOfPro($idProject){
        $table = 't_clagro as c';
        $columns = 'claName';
        $join = ' INNER JOIN t_lier as l on l.fkClagro = c.idClagro INNER JOIN t_project as p on l.fkProject = p.idProject';
        $where =  'p.idProject = ' . $idProject;

        $request =  new DataBaseQuery();

        return $request->selectJoin($table, $columns, $join, $where);
        
    }

    // Modifie un projet spécifique
    public function update($proName, $proStart, $proEnd, $idProject) {

        $request = new DataBaseQuery();
        $table = 't_project';
        $columns = 'proName = \''.$proName.'\', proStart = \''.$proStart.'\', proEnd = \''.$proEnd.'\'';
        $where = 'idProject = ' . $idProject;

        return $request->update($table, $columns, $where);
    }

    // Sélectionne toutes les classes et tous les groupes de la base de données
    public function findAllClagro(){
        $request = new DataBaseQuery();
        $table = 't_clagro';
        $columns = 'idClagro, claName';
        
        return $request->select($table, $columns);
    }

    // Permet de sélectionner un seul utilisateur depuis son adresse e-mail
    public function findOneUser($useEmail){
        $table = 't_user as u';
        $columns = 'idUser';
        $where =  'u.useEmail = \''.$useEmail.'\'';

        $request = new DataBaseQuery();

        return $request->select($table, $columns, $where);
    }

    // Permet de sélectionner tous les utilisateurs d'un projet
    public function getUserFromClagro($idProject){
        $request = new DatabaseQuery;
        $table = 't_user as u';
        $columns = 'useSurname, useName';
        $join = ' INNER JOIN t_appartenir as a ON a.fkUser = u.idUser
                  INNER JOIN t_clagro as c ON c.idClagro = a.fkClagro
                  INNER JOIN t_lier as l ON l.fkClagro = c.idClagro
                  INNER JOIN t_project as p ON p.idProject = l.fkProject';
        $where = 'p.idProject = '.$idProject;

        return $request->selectJoin($table, $columns, $join, $where);
    }

    // Fonction permettant d'afficher la valeur maximale d'une table
    public function getMaxValue($table, $columns){
        $request = new DataBaseQuery();
        return $request->getMaxValue($table, $columns);

    }

    // Créer un projet
    public function createProject($idProject, $proName, $proStart, $proEnd){
        $request = new DataBaseQuery();
        $values = '(\''.$idProject.'\', \''.$proName.'\', \''.$proStart.'\', \''.$proEnd.'\')';
        return $request->insert('t_project', '(`idProject`, `proName`, `proStart`, `proEnd`)', $values);
    }

    // Créer une tâche
    public function createTask($tasName, $tasStart, $tasEnd, $tasDescription, $tasFkProject){
        $request = new DataBaseQuery();
        $values = '(\''.$tasName.'\', \''.$tasStart.'\', \''.$tasEnd.'\', \''.$tasDescription.'\', \''.$tasFkProject.'\')';
        return $request->insert('t_task', '(`tasName`, `tasStart`, `tasEnd`, `tasDescription`, `fkProject`)', $values);
    }

    // Modifier une tâche selon son ID
    public function editTask($tasName, $tasStart, $tasEnd, $tasDescription, $tasId){
        $request = new DataBaseQuery();
        $values = 'tasName = \''.$tasName.'\', tasStart = \''.$tasStart.'\', tasEnd = \''.$tasEnd.'\', tasDescription = \''.$tasDescription.'\'';
        $where = 'idTask = ' . $tasId;
        return $request->update('t_task', $values, $where);
    }

    // Ajouter une ligne à la table t_lier afin de lier une classe à un projet 
    public function createLierCla($fkClass, $fkProject){

        $request = new DataBaseQuery();
        $values = '('.$fkClass.', NULL , '.$fkProject.')';

        return $request->insert('t_lier', '(`fkClass`, `fkGroup`,`fkProject`)', $values);
    }

    // Ajouter une ligne à la table t_lier afin de lier une classe à un projet  
    public function createLierGro($fkGroup, $fkProject){

        $request = new DataBaseQuery();
        $values = '(NULL, '.$fkGroup.', '.$fkProject.')';

        return $request->insert('t_lier', '(`fkClass`, `fkGroup`,`fkProject`)', $values);
    }

    // Sélectionne une seule classe ou groupe selon son nom
    public function findOneClaGro($claName){

        $table = 't_clagro as c';
        $columns = 'idClagro';
        $where =  'c.claName = \''.$claName.'\'';

        $request = new DataBaseQuery();

        return $request->select($table, $columns, $where);
    }

    // Crée une classe ou un groupe selon son nom
    public function createClaGro($claName){

        $find = $this->findOneClaGro($claName);

        // si le nom éxiste déjà
        if (isset($find) && is_array($find) && count($find) > 0) {
            return false;
        }

        $request = new DataBaseQuery();
        $values = '(\''.$claName.'\')';

        return $request->insert('t_clagro', '(`claName`)', $values);
    }

    // Trouver une relation entre un utilisateur et un groupe selon leur id
    public function findOneAppartenir($idUser, $idClagro) {
        $table = 't_appartenir as a';
        $columns = 'idAppartenir';
        $where =  'a.fkUser = \''.$idUser.'\' AND a.fkClagro = \''.$idClagro.'\'';

        $request = new DataBaseQuery();

        return $request->select($table, $columns, $where);
    }

    // Créer une relation entre un utilisateur et un groupe / classe
    public function createAppartenirLink($idUser, $idClagro) {
        $request = new DataBaseQuery();
        $values = '(\''.$idUser.'\', \''.$idClagro.'\')';

        return $request->insert('t_appartenir', '(`fkUser`, `fkClagro`)', $values);
    }
}