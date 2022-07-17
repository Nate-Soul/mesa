<?php 

class Cookie {

	public static function exists($name) {
		return(!empty($name) && isset($_COOKIE[$name])) ? true : false;
	}

	public static function get($name) {
        if(!empty($name)){
            if(self::exists($name)){
                return $_COOKIE[$name];
            }
            return null;
        }
	}

	public static function set($name, $value, $expiry) {
        if(!empty($name) && !empty($expiry)){
            if(setcookie($name, $value, time() + $expiry, '/')) {
                return true;
            }
            return false;
        }
	}

	public static function delete($name) {
        if(!empty($name) && self::exists($name)){
            unset($_COOKIE[$name]);
            self::set($name, null, time() - 1);
        }
	}

}