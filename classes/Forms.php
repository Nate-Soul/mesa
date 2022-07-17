<?php

class Forms{

    public static function isPost()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            return true;
        }
        return false;
    }


    public static function isGet()
    {
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            return true;
        }
        return false;
    }


    public static function postToSelf(int $url = 1){
        $url = ($url == 1) ? $_SERVER["REQUEST_URI"] : $_SERVER["PHP_SELF"];
        return $url;
    }

    public static function assertPost($field){
        if(isset($_POST[$field]) && !empty($_POST[$field])){
            return true;
        }
        return false;
    }

    public static function getPost($field)
    {
        return (self::assertPost($field)) ? $_POST[$field] : null;
    }

    //sticky input fields
    public static function stickyText($field, $safe = 0){
        if(self::assertPost($field)){
            if($safe == 1){
                echo "value=\"".$_POST[$field]."\"";
            } else {
                echo "value=\"".strip_tags($_POST[$field])."\"";
            }
        }
    }

     //sticky input for edits fields
     public static function stickyTextEdit($val, $field){
        if(isset($_POST[$field]) && !empty($_POST[$field])){
            echo "value=\"".strip_tags($_POST[$field])."\"";
        } elseif(!empty($val)){
            echo "value=\"".strip_tags($val)."\"";
        }
    }


    //stick text area fields
    public static function stickyArea($field){
        if(self::assertPost($field)){
            echo strip_tags($_POST[$field]);
        }        
    }


    //stick text area for edits fields
    public static function stickyAreaEdit($val, string $field){
        if(self::assertPost($field))
        {
            echo strip_tags(self::getPost($field));
        } elseif(!empty($val))
        {
            echo strip_tags($val);
        }        
    }

    
    //sticky select
    public static function stickySelect($field, $value){
        if(isset($_POST[$field]) && $_POST[$field] == $value){
            return "selected=\"selected\"";
        }
    }

    //sticky select for edit fields
    public static function stickySelectEdit($field, $oldValue, $newValue){
        if(
            !empty($oldValue) && $oldValue == $newValue 
            || 
            self::assertPost($field) && self::getPost($field) == $newValue
            ){
            return "selected=\"selected\"";
        }
    }


    public static function stickyCheck($field){
        if(isset($_POST[$field]) && self::getPost($field) == "on"){
            return "checked";
        }
    }

    public static function stickyCheckEdit($field, $oldValue){
        if(
            isset($_POST[$field]) 
            && self::getPost($field) == "on" 
            || $oldValue === 1
        ){
            return "checked";
        }
    }

    
    //encrypt password
    public static function encryptPsw($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkIfEmpty(array $array){
        foreach($array as $single){
            if(isset($single) && !empty($single)){
                return true;
            }
            return false;
        }
    }

    public static function isEmail($email){
        if(!empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return false;
            }
            return true;
        }
    }


    public static function equalsTo($param, $check, $strict = false){
        $operator = ($strict === false) ? "==" : "===";
        return ($param." ".$operator." ".$check) ? true : false;
    }

    public static function inRange($min, $max, $minCompare, $maxCompare, $strict = false)
    {
        $minOperator = (!$strict) ? ">" : ">=";
        $maxOperator = (!$strict) ? "<" : "<=";
        return ($minCompare." ".$minOperator." || ". $maxCompare." ".$maxOperator." ".$maxCompare)
        ? true : false;
    }








}