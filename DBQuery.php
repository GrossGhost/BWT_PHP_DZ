<?php
class DBQuery{
  
  private $_db = null;
  private $sqlTime = 0;
  
  public function __construct($DBConnection){
    $this->_db = $DBConnection;
  }
  public function getDBConnection(){
    return $this->_db;
  }
  public function setDBConnection($DBConnection){
    $this->_db = $DBConnection;
  }
  
  public function query($query, $params = null){
    try{
      $time_start = microtime(true);
      $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $stmt->execute($params);
      $time_end = microtime(true);
      $this->sqlTime = $time_end - $time_start;
      return $stmt;
    }catch(PDOException  $e){
      echo "Error: ".$e;
      return false;
    }
  }
  
  public function queryAll($query, $params = null){
    $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $time_start = microtime(true);
    $stmt->execute($params);
    $time_end = microtime(true);
    
    $this->sqlTime = $time_end - $time_start;
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function queryRow($query, array $params = null){
    $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $time_start = microtime(true);
    $stmt->execute($params);
    $time_end = microtime(true);
    
    $this->sqlTime = $time_end - $time_start;
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function queryColumn($query, array $params = null){
    $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $time_start = microtime(true);
    $stmt->execute($params);
    $time_end = microtime(true);
    
    $this->sqlTime = $time_end - $time_start;
    
    while ($row = $stmt->fetchColumn()){
      $array [] = $row;
    }
    return $array;
  }
  public function queryScalar($query, array $params = null){
    $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $time_start = microtime(true);
    $stmt->execute($params);
    $time_end = microtime(true);
    
    $this->sqlTime = $time_end - $time_start;
    return $stmt->fetchColumn();
  }
  public function execute($query, array $params = null){
    $stmt = $this->_db->prepare($query,  array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
    $time_start = microtime(true);
    $result = $stmt->execute($params);
    $time_end = microtime(true);
    
    $this->sqlTime = $time_end - $time_start;
    return $result;
  }
  public function getLastQueryTime(){
    return $this->sqlTime;
  }
  
}