<?php


CONST SITE_NAME = "Mesa";

$url = $_SERVER["REQUEST_URI"];
$url = explode("/", $url);
$url = $url[1];

$link = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" 
? "https://" : "http://").$_SERVER["SERVER_NAME"]."/".$url;

#SITE URL
define("SITE_URL", $link);

#BASE DIRECTORY dirname(__FILE__)
define("BASE_DIR", dirname(__FILE__, 2));

#DIRECTORY SEPARATOR
define("DS", DIRECTORY_SEPARATOR);

#MEDIA DIRECTORY
define("MEDIA_DIR", BASE_DIR.DS."media");

#ACCOUNT DIRECTORY
define("ACCOUNT_DIR", BASE_DIR.DS."account");

#CLASSES DIRECTORY
define("CLASSES_DIR", BASE_DIR.DS."classes");

#INCLUDES DIRECTORY
define("INCLUDES_DIR", BASE_DIR.DS."includes");
#EMAILS DIRECTORY
define("EMAILS_DIR", INCLUDES_DIR.DS."emails");

#MODULES DIRECTORY
define("MODULES_DIR", BASE_DIR.DS."modules");

#TEMPLATES DIRECTORY
define("LAYOUTS_DIR", BASE_DIR.DS."layouts");

#IMAGES DIRECTORY
define("IMAGES_DIR", MEDIA_DIR.DS."images");
#PRODUCTS DIRECTORY
define("PRODUCTS_DIR", IMAGES_DIR.DS."products");
#AVATARS DIRECTORY
define("AVATARS_DIR", IMAGES_DIR.DS."avatars");
#STATIC DIRECTORY

define("STATIC_FILES_DIR", BASE_DIR.DS."static");
#STATIC/ASSETS DIRECTORY
define("ASSETS_FILES_DIR", STATIC_FILES_DIR.DS."assets");
#STATIC/VENDOR DIRECTORY
define("VENDOR_FILES_DIR", STATIC_FILES_DIR.DS."vendor");

// URLS

#ASSETS FILES URL
if(file_exists(STATIC_FILES_DIR)){
    define("STATIC_FILES_URL", SITE_URL."/static");
}
if(file_exists(ASSETS_FILES_DIR)){
    define("ASSETS_FILES_URL", STATIC_FILES_URL."/assets");
}
if(file_exists(VENDOR_FILES_DIR)){
    define("VENDOR_FILES_URL", STATIC_FILES_URL."/vendor");
}

#PRODUCT IMAGES URL
if(file_exists(IMAGES_DIR)){
    define("IMAGES_URL", SITE_URL."/media/images");
}
if(file_exists(PRODUCTS_DIR)){
    define("PRODUCTS_URL", IMAGES_URL."/products");
}
if(file_exists(AVATARS_DIR)){
    define("AVATARS_URL", IMAGES_URL."/avatars");
}

#MODULES URL
if(file_exists(MODULES_DIR)){
    define("MODULES_URL", SITE_URL."/modules");
}

#DASHBOARD DIRECTORY
if(file_exists(ACCOUNT_DIR)){
    define("DASHBOARD_URL", SITE_URL."/account");
}

?>