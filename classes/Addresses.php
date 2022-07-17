<?php

class Addresses extends Connect{

    private $table   = "addresses";
    private $tableID = "id";

    public function create(array $array){
        $this->conn->prepareInsertAll($this->table, $array);
        if($this->conn->insertData()){
            return true;
        } 
        return false;
    }

    public function read(){
        $sql = "SELECT * FROM `{$this->table}`";
        return $this->conn->fetchAllData($sql);
    }

    public function updateUserAddress($addressID, array $values){
        $this->conn->prepareUpdate($this->table, $values);
        if($this->conn->updateData($this->tableID, $addressID)){
            return true;
        }
        return false;
    }


    public function unsetUserDefaultAddress($userID){
        if(!empty($userID)){
            $sql   = "UPDATE `{$this->table}` SET `isDefault` = ? WHERE `userId` = ?";
            if($this->conn->exec($sql, array(false, $userID))){
                return true;
            }
            return false;
        }
    }

    public function setUserDefaultAddress($addressID, $userID){
        if(!empty($userID) && !empty($addressID)){
            $sql   = "UPDATE `{$this->table}` SET `isDefault` = ? WHERE `{$this->tableID}` = ? AND `userId` = ?";
            if($this->conn->exec($sql, array(true, $addressID, $userID))){
                return true;
            }
            return false;
        }
    }


    public function deleteUserAddress($addressID, $userID){
        if(!empty($userID) && !empty($addressID)){
            $sql = "DELETE FROM `{$this->table}` WHERE `{$this->tableID}` = ? AND `userId` = ?";
            if($this->conn->exec($sql, array($addressID, $userID))){
                return true;
            }
            return false;
        }
    }

    public function deleteUserAddresses($userID){
        if(!empty($userID)){
            $sql = "DELETE FROM `{$this->table}` WHERE `userId` = ?";
            if($this->conn->exec($sql, array($userID))){
                return true;
            }
            return false;
        }
    }


    public function getUserAddresses($userID){
        if(!empty($userID)){
            $sql = "
                SELECT address.*, country.* 
                    FROM `{$this->table}` AS address
                    INNER JOIN `countries` AS country
                    ON `address`.`countryCode` = `country`.`code`
                    WHERE `address`.`userId` = ?
                    ORDER BY `isDefault` DESC
            ";
            $user_addresses = $this->conn->fetchData($sql, array($userID), false);
            return $user_addresses;
        }
    }



    public function getUserAddressesCount($userID)
    {
        if(!empty($userID)){
            return count($this->getUserAddresses($userID));
        }
    }

    public function getUserAddressById($addressID, $userID){
        if(!empty($addressID) && !empty($userID)){
            $sql = "SELECT address.*, country.* 
                        FROM `{$this->table}` AS address
                        INNER JOIN `countries` AS country
                        ON `address`.`countryCode` = `country`.`code`
                        WHERE `address`.`userId` = ? AND `address`.`id` = ?
                        ORDER BY `isDefault` DESC";
        }
        $user_addresses = $this->conn->fetchData($sql, array($userID, $addressID));
        return $user_addresses;
    }

    public function getUserDefaultAddress($userID){
        if(!empty($userID)){
            $sql = "
                SELECT address.*, country.* 
                    FROM `{$this->table}` AS address
                    INNER JOIN `countries` AS country
                    ON `address`.`countryCode` = `country`.`code`
                    WHERE `address`.`userId` = ? AND `address`.`isDefault` = true
            ";
            $user_default_address = $this->conn->fetchData($sql, array($userID));
            return $user_default_address;
        }
    }


    public function getAddressesCount()
    {
        return count($this->read());
    }


}