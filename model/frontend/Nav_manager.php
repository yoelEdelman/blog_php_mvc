<?php
require_once '././model/Manager.php';

class Nav_manager extends Manager {
    public function nav_list(){
        $db = $this->db_connect();

        //récupération de la liste des catégories pour générer le menu
        $query = $db->query('SELECT  name ,id FROM category ');
        $categoriesList = $query->fetchAll();

        return $categoriesList;
    }
}