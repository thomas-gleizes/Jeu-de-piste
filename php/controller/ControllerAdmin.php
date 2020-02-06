<?php

require_once (File::build_path(array('lib','Security.php')));
require_once (File::build_path(array('lib','Session.php')));
require_once (File::build_path(array('model','ModelUtilisateur.php')));
require_once (File::build_path(array('model','ModelGroupe.php')));
require_once (File::build_path(array('model','ModelParcours.php')));

require_once ("./../lib/phpqrcode/qrlib.php");
require_once ("./../lib/phpqrcode/qrconfig.php");
require_once ("./../lib/fpdf/fpdf.php");

class ControllerAdmin{

    // afficher la vue Admin
    public static function displayViewAdmin(){
        Session::lancerSession();
        if (Session::testAdmin()){
            $tabParcours = ModelParcours::getAllParcours();
            $tabEnigmes = ModelParcours::getAllEnigmes();
            require (File::build_path(array('view','Admin.php')));
        } else {
            header("Location:./../../index.html");
        }
    }

    //fonction creant un groupe en tant que Admin :: Useless
    public static function createGroupe(){
        Session::lancerSession();
        if (Session::testAdmin()){
            $idChef = ModelUtilisateur::getId($_POST['pseudoChef']);
            ModelGroupe::insertGroupe($_POST['nomGroupe'], $idChef, ModelUtilisateur::getId($_SESSION['pseudo']));
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=0");
    }

    //fonction suppriment un groupe en tant que Admin :: Useless
    public static function supprGroupe(){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelGroupe::deleteGroupe($_POST['idGroupe']);
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=0");
    }

    //ajouté un utilisateur a un groupe en tant que admin
    public static function addPlayer(){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelUtilisateur::addGroupe(ModelUtilisateur::getId($_SESSION['pseudo']), $_POST['idGroupe']);
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=0");
    }

    // supprime un utilisateur d'un groupe en tant que admin
    public static function supprPlayer(){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelUtilisateur::deleteFromGroupe(ModelUtilisateur::getId($_SESSION['pseudo']));
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=0");
    }

    //génére une chaine de caratère a partir d'un idPP et d'un idParcours puis génére un QR code et l'affiché
    public static function hashMe (){
        if (isset($_GET['idPP']) && isset($_GET['idParcours'])){
            $res = Security::generateQRstring($_GET['idPP'], $_GET['idParcours']);
            $src = './../../image/qrcode.png';
            QRcode::png($res, $src,'H',5,2);
            header("Location:./routeur.php?Admin=displayViewAdmin&res=".$res);
            //self::displayViewAdmin();
        }
    }

    //Crée un parcours
    public static function creeParcours(){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelParcours::insertParcours($_POST['nomParcours']);
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=1");
    }

    // ajoute un Point de passage en dernier positon a un parcours donné
    public static function ajouterPP(){
        Session::lancerSession();
        if (Session::testAdmin()){
            $idPP = ModelParcours::countNbPP($_POST['idParcours']) + 1;
            ModelParcours::insertPP($idPP, $_POST['idParcours'], $_POST['idEnigme'], $_POST['localisation'], $_POST['info']);
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=2");
    }

    // ajoute une enigme a la base de donnée
    public static function creeEnigme (){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelParcours::insertEnigme($_POST['intitule'], $_POST['reponse']);
        }
        header("Location:./routeur.php?Admin=displayViewAdmin&status=3");
    }

    // supprime un parcours en tant que admin
    public static function supprParcours(){
        Session::lancerSession();
        if (Session::testAdmin()){
            ModelParcours::deleteParcours($_POST['idParcours']);
        }
        self::displayViewAdmin();
    }

    //génére un pdf avec tout les QR code d'un parcours données
    public static function generatePdf(){
        Session::lancerSession();
        $idParcours = $_POST['idParcours'];
        $tab = ModelParcours::getIdPPLocatisation($idParcours);
        $nomParcours = ModelParcours::getNomParcours($idParcours);
        $src = "./../../image/QR";
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Write(0, "Voici tout les QrCode du parcours \"$nomParcours\".");
        $i = 20;
        $n = 15;
        $d = 0;
        $v = 0;
        foreach ($tab as $item) {
            $text = "\nPoint de passage ". $item['idPP']." Localisation:".$item['loca'];
            $pdf->Write($n/($d + 1), $text);
            if ($d%4 == 0) $i = 15;
            $code = Security::generateQRstring($item['idPP'], $idParcours);
            QRcode::png($code, $src.$v.'.png','H',4,2);
            $pdf->Image($src.$v.'.png',130, $i,'55','55','PNG');
            $i += 60;
            $n += 73;
            $d += 1;
            $v += 1;
        }
        $pdf->Output('I','Parcours_'.$nomParcours,false);
    }




}