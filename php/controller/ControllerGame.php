<?php

require_once (File::build_path(array('lib','Security.php')));
require_once (File::build_path(array('lib','Session.php')));
require_once (File::build_path(array('model','ModelUtilisateur.php')));
require_once (File::build_path(array('model','ModelGroupe.php')));
require_once (File::build_path(array('model','ModelParcours.php')));
require_once (File::build_path(array('model','ModelClassement.php')));

class ControllerGame {

    public static function lancerGame(){
        Session::lancerSession();
        if (ModelParcours::countNbParcours($_POST['idParcours']) == 0){ // parcours existe
            header("Location:./routeur.php?Groupe=displayGroupe?&error=8");
        } else if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){ // chef de groupe
            ModelGroupe::setParcours($_SESSION['groupe'], $_POST['idParcours']); //idPP = 1 & statusPP = 1;
            self::displayGame();
        } else { // erreur de chef de groupe
            header("Location:./routeur.php?Groupe=displayGroupe&error=5");
        }
    }

    public static function displayGame(){
        Session::lancerSession();
        $idParcours = ModelGroupe::getidParcours($_SESSION['groupe']);
        if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
            $_SESSION['meme'] = 0;
        }
        if ($idParcours == 0 ){ // parcours différent de default
            ModelGroupe::setPP0($_SESSION['groupe']);
            header("Location:./routeur.php?Groupe=displayGroupe&error=6");
        } else if (ModelParcours::countNbPP($idParcours) < ModelGroupe::getIdPP($_SESSION['groupe'])) { //Parcours terminer ?
            self::finirGame();
        } else { // afficher la vue Game
            $nomGroupe = ModelGroupe::getNomGroupe($_SESSION['groupe']);
            $nomParcours = ModelParcours::getNomParcours($idParcours);
            $idPP = ModelGroupe::getIdPP($_SESSION['groupe']);
            $idEnigme = ModelParcours::getidEnigme($idPP, $idParcours);
            if (ModelGroupe::getStatusPP($_SESSION['groupe']) == 1){ // status de l'éngime 1: localisation / 0: réponse
                $localisation = ModelParcours::getLocalisation($idPP, $idParcours);
            } else {
                $intitule = ModelParcours::getIntituler($idEnigme);
                $info = ModelParcours::getInfo($idPP, $idParcours);
            }
            if (ModelGroupe::getIdChef($_SESSION['groupe']) == ModelUtilisateur::getId($_SESSION['pseudo'])){
                $Chef = 1;
            } else {
                $Chef = 0;
            }
            $statusPP = ModelGroupe::getStatusPP($_SESSION['groupe']);
            $score = ModelGroupe::getScore($_SESSION['groupe']);
            $nbEnigmes = ModelParcours::countNbPP($idParcours);
            require (File::build_path(array('view','inGame.php')));
        }
    }

    public static function validerReponse(){
        Session::lancerSession();
        if (ModelGroupe::getStatusPP($_SESSION['groupe']) == 0){
            $idPP = ModelGroupe::getIdPP($_SESSION['groupe']);
            if (ModelParcours::getReponse($_POST['idEnigme']) == $_POST['reponse']){
                ModelGroupe::setScore($_SESSION['groupe'], $idPP * 50);
                ModelGroupe::inecrePP($_SESSION['groupe']); //idPP +1 & statusPP = 1
                $idParcours = ModelGroupe::getidParcours($_SESSION['groupe']);
                if (ModelParcours::countNbPP($idParcours) < $idPP){
                    self::finirGame();
                } else {
                    self::displayGame();
                }
            } else {
                if (ModelGroupe::getScore($_SESSION['groupe']) >= $idPP * 20){
                    ModelGroupe::setScore($_SESSION['groupe'], -($idPP * 5));
                }
                header("Location:./routeur.php?Game=displayGame&error=1");
            }
        } else {
            self::displayGame();
        }

    }

    public static function validerQRcode(){
        Session::lancerSession();
        $idPP = ModelGroupe::getIdPP($_SESSION['groupe']);
        $idParcours = ModelGroupe::getidParcours($_SESSION['groupe']);
        $tabLocalisation = ModelGroupe::getLocalistatinGroupe($_SESSION['groupe']);
        if ($tabLocalisation['longetidue'] == 0 || $tabLocalisation['latidude'] == 0){
            header("Location:./routeur.php?Game=displayGame&error=3");
        } else if ($_POST['QRcode'] == Security::generateQRstring($idPP, $idParcours)){
            ModelGroupe::setStatusPP($_SESSION['groupe'], 0);
            ModelGroupe::setScore($_SESSION['groupe'], $idPP * 10);
            self::displayGame();
        } else {
            if (ModelGroupe::getScore($_SESSION['groupe']) >= $idPP * 20){
                ModelGroupe::setScore($_SESSION['groupe'], - ($idPP * 3));
            }
            header("Location:./routeur.php?Game=displayGame&error=2");
        }
    }

    public static function finirGame (){
        Session::lancerSession();
        $idParcours = ModelGroupe::getidParcours($_SESSION['groupe']);
        if (ModelParcours::countNbPP($idParcours) < ModelGroupe::getIdPP($_SESSION['groupe'])){
            $nomGroupe = ModelGroupe::getNomGroupe($_SESSION['groupe']);
            $nomParcours = ModelParcours::getNomParcours(ModelGroupe::getidParcours($_SESSION['groupe']));
            $score = ModelGroupe::getScore($_SESSION['groupe']);
            if (ModelGroupe::getIdChef($_SESSION['groupe']) != ModelUtilisateur::getId($_SESSION['pseudo'])){
                $classement = 0;
            } else {
                $classement = self::addClassement();
                sleep(2); // permet de laisser les autre joueur la vue finGame
                ModelGroupe::deleteGroupe($_SESSION['groupe']);
            }
            ModelUtilisateur::setGroupe0($_SESSION['groupe']);
            $_SESSION['groupe'] = 0;
            require(File::build_path(array('view','finGame.php')));
        } else {
            header("Location:./routeur.php?Utilisateur=displayPreLobby");
        }
    }

    public static function addClassement(){
        Session::lancerSession();
        $tab = ModelClassement::getScoreClassement();
        $score = ModelGroupe::getScore($_SESSION['groupe']);
        $i = 0;
        foreach ($tab as $item){
            $i += 1;
            //echo "<br>score classement :" . $item['score'] . "::" . $score . "SCORE groupe";
            if ($item['score'] < $score && $score > 0){
                ModelClassement::insertClassement(ModelGroupe::getNomGroupe($_SESSION['groupe']), $score);
                $ID = ModelClassement::getLastIdClassement();
                $tabIdUti = ModelUtilisateur::getAllUtiGroupe($_SESSION['groupe']);
                foreach ($tabIdUti as $value){
                    ModelClassement::insertListeClassement($value["idUtilisateur"], $ID);
                }
                return $i;
            }
        }
        return 0;
    }

}