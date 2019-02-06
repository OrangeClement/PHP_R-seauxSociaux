
<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();

//récupérer les valeurs saisis dans le formulaire à la page Inscription
$nom = filter_input(INPUT_GET, "txtnom", FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_GET, "txtprenom", FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_GET, "txtpseudo", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_GET, "txtemail", FILTER_SANITIZE_SPECIAL_CHARS);
$psw = filter_input(INPUT_GET, "txtpsw", FILTER_SANITIZE_SPECIAL_CHARS);

//vérifier s'il y a des valeurs saisis dans les checkbox et la liste déroulante
//Si oui, récupérer les valeurs dans un tableau
if (empty($_GET["liste_comp"]) != TRUE){
    $compchoisies = array();
    foreach ($_GET["liste_comp"] as $idcomp) {
        $compchoisies[] = $idcomp;
    }

    $nivchoisies = array();
    foreach ($_GET["liste_niveau"] as $idniv) {
     $nivchoisies[] = $idniv;
    }
}
//préserver l'email et le mot de passe dans une session 
//pour que on puisse réutiliser dans les pages suivantes
session_start();

$_SESSION["emailconnexion"] = $email;
$_SESSION["passwordconnexion"] = $psw;
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Enregistrement Inscription</title>
    </head>
    <body>
        
        <?php
        //vérifier si l'email existe
        //Si oui, refuser l'inscription
         if (emailExiste($cx, $email) == FALSE) { // email jamais utilisé
                // construire ordre SQL (connexion faite !)
                $insertMembre = "INSERT INTO membre(NOMM, PRENOMM, EMAILM, PSEUDOM,PASSWORD) " .
                        " VALUES(?,?,?,?,?)";

                // exécuter SQL   
                $ordreInsertMembre = mysqli_prepare($cx, $insertMembre);
                $rstAffectationVarsMembre = mysqli_stmt_bind_param($ordreInsertMembre, 
                        "sssss",$nom, $prenom, $email, $pseudo, $psw );
                if ($rstAffectationVarsMembre == FALSE) {
                    echo("<h3>Problem dans l'affectation des valeurs pour la requete"
                        . "paramétrée :</h3>" . mysqli_error($cx));
                    }
                
                $crExecmembre = mysqli_stmt_execute($ordreInsertMembre);

                // compte-rendu
                if ($crExecmembre == TRUE) {
                    echo("<div class='center'>");
                    echo("<h3>Bravo, vos informations sont bien enregistrées !</h3>");
                    echo("<table><tr><td>Nom</td><td>" . $nom . "</td></tr>");
                    echo("<tr><td>Prénom</td><td>" . $prenom . "</td></tr>");
                    echo("<tr><td>Pseudo</td><td>" . $pseudo . "</td></tr>");
                    echo("<tr><td>Email</td><td>" . $email . "</td></tr>");
                    //Après avoir réussi à insérer les informations
                    //construire la requête SQL pour insérer les compétences et les niveaux
                    $membre = retrouvermembre($cx, $email, $psw);
                    if (empty($_GET["liste_comp"])){
                        echo("<h3>Vous n'avez pas choisir une compétence !</3>");
                        }else {
                        foreach ($compchoisies as $idcompetence) {
                            $idniveau = $nivchoisies[$idcompetence-1];
                            $insertcomp = "INSERT INTO posseder(IDM, IDC, IDN) " .
                                  " VALUES('$membre[IDM]]', '$idcompetence', '$idniveau')";  
                            $crExeccomp = mysqli_query($cx, $insertcomp);
                    
                            if ($crExeccomp == FALSE) {
                                echo("<h3>Problem dans l'enegistrement des valeurs pour la requete" .
                                    "insertcomp :</h3>" . mysqli_error($cx));
                            } 
                        } 
                
                        //compte-rendu
                        echo("<tr><td>Compétence</td><td>Niveau</td></tr>");
                        foreach ($compchoisies as $idcompetences) {
                            $comp = retrouvercomp($cx, $idcompetences);
                            echo("<tr><td>");
                            echo($comp["NOMC"]);
                            echo("</td><td>");
                            $niv = retrouverniveau($cx,$nivchoisies[$idcompetences-1]);
                            echo($niv["NOMN"]);
                            echo("</td></tr>");
                            }
                        }
                    echo("</table>");
                    echo("<br/><a href='ProfilPersonnel.php'>Accéder</a>");
                }else {
                    echo(mysqli_error($cx));
                    echo("<br/>");
                    echo("<h3>Inscription impossible</h3>");
                }
            echo("</div>");
            } else { // email existant
                echo("<div class='center'>");
                echo("<h3>email dejà utilisé - <a href='Inscription.php'>à modifier</a></h3>");
                echo("</div>");
            }
           
        ?>
        
        <div class="pied">
            <hr>
            <p><strong>Créé par CHANG Jiayu et LIU Daishuang</strong></p>
        </div>
    </body>
</html>
