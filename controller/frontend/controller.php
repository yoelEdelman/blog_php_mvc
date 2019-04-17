<?php

require_once '././model/frontend/Nav_manager.php';
require_once '././model/frontend/Articles_manager.php';
require_once '././model/frontend/Login_register_manager.php';
require_once '././model/frontend/Profile_manager.php';

//require_once '././model/frontend/model.php';




function articles_list($category_id = 'unknown', $limit = 'unknown'){
    $nav = new Nav_manager();
    $categories_list = $nav->nav_list();

    $articles_manager = new Articles_manager();

    if ($limit != 'unknown'){
        $articles = $articles_manager->articles_list('', 3);
        require_once '././view/frontend/index.php';
        exit;
    }
    elseif ($category_id != 'unknown'){
        $selected_category = $articles_manager->selected_category($category_id);
        $articles = $articles_manager->articles_list($category_id);
    }
    else{
        $articles = $articles_manager->articles_list();
    }
    require_once '././view/frontend/article_list.php';
}


function article(){
    $nav = new Nav_manager();
    $categories_list = $nav->nav_list();

    $articles_manager = new Articles_manager();

    $article = $articles_manager->article($_GET['article_id']);

    //si aucun article n'a été trouvé je redirige
    if(!$article['id']){
        header('location:index.php');
        exit;
    }
    require '././view/frontend/article.php';
}


function login(){
    $nav = new Nav_manager();
    $categories_list = $nav->nav_list();

    $login = new Login_register_manager();

    // On declare un tableau warning pour stocker les eventuellescmessages d'erreur
    $warnings = [];

    // si le formulaire de connexion a ete envoyer
    if(isset($_POST['login']) ) {

        // on verifie que les champs obligatoires sont remplie
        if (empty($_POST['email']) OR empty($_POST['password'])) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        else{
            // on recupere toutes les infos de la table user la ou le mail et pwd est egale a celui recu en post
            $user_info = $login->user_info($_POST['email'], $_POST['password']);

            // si l'email ou pwd ne correnspondent a celui de la db
            if (!$user_info) {

                $warnings['error_login'] = 'Mauvaise identifiant !';
            }
            // si l'email et pwd recu en post correnspondent a celui de la db on connecte l'utilisateur et on le redirige a la page d'acceuil
            else{
                $_SESSION['user']['first_name'] = $user_info['first_name'];
                $_SESSION['user']['is_admin'] = $user_info['is_admin'];
                $_SESSION['user']['id'] = $user_info['id'];
                $_SESSION['message']['valid_login'] = 'Vous etes connecté ! ' . $_SESSION['first_name'];

                header('location:index.php');
                exit;
            }
        }
    }
    require_once '././view/frontend/login_register.php';
}


function register(){
    $nav = new Nav_manager();
    $categories_list = $nav->nav_list();

    $register = new Login_register_manager();

    // si le formulaire inscription utilisateur a ete envoyer
    if(isset($_POST['register'])) {
        // on recupere l'email pour verifier que le mail n'est pas deja dans la db
        $mail_exist = $register->mail_exist($_POST['email']);

        // on verifie que les champs obligatoires sont remplie
        if (empty($_POST['first_name']) OR empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['password_confirm']) ) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        // si l'email existe en db
        elseif ($mail_exist){
            $warnings['exist'] = 'Cette email existe deja !';
        }
        // pwd et confirm_pwd ne sont pas egale
        elseif ($_POST['password'] != $_POST['password_confirm']){
            $warnings['no_match'] = 'Les mots de passe ne sonts pas identiques !';
        }
        else{
            // on insert en bdd
            $last_inserted_id = $register->new_visitor($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['bio']);

            $_SESSION['user']['is_admin'] = 0; //PAS ADMIN !
            $_SESSION['user']['first_name'] = $_POST['first_name'];
            $_SESSION['user']['id'] = $last_inserted_id;
            $_SESSION['message']['inserted'] = 'Inscription efféctuée avec succes !';

            header('location:index.php');
            exit;
        }
    }
    require_once '././view/frontend/login_register.php';
}





function update_profile(){
    $nav = new Nav_manager();
    $categories_list = $nav->nav_list();

    $update_profile = new Profile_manager();

    // On declare un tableau warning pour stocker les eventuellescmessages d'erreur
    $warnings = [];

    // pour aficher les champs existant pour le update
    if (isset($_SESSION['user']['id'])){

        $user = $update_profile->user_info($_SESSION['user']['id']);

    }
    // si le formulaire insertion utilisateur/admin a ete envoyer
    if(isset($_POST['update'])) {
        // on verifie que les champs obligatoires sont remplie
        if (empty($_POST['first_name']) OR empty($_POST['email'])) {
            $warnings['empty'] = 'Tous les chams sont obligatoire !';
        }
        // si le champs password n'est pas vide
        elseif (!empty($_POST['password'])) {
            // on verifie aue les champs password et password_confirm sont identiques
            if ($_POST['password'] != $_POST['password_confirm']) {
                $warnings['no_match'] = 'Les mots de passe ne sonts pas identiques !';
            }
            else{
                $result = $update_profile->update_profile($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['bio'], $_POST['user_id'], $_POST['password'], $_POST['password_confirm']);
            }
        }
        else{
            $result = $update_profile->update_profile($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['bio'], $_POST['user_id']);

        }
        if(isset($result) AND $result){
            $_SESSION['user']['first_name'] = $_POST['first_name'];
            $_SESSION['message']['updated'] = 'Mise a jour efféctuée avec succes !';
            header('location:index.php');
            exit;
        }
        // on pré remplie tout les input en ecrasant les variables $user pour pas que l'utilisateur doit tout re'ecrire
        $user['first_name'] = $_POST['first_name'];
        $user['last_name'] = $_POST['last_name'];
        $user['mail'] = $_POST['email'];
        $user['biography'] = $_POST['bio'];
    }
    require '././view/frontend/user_profile.php';
}










