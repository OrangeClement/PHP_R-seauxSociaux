<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//récupérer la compétence choisie
$recherchecomp = filter_input(INPUT_GET, "recherchecomp", FILTER_SANITIZE_SPECIAL_CHARS);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Rchercher les membres sur une compétence</title>
    </head>
    <body>
        <div>
        <?php
        //chercher ce qui possède cette compétence
        $mp = membreposseder($cx, $recherchecomp);
        //compte-rendu
        if($mp == NULL){
            echo("<h3>Personne possède cette compétence !</h3>");
        }else{
            echo("<h3>Ces membres possèdent cette compétence :</h3>");
            foreach($mp as $idmp => $nommp){
                echo("<li>");
                echo($nommp["NOMM"] ." ". $nommp["PRENOMM"]);
                echo("</li>");
            }
        }
        //chercher ce qui est recommandé sur cette compétence
        $mr = membrerecom($cx, $recherchecomp);
        //compte-rendu
        if($mr == NULL){
            echo("<h3>Personne est recommandé sur cette compétence !</h3>");
        }else{
            echo("<h3>Ces membres sont recommandé sur cette compétence !</h3>");
            foreach($mr as $idmr => $nommr){
                echo("<li>");
                echo( $nommr["NOMETREREC"] ." ". $nommr["PRENOMETREREC"] . " est recommandé par " .
                      $nommr["NOMREC"] ." ". $nommr["PRENOMREC"]);
                echo("</li>"); 
            }
        }
        ?>
        </div>
        
        <A href="ProfilPersonnel.php">Retour</a>
    </body>
</html>
