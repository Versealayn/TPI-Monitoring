<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : DataBaseQuery.php
 * Description : Page regroupant les requêtes SQL
 */

include 'Config.php';

class DataBaseQuery
{

    /** @var \PDO $connection */
    private $connection;


    // Connexion à la base de données
    public function __construct() {

        $user   = $GLOBALS['MM_CONFIG']['database']['username'];
        $pass   = $GLOBALS['MM_CONFIG']['database']['password'];
        $dbname = $GLOBALS['MM_CONFIG']['database']['dbname'];
        $host   = $GLOBALS['MM_CONFIG']['database']['host'];
        $port   = $GLOBALS['MM_CONFIG']['database']['port'];
        $charset = $GLOBALS['MM_CONFIG']['database']['charset'];

        try
        {
            $this->connection = new \PDO(
                'mysql:host=' . $host .
                ';port=' . $port .
                ';dbname=' . $dbname .
                ';charset='. $charset, $user, $pass,array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $e)
        {
            // Afficher l'erreur
            die('Error : ' . $e->getMessage());
        }
    }

    // Selectionne des données dans la base de données et inclus la possibilité de join des tables
    public function selectJoin($table, $columns, $join = '', $where = '', $groupBy = '') {
        $query = 'SELECT ' . $columns . ' FROM ' . $table;

        if ($join !== ''){
            $query .= $join;
        }

        if ($where !== '') {
            $query .= ' WHERE ' . $where;
        }

        if ($groupBy !== '') {
            $query .= ' GROUP BY ' . $groupBy;
        }

        return $this->rawQuery($query);

    }

    // Selectionne des données dans la base de données et n'inclus pas la possibilité de join des tables
    public function select($table, $columns, $where = '', $orderBy = '') {

        $query = 'SELECT ' . $columns . ' FROM ' . $table;

        if ($where !== '') {
            $query .= ' WHERE ' . $where;
        }

        if ($orderBy !== '') {
            $query .= ' ORDER BY ' . $orderBy;
        }

        return $this->rawQuery($query);

    }

    // Envoi des informations à la base de données par PDO
    public function rawQuery($query,$mode=PDO::FETCH_ASSOC) {

        $req = $this->connection->prepare($query);
        $req->execute();
        return $req->fetchAll($mode);

    }

    // Insertion de données dans une table
    public function insert($table, $columns, $values) {

        $query = 'INSERT INTO ' . $table . ' ' . $columns . ' VALUES ' . $values ;   

        $req = $this->connection->prepare($query);
        return $req->execute();
    }

    // Modification des valeurs
    public function update($table, $columns, $where) {
        $query = 'UPDATE ' . $table . ' SET ' . $columns . ' WHERE ' . $where;
        $req = $this->connection->prepare($query);
   
        return $req->execute();
    }

    // Supression de données dans la base de données
    public function delete($table, $where){
        $query = 'DELETE FROM ' . $table . ' WHERE ' . $where;

        $req = $this->connection->prepare($query);
        return $req->execute();
    }

    // Permet de savoir la valeur la plus haute d'une table
    public function getMaxValue($table, $columns){
        $query = 'SELECT MAX(' . $columns . ') FROM ' . $table;

        return $this->rawQuery($query);
    }
}