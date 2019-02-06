<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//restituer les valeurs de l'utilisateur: email et mot de passe
session_start();

$email = $_SESSION["emailconnexion"] ;
$psw = $_SESSION["passwordconnexion"] ;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Profil Personel</title>
    </head>
    <body>
        
        <?php
        //récupérer idm de l'utilisateur
        $membre= retrouvermembre($cx, $email,$psw);        
       
        echo("<div><h2>"."Bonjour," . " " . $membre["PSEUDOM"] . "</h2></div>");
        //le menu
        echo("<div class='menu'><hr>");
        echo("<ul class='nav'><li class='menu_item'><a href='Modification.php'>Mon profil</a></li>" .
              "<li class='menu_item'><a href='Consultation.php'>Consultation</a></li>" .
              "<li class='menu_item'><a href='Commentaire.php'>Commentaires</a></li>" .
                "<li class='menu_item'><a href='Accueil.html'>Déconnexion</a></li>" .
              "</ul><hr></div>");
        ?>
        <div style="text-align: center">
        <form action="Recherche.php" method="GET">
        <?php
            echo("<select name='recherchecomp'>");
            $listecomp = listecompetence($cx);
            foreach ($listecomp as $idcomp => $nomcomp) {
                echo("<option value='$idcomp'>");
                echo($nomcomp["NOMC"]);
                echo("</option>");
            }
            echo("</select>");
        ?>  
        <input type="submit" value="Rechercher">
        </form>
        </div>
        <div>
            <p>Dans la menu, quatre liens sont disponibles pour vous :</p>
            <li>Modification</li>
            <p>Voir et Modifier votre profil.</p>
            <li>Consultation</li>
            <p>Consulter les profils des autres membres, puis vous pouvez les abonner ou recommander.</p>
            <li>Commentaires</li>
            <p>Ecrire une commentaire et voir les commentaires de ceux qui vous avez abonnés</p>
            <li>Déconnexion</li>
            <p>Revenir à la page d'Accueil</p>
           
        </div>
        
    </body>
</html>
