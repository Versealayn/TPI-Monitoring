<?php
/**
 * ETML
 * Date: 01.06.2017
 * Shop
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';


class LoginRepository implements Entity {

    /**
     * Find all entries
     *
     * @return array|resource
     */
    public function findAll() {

        $table = 't_user';
        $columns = 'useEmail';

        $request =  new DataBaseQuery();
        
        return $request->select($table, $columns);

    }

    /**
     * Find One entry
     *
     * @param $login
     *
     * @return array
     */
    public function findOne($email) {

        $table = 't_user';
        $columns = '*';
        $where = 'useEmail = \''.$email.'\'';

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where);

    }

    /**
     * Login
     *
     * @param $login
     * @param $password
     *
     * @return bool
     */
    public function login($email, $password) {

        $result = $this->findOne($email);
        if(isset($result) && count($result)>0){
        	if($password == $result[0]['usePassword']){
                $_SESSION['user']['userId'] = $result[0]['idUser'];
                $_SESSION['user']['userRight'] = $result[0]['useRight'];
                $_SESSION['user']['userEmail'] = $email;
                $_SESSION['user']['loggedin'] = true;
		        $connect = true;

	        } else {
		        $_SESSION['right'] = null;
		        $connect = false;
	        }

        } else {
            $_SESSION['right'] = null;
            $connect = false;
        }

        return $connect;
    }
}