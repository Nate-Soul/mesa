<?php

require_once("../bootstrap/autoload.php");

$deliveryObj = new Delivery();
$cartObj     = new Cart();


if(Forms::isPost("action") && $_POST["action"] == "post")
{
    $response = array();

    $delivery_option = (int)$_POST["delivery_option"];
    if(!empty($delivery_option) && is_numeric($delivery_option))
    {
        $delivery_type = $deliveryObj->getDeliveryById($delivery_option);
        if (!isset($_SESSION["purchase"]))
        {
            Session::setSession("purchase", array(
                    "delivery_id" => $delivery_type["id"]
                )
            );
        } else {
            unset(Session::getSession("purchase")["delivery_id"]);
            $_SESSION["purchase"]["delivery_id"] = $delivery_type["id"];
        }

        $response["final_price"]  = $cartObj->get_final_price();
        $response["delivery_fee"] = $delivery_type["fee"];

    } else {
        $response["error"] = "Empty Values parsed";
    }

    echo json_encode($response);

}

?>