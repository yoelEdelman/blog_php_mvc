<?php

namespace backend;

require_once '././model/Manager.php';


class Nav_manager extends \Manager {

    public function nav_list_users(){

        $db = $this->db_connect();

        $query = $db->query('SELECT COUNT(*) FROM user');
        $users_quantity = $query->fetch();

        return $users_quantity;
    }

    public function nav_list_categories(){

        $db = $this->db_connect();

        $query = $db->query('SELECT COUNT(*) FROM category');
        $categories_quantity = $query->fetch();

        return $categories_quantity;
    }

    public function nav_list_articles(){

        $db = $this->db_connect();

        $query = $db->query('SELECT COUNT(*) FROM article');
        $articles_quantity = $query->fetch();

        return $articles_quantity;
    }
}
