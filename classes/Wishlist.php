<?php

class Wishlist{

    public function getWishlists($userID){
        if(!empty($userID)){
            return array(0 => 
                array(
                    "id" => 1,
                    "product_id" => 1,
                    "user_id" => 1
                ),
                array(
                    "id" => 2,
                    "product_id" => 2,
                    "user_id" => 1
                ),
                array(
                    "id" => 3,
                    "product_id" => 2,
                    "user_id" => 1
                )
            );
        }
    }
}