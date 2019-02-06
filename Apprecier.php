<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//restituer idcom
$comapprecier = filter_input(INPUT_GET, "comapprecier", FILTER_SANITIZE_SPECIAL_CHARS);
//récupérer les valeurs : email et mot de passe
session_start();

$email =$_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Apprecier</title>
    </head>
    <body>
        <div>
        <?php
        //récupérer idm de l'utilisateur
        $membre = retrouvermembre($cx, $email,$psw);       
         //vérifier is l'utilisateur a déjà apprécié ce commentaire
        $res = apprecierExiste($cx, $membre["IDM"], $comapprecier);
        if($res != NULL){
            die("<h3>Vous avez déjà apprécié ce commentaire ! </h3><a href='Commentaire.php'>Retour</a>");
        }else{
            //insérer dans table apprecier cette information
            $sqlapprecier="INSERT INTO apprecier(IDM,IDCOM) VALUES ($membre[IDM],$comapprecier)"; 
          
            $executesql=mysqli_query($cx,$sqlapprecier);
        
            if ($executesql == TRUE) {                                      
                echo("<h3>Vous avez apprécié le commentaire de ce membre</h3>");
                echo("<a href='Commentaire.php'>Retour</a>");
            }else {
                echo(mysqli_error($cx));
                echo("<br/>");
                echo("<h3>Appréciation impossible</h3>");
                echo("<a href='Commentaire.php'>Retour</a>");
            }
        }
       
           
        ?>
            </div>
        
   
    </body>
</html>
