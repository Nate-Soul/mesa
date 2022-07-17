<?php


class Url{


    public static function getParam($param)
    {
        return (isset($_GET[$param]) 
                && !empty($_GET[$param])) 
                ? $_GET[$param] : null;
    }
    

    public static function getRefererUrl($referer = "next_page")
    {
        if(!empty(self::getParam($referer))){
            return self::getParam($referer);
        }
    }


}