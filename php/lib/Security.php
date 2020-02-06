<?php

class Security{

    private static $seed = 'OLL3pFULt7Hs80Tam9c4RRtZqq2A5jsUnZEnCQ7o';
    private static $QRseed = 'iAIqx0YZtozXZ9HR90BthuX5jlrYveXP50mKqhYP';

    public static function chiffrermdp($mdp){
        return hash('sha256',$mdp . self::$seed);
    }

    public static function generateQRstring ($idPP, $idParcours){
        return hash('sha256',"idPP=" . $idPP . "_idParcours=" . $idParcours . "_" . self::$QRseed);
    }

    public static function containsEmoji( $string ) {
        preg_match( '/[\x{1F600}-\x{1F64F}]/u', $string, $matches_emo );
        return !empty( $matches_emo[0] ) ? true : false;
    }

}