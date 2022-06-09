<?php
/**
 * ETML
 * Auteur : Nelson Tivollier
 * Date: 12.05.2022
 * Projet : TPI - Monitoring
 * Page Name : LoginRepository.php
 * Description : page traitant les données de la page de login
 */

include_once 'database/DataBaseQuery.php';
include_once 'Entity.php';


class LoginRepository implements Entity {

    // Sélectionne tous les e-mail des utilisateurs de la base de données
    public function findAll() {

        $table = 't_user';
        $columns = 'useEmail';

        $request =  new DataBaseQuery();
        
        return $request->select($table, $columns);

    }

    // Sélectionne un utilisateur selon son e-mail
    public function findOne($email) {

        $table = 't_user';
        $columns = 'idUser, useName, useSurname, useEmail, usePassword, useRight';
        $where = 'useEmail = \''.$email.'\'';

        $request =  new DataBaseQuery();

        return $request->select($table, $columns, $where);

    }

    // Permet la connexion
    public function login($email, $password) {

        // Cherche un utilisateur selon son e-mail
        $result = $this->findOne($email);

        // Si l'utilisateur est trouvé et authentifié, ajoutes ses données dans la session
        if(isset($result) && count($result)>0){
        	if($password == $result[0]['usePassword']){
                $_SESSION['user']['userId'] = $result[0]['idUser'];
                $_SESSION['user']['userRight'] = $result[0]['useRight'];
                $_SESSION['user']['userEmail'] = $email;
                $_SESSION['user']['loggedin'] = true;

                // Utilisateur connecté
		        $connect = true;

            // Sinon l'utilisateur n'a aucun droit et n'a pas accès
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