<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//récupérer les valeurs  de l'utilisateur : email et mot de passe
session_start();

$email = $_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Consultation</title>
    </head>
    <body>
        <div><h1>Liste des membres</h1></div>
        <dov>
        <form action="ProfilMembre.php" method="GET">
            <table>
                <?php
                //récupérer idm de l'utilisateur
                    $membre = retrouvermembre($cx, $email, $psw);
                    //récupérer la liste des membres sauf l'utilisateur
                    $listemembre = consultermembre($cx,$membre["IDM"]);
                    foreach($listemembre as $idm => $nupletmembre)
                    {
                     echo("<tr><td><input type='radio' name='liste_membre' value='$idm'>");
                     echo($nupletmembre["NOMM"] . " " .
                         $nupletmembre["PRENOMM"] . "</td></tr>");
                    }
                ?>
                <tr><td>&nbsp</td></tr>
                <tr><td><input type="submit" value="Voir le profil" /></td></tr>
            </table>
        </form>
        </div>
        <br/>
        <a href="ProfilPersonnel.php">Retour</a> 
    </body>
</html>
