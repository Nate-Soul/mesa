<?php


class Countries extends Connect{


    private $table = "countries";

    public function read(){
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `name` ASC";
        return $this->conn->fetchAllData($sql);
    }

    public function insert(array $array){
        $this->conn->prepareInsert($this->table, $array);
        if($this->conn->insertData()){
            return true;
        }
        return false;
    }

    public function getCountryById($id){
        if(!empty($id)){
            $sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?";
            return $this->conn->fetchData($sql, array($id));
        }
    }


    public function getCountriesSelect($record = null){
        $countries = $this->read();
        if(!empty($countries)){
            $countrySelect  = "<select name=\"country\" class=\"form-select\" id=\"id_country\">";
            $countrySelect .= "<optgroup>";
            $countrySelect .= "<option value=\"\">Select Country&hellip;</option>";
        }
        foreach($countries as $country){
            $countrySelect .= "<option value=\"";
            $countrySelect .= $country['code'];
            $countrySelect .= "\"";
            $countrySelect .= (empty($record)) ? Forms::stickySelect('country', $country['code']) : Forms::stickySelectEdit('country', $record, $country['code']);
            $countrySelect .= ">";
            $countrySelect .= $country['name'];
            $countrySelect .= "</option>";
        }
        $countrySelect .= "</optgroup>";
        $countrySelect .= "</select>";
        return $countrySelect;
    }


}