<?php

require_once ('../lib/File.php');
require_once (File::build_path(array('controller','ControllerUtilisateur.php')));
require_once (File::build_path(array('controller','ControllerGroupe.php')));
require_once (File::build_path(array('controller','ControllerGame.php')));

require_once (File::build_path(array('controller','ControllerAjax.php')));
require_once (File::build_path(array('controller','ControllerAdmin.php')));

if (!$_GET == null){
    if (isset($_GET['Utilisateur'])){
        $action = $_GET['Utilisateur'];
        ControllerUtilisateur::$action();
    } else if (isset($_GET['Groupe'])){
        $action = $_GET['Groupe'];
        ControllerGroupe::$action();
    } else if (isset($_GET['Admin'])){
        $action = $_GET['Admin'];
        ControllerAdmin::$action();
    } else if (isset($_GET['Ajax'])){
        $action = $_GET['Ajax'];
        ControllerAjax::$action();
    } else if (isset($_GET['Game'])){
        $action = $_GET['Game'];
        ControllerGame::$action();
    }
}

if (!$_POST == null) {
    if (isset($_POST['Utilisateur'])){
        $action = $_POST['Utilisateur'];
        ControllerUtilisateur::$action();
    } else if (isset($_POST['Groupe'])){
        $action = $_POST['Groupe'];
        ControllerGroupe::$action();
    } else if (isset($_POST['Admin'])){
        $action = $_POST['Admin'];
        ControllerAdmin::$action();
    } else if (isset($_POST['Game'])){
        $action = $_POST['Game'];
        ControllerGame::$action();
    } else if (isset($_POST['Ajax'])){
        $action = $_POST['Ajax'];
        ControllerAjax::$action();
    }
}
?>
