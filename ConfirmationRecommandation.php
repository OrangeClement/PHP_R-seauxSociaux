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
//récupérer les compétences recommandées dans un tableau
$comp = array();
foreach ($_GET["liste_comp"] as $idcomp) {
    $comp[] = $idcomp;
}
//récupérer les valeurs  de l'utilisateur : email et mot de passe
//récupérer idm de ce qui l'utilisateur veut recommander 
session_start();

$idm = $_SESSION["IDM_CHOISI"];
$email = $_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Confirmation de la recommandation</title>
    </head>
    <body>
        <div>
        <?php
        //récupérer idm de l'utilisateur
        $membrerecom = retrouvermembre($cx, $email, $psw);
         // construire SQL pour insérer dans la table recommander les informations
        foreach ($comp as $idc) {
            //vérifier si l'utilisateur a déjà recommander ce membre sur cette compétence
            $res = recommandExiste($cx, $membrerecom["IDM"], $idm, $idc);
            if($res != NULL){
                //récupérer le nom de compétence
                $nomcomp = retrouvercomp($cx, $idc);
                die("<h3>Vous avez déjà recommandé ce membre sur :".$nomcomp["NOMC"]."</h3><a href='Consultation.php'>Retour</a>");
            }else{
               $insertSQL = "INSERT INTO recommander(IDMRECOM, IDMETRERECOM, IDC) " .
                        " VALUES($membrerecom[IDM], $idm, $idc)";

                // exécuter SQL               
                $crExecSQL = mysqli_query($cx, $insertSQL);

                // compte-rendu
                if ($crExecSQL == TRUE) {
                    echo("<h3>Recomandation Réussite</h3>");
                } else {
                    echo(mysqli_error($cx));
                    echo("<br/>");
                    echo("<h3>Recommandation impossible</h3>");
                } 
            }
            
        }
        
        ?>
        </div>
        <a href="Consultation.php">Retour</a>
    </body>
</html>
