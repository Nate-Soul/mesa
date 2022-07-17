<?php

class Session{

    public static function set($name, $value){
        if(!empty($name)){
            $_SESSION[$name] = $value;
        }
    }



    public static function get($name){
        if(!empty($name)){
            return (self::exists($name)) ? $_SESSION[$name] : null;
        }
    }


    public static function remove($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
            return true;
        }
    }



    public static function wipe(){
        if(!session_destroy()){
            return false;
        }
        return true;
    }


    public static function exists($name){
        if(!empty($name) && isset($_SESSION[$name])){
            return true;
        }
        return false ;
    }


}