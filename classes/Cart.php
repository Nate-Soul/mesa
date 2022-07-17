<?php


class Cart{

    public $cart_name = "cart";
    private $productObj;



    public function __construct()
    {
        if(!isset($_SESSION[$this->cart_name]))
        {
            Session::set($this->cart_name, []);
        }
        $this->productObj  = new Products();
        $this->deliveryObj = new Delivery();
    }



    public function add(int $id, int $qty=1)
    {
        if(!empty($id) && is_numeric($id) && is_numeric($qty)){
            if(isset($_SESSION[$this->cart_name][$id])){
                if($this->update($id, $qty)){
                    return true;
                }
            } else {
                $product = $this->productObj->getProduct($id);
                $_SESSION[$this->cart_name][$id]["qty"] = $qty;
                $_SESSION[$this->cart_name][$id]["total"] = $qty * $product["price"];
                return true;
            }
        }else {
            throw new Exception("No push to cart");
        }
    }


    public function update(int $id, int $qty){
        if(!empty($id) && is_numeric($id)){
            $product = $this->productObj->getProduct($id);
            $_SESSION[$this->cart_name][$id]["qty"] = $qty;
            $_SESSION[$this->cart_name][$id]["total"] = $qty * $product["price"];
            return true;
        }
    }



    public function delete(int $id)
    {
        if(!empty($id) && is_numeric($id))
        {
            unset($_SESSION[$this->cart_name][$id]);
            return true;
        }
    }



    public function get_total_items()
    {
        $value = 0;
        $cart_items = Session::get($this->cart_name);
        if($cart_items){
            foreach($cart_items as $key => $basket){
                $value += $basket['qty'];
            }
        }
        return floatval($value);
    }


    public function isEmpty()
    {
        if(!$this->get_total_items()){
            return true;
        }
        return false;
    }



    public function get_sub_total()
    {
        $value = 0;
        $cart_items = Session::get($this->cart_name);
        foreach($cart_items as $key => $basket){
            $value += $basket['total'];
        }

        return floatval($value);
    }


    public function get_delivery_fee()
    {
        $delivery_fee = 0;
        if(isset($_SESSION["purchase"]))
        {
            $delivery_id  = (int)Session::get("purchase")["delivery_id"];
            $delivery     = $this->deliveryObj->getDeliveryById($delivery_id);
            $delivery_fee = $delivery["fee"];
        }
        return $delivery_fee;
    }



    public function get_final_price()
    {
        $shipping = $this->get_delivery_fee();
        $subtotal = $this->get_sub_total();

        return (float) $shipping + $subtotal;
    }



    public function getCartItems()
    {
        $item = array();
        $cart_items = Session::get($this->cart_name);
        //$cart_items = $_SESSION[$this->cart_name];
        foreach($cart_items as $key => $basket){
            $item[$key] = $this->productObj->getProduct($key);
        }
        return $item;
    }



    public function clear(){
        Session::remove($this->cart_name);
        Session::remove("address");
        Session::remove("purchase");
    }
}