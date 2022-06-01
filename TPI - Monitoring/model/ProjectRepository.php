<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 11.05.2022
 * Projet : TPI - Monitoring
 * Page Name : ProjectRepository.php
 * Description : Connexion à la base de données
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';

class ShopRepository implements Entity {

    /**
     * Récupérer tous les clients
     *
     * @return array
     */
    public function findAll() {

        $table = 't_product as p, t_category as c';
        $columns = '*';
        $where =  'p.fkCategory = c.idCategory';

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
    public function findOne($idProduct) {

        $table = 't_product as p, t_category as c';
        $columns = '*';
        $where = 'p.fkCategory = c.idCategory AND p.idProduct = ' . $idProduct . ' LIMIT 1';

        $request = new DataBaseQuery();
        $query = $request->select($table, $columns, $where);
        return $query;
    }
}