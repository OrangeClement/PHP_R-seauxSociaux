<!DOCTYPE html>

<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();


//récupérer les valeurs  de l'utilisateur  : l'email et le mot de passe

session_start();

$email = $_SESSION["emailconnexion"];
$psw = $_SESSION["passwordconnexion"];


?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Modification</title>
    </head>
    <body>
        <div><h1>Mon profil</h1></div>
        <div>
        <?php
        //récupérer les informations de l'utilisateur et les afficher dans le formulaire
        $membre = retrouvermembre($cx, $email, $psw);
        echo("<form action='ConfirmationModification.php' method='GET'>");
        echo("<table><tr><td>Nom</td><td><input type='text' name='txtnom' value='$membre[NOMM]' required></td></tr>");
        echo("<tr><td>Prenom</td><td><input type='text' name='txtprenom' value='$membre[PRENOMM]'></td></tr>");
        echo("<tr><td>Pseudo</td><td><input type='text' name='txtpseudo' value='$membre[PSEUDOM]' required></td></tr>"); 
        echo("<tr><td>Email</td><td><input type='text' name='txtemail' value='$membre[EMAILM]'required></td></tr>");  
        echo("<tr><td>Mot de Passe</td><td><input type='text' name='txtpsw' value='$membre[PASSWORD]'required></td></tr>");       
        echo("<tr><td>&nbsp</td><td>&nbsp</td></tr>");
        echo("<tr><td>Compétence</td><td>Niveau</td></tr>");
        //récupérer la liste des compétences et la liste des niveaux
        $comp = listecompetence($cx);
        $niv = listeniveau($cx);
        
        $mc = retroucompemembre($cx, $membre["IDM"]);
        foreach($comp as $idc => $nomc){
            echo("<tr><td>");
            //trouver dans la liste des compétences ce que l'utilisateur possède
            //au début, c'est false par défaut pour $trouver
            $trouver = FALSE;
            foreach($mc as $idmc => $nommc){
                if($nommc["NOMC"] == $nomc["NOMC"]){
                    //si trouver, on donne true au $trouver 
                    $trouver = TRUE;
                }
            }   
            if($trouver === TRUE){
                //si $trouver = true, la compétence est choisi par défaut dans le checkbox
                echo("<input type='checkbox' name='liste_comp[]' value='$idc' checked> $nomc[NOMC] ");
                echo("</td><td>");
                    echo("<select name='liste_niveau[]'>");
                    foreach ($niv as $idn => $nomn) {
                            if ($nomn["NOMN"] == $nommc["NOMN"]){
                                //trouver le niveau qui correspond à la compétence qui l'utilisateur possède
                                //selecter ce niveau par défaut
                                echo("<option value='$idn' selected>");
                                echo($nomn["NOMN"]);
                                echo("</option>");
                            } else {
                                echo("<option value='$idn'>");
                                echo($nomn["NOMN"]);
                                echo("</option>");
                                }
                    } 
                }else{
                    //si $trouver = false, ne choisir pas les compétences
                    echo("<input type='checkbox' name='liste_comp[]' value='$idc'> $nomc[NOMC] ");
                    echo("</td><td>");
                    echo("<select name='liste_niveau[]'>");
                    foreach ($niv as $idn => $nomn) {
                        echo("<option value='$idn'>");
                        echo($nomn["NOMN"]);
                        echo("</option>");
                    }
                    
                }
                echo("</select></td></tr>");
           
        }
        echo("<tr><td>&nbsp</td><td>&nbsp</td></tr>");
	echo("<tr><td colspan='2'>Ajouter une novelle compétence :</td></tr>");
	echo("<tr><td>");
	echo("<input type='text' name='newcomp'></td><td>");
	foreach($niv as $idn => $nomn){
		echo("<input type='radio' name='newniv' value='$idn'> $nomn[NOMN]");
	}
	echo("</td></tr>");

        
        ?>
        <tr><td>&nbsp</td><td>&nbsp</td></tr>
        <tr>
            <td><input type='submit' value='Modifier'></td>
            <td><input type='reset' value='Effacer'></td>
        </tr>
                
        </table>
        </form>
        
        <a href="ProfilPersonnel.php">Retour</a>  
        
    </body>
</html>
