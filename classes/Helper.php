<?php

class Helper{


    
    //error message handler
    public static function displayErrors($errors){
        if(isset($errors) && !empty($errors) === true){
            if(is_array($errors)){
                foreach($errors as $err){
                    echo "<div class=\"alert alert-danger alert-dismissible\">";
                    echo $err;
                    echo "</div>";
                }
            } else {
                echo "<div class=\"alert alert-danger\">";
                echo $errors;
                echo "</div>";
            }
        }
    }

    //success message handler
    public static function displaySuccesses($successes){
        if(isset($successes) && !empty($successes)){
            if(is_array($successes)){
                foreach($successes as $success){
                    echo "<div class=\"alert alert-success\">";
                    echo $success;
                    echo "</div>";
                }
            } else {
                echo "<div class=\"alert alert-success\">";
                echo $successes;
                echo "</div>";
            }
        }
    }
	
    public static function displayWarnings($warnings){
        if(isset($warnings) && !empty($warnings)){
            if(is_array($warnings)){
                foreach($warnings as $warning){
                    echo "<div class=\"alert alert-warning\">";
                    echo $warning;
                    echo "</div>";
                }
            } else {
                echo "<div class=\"alert alert-warning\">";
                echo $warnings;
                echo "</div>";
            }
        }
    }
	


    public static function displayMessages($message){
        if(isset($message) && !empty($message)){
            if(isset($message["success"])){
                $msg_success = $message["success"];
                self::displaySuccesses($msg_success);
            } elseif(isset($message["error"])){
                $msg_error = $message["error"];
                self::displayErrors($msg_error);
            } elseif(isset($message["warning"])){
                $msg_warning = $message["warning"];
                self::displayWarnings($msg_warning);
            }
            Session::remove("msg");
        }
    }
	

    //search array
	public static function ArraySearch($array, $field, $search){
        $found = array();
        if(is_array($array) && count($array) > 0){
            for($i = 0; $i<count($array); $i++){
                if(is_array($array[$i]) && count($array[$i])>0){ 
                    if($array[$i][$field] == $search){
                        $found[] = $array[$i];
                    }
                }
            }
        }
        if(count($found) != 0){
            return $found;
        } else {
            return null;
        }
    }
	

    //search array
	/*public static function searchArray($array, $key, $value){
		$found = array();
        if(is_array($array) && count($array) > 0){
            if(isset($array[$key]) && $array[$key] == $value){
                $found[] = $array;
            } else {
                foreach($array as $subarray){
                    $new_array = Helper::searchArray($subarray, $key, $value);
                    $found = array_merge($found, $new_array);
                }
            }
        }
        if(count($found) != 0){
            return $found;
        }
        return false;
	}*/
    

    //redirect
    public static function redirectTo($action, $url = null){
        switch($action){
            case 1:
                return header("refresh:2 ".$url);
                break;
            case 2:
                return header("refresh:2 ".$_SERVER["PHP_SELF"]);
                break;
            case 3:
                return header("location: ".$url);
                break;
        }
    }
	
	public static function slugify(string $string, $delimiter = "-"){
		if(!empty($string)){
            $unwanted_keywords = array(" and ");
            $slug   = strip_tags(trim($string));
            $slug   = preg_replace("/[^a-zA-Z0-9\s-]/", "", $string);
            $slug   = str_replace($unwanted_keywords, "", $slug);
            $slug   = str_replace(" ", $delimiter, $slug);
            $slug   = preg_replace("~-+~", $delimiter, $slug);
            $slug   = trim($slug, $delimiter);
			$slug   = strtolower($slug);
            return $slug;
		}		
	}
    
    
    public static function truncateText($string, $len = 200) {
        if (strlen($string) > $len) {
            $string = trim(substr($string, 0, $len));
            $string = substr($string, 0, strrpos($string, " "))."&hellip;";
        } else {
            $string .= "&hellip;";
        }
        return $string;
    }



	
	
}