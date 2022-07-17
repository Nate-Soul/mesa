<?php


class Delivery extends Connect{

    private $table = "delivery_options";


    public function readAll(){
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `name` ASC";
        return $this->conn->fetchAllData($sql);
    }

    public function read(){
        $sql = "SELECT * FROM `{$this->table}` WHERE `isActive` = TRUE ORDER BY `fee` ASC";
        return $this->conn->fetchAllData($sql);
    }


    public function add(array $data){
        $this->conn->prepareInsertAll($this->table, $data);
        if($this->conn->insertData()){
            return true;
        }
        return false;
    }


    public function update(array $data, $id){
        $this->conn->prepareUpdate($this->table, $data);
        if($this->conn->updateData("id", $id)){
            return true;
        }
        return false;
    }


    public function delete(){
        return '';
    }

    public function getDeliveryById($id)
    {
        if(!empty($id))
        {
            $sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?";
            return $this->conn->fetchData($sql, array($id));                                                                                                                                                                                $this->conn->fetchData($sql, array($id, true));
        }
    }


    
}