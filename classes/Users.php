<?php

class Users extends Connect{


    private $table = "users";


    public function add($data)
    {
        $this->conn->prepareInsert($this->table, $data);
        if($this->conn->insertData())
        {
            return true;
        }
        return false;
    }
    
    public function read()
    {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `registeredAt` DESC";
        return $this->conn->fetchAllData($sql);
    }

    public function update($id, $array){
        if(!empty($id) && !empty($array)){
            $this->conn->prepareUpdate($this->table, $array);
            if($this->conn->updateData("id", $id))
            {
                return true;
            }
            return false;
        }
    }

    public function makeActive($userID){
        if(!empty($userID)){
            $current_time = date("Y-m-d H:i:s", time());
            $array = array("isActive" => 1, "activatedAt" => $current_time);
            $this->conn->prepareUpdate($this->table, $array);
            if($this->conn->updateData("id", $userID)){
                return true;
            }
            return false;
        }
    }

    public function updateLastLogin($userID){
        if(!empty($userID)){
            $today = date("Y-m-d H:i:s", time());
            $array = array("lastLogin" => $today);
            $this->conn->prepareUpdate($this->table, $array);
            if($this->conn->updateData("id", $userID)){
                return true;
            }
            return false;
        }
    }

    public function delete($id){
        if(!empty($id)){
            $sql = "DELETE FROM `{$this->table}` WHERE `id` = ?";
            return ($this->conn->exec($sql, array($id))) ? true : false;
        }
    }

    public function deleteInactiveUser($id)
    {
        if(!empty($id)){
            $sql = "DELETE FROM `{$this->table}` WHERE `isActive` = ? AND `id` = ?";
            return ($this->conn->exec($sql, array(0, $id))) ? true : false;
        }
    }

    public function fetchUserById($id){
        if(!empty($id)){
            $sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?";
            return $this->conn->fetchData($sql, array($id));
        }
    }


    public function fetchUnverifiedUser(string $activationCode, string $email)
    {
        $sql = "SELECT `id`, `activationCode`, `activationExpiry` < NOW() AS expired 
                FROM `{$this->table}` WHERE `isActive` = 0 AND `email` = ?";
        $user = $this->conn->fetchData($sql, array($email));
        if ($user) {
            // already expired, delete the in active user with expired activation code
            if ((int)$user['expired'] === 1) {
                $this->deleteInactiveUser($user['id']);
                return null;
            }
            // verify the password
            if (password_verify($activationCode, $user['activationCode'])) {
                return $user;
            }
        }
        return null;
    }


    public function fetchUserByLogin($login){
        if(!empty($login)){
            $sql = "SELECT * FROM `{$this->table}` WHERE `email` = ?";
            return $this->conn->fetchData($sql, array($login));
        }
    }

    public function fetchUserPassword($userID){
        if(!empty($userID)){
            $user = $this->fetchUserById($userID);
            return $user["password"];
        }
    }

    public function fetchUserAddresses($userID){
        if(!empty($userID)){
            $addressObj = new Addresses();
            return $addressObj->getUserAddresses($userID);
        }
    }


    public function fetchUserOrders($userID){
        if(!empty($userID)){
            $addressObj = new Orders();
            return $addressObj->getUserOrders($userID);
        }
    }


    Public function fetchUserWishlist($userID){
        if(!empty($userID)){
            $wishlistObj = new Wishlist();
            return $wishlistObj->getWishlists($userID);
        }
    } 
    
    public function search(){
        return false;
    }
}