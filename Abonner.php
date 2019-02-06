<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//ouvrir une session pour récupérer l'email et le mot de passe de l'utilisateur
//et idm de membre qui l'utilisateur veut abonner
session_start();

$idm = $_SESSION["IDM_CHOISI"];
$email = $_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Abonner</title>
    </head>
    <body>
        <div>
        <?php
        //récupérer idm de l'utilisateur
        $membreabonne = retrouvermembre($cx, $email,$psw);
        //vérifier is l'utilisateur a déjà abonné ce membre
        $res = abonnerExiste($cx, $membreabonne["IDM"], $idm);
        if($res != NULL){
            die("<h3>Vous avez déjà abonné ce membre ! </h3><a href='Consultation.php'>Retour</a>");
        }else{
            //insérer dans table abonner cette information
            $sqlabonner="INSERT INTO abonner(IDMABO,IDMETREABO) VALUES ($membreabonne[IDM],$idm)"; 
          
            $executesql=mysqli_query($cx,$sqlabonner);
        
            if ($executesql == TRUE) {
            //recupérer nom et prenom dont est abonné
                $infomembre = retrouverinfomembre($cx, $idm);
                echo("<h3>Vous avez abonné". " " . $infomembre["NOMM"]. " " . $infomembre["PRENOMM"]."</h3>");
            } else {
                echo(mysqli_error($cx));
                echo("<br/>");
                echo("Abonnement impossible");
            }
        }
    
        ?>
            </div>
        <a href="Consultation.php">Retour</a>
    </body>
</html>
