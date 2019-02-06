<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//restituer les valeurs  de l'utilisateur : email et mot de passe
session_start();

$email =$_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Commentaires</title>
    </head>
    <body>
        <div class="center">
        <h2>Ecrire un commentaire :</h2>
        <form action="ConfirmationEcrireCommentaire.php" method="GET">
            <table>
                <tr><td>
                <textarea name="commentaire" rows="4" cols="50"></textarea> 
                </td></tr>
                <tr><td style="text-align: right;"><input type='submit' value='Ok'>  </td></tr>
            </table>
        </form>
        
        <a href="ProfilPersonnel.php">Retour</a>
        <hr>
        <h2>Commentaires historiques :</h2>
       
        <?php 
         //afficher les commentaire que l'utilisateur a écrit ou l'utilisateur a abonné 
        $membre = retrouvermembre($cx, $email, $psw);
        $commentaire = affichercommentaire($cx, $membre["IDM"]);       
        foreach($commentaire as $idcom => $contenue){
            $membrecom = retrouverinfomembre($cx, $contenue["IDM"]);
            //afficher les commentaire et le boutton like
            echo("<table class='tablecominitial'>");
            echo("<tr><td>".$contenue["DATECOM"]." ".$membrecom["PRENOMM"] ." ". $membrecom["NOMM"] . " ". "écrit :</td></tr>");
            echo("<form action='Apprecier.php' method='GET'>");
            echo("<tr><td><textarea name='cominitial' rows='4' cols='50'  disabled>");
            echo($contenue["DESCRIPTIONCOM"]);
            echo("</textarea></td></tr>");
            echo("<tr><td style='text-align: right;'><button type='submit' name='comapprecier' value='$contenue[IDCOM]'>Like</button></td></tr>");
            echo("</form><br/></table>");
            //répondre un commentaire
            echo("<table class='tablecomreponse'>");
            echo("<form action='RepondCommentaire' method='GET'>");
            echo("<tr><td><textarea name='commentaire' rows='4' cols='50' >");
            echo("</textarea></td></tr>");
            echo("<tr><td style='text-align: right;'><button type='submit' name='comreponse' value='$contenue[IDCOM]'>Répondre</button></td></tr>");
            echo("</form><br/></table>");
             //afficher les réponse des commentaires et le boutton like
            $reponse = afficherreponsecom($cx, $contenue["IDCOM"]);
            if($reponse != NULL){
                
                foreach ($reponse as $idrep => $nomrep){
                    echo("<table class='tablecomreponse'>");
                    echo("<tr><td>".$nomrep["DATECOM"] ." ".$nomrep["PRENOMM"] ." ". $nomrep["NOMM"] . " répond :");
                    echo( "</td></tr>");
                    echo("<form action='Apprecier.php' method='GET'>");
                    echo("<tr><td><textarea name='comcomplementaire' rows='4' cols='50' disabled>");
                    echo($nomrep["DESCRIPTIONCOM"]);
                    echo("</textarea></td></tr>");
                    echo("<tr><td style='text-align: right;'><button type='submit' name='comapprecier' value='$nomrep[IDCOM]'>Like</button></td></tr>");
                    echo("</form><br/></table>");
               
                }
            }
        }
        
        ?>    
        </div>
    </body>
</html>
