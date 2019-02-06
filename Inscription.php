<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();

?>

<html>
    <head>
        <meta charset="UTF-8">      
        <title>Inscription</title>
        <link href="Style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div>
        <h2>Bonjour, Monsieur / Madame:</h2>
        </div>
        <!--formulaire de l'inscription-->
        <div>
        <form action="ConfirmationInscription.php" method="GET"> 
            <table>
                <tr>
                    <td>Nom</td>
                    <td><input type="text" name="txtnom" required=""></td>
                </tr>
                <tr>
                    <td>Prenom</td>
                    <td><input type="text" name="txtprenom"></td>
                </tr>
                <tr>
                    <td>Pseudo</td>
                    <td><input type="text" name="txtpseudo" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="txtemail" required></td>
                </tr>
                <tr>
                    <td>Mot de Passe</td>
                    <td><input type="text" name="txtpsw" required></td>
                </tr>
                <tr><td>&nbsp</td><td>&nbsp</td></tr>
                <tr>
                    <td>Compétence :</td>
                    <td>Niveau :</td>
                </tr>
                
                <?php
                // afficher la liste des compétences en utilisant 'checkbox' et 
                // la liste des niveaux en utilisant 'liste déroulante'
                $comp = listecompetence($cx);
                $niv = listeniveau($cx);
               
                foreach ($comp as $idc => $nomc) {
                    echo("<tr><td>");
                    echo("<input type='checkbox' name='liste_comp[]' value='$idc'> $nomc[NOMC] ");
                    echo("</td><td>");
                    echo("<select name='liste_niveau[]'>");
                       foreach ($niv as $idn => $nomn) {
                           echo("<option value='$idn'>");
                           echo($nomn["NOMN"]);
                           echo("</option>");
                       }
                    echo("</select></td></tr>");
                }  
                ?>
                
                <tr><td>&nbsp</td><td>&nbsp</td></tr>
                <tr>
                    <td style="text-align: right"><input type='reset' value='Effacer'></td>
                    <td style="text-align: right"><input type='submit' value='Confirmer'></td>
                </tr>
            </table>    
        </form>
        </div>
        <br/>
        <!--Retour à la page Accueil-->
        <div ><a href="Accueil.html">Retour</a></div>  
        <div class="pied">
            <hr>
            <p><strong>Créé par CHANG Jiayu et LIU Daishuang</strong></p>
        </div>
    </body>
</html>
