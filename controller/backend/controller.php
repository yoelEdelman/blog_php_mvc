<?php

require_once '././model/backend/Nav_manager.php';
require_once '././model/backend/User_manager.php';
require_once '././model/backend/Categories_manager.php';
require_once '././model/backend/Articles_manager.php';
//require_once '././model/backend/User_form_manager.php';
//require_once '././model/backend/Category_form_manager.php';
//require_once '././model/backend/Article_form_manager.php';



//require_once '././model/backend/model.php';

function admin_home(){
    $nav_manager = new \backend\Nav_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/index.php';
}

function user_list(){
    $user_manager = new \backend\User_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
    header('location:../index.php');
    exit;
    }

    // si user_id est existe on delete tout de la table user ou id est egale a l'id recu en get
    if (isset($_GET['user_id']) AND isset($_GET['action']) AND $_GET['action'] == 'delete'){
        $result = $user_manager->delete_user($_GET['user_id']);
    }

    $users = $user_manager->users_list();

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/user_list.php';
}


function category_list(){
    $category_manager = new \backend\Categories_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    // si le param category_is existe on suprime tout de la table category la ou id est egale a l'id recu en get
    if (isset($_GET['category_id']) AND isset($_GET['action']) AND $_GET['action'] == 'delete'){
        $result = $category_manager->delete_ac($_GET['category_id']);
        $result = $category_manager->delete_category($_GET['category_id']);
    }

    $categories = $category_manager->categories_list();

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/category_list.php';
}


function admin_articles_list(){
    $article_manager = new \backend\Articles_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    // si le param article_id existe en url on suprime tout de la table article la ou id est egale a l'id recu en get
    if (isset($_GET['article_id']) AND isset($_GET['action']) AND $_GET['action'] == 'delete'){
        $result = $article_manager->delete_ac($_GET['article_id']);
        $result = $article_manager->delete_article($_GET['article_id']);
    }

    $articles = $article_manager->articles_list();

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/article_list.php';
}


function user_form(){
    $user_manager = new \backend\User_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    $warnings = [];

    // pour aficher les champs existant pour le update
    if (isset($_GET['user_id']) AND isset($_GET['action']) AND $_GET['action'] == 'edit'){
        $user = $user_manager->user_info($_GET['user_id']);
    }

    // si le formulaire insertion utilisateur/admin a ete envoyé
    if(isset($_POST['save']) OR isset($_POST['update'])) {

        // on verifie que les champs obligatoires sont remplie
        if (empty($_POST['first_name']) OR empty($_POST['last_name']) OR empty($_POST['email'])) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        else{
            //  si $_POST['update'] existe donc on met a jour l'utilisateur en db
            if (isset($_POST['update'])){

                $result = $user_manager->update_user($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['bio'], $_POST['is_admin'], $_POST['user_id']);

                if($result){
                    $_SESSION['message']['updated'] = 'Mise a jour efféctuée avec succes !';
                    header('location:index.php?page=admin_user_list');
                    exit;
                }
                else{
                    $warnings['error'] = "Impossible d'enregistrer le nouvel utilisateur...";
                }
            }
            else{
                // on verifie que le mail n'est pas deja dans la db
                $mail_exist = $user_manager->user_mail($_POST['email']);
                if ($mail_exist){
                    $warnings['exist'] = 'Cette email existe deja !';
                }
                else{
                    // on insert en bdd
                    $result = $user_manager->new_user($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['bio'], $_POST['is_admin']);

                    if($result){
                        $_SESSION['message']['inserted'] = 'Insertion efféctuée avec succes !';
                        header('location:index.php?page=admin_user_list');
                        exit;
                    }
                    else{
                        $warnings['error'] = "Erreur.";
                    }
                }
            }
        }
        // on enrengistre tout les input pour pas que l'admin doit tout r'ecrire
        $user['first_name'] = $_POST['first_name'];
        $user['last_name'] = $_POST['last_name'];
        $user['mail'] = $_POST['email'];
        $user['biography'] = $_POST['bio'];
        $user['is_admin'] = $_POST['is_admin'];
    }

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/user_form.php';
}


function category_form(){
    $categories_manager = new \backend\Categories_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    $warnings = [];

    // pour aficher les champs existant pour le update
    if (isset($_GET['category_id'])){
        $category = $categories_manager->category_info($_GET['category_id']);
    }

    // si le formulaire insertion ou update categorie a ete envoyer
    if(isset($_POST['save']) OR isset($_POST['update'])) {
        // on verifie que les champs obligatoires sont remplie
        if (empty($_POST['name'])) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        else{
            if (isset($_FILES['image']) AND ($_FILES['image']['error'] === 0)) {

                $allowed_extensions = ['jpg', 'jpeg', 'gif', 'png'];

                $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                if(!$my_file_extension){
                    $warnings['type'] = "Le type de fichier n'est pas conforme !";
                }
                elseif ($_FILES['image']['size'] > 1500000){
                    $warnings['size'] = 'Votre fichier est trop lourd !';
                }
                else{
                    do{
                        $new_file_name = rand().time() . $_FILES['image']['name'];
                        $destination = '././assets/img/' . $new_file_name;
                    }while(file_exists($destination));

                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                }
            }
            // si le tableau messages est vide ( qu'il ny a aucune erreur )
            if (empty($warnings)){
                //  si $_POST['update'] existe donc on met a jour la categorie en db
                if (isset($_POST['update'])){
                    $result = $categories_manager->update_category($_POST['name'], $_POST['description'], $new_file_name, $_POST['category_id']);

                    if($result){
                        $_SESSION['message']['updated'] = 'Mise a jour efféctuée avec succes !';
                        header('location:index.php?page=admin_categories_list');
                        exit;
                    }
                    else{
                        $warnings['error'] = "Erreur.";
                    }
                }
                // sinon il s'agit d'une nouvelle categorie donc on insert la categorie en db
                else{
                    // on verifie que le nom de categorie n'est pas deja dans la db
                    $category_exist = $categories_manager->category_exist($_POST['name']);

                    if ($category_exist) {
                        $warnings['exist'] = 'Cette categorie existe deja !';
                    }
                    else{
                        // on insert en bdd
                        $result = $categories_manager->new_category($_POST['name'], $_POST['description'], $new_file_name);

                        if($result){
                            $_SESSION['message']['inserted'] = 'Insertion efectue avec succes !';
                            header('location:index.php?page=admin_categories_list');
                            exit;
                        }
                        else{
                            $warnings['error'] = "Impossible d'enregistrer la nouvel categorie...";
                        }

                    }
                }
            }
        }
        // on enrengistre tout les input pour preremplir le formulaire pour pas que l'admin doit tout r'ecrire en cas d'erreur
        $category['name'] = $_POST['name'];
        $category['description'] = $_POST['description'];
        $image = $_FILES['image'];
    }

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/category_form.php';
}


function article_form(){
    $articles_manager = new \backend\Articles_manager();

    if(!isset($_SESSION['user']) OR $_SESSION['user']['is_admin'] == 0){
        header('location:../index.php');
        exit;
    }

    // pour afficher les categories du menu select
    $categories = $articles_manager->categories_list();

    $warnings = [];

    // pour aficher les champs existant pour le update
    if (isset($_GET['article_id'])){
        $article = $articles_manager->article_info($_GET['article_id']);
    }

    // si le formulaire insertion ou de mise a jour d'article a ete envoyer
    if(isset($_POST['save']) OR isset($_POST['update'])) {
        // on verifie que tout les champs obligatoires ne sont pas vide ( $_POST['title'] $_POST['date'] $_POST['categories'] )
        if (empty($_POST['title']) OR empty($_POST['published_at']) OR empty($_POST['categories'])) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        else{
            if (isset($_FILES['image']) AND ($_FILES['image']['error'] === 0)) {

                $allowed_extensions = ['jpg', 'jpeg', 'gif', 'png'];

                $my_file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                if(!in_array($my_file_extension , $allowed_extensions)){
                    $warnings['type'] = "Le type de fichier n'est pas conforme !";
                }
                elseif ($_FILES['image']['size'] > 1500000){
                    $warnings['size'] = 'Votre fichier est trop lourd !';
                }
                else{
                    do{
                        $new_file_name = rand().time() . $_FILES['image']['name'];
                        $destination = '././assets/img/' . $new_file_name;
                    }while(file_exists($destination));

                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                }
            }

            // si le tableau $warnings est vide ( qu'il ny a aucune erreur )
            if (empty($warnings)){
                // si $_POST['update'] existe il s'agit d'un nouvelle article donc on insert l'article en db
                if (isset($_POST['update'])){

                    $result = $articles_manager->update_article($_POST['categories'], $_POST['published_at'], $_POST['title'], $_POST['summary'], $_POST['content'], $new_file_name, $_POST['is_published'], $_POST['article_id'], $article['image']);

                    if($result){
                        $_SESSION['message']['updated'] = 'Mise a jour efféctuée avec succes !';
                        header('location:index.php?page=admin_articles_list');
                        exit;
                    }
                    else{
                        $warnings['error'] = "Erreur.";
                    }
                }
                // sinon il s'agit de $_POST['save'] donc on insert l'article en db
                else{
                    $result = $articles_manager->new_article($_POST['categories'], $_POST['published_at'], $_POST['title'], $_POST['summary'], $_POST['content'], $new_file_name, $_POST['is_published']);

                    if($result){
                        $_SESSION['message']['inserted'] = 'Insertion efféctuée avec succes !';
                        header('location:index.php?page=admin_articles_list');
                        exit;
                    }
                    else{
                        $warnings['error'] = "Impossible d'enregistrer le nouvelle article...";
                    }
                }
            }
        }
        // on enrengistre tout les input pour preremplir le formulaire pour pas que l'admin doit tout r'ecrire en cas d'erreur
        $article['title'] = $_POST['title'];
        $article['published_at'] = $_POST['published_at'];
        $article['summary'] = $_POST['summary'];
        $article['content'] = $_POST['content'];
        $image = $_FILES['image'];
        $article['is_published'] = $_POST['is_published'];
        // pour plus tard
        //if (isset($_GET['article_id'])){
        //    $category['id'] = $_POST['categories'];
        //}
    }

    $nav_manager = new \backend\Nav_manager();
    $users_quantity = $nav_manager->nav_list_users();
    $categories_quantity = $nav_manager->nav_list_categories();
    $articles_quantity = $nav_manager->nav_list_articles();

    require_once '././view/backend/article_form.php';
}