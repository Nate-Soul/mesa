<?php


// generate CSRF TOKEN input fields
function csrf_token(string $name = "token"){
    $csrf_token = Token::generateCSRFToken();
    return "<input type=\"hidden\" name=\"{$name}\" value=\"{$csrf_token[0]}\">";
}

//Used to check pages
function isPage(string $pageName){
    if(!empty($pageName)){
        $get_current_page = trim(htmlentities($_SERVER["PHP_SELF"]));
        $get_current_page = explode("/", $get_current_page);
        $get_current_page = trim(str_replace(".php", "", $get_current_page[count($get_current_page) - 1]));
        return ($get_current_page == $pageName) ? true : false;
    }
}

