<?php

require_once (File::build_path(array('lib','Security.php')));
require_once (File::build_path(array('lib','Session.php')));
require_once (File::build_path(array('model','ModelUtilisateur.php')));
require_once (File::build_path(array('model','ModelGroupe.php')));
require_once (File::build_path(array('model','ModelParcours.php')));

class ControllerGroupe{

    public static function creeGroupe(){
        Session::lancerSession();
        if ($_SESSION['groupe'] != 0){
            self::displayGroupe();
        } else if (strlen(trim($_POST['nomGroupe'])) == 0 || Security::containsEmoji($_POST['nomGroupe']) || strlen($_POST['nomGroupe']) >= 20){
            header("Location:./routeur.php?Utilisateur=displayPreLobby&error=6");
        } else {
            if ($_SESSION['admin'] == 1){
                $idChef = $_POST['idChef'];
            } else {
                $idChef = ModelUtilisateur::getId($_SESSION['pseudo']);
            }
            if (ModelGroupe::countNbNomGroupe($_POST['nomGroupe']) == 1){
                header("Location:./routeur.php?Utilisateur=displayPreLobby&error=1");
            } else {
                $idCreateur = ModelUtilisateur::getId($_SESSION['pseudo']);
                ModelGroupe::insertGroupe($_POST['nomGroupe'], $idChef, $idCreateur);
                $_SESSION['groupe'] = ModelGroupe::getLastId($idCreateur);
                header("Location:./routeur.php?Groupe=displayGroupe");
            }
        }
    }

    public static function invite(){
        Session::lancerSession();
        $erreur = 0;
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        if (ModelUtilisateur::countNbMembreGroupe($_SESSION['groupe']) + ModelGroupe::countInvitationGroupe($_SESSION['groupe']) >= 5){
            $erreur = 7;
        } else if (ModelUtilisateur::getNbPseudo($_POST['pseudo']) != 1){
            //echo "Pseudo inéxistant, verifé l'orthographe !";
            $erreur = 1;
        } else {
            $idJoueur = ModelUtilisateur::getId($_POST['pseudo']);
            if (ModelUtilisateur::getAdmin($idJoueur) == 1){
                $erreur = 2;
                // on invite pas les admin
            } else if ($idJoueur == $idUtilisateur || $idJoueur == 0){
                $erreur = 2;
                //echo "Vous ne pouvez pas inviter c'est joueur !";
            } else {
                $tabMembre = ModelGroupe::getUtilisateurGroupe($idUtilisateur, $_SESSION['groupe']);
                foreach ($tabMembre as $value){
                    if ($idJoueur == $value['idMembre']){
                        $erreur = 3;
                        break;
                        //echo "Ce joueur est déja dans votre groupe";
                    }
                }
                $tabInvit = ModelGroupe::getInvitation($_SESSION['groupe']);
                foreach ($tabInvit as $value){
                    if ($idJoueur == $value['idInvit']){
                        $erreur = 4;
                        break;
                        //echo "Ce joueur est déjà invité dans le groupe !";
                    }
                }
            }
        }
        if ($erreur == 0){
            echo $idJoueur . "idJoueur<br>";
            echo $_SESSION['groupe'] . "groupe <br>";
            ModelGroupe::insertInvitation($idJoueur, $_SESSION['groupe']);
            header("Location:./routeur.php?Groupe=displayGroupe");
        } else {
            header('Location:./routeur.php?Groupe=displayGroupe&error=' . $erreur);
        }
    }

    public static function displayGroupe(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        $meme = $_SESSION['groupe'];
        $idGroupe = ModelUtilisateur::getIdGroupe($idUtilisateur);
        if ($idGroupe == -1){
            $_SESSION['groupe'] = 0;
            if (ModelGroupe::countNbGroupe($meme) == 0){
                header("Location:./routeur.php?Utilisateur=displayPreLobby&error=2");
            } else {
                header("Location:./routeur.php?Utilisateur=displayPreLobby&error=4");
            }

        } else if (ModelGroupe::getidParcours($idGroupe) == 0){
            $_SESSION['groupe'] = $idGroupe;
            $nomGroupe = ModelGroupe::getNomGroupe($idGroupe);
            $tabMembre = ModelGroupe::getUtilisateurGroupe($idUtilisateur, $idGroupe);
            $tabInvit = ModelGroupe::getInvitation($idGroupe);
            if ($idUtilisateur == ModelGroupe::getIdCreateur($idGroupe)){
                $createur = 1;
                $tabParcours = ModelParcours::getAllParcours();
            } else {
                $createur = 0;
                $tabParcours = [];
            }
            require (File::build_path(array('view','lobby.php')));
        } else {
            header("Location:./routeur.php?Game=displayGame");
        }
    }


    public static function supprMembre(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        if ($idUtilisateur == ModelGroupe::getIdCreateur($_SESSION['groupe'])){
            ModelUtilisateur::deleteFromGroupe($_POST['idUtilisateur']);
        }
        self::displayGroupe();
    }

    public static function supprInvit(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        if ($idUtilisateur == ModelGroupe::getIdCreateur($_SESSION['groupe'])){
            ModelGroupe::deleteInvitation($_POST['idUtilisateur'], $_SESSION['groupe']);
        }
        self::displayGroupe();
    }

    public static function accepterInvit(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        if (ModelGroupe::countInvitation($idUtilisateur, $_POST['idGroupe']) == 0){
            header("Location:./routeur.php?Utilisateur=displayPreLobby&error=3");
        } else if (ModelUtilisateur::countNbMembreGroupe($_POST['idGroupe']) >= 5) {
            header("Location:./routeur.php?Utilisateur=displayPreLobby&error=5");
        } else {
            ModelUtilisateur::setGroupe($_POST['idGroupe'], $idUtilisateur);
            ModelGroupe::deleteInvitation($idUtilisateur, $_POST['idGroupe']);
            $_SESSION['groupe'] = $_POST['idGroupe'];
            self::displayGroupe();
        }
    }

    public static function declineInvit(){
        Session::lancerSession();
        ModelGroupe::deleteInvitation(ModelUtilisateur::getId($_SESSION['pseudo']), $_POST['idGroupe']);
        header("Location:./routeur.php?Utilisateur=displayPreLobby");
    }

}