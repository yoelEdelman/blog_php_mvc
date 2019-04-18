<?php
namespace backend;

require_once '././model/Manager.php';

class User_manager extends \Manager {

    public function delete_user($user_id){
        $db = $this->db_connect();
        $query = $db->prepare('DELETE FROM user WHERE id = ?');
        $result = $query->execute([$user_id]);
    }

    public function users_list(){
        $db = $this->db_connect();
        // on recupere les infos de la table user pour les afficher
        $query = $db->query('SELECT id, first_name, last_name, mail, is_admin FROM user');
        return $users = $query->fetchAll();
    }

    public function user_info($user_id){
        $db = $this->db_connect();
        $query_users = $db->prepare('SELECT * FROM user WHERE id = ?');
        $query_users->execute([$user_id]);
        return $user = $query_users->fetch();
    }

    public function update_user($first_name, $last_name, $email, $pwd, $bio, $is_admin, $user_id){
        $db = $this->db_connect();

        //début de la chaîne de caractères de la requête de mise à jour
        $query_string = 'UPDATE user SET first_name = :first_name, last_name = :last_name, mail = :mail, biography = :biography, is_admin = :is_admin ';
        //début du tableau de paramètres de la requête de mise à jour
        $query_parameters = [
            'first_name' => htmlspecialchars(ucfirst($first_name)),
            'last_name' => htmlspecialchars(strtoupper($last_name)),
            'mail' => htmlspecialchars($email),
            'biography' => htmlspecialchars($bio),
            'is_admin' => htmlspecialchars($is_admin),
            'id' => $user_id
        ];
        //uniquement si l'admin souhaite modifier le mot de passe
        if( !empty($pwd)) {
            //concaténation du champ password à mettre à jour
            $query_string .= ', password = :password ';
            //ajout du paramètre password à mettre à jour
            $query_parameters['password'] = htmlspecialchars(md5($pwd));
        }
        //fin de la chaîne de caractères de la requête de mise à jour
        $query_string .= 'WHERE id = :id';
        //préparation et execution de la requête avec la chaîne de caractères et le tableau de données
        $query = $db->prepare($query_string);
        return $result = $query->execute($query_parameters);
    }

    public function user_mail($email){
        $db = $this->db_connect();
        $query = $db->prepare('SELECT mail FROM user WHERE mail = ?');
        $query->execute([$email]);
        return $mail_exist = $query->fetch();
    }


    public function new_user($first_name, $last_name, $email, $pwd, $bio, $is_admin){
        $db = $this->db_connect();
        // on insert en bdd
        $query = $db->prepare('INSERT INTO user (first_name, last_name, mail ,password, biography, is_admin)
            VALUES (?, ?, ?, ?, ?, ?)');
        return $result = $query->execute([
            htmlspecialchars(ucfirst($first_name)),
            htmlspecialchars(strtoupper($last_name)),
            htmlspecialchars($email),
            htmlspecialchars(md5($pwd)),
            htmlspecialchars($bio),
            htmlspecialchars($is_admin)
        ]);
    }
}