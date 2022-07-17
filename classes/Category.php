<?php


class Category extends Connect{


    private $table = "categories";


    public function add($array){
        if(count($array) > 0){
            $this->conn->prepareInsertAll($this->table, $array);
            if($this->conn->insertData()){
                return true;
            }
            return false;
        }
    }

    public function read(){
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `title` ASC";
        return $this->conn->fetchAllData($sql);
    }

    public function getCategoryBySlug($slug){
        if(!empty($slug)){
            $categories = $this->read();
            $category  = Helper::ArraySearch($categories, "slug", $slug);
            if(!empty($category)){
                $category  = array_shift($category);
                return $category;
            }
            return null;
        }
    }

    public function update($slug, array $array){
        $this->conn->prepareUpdate($this->table, $array);
        if($this->conn->updateData("slug", $slug)){
            return true;
        }
        return false;
    }

    public function delete($slug){
        $sql = "DELETE FROM `{$this->table}` WHERE `slug` = ?";
        if($this->conn->exec($sql, array($slug))){
            return true;
        }
    }



}