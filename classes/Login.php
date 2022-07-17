<?php

class Login{
    
    private $dashboard_url = DASHBOARD_URL;
    private static $user   = "user";
    private static $user_roles = array("User", "Vendor", "Admin");

    public function loginUser($login, $url = null)
    {
        if(!empty($login)){
            $accountObj  = new Users();
            $login_rows  = $accountObj->fetchUserByLogin($login);
            if(!empty($login_rows)){
                //set session for user
                Session::set(self::$user, $login_rows);
                //redirect user to dashboard
                $user_session = Session::get(self::$user);
                //update user's last login and set message
                $accountObj->updateLastLogin($login_rows["id"]);
                $_SESSION["msg"]["success"] = "Welcome Back ".ucfirst($user_session["first_name"]);
                if(empty($url)){
                    Helper::redirectTo(3, $this->dashboard_url."/index.php");
                } else {
                    Helper::redirectTo(3, $url);
                }
                return true;
            }
        }
    }



    public static function isAuthenticated(){
        if(
            Session::exists(self::$user) === true
            && 
            !empty(Session::get(self::$user))
        ){
            return true;
        }
        return false;
    }



    public static function isUser(){
        if(
            Session::exists(self::$user) 
            && Session::get(self::$user)["role"] == self::$user_roles[0]
            ){
            return true;
        } else {
            return false;
        }
    }



    public static function isAuthor()
    {
        if(
            Session::exists(self::$user) 
            && Session::get(self::$user)["role"] == self::$user_roles[1]
            ){
            return true;
        }
        return false;
    }





    public static function isAdmin(){
        if(
            Session::exists(self::$user) 
            && Session::get(self::$user)["role"] == self::$user_roles[2]
            ){
            return true;
        }
        return false;
    }



    public static function isUserOrAuthor(){
        if(self::isUser() || self::isAuthor()){
            return true;
        }
        return false;
    }




    public static function isAdminOrAuthor()
    {
        if(self::isAdmin() || self::isAuthor())
        {
            return true;
        }
        return false;
    }




    public static function restrictVisitors($url = null){
        if(!self::isAuthenticated()){
            $_SESSION["msg"]["warning"] = "You must login first";
            if(!empty($url)){
                Helper::redirectTo(3, SITE_URL."/login.php?next_page=".$url);
            } else {
                Helper::redirectTo(3, SITE_URL."/login.php");
            }
        }
    }




    public static function restrictUsers()
    {
        if(self::isUser() && !self::isAdminOrAuthor()){
            $_SESSION["msg"]["warning"] = "You need authorization to access this page";
            Helper::redirectTo(3, "index.php");
        } elseif(!self::isAuthenticated()) {
            Helper::redirectTo(3, SITE_URL);
        }
    }




    public static function restrictVendors($url = null)
    {
        if(self::isUserOrAuthor()){
            $_SESSION["msg"]["warning"] = "You need Administrative rights to access this page";
            Helper::redirectTo(3, "index.php");
        } else if(!self::isAuthenticated()){
            Helper::redirectTo(3, SITE_URL);
        }
    }




    public static function logout(){
        if(Session::exists(self::$user)){
            Session::remove(self::$user);
            $_SESSION["msg"]["warning"] = "You're logged out";
            Helper::redirectTo(3, SITE_URL."/login.php");
        }
    }


}