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
//récupérer idm de ce qui l'utilisateur veut consulter
//enregistrer ce idm dans une session pour qu'il puisse être utilisé dans les pages abooner et recommander
session_start();

$idm = filter_input(INPUT_GET, "liste_membre", FILTER_SANITIZE_SPECIAL_CHARS);

$_SESSION["IDM_CHOISI"] = $idm;

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Profil Membre</title>
    </head>
    <body>
        <div>
        <?php
        //vérifier si l'utilisateur a choisi un membre 
        if ($idm == FALSE ) {
            echo ("<h3>Vous devez choisir un membre pour voit son profil !</h3> ");
        } else {
            //récupérer les information de ce membre
            $infomembre = retrouverinfomembre($cx, $idm);
            echo("<h1>Profil de " . "". $infomembre["PSEUDOM"] . "</h1>");
            echo("<table><tr><td>&nbsp</td><td>&nbsp</td></tr>".
                    "<tr><td>Nom</td><td>". $infomembre["NOMM"]. "</td></tr>".
                    "<tr><td>Prenom</td><td>". $infomembre["PRENOMM"] . "</td></tr>".
                    "<tr><td>Adresse mail</td><td>". $infomembre["EMAILM"]."</td></tr>" .
                    "<tr><td>Pseudo</td><td>". $infomembre["PSEUDOM"]."</td></tr>" );
            //récupérer les compétences possèdées par ce membre      
            $compmembre = retroucompemembre($cx, $idm);
            if($compmembre != NULL){
                echo("<tr><td>Compétence</td><td>Niveau</td></tr>");
                foreach($compmembre as $idcn => $nomcn){
                    echo("</tr><td>" . $nomcn["NOMC"] . "</td>");
                    echo("<td>" . $nomcn["NOMN"] . "</td></tr>");
                }
            }
            echo("<tr><td>&nbsp</td><td>&nbsp</td></tr>");
            echo("<tr><td><a href = 'Abonner.php'>Abonner</a></td>");
            echo("<td><a href = 'Recommandation.php'>Recommander</a></td></tr>");
            echo("</table></br>");
            }
                
        ?>
       <a href='Consultation.php'>Retour</a> 
       </div>
    </body>
</html>

