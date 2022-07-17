<?php

class Token {

    private static $csrfToken = "csrf_token";
    private static $csrfTokenExpires = "csrf_token_expires";


    public static function generateCSRFToken(){
        Session::set(self::$csrfToken, []);
        //Session::set(self::$csrfToken, bin2hex(random_bytes(32)));
        $_SESSION[self::$csrfToken][] = bin2hex(random_bytes(32));
        Session::set(self::$csrfTokenExpires, time() + 3600);
        return Session::get(self::$csrfToken);
    }


    public static function generateActivationCode(){
        return bin2hex(random_bytes(16));
    }


    public static function generateUserToken() :array
    {

        $selector  = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ':' . $validator];
    }

    function parse_token(string $token): ?array
    {
    
        $parts = explode(':', $token);

    if ($parts && count($parts) == 2) {
        return [$parts[0], $parts[1]];
    }
    return null;
}


    public static function confirmCSRFToken(){
        if(Session::exists(self::$csrfToken) && Session::exists(self::$csrfTokenExpires)){
            return true;
        }
        return false;
    }


    public static function confirmCSRFTokenExpire(){
        if(time() < Session::get(self::$csrfTokenExpires)){
            return true;
        }
        //die("token Expired");
        return false;
    }


    public static function checkCSRFToken($token){
        if(!empty($token)){
            if( 
                self::confirmCSRFToken() 
                && in_array($token, Session::get(self::$csrfToken))
            ){
                self::removeCSRFToken();
                return true;
            }
            die("tokens doesn't match");
            return false;
        }
    }


    public static function removeCSRFToken(){
        Session::remove(self::$csrfToken);
        Session::remove(self::$csrfTokenExpires);
    }



}