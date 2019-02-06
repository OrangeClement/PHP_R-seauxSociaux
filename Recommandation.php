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
//récupérer idm de l'utilisateur vient de consulter
session_start();

$idm = $_SESSION["IDM_CHOISI"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Recommandation</title>
    </head>
    <body>
        <div>
        <form action="ConfirmationRecommandation.php" method="GET">
        <?php
        // récupérer nom et prenom de ce membre
        $membre = retrouverinfomembre($cx, $idm);
        echo("<h3>Vous voulez recommander" . " " . $membre["NOMM"] . " " . "sur :</h3>");
        echo("<br/>");
        $competence = listecompetence($cx);
        echo("<table>");
        foreach ($competence as $idc => $nomc) {
            echo("<tr><td>");
            echo("<input type='checkbox' name='liste_comp[]' value='$idc'> $nomc[NOMC] ");
            echo("</tr></td>");
         }
         echo("<tr><td>&nbsp</td></tr>");
        echo("<tr><td><input type='submit' value='Confirmer'></td></tr>");
        echo("</table>");
         
        ?>
        </br>
         
        </form>
        </div>
    </body>
</html>
