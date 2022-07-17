<?php


class Controller{

  //database credentials
  private $_host        =  "localhost";
  private $_user        =  "root";
  private $_psw         =  "";
  private $_dbName      =  "mesa";
  private $_dbEngine    =  "mysql:host";
  private $_dbCharset   = "utf8";
  protected $db;
	protected $stmt;
  private $insert_keys   = array();
  private $insert_values = array();
	private $insert_table  = null;
	private $update_table  = null;
  private $update_keys   = array();
  private $update_values = array();
	private $update_sets   = array();
  public $error          = "";
  public $lastID         = null;
    

	//initialize connection	
  public function __construct(){
    $this->connect();
  }


  //connect to the database
  public function connect(){
    try{
      $this->db = new PDO($this->_dbEngine.".=".$this->_host.";dbname=".$this->_dbName, $this->_user, $this->_psw);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  //START TRANSACTION
  public function start(){
    $this->db->beginTransaction();
  }

  //END TRANSACTION
  public function end(bool $pass = true){
    if($pass){
      $this->db->commit();
    } else {
      $this->db->rollBack();
    }
  }

  //LAST INSERT ID
  public function lastInsertedID(){
    $this->lastID = $this->db->lastInsertId();
  }

  //PREPARE AND EXECUTE
  public function exec($sql, array $values = null){
		if(!empty($sql) && !empty($values)){
    try{
      $this->stmt = $this->db->prepare($sql);
      $this->stmt->execute($values);
      return true;
      $this->stmt = null;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
      return false;
		}
	}
  
  //GET ROW COUNT
	public function fetchRows($sql = null){
		if(!empty($sql)){		
			$this->stmt = $this->db->query($sql);
			return $this->stmt->rowCount();
			$this->stmt = null;
		}
		return false;
	}

  public function fetchAllData($sql = null){
		if(!empty($sql)){
			$this->stmt = $this->db->query($sql);
			return $this->stmt->fetchAll();
			$this->stmt = null;
		}
	}

  public function fetchData(string $sql, array $values, bool $one = true)
  {
    $output = array();
    if(!empty($sql) && !empty($values))
    {
      $this->stmt = $this->db->prepare($sql);
			if($this->stmt)
      {
        $this->stmt->execute($values);
        while($rows = $this->stmt->fetch()){
          $output[] = $rows;
        }
      }
      return ($one) ? array_shift($output) : $output;
      $this->stmt = null;
    }
  }

  //FETCH TABLE COLUMN NAMES
  public function fetchTableCols($table = null){
		if(!empty($table)){
			$sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS`
					WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?";
					return $this->fetchData($sql, array($this->_dbName, $table), false);
		}
		return null;
	}



  /* ===============================================================================
  | ---------------------------- CRUD FUNCTIONS ------------------------------- | 
  ================================================================================= */
	
  public function prepareInsert(string $table, array $array){
    if (!empty($array) && !empty($table))
    {
        foreach($array as $key => $value) {
            $this->insert_keys[] = $key;
            $this->insert_values[] = $value;
        }
        $this->insert_table =$table;
    }
}

  public function prepareInsertAll(string $table = null, array $array = null){
    $array_keys = array();
    if(!empty($array) && is_array($array_keys)){
      $array_one   = $this->fetchTableCols($table);
      foreach($array_one as $subArray){
        $array_keys[] = $subArray['COLUMN_NAME'];
      }
      array_shift($array_keys);
      $newArray = array_combine($array_keys, $array);
      foreach($newArray as $key => $value){
        $this->insert_keys[] 	 = $key;
        $this->insert_values[]   = $value;
      }
      $this->insert_table = $table;
    }
  }


  public function insertData(){
    if (
      !empty($this->insert_table) && 
      !empty($this->insert_keys) && 
      !empty($this->insert_values)
    ) {
      $sql  = "INSERT INTO `{$this->insert_table}` (`";
      $sql .= implode("`, `", $this->insert_keys);
      $sql .= "`) VALUES (:";
      $sql .= implode(", :", $this->insert_keys);
      $sql .= ")";
      //prepare, bind and execute
      $array_one   = ":".implode(", :", $this->insert_keys);
      $array_keys  = explode(", ", $array_one);
      $values      = array_combine($array_keys, $this->insert_values);
      $res         = $this->exec($sql, $values);
      if($res){
        return true;
      }
      return false;
    }
  }

  
//prepare update
public function prepareUpdate(string $table = null, array $array = null)
{
  if (
    !empty($array) &&
    !empty($table)
    ){
      foreach($array as $key => $value) {
        $this->update_sets[]   = "`{$key}` = :".$key."";
        $this->update_keys[]   = $key;
        $this->update_values[] = $value;
      }
      $this->update_table = $table;
    }
  }

  
	//update data for all fields
	public function updateData($table_id = null, $id = null) {
		if (
			!empty($this->update_table) && 
			!empty($id) && 
			!empty($this->update_sets) && 
			!empty($this->update_keys) && 
			!empty($table_id) && 
			!empty($this->update_values)
			) {
				//prepare update statement	
				$sql  = "UPDATE `{$this->update_table}` SET ";
				$sql .= implode(", ", $this->update_sets);
				$sql .= " WHERE `{$table_id}` = :id";
				//prepare, bind and execute
				$array_one     = ":".implode(", :", $this->update_keys);
				$array_keys    = explode(", ", $array_one);
				$values        = array_combine($this->update_keys, $this->update_values);
				$values[':id'] = $id;
				if($this->exec($sql, $values))
        {
          return true;
        }
        return false;
		}
	}



  public function throwMessages(){
    if(!empty($this->error))
    {
      Helper::displayErrors($this->error);
    }
  }

  //destroy class and close database connection
	public function __destruct()
  {
		if($this->stmt != null && $this->db != null){
			$this->db   = null;
			$this->stmt	= null;
		}			
	}

}