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
        $columns = '*';

        $request =  new DataBaseQuery();

        return $request->select($table, $columns);

    }

    // Sélection un projet précis selon son ID
    public function findOne($idProject) {

        $table = 't_project as p';
        $columns = '*';
        $where =  'p.idProject = ' . $idProject;

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where);

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

    public function update($proName, $proStart, $proEnd, $idProject) {

        $request = new DataBaseQuery();
        $table = 't_project';
        $columns = 'proName = \''.$proName.'\', proStart = .\''.$proStart.'\', proEnd = \''.$proEnd.'\'';
        $where = 'idProject = ' . $idProject;

        return $request->update($table, $columns, $where);
    }

    public function findAllClagro(){
        $request = new DataBaseQuery();
        $table = 't_clagro';
        $columns = 'idClagro, claName';
        
        return $request->select($table, $columns);
    }

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

    public function getMaxValue($table, $columns){
        $request = new DataBaseQuery();
        return $request->getMaxValue($table, $columns);

    }

    public function createProject($idProject, $proName, $proStart, $proEnd){
        $request = new DataBaseQuery();
        $values = '(\''.$idProject.'\', \''.$proName.'\', \''.$proStart.'\', \''.$proEnd.'\')';
        return $request->insert('t_project', '(`idProject`, `proName`, `proStart`, `proEnd`)', $values);
    }

    public function createTask($tasName, $tasStart, $tasEnd, $tasDescription, $tasFkProject){
        $request = new DataBaseQuery();
        $values = '(\''.$tasName.'\', \''.$tasStart.'\', \''.$tasEnd.'\', \''.$tasDescription.'\', \''.$tasFkProject.'\')';
        return $request->insert('t_task', '(`tasName`, `tasStart`, `tasEnd`, `tasDescription`, `fkProject`)', $values);
    }

    public function createLierCla($fkClass, $fkProject){

        $request = new DataBaseQuery();
        $values = '('.$fkClass.', NULL , '.$fkProject.')';

        return $request->insert('t_lier', '(`fkClass`, `fkGroup`,`fkProject`)', $values);
    }
    public function createLierGro($fkGroup, $fkProject){

        $request = new DataBaseQuery();
        $values = '(NULL, '.$fkGroup.', '.$fkProject.')';

        return $request->insert('t_lier', '(`fkClass`, `fkGroup`,`fkProject`)', $values);
    }

}