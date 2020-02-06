<?php

require_once (File::build_path(array('model','Model.php')));

class ModelUtilisateur{

    public static function insertUtilisateur($pseudo, $mdp){
        $sql = "INSERT INTO Utilisateurs VALUES ('', :pseudo, :mdp, '-1', '0')";
        $value{'pseudo'} = $pseudo;
        $value['mdp'] = $mdp;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getNbPseudo($pseudo){
        $sql = "SELECT COUNT(pseudo) AS NB FROM Utilisateurs WHERE pseudo = :pseudo;";
        $value['pseudo'] = $pseudo;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function getMdp($idUtilisateur){
        $sql = "SELECT mdp FROM Utilisateurs WHERE idUtilisateur = :idUtilisateur";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['mdp'];
    }

    public static function getId($pseudo){
        $sql = "SELECT idUtilisateur FROM Utilisateurs WHERE pseudo = :pseudo;";
        $value['pseudo'] = $pseudo;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idUtilisateur'];
    }

    public static function getAdmin($idUtilisateur){
        $sql = "SELECT prioriter FROM Utilisateurs WHERE idUtilisateur = :idUtilisateur;";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['prioriter'];
    }

    public static function getInvitation($idUtilisateur){
        $sql = "SELECT g.idGroupe, g.nomGroupe FROM Invitations i JOIN Groupes g ON i.idGroupe = g.idGroupe WHERE i.idUtilisateur = :idUtilisateur ORDER BY (i.idGroupe) DESC;";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getIdGroupe($idUtilisateur){
        $sql = "SELECT idGroupe FROM Utilisateurs WHERE idUtilisateur = :idUtilisateur";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idGroupe'];
    }

    public static function addGroupe($idUtilisateur, $idGroupe){
        $sql = "UPDATE Utilisateurs SET idGroupe = :idGroupe WHERE idUtilisateur = !idUtilisateur;";
        $value['idGroupe'] = $idGroupe;
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function deleteFromGroupe($idUtilisateur){
        $sql = "UPDATE Utilisateurs SET idGroupe = '-1' WHERE idUtilisateur = :idUtilisateur;";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getAllUtiGroupe($idGroupe){
        $sql = "SELECT idUtilisateur FROM Utilisateurs WHERE idGroupe = :idGroupe;";
        $value["idGroupe"] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function setGroupe($idGroupe, $idUtilisateur){
        $sql = "UPDATE Utilisateurs SET idGroupe = :idGroupe WHERE idUtilisateur = :idUtilisateur;";
        $value["idGroupe"] = $idGroupe;
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function setGroupe0 ($idGroupe){
        $sql = "UPDATE Utilisateurs SET idGroupe = '-1' WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function countNbMembreGroupe($idGroupe){
        $sql = "SELECT COUNT(idUtilisateur) AS NB FROM Utilisateurs WHERE idGroupe = :idGroupe;";
        $value["idGroupe"] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }








}