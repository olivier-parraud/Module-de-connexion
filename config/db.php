<?php

function connect_pdo()
{



    try {

        // $host = "localhost";
        // $dbname = "module-de-connexion";
        // $id = "root";
        // $mdp = "root";

        $pdo = new PDO("mysql:host=localhost;dbname=moodule-de-connexion", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Si une erreur se produit (connexion ou requête), tu récupères le message d'erreur
        echo "C'est pas le bon mot de passe, tu es bidon" . $e->getMessage();
    }
}
