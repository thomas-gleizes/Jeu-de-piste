<?php

require_once (File::build_path(array('model','Model.php')));

class ModelGroupe{

    public static function insertGroupe($nomGroupe, $idChef, $idCreateur){
        $sql = "INSERT INTO Groupes VALUES ('', :nomGroupe, :idChef, :idCreateur, '0','0','0','0','0','0')";
        $value['nomGroupe'] = $nomGroupe;
        $value['idChef'] = $idChef;
        $value['idCreateur'] = $idCreateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function deleteGroupe($idGroupe){
        $sql = "DELETE FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getNomGroupe($idGroupe){
        $sql = "SELECT nomGroupe AS nom FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['nom'];
    }

    public static function getUtilisateurGroupe($idUtilisateur, $idGroupe){
        $sql = "SELECT idUtilisateur AS idMembre, pseudo AS pseudoMembre FROM Utilisateurs WHERE idUtilisateur != :idUtilisateur AND idGroupe = :idGroupe";
        $value['idUtilisateur'] = $idUtilisateur;
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getAllUtilisateursDispo($idUtilisateur){
        $sql = "SELECT idUtilisateur AS idDispo, pseudo AS pseudoDispo FROM utilisateurs WHERE idUtilisateur != :idUtilisateur AND idUtilisateur != 0 AND idGroupe = '-1' ;";
        $value['idUtilisateur'] = $idUtilisateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getInvitation($idGroupe){
        $sql = "SELECT u.idUtilisateur AS idInvit, pseudo AS pseudoInvit FROM Utilisateurs u JOIN Invitations i ON i.idUtilisateur = u.idUtilisateur WHERE i.idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function deleteInvitation($idUtilisateur, $idGroupe){
        $sql = "DELETE FROM Invitations WHERE idUtilisateur = :idUtilisateur AND idGroupe = :idGroupe;";
        $value['idUtilisateur'] = $idUtilisateur;
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function insertInvitation($idUtilisateur, $idGroupe){
        $sql = "INSERT INTO Invitations VALUES (:idUtilisateur, :idGroupe)";
        $value['idUtilisateur'] = $idUtilisateur;
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getAllGroupe(){
        $sql = "SELECT * FROM Groupes";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }

    public static function getIdChef($idGroupe){
        $sql = "SELECT idChef FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idChef'];
    }

    public static function getIdCreateur($idGroupe){
        $sql = "SELECT idCreateur FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idCreateur'];
    }

    public static function countNbNomGroupe($nomGroupe){
        $sql = "SELECT COUNT(nomGroupe) AS NB FROM Groupes WHERE nomGroupe = :nomGroupe;";
        $value['nomGroupe'] = $nomGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function countInvitation($idUtilisateur, $idGroupe){
        $sql = "SELECT COUNT(*) AS NB FROM Invitations WHERE idUtilisateur = :idUtilisateur AND idGroupe = :idGroupe;";
        $value['idUtilisateur'] = $idUtilisateur;
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function countInvitationGroupe($idGroupe){
        $sql = "SELECT COUNT(idUtilisateur) AS NB FROM Invitations WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function getLastId($idCreateur){
        $sql = "SELECT LAST_INSERT_ID(idGroupe) AS ID FROM Groupes WHERE idCreateur = :idCreateur ORDER BY (idGroupe) DESC;";
        $value['idCreateur'] = $idCreateur;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['ID'];
    }

    public static function countNbGroupe($idGroupe){
        $sql = "SELECT COUNT(idGroupe) AS NB FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['NB'];
    }

    public static function setParcours ($idGroupe, $idParcours){
        $sql = "UPDATE Groupes SET idParcours = :idParcours, idPP = '1', statusPP = '1' WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $value['idParcours'] = $idParcours;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getIdPP($idGroupe){
        $sql = "SELECT idPP FROM Groupes WHERE idGroupe = :idGroupe";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idPP'];
    }

    public static function getidParcours($idGroupe){
        $sql = "SELECT idParcours FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['idParcours'];
    }

    public static function getScore ($idGroupe){
        $sql = "SELECT score FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['score'];
    }

    public static function setScore ($idGroupe, $score){
        $sql = "UPDATE Groupes SET score = score + :score WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $value['score'] = $score;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function inecrePP ($idGroupe){
        $sql = "UPDATE Groupes SET idPP = idPP + 1, statusPP = '1' WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getStatusPP ($idGroupe){
        $sql = "SELECT statusPP FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0]['statusPP'];
    }

    public static function setStatusPP($idGroupe, $statusPP){
        $sql = "UPDATE Groupes SET statusPP = :statusPP WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $value['statusPP'] = $statusPP;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function setPP0($idGroupe){
        $sql = "UPDATE Groupes SET idPP = 0, statusPP = 0, score = 0 WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function updateLocalisation($longitude, $latitude, $idGroupe){
        $sql = "UPDATE Groupes SET longitude = :longitude, latitude = :latitude WHERE idGroupe = :idGroupe;";
        $value['latitude'] = $latitude;
        $value['longitude'] = $longitude;
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
    }

    public static function getLocalistatinGroupe($idGroupe){
        $sql = "SELECT longitude, latitude FROM Groupes WHERE idGroupe = :idGroupe;";
        $value['idGroupe'] = $idGroupe;
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute($value);
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab[0];
    }

    public static function getLocalisationAllGroupes(){
        $sql = "SELECT nomGroupe, longitude, latitude FROM Groupes WHERE idParcours != 0;";
        $rec_prep = Model::$pdo->prepare($sql);
        $rec_prep->execute();
        $rec_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $rec_prep->fetchAll();
        return $tab;
    }


}