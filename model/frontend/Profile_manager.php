<?php
require_once '././model/Manager.php';

class Profile_manager extends Manager {

    public function user_info($session_id){
        $db = $this->db_connect();


        $query_users = $db->prepare('SELECT * FROM user WHERE id = ?');
        $query_users->execute([$session_id]);

        return $user = $query_users->fetch();
    }








    public function update_profile($first_name, $last_name, $mail, $bio, $user_id, $pwd = 'unknown', $pwd_confirm = 'unknown'){
        $db = $this->db_connect();

        //début de la chaîne de caractères de la requête de mise à jour
        $query_string = 'UPDATE user SET first_name = :first_name, last_name = :last_name, mail = :mail, biography = :biography';
        //début du tableau de paramètres de la requête de mise à jour
        $query_parameters = [
            'first_name' => htmlspecialchars(ucfirst($first_name)),
            'last_name' => htmlspecialchars(strtoupper($last_name)),
            'mail' => htmlspecialchars($mail),
            'biography' => htmlspecialchars($bio),
            'id' => $user_id
        ];

        // si le champs password n'est pas vide
        if ($pwd != 'unknown') {
            // on verifie aue les champs password et password_confirm sont identiques
            if ($pwd == $pwd_confirm){

                //concaténation du champ password à mettre à jour
                $query_string .= ', password = :password ';
                //ajout du paramètre password à mettre à jour
                $query_parameters['password'] = md5($pwd);
            }
        }

        //on fait le update uniquement dans les cas ou le champ password est vide ou qu'il n'est pas vide et qu'il soit identique au champ password_confirm
        if (($pwd == 'unknown') OR ($pwd != 'unknown' AND $pwd == $pwd_confirm)){

            //fin de la chaîne de caractères de la requête de mise à jour
            $query_string .= ' WHERE id = :id';

            //préparation et execution de la requête avec la chaîne de caractères et le tableau de données
            $query = $db->prepare($query_string);

        }

        return $result = $query->execute($query_parameters);
    }


}