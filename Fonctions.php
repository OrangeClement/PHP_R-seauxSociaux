<?php

//Définir les constantes de connextion

define("LOGIN","21611924");
define("PASSEWORD","R01R13");
define("MACHINE_MYSQL","etu-web2.ut-capitole.fr");
define("BASE_MYSQL","db_21611924_2");

/* fonction de connexion
 * 
 *  retour : objet connexion (base choisie)
 */

function connexionbd() {
    $cx=mysqli_connect(MACHINE_MYSQL,LOGIN,PASSEWORD);
    
    if ($cx == NULL) {
        // connexion échouée
        die("Erreur connexion à MySQL/Maria DB : " . mysqli_connect_error());
    }
    else {
        if (mysqli_select_db($cx,BASE_MYSQL) == FALSE) {
            die("Choix base impossible : " . mysqli_error($cx));
            //Choix base de données échoué
    }
        else {
            //Connexion et choix de base de données réussit
            return $cx;
        }
    }
}

/* Verification unicité email 
 * 
 *   connexion en parm entree
 *   email en parm entree
 *   booleen en sortie : vrai si email existe sinon faux
 */

function emailExiste($cx, $email) {
    $sqlEmail = "SELECT * FROM membre WHERE EMAILM = '$email'";

    $curseur = mysqli_query($cx, $sqlEmail);
    if ($curseur == FALSE) {
        die("erreur fonction email");
    } else {
        if (mysqli_num_rows($curseur) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* Verification unicité apprécier 
 * 
 *   connexion en parm entree
 *   idm d'un membre et idcom de commentaire en parm entree
 *   booleen en sortie : vrai si apprécier existe sinon faux
 */

function apprecierExiste($cx, $idm, $idcom) {
    $sqlapprecier = "SELECT * FROM apprecier WHERE IDM = '$idm' AND IDCOM='$idcom' ";

    $curseur = mysqli_query($cx, $sqlapprecier);
    if ($curseur == FALSE) {
        die("erreur fonction apprecier");
    } else {
        if (mysqli_num_rows($curseur) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* Verification unicité abonner 
 * 
 *   connexion en parm entree
 *   idm d'un membre et idm de l'autre membre qui sera abonné en parm entree
 *   booleen en sortie : vrai si aabonner existe sinon faux
 */
function abonnerExiste($cx, $idmabo, $idmetreabo) {
    $sqlabonner = "SELECT * FROM abonner WHERE IDMABO = '$idmabo' AND IDMETREABO='$idmetreabo' ";

    $curseur = mysqli_query($cx, $sqlabonner);
    if ($curseur == FALSE) {
        die("erreur fonction abonner");
    } else {
        if (mysqli_num_rows($curseur) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* Verification unicité recommander
 * 
 *   connexion en parm entree
 *   idm d'un membre, idm de l'autre membre qui sera recommandé et idc d'une compétence en parm entree
 *   booleen en sortie : vrai si recommander existe sinon faux
 */
function recommandExiste($cx, $idmrecom, $idmetrerecom, $idc) {
    $sqlrecommander = "SELECT * FROM recommander WHERE IDMRECOM ='$idmrecom' AND IDMETRERECOM='$idmetrerecom' AND IDC='$idc' ";

    $curseur = mysqli_query($cx, $sqlrecommander);
    if ($curseur == FALSE) {
        die("erreur fonction abonner");
    } else {
        if (mysqli_num_rows($curseur) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* retrouver les données personnelles d'un membre à l'aide de son email et le mot de passe
 *   connexion en parm entree
 *   email et mot de passe en parm entree
 *   tableau en sortie : contient toutes les informations(idm,nom,prenom,email,pseudo, password)
 *   du membre (null si aucun)
 */

function retrouvermembre($cx, $email,$psw) {
    $sqlEmail = "SELECT * " .
                "FROM membre " .
                "WHERE EMAILM ='$email'" .
                "AND PASSWORD = '$psw' ";

    $curseur = mysqli_query($cx, $sqlEmail);
    if ($curseur == FALSE) {
        die("erreur fonction retrouvermembre". mysqli_error($cx));
    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
    
}

/* retrouver la liste des membres sauf un membre
 *   connexion en parm entree
 *   idm d'e l'utilisateur'un membre
 *   tableau en sortie : contient le nom et le prénom des membres sauf ce membre (null si aucun)
 */

function consultermembre($cx, $idm) {
    $sqlnom = "SELECT IDM, NOMM, PRENOMM " .
                "FROM membre WHERE IDM <> $idm";

    $curseur = mysqli_query($cx, $sqlnom);
    if ($curseur == FALSE) {
        die("erreur fonction consultermembre : " . mysqli_error($cx));
    } else {
       $listemembre=array();
       while($nuplet = mysqli_fetch_array($curseur)) {
           $codem=$nuplet["IDM"];
           $membre =array ("NOMM" => $nuplet["NOMM"],
                                "PRENOMM" => $nuplet["PRENOMM"]);
           $listemembre[$codem] = $membre;
       }
    }
    
    return $listemembre;
    
}
/* retrouver la liste des compétences
 *   connexion en parm entree
 *   
 *   tableau en sortie : contient id et nom des compétences (null si aucun)
 */

function listecompetence($cx) {
    $sqlcompetence = "SELECT * " .
                "FROM competence ";

    $curseur = mysqli_query($cx, $sqlcompetence);
    if ($curseur == FALSE) {
        die("erreur fonction mistecompetence : " . mysqli_error($cx));
    } else {
       $listecomp=array();
       while($nuplet = mysqli_fetch_array($curseur)) {
           $codecomp=$nuplet["IDC"];
           $competence =array ("NOMC" => $nuplet["NOMC"]);
           $listecomp[$codecomp] = $competence;
       }
    }
    
    return $listecomp;
    
}

/* retrouver le nom d'unecompétences
 *   connexion en parm entree
 *   idc d'une compétence
 *   tableau en sortie : contient nom d'une compétences (null si aucun)
 */

function retrouvercomp($cx, $idc) {
    $sqlcomp = "SELECT * "
            . " FROM competence WHERE IDC = $idc"; 

    $curseur = mysqli_query($cx, $sqlcomp);
    if ($curseur == FALSE) {
        die("erreur fonction  recherche competence : " . mysqli_error($cx));
    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
    
}

/* retrouver la liste des niveaux
 *   connexion en parm entree
 *   
 *   tableau en sortie : contient id et nom des niveaux (null si aucun)
 */

function listeniveau($cx) {
    $sqlniveau = "SELECT * " .
                "FROM niveau ";

    $curseur = mysqli_query($cx, $sqlniveau);
    if ($curseur == FALSE) {
        die("erreur fonction niveau : " . mysqli_error($cx));
    } else {
       $listeniv=array();
       while($nuplet = mysqli_fetch_array($curseur)) {
           $codeniveau=$nuplet["IDN"];
           $niveau =array ("NOMN" => $nuplet["NOMN"]);
           $listeniv[$codeniveau] = $niveau;
       }
    }
    
    return $listeniv;
    
}

/* retrouver le nom d'un niveau
 *   connexion en parm entree
 *   idc d'un niveau
 *   tableau en sortie : contient nom d'un niveau (null si aucun)
 */

function retrouverniveau($cx, $idn) {
    $sqlniv = "SELECT * "
            . " FROM niveau WHERE IDN = $idn"; 

    $curseur = mysqli_query($cx, $sqlniv);
    if ($curseur == FALSE) {
        die("erreur fonction  recherche niveau : " . mysqli_error($cx));
    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
    
}
/* retrouver les informations d'un membre à l'aide de ID
 *   connexion en parm entree
 *   IDM en parm entree
 *   tableau en sortie : contient nom,prenom,email,pseudo d'un membre (null si aucun)
 */

function retrouverinfomembre($cx, $idm) {
    $sqlinfo = "SELECT `NOMM`, `PRENOMM`, `EMAILM`, `PSEUDOM` FROM `membre` WHERE IDM = $idm ";

    $curseur = mysqli_query($cx, $sqlinfo);
    if ($curseur == FALSE) {
        die("erreur fonction retrouverinfomembre : " . mysqli_error($cx));
    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
    
}

/* retrouver les competences et ses niveaux d'un membre à l'aide de ID
 *   connexion en parm entree
 *   IDM en parm entree
 *   tableau en sortie : contient les competences et ses niveaux d'un membre (null si aucun)
 */

function retroucompemembre($cx, $idm) {
    $sqlcompetence = "SELECT posseder.IDC as IDC,NOMC, NOMN " .
        "FROM posseder,competence, niveau WHERE IDM = $idm AND posseder.IDC = competence.IDC AND posseder.IDN = niveau.IDN ";

    $curseur = mysqli_query($cx, $sqlcompetence);
    if ($curseur == FALSE) {
        die("erreur fonction retrouvercompetence : " . mysqli_error($cx));
    } else {
       $res=array();
       $i=0;
       while($nuplet = mysqli_fetch_array($curseur)) {
           $comp =array ("IDC" => $nuplet["IDC"],
                         "NOMC" => $nuplet["NOMC"],
                         "NOMN" => $nuplet["NOMN"]);
           $res[$i] = $comp;
           $i++;
       }
    }
    
    return $res;
}

/* retrouver les membres qui possèdent une même compétence
 *   connexion en parm entree
 *   IDC d'un compétence en parm entree
 *   tableau en sortie : contient noms et prenoms des membres(null si aucun)
 */
function membreposseder($cx, $idc) {
    $sqlmp = "SELECT NOMM, PRENOMM "
            . " FROM posseder, membre WHERE IDC = $idc AND posseder.IDM = membre.IDM";

    $curseur = mysqli_query($cx, $sqlmp);
        if ($curseur == FALSE) {
        die("erreur fonction  recherche membre : " . mysqli_error($cx));
        } else {
            $i=0;
            $res=array();
            while($nuplet = mysqli_fetch_array($curseur)) { 
               $mp =array ("NOMM" => $nuplet["NOMM"],
                         "PRENOMM" => $nuplet["PRENOMM"]);
           $res[$i] = $mp;
           $i++;                     
            }
        }   
    return $res;
}
/* retrouver les membres qui sont recommandés sur une même compétence
 *   connexion en parm entree
 *   IDC d'un compétence en parm entree
 *   tableau en sortie : contient noms et prenoms des membres qui sont recommandés
 *   et des membres qui recommandent (null si aucun)
 */

function membrerecom($cx, $idc) {
    $sqlmr = "SELECT m1.NOMM as NOMREC, m1.PRENOMM as PRENOMREC, m2.NOMM as NOMETREREC, m2.PRENOMM as PRENOMETREREC " .
            " FROM recommander, membre m1, membre m2 WHERE IDC = $idc " .
            "AND recommander.IDMRECOM = m1.IDM AND recommander.IDMETRERECOM = m2.IDM ";

    $curseur = mysqli_query($cx, $sqlmr);
        if ($curseur == FALSE) {
        die("erreur fonction  recherche membre : " . mysqli_error($cx));
        } else {
            $i=0;
            $res=array();
            while($nuplet = mysqli_fetch_array($curseur)) { 
               $mr =array ("NOMREC" => $nuplet["NOMREC"],
                         "PRENOMREC" => $nuplet["PRENOMREC"],
                       "NOMETREREC" => $nuplet["NOMETREREC"],
                   "PRENOMETREREC" => $nuplet["PRENOMETREREC"]);
           $res[$i] = $mr;
           $i++;                     
            }
        }   
    return $res;
}

/* retrouver les commentaires d'un membre
 *   connexion en parm entree
 *   IDM d'un membre en parm entree
 *   tableau en sortie : contient idcom, idm, description et date des commentaires 
 */

function affichercommentaire($cx,$idm) {
    $sqlcherchercommentaire = "SELECT IDCOM,IDM, DESCRIPTIONCOM,DATECOM ". 
        "FROM commentaire WHERE IDCOMINITIAL IS NULL ". 
        "AND commentaire.IDM='$idm' ". 
        "UNION ".
        "SELECT IDCOM,IDM, DESCRIPTIONCOM,DATECOM FROM commentaire,abonner ".
        "WHERE IDCOMINITIAL IS NULL AND commentaire.IDM =abonner.IDMETREABO ".
        "AND abonner.IDMABO='$idm' ORDER BY DATECOM DESC "; 
    
    $curseur = mysqli_query($cx, $sqlcherchercommentaire );
    if ($curseur == FALSE) {
        die("erreur fonction  afficher commentaire : " . mysqli_error($cx));
    } else {
        $listecommentaire = array();
        $i=0;
        while ($nuplet = mysqli_fetch_array($curseur)) {
           $com = array("IDCOM" => $nuplet["IDCOM"],
               "IDM" => $nuplet["IDM"],
               "DESCRIPTIONCOM" => $nuplet ["DESCRIPTIONCOM"],
                   "DATECOM" => $nuplet["DATECOM"]);
           $listecommentaire[$i] = $com;
           $i++;
        }
    }
    return $listecommentaire;
}

/* retrouver les réponses à un commentaire 
 *   connexion en parm entree
 *   IDMINITIAL d'un commentaire initial en parm entree
 *   tableau en sortie : contient idcom, nom, prenom, description et date des réponses 
 */

function afficherreponsecom($cx,$idminitial) {
    $sqlcherchercommentaire = " SELECT IDCOM, NOMM,PRENOMM, DESCRIPTIONCOM, DATECOM " 
            . " FROM commentaire, membre "
            . " WHERE IDCOMINITIAL='$idminitial' AND commentaire.IDM=membre.IDM "
            . " ORDER BY DATECOM DESC "; 
    
    $curseur = mysqli_query($cx, $sqlcherchercommentaire );
    if ($curseur == FALSE) {
        die("erreur fonction  afficher commentaire complémentaire: " . mysqli_error($cx));
    } else {
        $listecommentaire = array();
        $i=0;
        while ($nuplet = mysqli_fetch_array($curseur)) {
            $com = array("IDCOM" => $nuplet["IDCOM"],
                "NOMM" => $nuplet["NOMM"],
                "PRENOMM" => $nuplet["PRENOMM"],
                "DESCRIPTIONCOM" => $nuplet ["DESCRIPTIONCOM"],
                "DATECOM" => $nuplet["DATECOM"]);
           $listecommentaire[$i] = $com;
           $i++;
        }
    }
    return $listecommentaire;
}

/* retrouver id d'une compétences
 *   connexion en parm entree
 *   nom d'une compétence en parm entree
 *   tableau en sortie : contient id d'une compétences (null si aucun)
 */

function retrouveridcomp($cx, $nomc) {
    $sqlcomp = "SELECT * "
            . " FROM competence WHERE NOMC = '$nomc' "; 

    $curseur = mysqli_query($cx, $sqlcomp);
    if ($curseur == FALSE) {
        die("erreur fonction  recherche competence : " . mysqli_error($cx));
    } else {
        if (mysqli_num_rows($curseur) == 0) {
            return NULL;
        } else {
            return mysqli_fetch_array($curseur);
        }
    }
    
}

