<?php

require_once (File::build_path(array('model','ModelUtilisateur.php')));
require_once (File::build_path(array('model','ModelGroupe.php')));
require_once (File::build_path(array('model','ModelParcours.php')));

class ControllerAjax {

    //maj les membre de la vue lobby
    public static function refreshLobby(){
        Session::lancerSession();
        $idUtilisateur = ModelUtilisateur::getId($_SESSION['pseudo']);
        $tabMember = ModelGroupe::getUtilisateurGroupe($idUtilisateur, $_SESSION['groupe']);
        foreach ($tabMember as $value){
            echo "$";
            foreach ($value as $val){
                echo $val.",";
            }
        }
    }

    // maj les invitation de la vue lobby
    public static function refreshInvit(){
        Session::lancerSession();
        $tabInvit = ModelGroupe::getInvitation($_SESSION['groupe']);
        foreach ($tabInvit as $value){
            echo "$";
            foreach ($value as $val){
                echo $val.",";
            }
        }
    }

    //retourne 1 si l'utilisateur est Créateur du groupe, 0 sinon
    public static function getCreateur(){
        Session::lancerSession();
        if (ModelGroupe::getIdCreateur($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
            echo "1";
        } else {
            echo "0";
        }
    }

    //retourne 1 si l'utilisateur est le chef du goupe, 0 sinon
    public static function getChef(){
        Session::lancerSession();
        if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
            echo "1";
        } else {
            echo "0";
        }
    }

    //retourne l'etat de le game
    public static function getStateGame(){
        Session::lancerSession();
        if (ModelUtilisateur::getIdGroupe(ModelUtilisateur::getId($_SESSION['pseudo'])) == -1){
            $_SESSION['groupe'] = 0;
            echo 1;
        } else if (ModelGroupe::getidParcours($_SESSION['groupe']) != 0){
            echo 0;
        }
    }

    //maj le point de passage du parcours durant une game
    public static function refreshGame(){
        Session::lancerSession();
        if (ModelUtilisateur::getIdGroupe(ModelUtilisateur::getId($_SESSION['pseudo'])) == -1){
            $_SESSION['groupe'] = 0;
            echo 2; // /.routeur.php?Utilisateur=displayPreLobby
        } else if (ModelGroupe::getIdChef($_SESSION['groupe']) != ModelUtilisateur::getId($_SESSION['pseudo'])){
            if (ModelParcours::countNbPP(ModelGroupe::getidParcours($_SESSION['groupe'])) < ModelGroupe::getIdPP($_SESSION['groupe'])){
                echo 0; //header("Location:./routeur.php?Game=finirGame");
            }
            $statusPP = ModelGroupe::getStatusPP($_SESSION['groupe']);
            if ($_SESSION['meme'] != $statusPP){
                $_SESSION['meme'] = $statusPP;
                echo 1; // header("Location:./routeur.php?Game=displayGame");
            }
        }
    }

    //maj les invitation
    public static function refreshPreLobby(){
        Session::lancerSession();
        $tabInvit = ModelUtilisateur::getInvitation(ModelUtilisateur::getId($_SESSION['pseudo']));
        foreach ($tabInvit as $value){
            echo "$";
            foreach ($value as $val){
                echo $val.",";
            }
        }
    }

    //maj de la BD de la localisation du groupe si il est dans le groupe
    public static function updateLocalisation(){
        Session::lancerSession();
        if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
            if ($_GET['longitude'] >= 3.849668 && $_GET['longitude'] <= 3.852008 && $_GET['latitude'] >= 43.634486 && $_GET['longitude'] <= 43.638115){
                ModelGroupe::updateLocalisation($_GET['longitude'],$_GET['latitude'],$_SESSION['groupe']);
            }
        }
    }

    //retourne la localisation de tout les groupe
    public static function getLocalisation(){
        Session::lancerSession();
        $tab = ModelGroupe::getLocalisationAllGroupes();
        foreach ($tab as $value){
            echo "$";
            foreach ($value as $val){
                echo $val.",";
            }
        }
    }

    //retourne 1 si le QR code est valide et maj le score
    public static function validerQRcode(){
        Session::lancerSession();
        $idPP = ModelGroupe::getIdPP($_SESSION['groupe']);
        $idParcours = ModelGroupe::getidParcours($_SESSION['groupe']);
        if ($_GET['QRcode'] == Security::generateQRstring($idPP, $idParcours)){
            ModelGroupe::setStatusPP($_SESSION['groupe'], 0);
            ModelGroupe::setScore($_SESSION['groupe'], $idPP * 10);
            echo 1;
        } else {
            if (ModelGroupe::getScore($_SESSION['groupe']) >= $idPP * 20){
                ModelGroupe::setScore($_SESSION['groupe'], -($idPP * 3));
            }
            echo 2;
        }
    }

    //défénie la localition du groupe a 0;
    public static function setLocalisation0(){
        Session::lancerSession();
        if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
            ModelGroupe::updateLocalisation(0,0, $_SESSION['groupe']);
        }
    }
}