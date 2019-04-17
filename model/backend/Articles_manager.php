<?php
namespace backend;

require_once '././model/Manager.php';

class Articles_manager extends \Manager {

    public function delete_ac($article_id){
        $db = $this->db_connect();

        $query = $db->prepare('DELETE FROM articles_categories WHERE article_id = ?');
        $result = $query->execute([$article_id]);
    }

    public function delete_article($article_id){
        $db = $this->db_connect();

        $query = $db->prepare('DELETE FROM article WHERE id = ?');
        $result = $query->execute([$article_id]);
    }

    public function articles_list(){
        $db = $this->db_connect();

        // on recupere les infos de la table article a afficher
        $query = $db->query('SELECT id, title, is_published FROM article ORDER BY published_at DESC ');

        return $articles = $query->fetchAll();
    }






    public function categories_list(){
        $db = $this->db_connect();

        // pour afficher les categories du menu select
        $query = $db->query('SELECT * FROM category');

        return $categories = $query->fetchAll();
    }

    public function article_info($article_id){
        $db = $this->db_connect();

        $query_articles = $db->prepare('SELECT * FROM article WHERE id = ?');
        $query_articles->execute([$article_id]);

        return $article = $query_articles->fetch();
    }

    public function update_article($categories, $published_at, $title, $summary, $content, $img, $is_published, $article_id, $unlink_article_img){
        $db = $this->db_connect();

        $query = $db->prepare('DELETE FROM articles_categories WHERE article_id = :article_id');
        $query->execute(['article_id' => $article_id]);

        //début de la chaîne de caractères de la requête de mise à jour
        $query_string = 'UPDATE article SET published_at = :published_at, title = :title, summary = :summary, content = :content, is_published = :is_published ';
        //début du tableau de paramètres de la requête de mise à jour
        $query_parameters = [
            'published_at' => htmlspecialchars($published_at),
            'title' => htmlspecialchars(ucfirst($title)),
            'summary' => htmlspecialchars($summary),
            'content' => htmlspecialchars($content),
            'is_published' => htmlspecialchars($is_published),
            'id' => $article_id
        ];

        //uniquement si l'admin souhaite mettre a jour l'image
        if (isset($img) AND !empty($img)) {
            //concaténation du champ image à mettre à jour
            $query_string .= ', image = :image ';
            //ajout du paramètre password à mettre à jour
            $query_parameters['image'] = htmlspecialchars($img);
            unlink('././assets/img/' . $unlink_article_img);
        }

        //fin de la chaîne de caractères de la requête de mise à jour
        $query_string .= 'WHERE id = :id';

        //préparation et execution de la requête avec la chaîne de caractères et le tableau de données
        $query = $db->prepare($query_string);
        $result = $query->execute($query_parameters);

        $query = $db->prepare('INSERT INTO articles_categories (article_id, category_id)
                  VALUES (:article_id, :category_id)');
        foreach ($categories as $category) {
            $query->execute([
                'article_id' => $article_id,
                'category_id' => htmlspecialchars($category)
            ]);
        }
        return $result;
    }

    public function new_article($categories, $published_at, $title, $summary, $content, $img, $is_published){
        $db = $this->db_connect();

        $query_string = 'INSERT INTO article (published_at, title, summary, content, is_published ';
        $query_values = 'VALUES (:published_at, :title, :summary, :content, :is_published';
        $query_parameters = [
            'published_at' => htmlspecialchars($published_at),
            'title' => htmlspecialchars(ucfirst($title)),
            'summary' => htmlspecialchars($summary),
            'content' => htmlspecialchars($content),
            'is_published' => htmlspecialchars($is_published)
        ];

        //uniquement si l'admin souhaite ajouter une image
        if (isset($img) AND !empty($img)) {
            //concaténation du champ image à ajouter
            $query_string .= ', image ';
            $query_values .= ', :image';
            $query_parameters['image'] = htmlspecialchars($img);
        }

        $query_string .= ') ';
        $query_values .= ')';

        $query_string .= $query_values;

        //préparation et execution de la requête avec la chaîne de caractères et le tableau de données
        $query = $db->prepare($query_string);
        $result = $query->execute($query_parameters);

        $last_insert = $db->lastInsertId();

        $query = $db->prepare('INSERT INTO articles_categories (article_id, category_id)
                  VALUES (:article_id, :category_id)');
        foreach ($categories as $category) {
            $query->execute([
                'article_id' => $last_insert,
                'category_id' => htmlspecialchars($category)
            ]);
        }
        return $result;
    }





}