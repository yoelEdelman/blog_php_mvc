<?php
require_once '././model/Manager.php';
//require_once '././_tools.php';

class Articles_manager extends Manager{

    public function articles_list($category_id = 'unknown', $limit = 'unknown'){
        $db = $this->db_connect();

        if ($limit == 3) {
            // on recupere les infos des tables article et category avec jointure pour les aficher
            $query = $db->query('SELECT title, GROUP_CONCAT(name), published_at, summary, article.id, article.image 
                FROM article INNER JOIN articles_categories
                ON article.id = articles_categories.article_id
                INNER JOIN category 
                ON articles_categories.category_id = category.id
                WHERE published_at <= NOW() AND is_published = 1 
                GROUP BY article.id DESC
                ORDER BY published_at DESC LIMIT 3');
        } elseif ($category_id == 'unknown') {
            //si pas decatégorie demandée j'affiche tous les articles
            $query = $db->query('SELECT title, GROUP_CONCAT(name), published_at, summary, article.id, article.image 
                FROM article JOIN articles_categories
                ON article.id = articles_categories.article_id
                JOIN category 
                ON articles_categories.category_id = category.id
                WHERE published_at <= NOW() AND is_published = 1 
                GROUP BY article.id
                ORDER BY published_at DESC');
        } else {
            //selection des articles de la catégorie demandée
            $query = $db->prepare('SELECT article.*, articles_categories.category_id
                FROM article INNER JOIN articles_categories
                ON article.id = articles_categories.article_id
                WHERE published_at <= NOW() AND articles_categories.category_id = ? AND is_published = 1 
                ORDER BY published_at DESC');

            $query->execute([$category_id]);
        }
        //puis je récupère les données selon la requête générée avant
        return $articles = $query->fetchAll();
    }

    public function selected_category($category_id){
        $db = $this->db_connect();

        //selection des informations de la catégorie demandée
        $query_category = $db->prepare('SELECT * FROM category WHERE id = ?');
        $query_category->execute([$category_id]);

        $selected_category = $query_category->fetch();

        //si l'id envoyé n'est pas un nombre entier, je redirige
        //si la catégorie n'a pas été trouvé je redirige
        if (!$selected_category OR !ctype_digit($category_id)) {
            header('location:index.php');
            exit;
        }

        return $selected_category;
    }

    public function article($article_id){
        $db = $this->db_connect();

        $query = $db->prepare('SELECT a.*, GROUP_CONCAT(c.name) as category_name 
            FROM article a INNER JOIN articles_categories a_c
            ON a.id = a_c.article_id
            INNER JOIN category c
            ON a_c.category_id = c.id
            WHERE a.id = ? ');
        $query->execute([$article_id]);

        return $article = $query->fetch();
    }

}