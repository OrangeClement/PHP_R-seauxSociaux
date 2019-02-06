<!DOCTYPE html>
<!-- restituer les valeur: email et mot de passe
-->

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//restituer les valeurs  de l'utilisateur : email et mot de passe
//enregistrer les valeurs dans une session

session_start();

$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_SPECIAL_CHARS);
$psw = filter_input(INPUT_GET, "txtpsw", FILTER_SANITIZE_SPECIAL_CHARS);

$_SESSION["emailconnexion"] = $email;
$_SESSION["passwordconnexion"] = $psw;
?>

<html>
    <head>
        <meta charset="UTF-8">        
        <title>Connexion</title>
        <link href="Style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="center">
        <?php
        //récupérer idm de l'utilisateur
        $membre= retrouvermembre($cx, $email,$psw);
        //compt-rendu
        if ($membre == NULL) {
            echo ("Votre email ou mot de passe est faux !");
            echo ("<p><a href='Accueil.html'>Retour</a></p>");
        }
        else {
            echo("<h1>Connexion réussite ! </h1>");
            echo("<a href='ProfilPersonnel.php'>Accéder</a>");
        }
        ?>
            </div>
        <div class="pied">
            <hr>
            <p><strong>Créé par CHANG Jiayu et LIU Daishuang</strong></p>
        </div>
    </body>
</html>
