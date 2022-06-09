<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 12.05.2022
 * Projet : TPI - Monitoring
 * Page Name : DashboardRepository.php
 * Description : page traitant les données de la dashboard
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';

class DashboardRepository implements Entity {

    // Fonction non utilisée
    public function findAll() {
    }

    // Sélectionne tous les projets associés à l'utilisateur
    public function findProjects($idUser)
    {

        $table = 't_project as p';
        $columns = 'p.idProject, p.proName, p.proStart, p.proEnd, l.fkClagro, l.fkProject, a.fkClagro, f.fkUser';
        $join = ' INNER JOIN t_lier as l ON p.idProject = l.fkProject INNER JOIN t_appartenir as a ON l.fkClagro = a.fkClagro';
        $where = 'a.fkUser = ' . $idUser;
        $groupBy = 'p.idProject';

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where, $groupBy);

        return $query;
    }

    // Sélectionne tous les projets associés à un groupe ou une classe spécifique
    public function findProjectsClagro($idUser)
    {

        $table = 't_project as p';
        $columns = 'p.idProject, p.proName, p.proStart, p.proEnd, l.fkClagro, l.fkProject, c.idClagro, c.claName, a.fkClagro, a.fkUser, u.idUser, u.useName, u.useSurname, u.useRight';
        $join = ' INNER JOIN t_lier as l ON l.fkProject = p.idProject INNER JOIN t_clagro as c ON l.fkClagro = c.idClagro INNER JOIN t_appartenir as a ON a.fkClagro = c.idClagro INNER JOIN t_user as u ON u.idUser = a.fkUser';
        $where = 'u.idUser = ' . $idUser;
        $groupBy = 'p.idProject';

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where, $groupBy);

        return $query;
    }

    // Trouver les classes et groupes associés à un projet
    public function findClagro($idProject)
    {
        $table = 't_clagro as c';
        $columns = 'claName';
        $join = 'INNER JOIN t_lier AS l ON l.fkClagro = idClagro INNER JOIN t_project AS p ON l.fkProject = p.idProject';
        $where = 'p.idProject = ' . $idProject;
        $groupBy = 'p.idProject';

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where, $groupBy);

        return $query;
    }

    // Sélectionne un projet spécifique
    public function findOneProject($idProject){
        $table = 't_project as p';
        $columns = 'idProject, proName, proStart, proEnd';
        $where = 'p.idProject = ' . $idProject;

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $where);

        return $query;
    }

    // Trouves toutes les tâches d'un projet spécifique
    public function findTasks($idProject)
    {

        $table = 't_task as t';
        $columns = 'tasName, tasDescription, tasStart, tasEnd, idTask, fkUser,  fkTask, staState';
        $join = ' LEFT JOIN t_project as p ON p.idProject = t.fkProject
        LEFT JOIN t_state as s ON t.idTask = s.fkTask
        LEFT JOIN t_user as u ON s.fkUser = u.idUser';
        $where = 'p.idProject = ' . $idProject;

        $request = new DataBaseQuery();
        $query = $request->selectJoin($table, $columns, $join, $where);

        return $query;
    }

    // Change l'état d'une tâche lorsqu'un utilisateur a cliqué (Fonctionnalité non entièrement fonctionnelle)
    public function changeState($idUser, $idTask, $state){

        $table = 't_state as s';
        $where = 's.fkUser = '.$idUser.' and s.fkTask = '.$idTask;

        $request = new DataBaseQuery();
        $query = $request->select($table,'fkUser', $where);
        $queryCount = count($query);

        // Si c'est la première fois que la tâche est modifiée, créer
        if($queryCount == 0) {
            $table = 't_state';
            $columns = '(fkUser,fkTask,staState)';
            $values = '('.$idUser.','.$idTask.',\''.$state.'\')';
            $query = $request->insert($table, $columns, $values);
        // Sinon modifier
        } else {
            $columns = 'fkUser = '.$idUser.', fkTask = '.$idTask.', staState = \''.$state.'\'';
            $query = $request->update($table, $columns, $where);

        }

        return $query;
    }
}