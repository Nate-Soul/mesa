<?php

session_start();
require_once("config.php");

spl_autoload_register("loadClasses");

// Autoload Core Libraries
function loadClasses($className) {
    //class directories
    $path = CLASSES_DIR."/";
    if(file_exists($path.$className.".php")){
        require_once ($path.$className.".php");
    }
}

require_once("functions.php");

$cartObj = new Cart();
$categoryObj = new Category(); 

?>