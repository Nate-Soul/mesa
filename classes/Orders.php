<?php

class Orders{

    private $table = "orders";

    public function read(){
        return array(0 => 
            array(
                "id" => "6VM63032PT0183052",
                "user_id" => 1,
                "address_1" => "1024 Abram Street"
            ),
            array(
                "id" => "9MP091321Y593990Y",
                "user_id" => 2,
                "address_1" => "802 Qatar Close"
            ),
            array(
                "id" => "1C03849507211850H",
                "user_id" => 3,
                "address_1" => "10238 Qatar Close"
            )
        );
    }

    public function getUserOrders($userID){
        if(!empty($userID)){
            $orders = $this->read();
            $userOrders  = Helper::ArraySearch($orders, "user_id", $userID);
            if(!empty($userOrders)){
                return $userOrders;
            }
        }
    }




}