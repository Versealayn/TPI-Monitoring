<?php
/**
 * ETML
 * Date: 01.06.2017
 * Shop
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';

class AdminRepository implements Entity {

    /**
     * Find all entries
     *
     * @return array|resource
     */
    public function findAll() {

        $table = 't_project as p';
        $columns = '*';

        $request =  new DataBaseQuery();

        return $request->select($table, $columns);

    }

    public function findOne($idProject) {

        $table = 't_project as p';
        $columns = '*';
        $where =  'p.idProject = ' . $idProject;

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where);

    }

    /**
     * Raw sql
     *
     * @return array|resource
     */
    public function rawQuery($query,$mode) {

        $request =  new DataBaseQuery();

        return $request->rawQuery($query,$mode);

    }
    
    /**
     * Delete
     *
     * @param int $id
     * @return bool
     */
    public function removeOne($id) {

        $request = new DataBaseQuery();
        $table = 't_product';
        
        $where =  'idProduct = ' . $id;

        $query = $request->delete($table, $where);

        return $query;
    }

    /**
     * Insert
     *
     * @param $name
     * @param $description
     * @param $price
     * @param $quantity
     * @param $file
     * @param $idCategory
     *
     * @return bool|string
     */
    public function insert($name, $description, $price, $quantity, $file, $idCategory) {

        $request = new DataBaseQuery();

        $table = 't_product';
        $columns = '(idProduct, proName, proDescription, proPrice, proQuantity, proImage, fkCategory)';
        $values = "(NULL, '$name', '$description', $price, $quantity, '$file', $idCategory)";

        return $request->insert($table, $columns, $values);
    }

    /**
     * Update
     *
     * @param $name
     * @param $description
     * @param $price
     * @param $quantity
     * @param $file
     * @param $idCategory
     * @param $idProduct
     *
     * @return bool
     */
    public function update($proName, $proStart, $proEnd, $idProject) {

        $request = new DataBaseQuery();
        $table = 't_project';
        $columns = "proName = '$proName', proStart = '$proStart', proEnd = '$proEnd'";
        $where = "idProject = " . $idProject;

        return $request->update($table, $columns, $where);
    }

    public function findAllClasses(){
        $request = new DataBaseQuery();
        $table = 't_class';
        $columns = 'idClass, claName';
        
        return $request->select($table, $columns);
    }

    public function findAllGroups(){
        $request = new DataBaseQuery();
        $table = 't_group';
        $columns = 'idGroup, groName';
        
        return $request->select($table, $columns);
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