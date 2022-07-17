<?php

require_once("./bootstrap/autoload.php");

if(Forms::isGet()){
    $email = Url::getParam("email");
    $hash  = Url::getParam("activation_code");

    if(!Forms::checkIfEmpty(array($email, $hash)))
    {
        $_SESSION["msg"]["errors"] = "Empty parameters passed";
        Helper::redirectTo(3, SITE_URL."/register.php");
    } else {
        if(!Forms::isEmail($email)){
            echo "invalid email address passed";
        } else {
            $accountObj = new Users();
            $user = $accountObj->fetchUnverifiedUser($hash, $email);
            if($user && (int)$user["isActive"] === 0)
            {
                if($accountObj->makeActive($user["id"])){
                    $_SESSION["msg"]["success"] = "Your account has been successfully activated! login here";
                    Helper::redirectTo(3, SITE_URL."/login.php");
                } else {
                    $_SESSION["msg"]["error"] = "Invalid activation link! please register again.";
                    Helper::redirectTo(3, SITE_URL."/register.php");
                }
            } else {
                $_SESSION["msg"]["error"] = "Your account was already activated, please contact administrator if you have any challenges";
                Helper::redirectTo(3, SITE_URL."/login.php");
            }
        }
    }


} else {
    Helper::redirectTo(3, SITE_URL."/register.php");
}

?>