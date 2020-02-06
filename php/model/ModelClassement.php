<?php

require_once (File::build_path(array('model','Model.php')));

class ModelClassement{

    public static function getClassement(){
        $sql = "SELECT idClassement, nomGroupe, score FROM Classement WHERE score > 0 ORDER BY score DESC LIMIT 5;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getUtilisaeurClassement($idClassement){
        $sql = "SELECT pseudo FROM Utilisateurs u JOIN ListeClassement lp ON lp.idUtilisateur = u.idUtilisateur WHERE idClassement = '10';";
        $value['idClassement'] = $idClassement;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getScoreClassement(){
        $sql = "SELECT score FROM Classement ORDER BY score DESC LIMIT 5;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function insertClassement($nomGroupe, $score){
        $sql = "INSERT INTO Classement VALUES ('', :nomGroupe, :score);";
        $value['nomGroupe'] = $nomGroupe;
        $value['score'] = $score;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getLastIdClassement(){
        $sql = "SELECT LAST_INSERT_ID(idClassement) AS ID FROM Classement ORDER BY (idClassement) DESC;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['ID'];
    }

    public static function insertListeClassement($idClassement, $idUtilisateur){
        $sql = "INSERT INTO ListeClassement VALUES (:idClassement, :idUtilisateur);";
        $value['idClassement'] = $idClassement;
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

}