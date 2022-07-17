<?php

require_once("../bootstrap/autoload.php");

$cart = new Cart();

if(Forms::isPost("action") && $_POST["action"] == "add"){

    $product_id  = (int)$_POST["id"];
    $product_qty = (int)$_POST["qty"];
    $object      = array();

    if(!empty($product_id) && is_numeric($product_id)){

        if($cart->add($product_id, $product_qty)){
            $object['items'] = $cart->get_total_items();
        } else {
            $object['error_2'] = "Error: Could not add item(s) to cart";
        }

    }  else {
        $object['error_1'] = "Error: Empty values passed";
     }


     echo json_encode($object);

}


if(Forms::isPost("action") && $_POST["action"] == "remove"){

    $product_id  = (int)$_POST["id"];
    $object      = array();

    if(!empty($product_id) && is_numeric($product_id)){

        if($cart->delete($product_id)){
            $object['items']    = $cart->get_total_items();
            $object['subtotal'] = $cart->get_sub_total();
        } else {
            $object['error_2'] = "Error: Could not delete item(s) from cart";
        }

    }  else {
        $object['error_1'] = "Error: Empty values passed";
     }


     echo json_encode($object);

}

