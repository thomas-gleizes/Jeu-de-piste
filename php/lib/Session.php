<?php

class Session {

    private static $name = "nabzveanzbe";

    public static function lancerSession(){
        if (session_status() == PHP_SESSION_NONE){
            session_name(self::$name);
            session_start();
        }
    }

    public static function testAdmin(){
        self::lancerSession();
        if (isset($_SESSION['admin'])){
            if ($_SESSION['admin'] == 1) return true;
            return false;
        }
    }

}