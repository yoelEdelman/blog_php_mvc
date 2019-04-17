<?php
require_once '././model/Manager.php';

class Login_register_manager extends Manager {

    public function user_info($mail, $pwd){
        $db = $this->db_connect();

        $query = $db->prepare('SELECT * FROM user WHERE mail = ? AND password = ?');
        $query->execute([
            $mail,
            md5($pwd)
        ]);
        return $login_info = $query->fetch();
    }

    public function mail_exist($email){
        $db = $this->db_connect();

        $query = $db->prepare('SELECT mail FROM user WHERE mail = ?');
        $query->execute([$email]);

        return $mail_exist = $query->fetch();
    }

    public function new_visitor($first_name, $last_name, $mail ,$pwd, $bio){
        $db = $this->db_connect();

        $query_user = $db->prepare('INSERT INTO user (first_name, last_name, mail ,password, biography) VALUES (?, ?, ?, ?, ?)');
        $query_user->execute([
            htmlspecialchars(ucfirst($first_name)),
            htmlspecialchars(strtoupper($last_name)),
            htmlspecialchars($mail),
            htmlspecialchars(md5($pwd)),
            htmlspecialchars($bio)
        ]);
        return $db->lastInsertId();
    }
}