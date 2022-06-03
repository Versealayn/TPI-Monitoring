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

    public function findProjects($idUser)
    {

        $table = 't_project as p';
        $columns = '*';
        $join = ' INNER JOIN t_lier as l ON p.idProject = l.fkProject INNER JOIN t_appartenir as a ON l.fkClagro = a.fkClagro';
        $where = 'a.fkUser = ' . $idUser;
        $groupBy = 'p.idProject';

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where, $groupBy);

        return $query;
    }

    public function findProjectsClagro($idUser)
    {

        $table = 't_project as p';
        $columns = '*';
        $join = ' INNER JOIN t_lier as l ON l.fkProject = p.idProject INNER JOIN t_clagro as c ON l.fkClagro = c.idClagro INNER JOIN t_appartenir as a ON a.fkClagro = c.idClagro INNER JOIN t_user as u ON u.idUser = a.fkUser';
        $where = 'u.idUser = ' . $idUser;
        $groupBy = 'p.idProject';

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where, $groupBy);

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

    public function findTasks($idProject)
    {

        $table = 't_task as t';
        $columns = 'tasName, tasStart, tasEnd, idTask, fkUser,  fkTask, staState';
        $join = ' LEFT JOIN t_project as p ON p.idProject = t.fkProject
        LEFT JOIN t_state as s ON t.idTask = s.fkTask
        LEFT JOIN t_user as u ON s.fkUser = u.idUser';
        $where = 'p.idProject = ' . $idProject;

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where);

        return $query;
    }

    public function changeState($idUser, $idTask, $state){

        $table = 't_state as s';
        $where = 's.fkUser = '.$idUser.' and s.fkTask = '.$idTask;

        $request = new DataBaseQuery();
        $query = $request->select($table,'fkUser', $where);
        $queryCount = count($query);

        if($queryCount == 0) {
            $table = 't_state';
            $columns = '(fkUser,fkTask,staState)';
            $values = '('.$idUser.','.$idTask.',\''.$state.'\')';
            $query = $request->insert($table, $columns, $values);
        } else {
            $columns = 'fkUser = '.$idUser.', fkTask = '.$idTask.', staState = \''.$state.'\'';
            $query = $request->update($table, $columns, $where);

        }

        return $query;
    }
}