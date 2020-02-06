<?php

require_once (File::build_path(array('model','Model.php')));

class ModelParcours {

    public static function getAllParcours (){
        $sql = "SELECT idParcours, nomParcours FROM Parcours WHERE idParcours != 0 ORDER BY (idParcours) DESC;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getAllEnigmes (){
        $sql = "SELECT idEnigme, intitule, reponse FROM Enigmes WHERE idEnigme != 0;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function insertParcours ($nomParcours){
        $sql = "INSERT INTO Parcours VALUES ('', :nomParcours)";
        $value['nomParcours'] = $nomParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getNomParcours ($idParcours){
        $sql = "SELECT nomParcours FROM Parcours WHERE idParcours = :idParcours";
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['nomParcours'];
    }

    public static function getidEnigme($idPointdePassage, $idParcours){
        $sql = "SELECT idEnigme FROM PointPassage WHERE idPointdePassage = :idPointdePassage AND idParcours = :idParcours;";
        $value['idPointdePassage'] = $idPointdePassage;
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idEnigme'];
    }

    public static function getIntituler($idEnigme){
        $sql = "SELECT intitule FROM Enigmes WHERE idEnigme = :idEnigme;";
        $value['idEnigme'] = $idEnigme;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['intitule'];
    }

    public static function getReponse ($idEnigme){
        $sql = "SELECT reponse FROM Enigmes WHERE idEnigme = :idEnigme;";
        $value['idEnigme'] = $idEnigme;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['reponse'];
    }

    public static function countNbPP ($idParcours){
        $sql = "SELECT COUNT(idPointdePassage) AS NB FROM PointPassage WHERE idParcours = :idParcours";
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function getLocalisation ($idPP, $idParcours){
        $sql = "SELECT localisation FROM PointPassage WHERE idPointdePassage = :idPP AND idParcours = :idParcours;";
        $value['idParcours'] = $idParcours;
        $value['idPP'] = $idPP ;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['localisation'];
    }

    public static function countNbParcours($idParcours){
        $sql = "SELECT COUNT(idParcours) AS NB FROM Parcours WHERE idParcours = :idParcours;";
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function getIdPPLocatisation($idParcours){
        $sql = "SELECT idPointdePassage AS idPP, localisation AS loca FROM PointPassage WHERE idParcours = :idParcours;";
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getLastIdParcours(){
        $sql = "SELECT LAST_INSERT_ID(idParcours) AS ID FROM Parcours ORDER BY (idParcours) DESC;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['ID'];
    }

    public static function insertPP($idPP, $idParcours, $idEnigme, $localisation, $info){
        $sql = "INSERT INTO PointPassage VALUES (:idPP, :idParcours, :idEnigme, :localisation, :info);";
        $value = array(
            "idPP" => $idPP,
            "idParcours" => $idParcours,
            "idEnigme" => $idEnigme,
            "localisation" => $localisation,
            "info" => $info
        );
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function insertEnigme($intitule, $reponse){
        $sql = "INSERT INTO Enigmes VALUES ('', :intitule, :reponse);";
        $value['intitule'] = $intitule;
        $value['reponse'] = $reponse;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function deleteParcours ($idParcours){
        $sql = "DELETE FROM Parcours WHERE idParcours = :idParcours;";
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getInfo ($idPP, $idParcours){
        $sql = "SELECT info FROM PointPassage WHERE idPointdePassage = :idPP AND idParcours = :idParcours;";
        $value['idPP'] = $idPP;
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['info'];
    }




}