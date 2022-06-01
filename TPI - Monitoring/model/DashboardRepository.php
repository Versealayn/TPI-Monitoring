<?php
/**
 * ETML
 * Date: 01.06.2017
 * Shop
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';

class DashboardRepository implements Entity {

    /**
     * Find all entries
     *
     * @return array|resource
     */
    public function findAll() {

        $table = 't_appartenir as s, t_user as c, t_project as d';
        $columns = '*';
        $where =  's.fkUser = ';

        $request =  new DataBaseQuery();
        return $request->select($table, $columns, $where);
    }

    /**
     * Find One entry
     *
     * @param $idProduct
     *
     * @return array
     */

    public function countClass() 
    {
        $table = 't_class';
        $columns = 'idClass';

        $request = new DataBaseQuery();
        $query = $request->getCount($table, $columns);
        return $query;
    }

    public function findUserClagro($idUser)
    {
        $table = 't_class as c';
        $columns = '*';
        $join = 't_appartenir as a ON a.fkClass = c.idClass INNER JOIN t_user as u ON u.idUser = a.fkUser';
        $where = 'u.idUser = ' . $idUser;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $join, $where);

        return $query;
    }

    public function findProjectFromClagro($idClass)
    {
        $table = 't_project as p';
        $columns = '*';
        $join = 't_lier as l ON l.fkProject = p.idProject INNER JOIN t_class as c ON l.fkClass = c.idClass';
        $where = 'c.idClass = ' . $idClass;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $join, $where);

        return $query;
    }

    public function findProjects($idUser)
    {

        $table = 't_project as p';
        $columns = '*';
        $join = 't_lier as l ON p.idProject = l.fkProject INNER JOIN t_appartenir as a ON l.fkClass = a.fkClass OR l.fkGroup = a.fkGroup';
        $where = 'a.fkUser = ' . $idUser;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $join, $where);

        return $query;
    }

    public function findOneProject($idProject){
        $table = 't_project as p';
        $columns = '*';
        $where = 'p.idProject = ' . $idProject;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $where);

        return $query;
    }

    /*public function findAllClaGroOfUser($idUser){
        $table = 't_appartenir as a';
        $columns = '*';
        $join = 't_class as c ON c.idClass = a.fkClass INNER JOIN t_group as g ON g.idGroup = a.fkGroup INNER JOIN t_user as u ON u.idUser = a.fkUser';
        $where = 'a.fkUser = ' . $idUser;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $join, $where);

        return $query;
    }*/

    public function findTasks($idProject)
    {

        $table = 't_project as p';
        $columns = '*';
        $join = array('t_task as t', 't.fkProject', 'p.idProject');
        $where = 'p.idProject = ' . $idProject;

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where);

        return $query;
    }

    public function changeState($idTask, $state){
        $table = 't_task';
        $columns = 'tasState = "' .$state . '"';
        $where = 'idTask='.$idTask;

        $request = new DataBaseQuery();
        $query = $request->update($table, $columns, $where);

        return $query;
    }
}