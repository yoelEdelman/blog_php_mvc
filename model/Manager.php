<?php
class Manager{
    protected function db_connect(){
        //paramétrage de la langue de traduction pour PHP
        setlocale(LC_ALL, "fr_FR");

        //connexion à la base de données
        try{
            return $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root',
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch (Exception $exception)
        {
            die( 'Erreur : ' . $exception->getMessage() );
        }
    }
}

session_start();