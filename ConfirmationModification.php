
<?php
//charger le fichier des fonctions
require("Fonctions.php");
//exécuter la fonction de connexion
$cx=connexionbd();
//récupérer les valeurs saisis dans le formulaire à la page modification
$nom = filter_input(INPUT_GET, "txtnom", FILTER_SANITIZE_SPECIAL_CHARS);
$prenom = filter_input(INPUT_GET, "txtprenom", FILTER_SANITIZE_SPECIAL_CHARS);
$pseudo = filter_input(INPUT_GET, "txtpseudo", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_GET, "txtemail", FILTER_SANITIZE_SPECIAL_CHARS);
$psw = filter_input(INPUT_GET, "txtpsw", FILTER_SANITIZE_SPECIAL_CHARS);
$newcomp = filter_input(INPUT_GET, "newcomp", FILTER_SANITIZE_SPECIAL_CHARS);
$newniv = filter_input(INPUT_GET, "newniv", FILTER_SANITIZE_SPECIAL_CHARS);

//vérifier s'il y a des valeurs saisis dans les checkbox et la liste déroulante
//Si oui, récupérer les valeurs dans un tableau
if (!empty($_GET["liste_comp"])){
    $compchoisies = array();
    foreach ($_GET["liste_comp"] as $idcomp) {
        $compchoisies[] = $idcomp;
    }
    $nivchoisies = array();
    foreach ($_GET["liste_niveau"] as $idniv) {
        $nivchoisies[] = $idniv;
    }
}

//récupérer les valeurs  de l'utilisateur  : email et mot de passe
session_start();

$emailconnexion = $_SESSION["emailconnexion"] ;
$pswconnexion = $_SESSION["passwordconnexion"];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="Style.css" rel="stylesheet" type="text/css"/>
        <title>Confirmation Inscription</title>
    </head>
    <body>
        <?php
        //récupérer idm de l'utilisateur
        $membre = retrouvermembre($cx, $emailconnexion, $pswconnexion);
        //vérifier si l'utilisateur a changé l'email
        if ($emailconnexion == $email){
            //l'utilisateur n'a pas changé l'email
            $updatemembre1 ="UPDATE membre SET NOMM ='$nom', PRENOMM ='$prenom', " .
                "PSEUDOM='$pseudo', PASSWORD='$psw' WHERE IDM='$membre[IDM]' ";
            $crExecupdate1 = mysqli_query($cx, $updatemembre1);
            $_SESSION["passwordconnexion"] = $psw;
            if ($crExecupdate1 == FALSE) {
                    die("<h3>Modification impossible</h3>");
                }
        } else {
            //l'utilisateur a changé l'email
            //puis vérifier si le nouveau email existe
            if (emailExiste($cx, $email) == FALSE) {
                //si nom, update l'informatio dans la table membre
                $updatemembre2 ="UPDATE membre SET NOMM ='$nom', PRENOMM ='$prenom', " .
                    "EMAILM='$email', PSEUDOM='$pseudo', PASSWORD='$psw' WHERE IDM='$membre[IDM]' ";
                $crExecupdate2 = mysqli_query($cx, $updatemembre2);
                //renouveler l'email et le mot de passe dans la session
                $_SESSION["emailconnexion"] = $email;
                $_SESSION["passwordconnexion"] = $psw;
        
                if ($crExecupdate2 == FALSE) {
                    die("<h3>Modification impossible</h3>");
                }
            }else { // email existant
                echo("<h3>email dejà utilisé - <a href='Inscription.html'>à modifier</a></h3>");
            }  
        }
        //supprimer les information concernant l'utilisateur dans la table posseder
        $deletecomp ="DELETE FROM posseder WHERE IDM='$membre[IDM]' ";
        $crExecdelete = mysqli_query($cx, $deletecomp);
            if ($crExecdelete == FALSE) {
                die("<h3>Delete competence impossible</h3>" . mysqli_error($cx));
            } else {
                if (empty($_GET["liste_comp"])){
                    echo("<h3>Vous n'avez pas choisir une compétence !</h3>");
                }else {
                    foreach ($compchoisies as $idcompetence) {
                        $idniveau = $nivchoisies[$idcompetence-1];
                        $insertcomp = "INSERT INTO posseder(IDM, IDC, IDN) " .
                                  " VALUES('$membre[IDM]]', '$idcompetence', '$idniveau')";  
                        $crExeccomp = mysqli_query($cx, $insertcomp);
                    
                        if ($crExeccomp == FALSE) {
                            echo("<h3>Problem dans l'enegistrement des valeurs pour la requete " .
                            "insertcomp :</h3>" . mysqli_error($cx));
                        }  
                    }
                     //vérifier si l'utilisateur ajoute une nouvelle compétence
                        if(!empty($_GET["newcomp"])){
			//l'utilisateur vient d'ajouter une nouvelle compétence
			$sqlnewcomp="INSERT INTO competence(NOMC) VALUES ('$newcomp')"; 
          
                         $executesqlnewcomp=mysqli_query($cx,$sqlnewcomp);
        
                                 if ($executesqlnewcomp == TRUE) {
				//trouver idc de cette nouvelle compétence
				$idnewcomp =retrouveridcomp($cx, $newcomp);
				//ajouter dans la table posseder cette information
				$sqlnewniv = "INSERT INTO posseder(IDM, IDC, IDN) " .
                                  " VALUES('$membre[IDM]', '$idnewcomp[IDC]', '$newniv')";
				$crExecnewniv = mysqli_query($cx, $sqlnewniv);
                    
                                        if ($crExecnewniv == FALSE) {
                                         echo("<h3>Problem dans l'enegistrement des valeurs pour la requete " .
                                         "sqlnewniv :</h3>" . mysqli_error($cx));
                                    	}else{
					
                                            echo("<h3>Vous avez ajouté une nouvelle compétence, vérifiez dans Mon profil ! </h3>");
				}
			}
		}                    
                
                echo("<h3>Bravo, vos modifications sont bien enregistrées !</h3>");
                }
            }
        
       
    
        ?>
        <a href="ProfilPersonnel.php">Retour</a>
    </body>
</html>
