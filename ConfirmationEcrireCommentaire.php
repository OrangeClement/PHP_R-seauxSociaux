<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//récupérer idcom que l'utilisateur vient d'écrire
$commentaireecrit = filter_input(INPUT_GET, "commentaire", FILTER_SANITIZE_SPECIAL_CHARS);
//restituer les valeurs : email et mot de passe
session_start();

$email =$_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Confirmation Commentaires</title>
    </head>
    <body> 
        <div>
        <?php
        //vérifier is le contenue du commentaire est vide
        if ($commentaireecrit == NULL) {
            echo ("<h3>Il faut écrire un texte !</h3>");           
        } else {
            //récupérer idm de l'utilisateur
            $membrecommente = retrouvermembre($cx, $email,$psw);
            //inserer dans la table commentaire cette information
            $insertcommentaire="INSERT INTO commentaire(IDM,DESCRIPTIONCOM,DATECOM) " . 
                        "VALUES ($membrecommente[IDM],'$commentaireecrit',now())"; 
        
            $executeinsert=mysqli_query($cx,$insertcommentaire);
                if ($executeinsert == TRUE) {
                    echo("<h3>Vous avez écrit un commentaire.</h3>");
                } else {
                    echo(mysqli_error($cx));
                    echo("<br/>");
                    echo("<h3>Commenter impossible</h3>");
                } 
        }
        
        ?>  
        </div>            
        <a href="Commentaire.php">Retour</a>
        
    </body>
</html>
