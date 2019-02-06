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
//récupérer le contenue du commentaire complémentaire
$com = filter_input(INPUT_GET, "commentaire", FILTER_SANITIZE_SPECIAL_CHARS);
//récupérer idm du commentaire initial
$idcomreponse = filter_input(INPUT_GET, "comreponse", FILTER_SANITIZE_SPECIAL_CHARS);
session_start();
//restituer les valeurs fr l'utilisateur : email et mot de passe
$email =$_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Répondre Commentaire</title>
    </head>
    <body>
        <div>
        <?php
        //vérifier si le contenue du commentaire est vide
        if ($com == NULL) {
            echo ("<h3>Il faut écrire un texte !</h3>");           
        } else {
            //si non, récupérer idm de l'utilisateur 
            $membre = retrouvermembre($cx, $email,$psw);
            //construire SQL pour insérer les données
            $insertcommentaire="INSERT INTO commentaire(IDM,IDCOMINITIAL, DESCRIPTIONCOM,DATECOM) " . 
                        "VALUES ($membre[IDM],$idcomreponse,'$com',now())"; 
        
            $executeinsert=mysqli_query($cx,$insertcommentaire);
            //compte-rendu
                if ($executeinsert == TRUE) {
                    echo("<h3>Vous avez répondu ce commentaire</h3>");
                } else {
                    echo(mysqli_error($cx));
                    echo("<br/>");
                    echo("<h3>Répondre impossible</h3>");
                } 
        }
           
        ?>
         </div>
        <a href="Commentaire.php">Retour</a>
    </body>
</html>
