<?php

require_once (File::build_path(array('lib','Security.php')));
require_once (File::build_path(array('lib','Session.php')));
require_once (File::build_path(array('model','ModelUtilisateur.php')));
require_once (File::build_path(array('model','ModelClassement.php')));

class ControllerUtilisateur {

    public static function inscription (){
        if (strlen(trim($_POST['pseudo'])) == 0) {
            header("Location:./routeur.php?Utilisateur=displayAcceuille&error=4");
        } else if (strlen($_POST['pseudo']) >= 30){
            header("Location:./routeur.php?Utilisateur=displayAcceuille&error=7");
        } else if (strlen($_POST['mdp1']) < 5){
            header("Location:./routeur.php?Utilisateur=displayAcceuille&error=5");
        } else if (Security::containsEmoji($_POST['pseudo']) || Security::containsEmoji($_POST['mdp1']) || Security::containsEmoji($_POST['mdp2'])){
            header("Location:./routeur.php?Utilisateur=displayAcceuille&error=6");
        } else {
            $pseudo = $_POST['pseudo'];
            $mdp1 = $_POST['mdp1'];
            $mdp2 = $_POST['mdp2'];
            if (ModelUtilisateur::getNbPseudo($pseudo) > 0 ){
                header("Location:./routeur.php?Utilisateur=displayAcceuille&error=2");
            } else if ($mdp1 != $mdp2){
                header("Location:./routeur.php?Utilisateur=displayAcceuille&error=1");
            } else {
                $mdp = Security::chiffrermdp($mdp1);
                ModelUtilisateur::insertUtilisateur($pseudo, $mdp);
                $idUtilisateur = ModelUtilisateur::getId($pseudo);
                Session::lancerSession();
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['admin'] = 0;
                $_SESSION['groupe'] = 0;
                self::displayPreLobby();
            }
        }
    }

    public static function Connexion(){
        $pseudo = $_POST['pseudo'];
        $mdp = Security::chiffrermdp($_POST['mdp']);
        $idUtilisateur = ModelUtilisateur::getId($pseudo);
        if (ModelUtilisateur::getMdp($idUtilisateur) == $mdp){
            Session::lancerSession();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['admin'] = ModelUtilisateur::getAdmin($idUtilisateur);
            $idGroupe = ModelUtilisateur::getIdGroupe($idUtilisateur);
            if ($idGroupe == -1){
                $_SESSION['groupe'] = 0;
            } else {
                $_SESSION['groupe'] = $idGroupe;
            }
            self::displayPreLobby();
        } else {
            header("Location:./routeur.php?Utilisateur=displayAcceuille&error=3");
        }
    }

    public static function displayPreLobby(){
        Session::lancerSession();
        if ($_SESSION['groupe'] != 0){
            header("Location:./routeur.php?Groupe=displayGroupe");
        } else {
            $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
            $tabInvit = ModelUtilisateur::getInvitation($idUtilisateur);
            require (File::build_path(array('view','preLobby.php')));
        }
    }

    public static function disconect (){
        Session::lancerSession();
        session_unset();
        session_destroy();
        header('Location:../../index.html');
    }

    public static function leaveGroupe(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        if ($idUtilisateur == ModelGroupe::getIdChef($_SESSION['groupe'])){
            ModelUtilisateur::setGroupe0($_SESSION['groupe']);
            ModelGroupe::deleteGroupe($_SESSION['groupe']);
        } else {
            ModelUtilisateur::deleteFromGroupe($idUtilisateur);
        }
        $_SESSION['groupe'] = 0;
        self::displayPreLobby();
    }

    public static function displayAcceuille(){
        $tab = ModelClassement::getClassement();

        /*$tabtop1 = ModelClassement::getUtilisaeurClassement($tab[0]['idClassement']);
        $tabtop2 = ModelClassement::getUtilisaeurClassement($tab[1]['idClassement']);
        $tabtop3 = ModelClassement::getUtilisaeurClassement($tab[2]['idClassement']);
        $tabtop4 = ModelClassement::getUtilisaeurClassement($tab[3]['idClassement']);
        $tabtop5 = ModelClassement::getUtilisaeurClassement($tab[4]['idClassement']);*/
        require ('../view/acceuille.php');
    }

}