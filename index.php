<?php
//require_once 'model/Manager.php';
require 'controller/frontend/controller.php';
require 'controller/backend/controller.php';


if(isset($_GET['page'])){

    switch ($_GET['page']) {
        case 'article_list':

            (isset($_GET['category_id']) ? articles_list($_GET['category_id']) : articles_list());

            break;
        case 'article':
            //si j'ai reçu article_id ET que c'est un nombre
            if(!isset($_GET['article_id']) OR !ctype_digit($_GET['article_id'])){
                header('location:index.php');
                exit;
            }
            else{
                article();
                exit;
            }

            break;
        case 'login_register':
            if (isset($_POST['register'])){
                register();
            }
            else{
                login();
            }
            break;
        case 'user_profile':
            update_profile();
            break;
        case 'admin':
            admin_home();
            break;
        case 'admin_user_list':
            user_list();
            break;
        case 'admin_user_form':
            user_form();
            break;
        case 'admin_categories_list':
            category_list();
            break;
        case 'admin_category_form':
            category_form();
            break;
        case 'admin_articles_list':
            admin_articles_list();
            break;
        case 'admin_article_form':
            article_form();
            break;

        default:
            // On redirige le visiteur vers la page d'accueil
            header('location:index.php');
            exit;
    }

}
else{

    // si on a recu le parametre logout en url
    if (isset($_GET['logout']) AND isset($_SESSION['user'])){

        // on deconecte
        unset($_SESSION["user"]);

        // On redirige le visiteur vers la page d'accueil
        header('location:index.php');
        exit;
    }

    articles_list('', 3);
}

