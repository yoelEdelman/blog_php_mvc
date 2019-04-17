<?php
namespace backend;

require_once '././model/Manager.php';

class Categories_manager extends \Manager {

    public function delete_ac($category_id){
        $db = $this->db_connect();

        $query = $db->prepare('DELETE FROM articles_categories WHERE category_id = ?');
        $result = $query->execute([$category_id]);
    }

    public function delete_category($category_id){
        $db = $this->db_connect();

        $query = $db->prepare('DELETE FROM category WHERE id = ?');
        $result = $query->execute([$category_id]);
    }

    public function categories_list(){
        $db = $this->db_connect();

        // on recupere les infos de la table category pour les afficher
        $query = $db->query('SELECT id, name, description FROM category');

        return $categories = $query->fetchAll();
    }

    public function category_info($category_id){
        $db = $this->db_connect();

        $query_categories = $db->prepare('SELECT * FROM category WHERE id = ?');
        $query_categories->execute([$category_id]);

        return $category = $query_categories->fetch();
    }

    public function update_category($name, $description, $img, $category_id){
        $db = $this->db_connect();

        //début de la chaîne de caractères de la requête de mise à jour
        $query_string = 'UPDATE category SET name = :name, description = :description ';
        //début du tableau de paramètres de la requête de mise à jour
        $query_parameters = [
            'name' => htmlspecialchars(ucfirst($name)),
            'description' => htmlspecialchars($description),
            'id' => $category_id
        ];

        //uniquement si l'admin souhaite mettre a jour l'image
        if(isset($img) AND !empty($img)) {
            //concaténation du champ image à mettre à jour
            $query_string .= ', image = :image ';
            //ajout du paramètre password à mettre à jour
            $query_parameters['image'] = htmlspecialchars($img);
        }

        //fin de la chaîne de caractères de la requête de mise à jour
        $query_string .= 'WHERE id = :id';

        //préparation et execution de la requête avec la chaîne de caractères et le tableau de données
        $query = $db->prepare($query_string);
        return $result = $query->execute($query_parameters);
    }


    public function category_exist($name){
        $db = $this->db_connect();

        // on verifie que le nom de categorie n'est pas deja dans la db
        $query = $db->prepare('SELECT name FROM category WHERE name = ?');
        $query->execute([$name]);

        return $category_exist = $query->fetch();
    }

    public function new_category($name, $description, $img){
        $db = $this->db_connect();

        // on insert en bdd
        $query = $db->prepare('INSERT INTO category (name, description, image) VALUES (?, ?, ?)');
        return $result = $query->execute([
            htmlspecialchars(ucfirst($name)),
            htmlspecialchars($description),
            htmlspecialchars($img)]);
    }
}