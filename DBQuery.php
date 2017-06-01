<?php
require_once "DBQueryInterface.php";

class DBQuery implements DBQueryInterface{
  
  private $_db = null;
  private $sqlTime = 0;
  
  public function __construct(\DBConnectionInterface $DBConnection){
    $this->_db = $DBConnection->getPdoInstance();
  }
  public function getDBConnection(): \DBConnectionInterface{
    return $this->_db;
  }
  public function setDBConnection(\DBConnectionInterface $DBConnection){
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
  
  public function queryAll($query, array $params = null): array {
    $stmt=$this->query($query, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function queryRow($query, array $params = null): array {
    $stmt=$this->query($query, $params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function queryColumn($query, array $params = null): array {
    $stmt=$this->query($query, $params);
    
    while ($row = $stmt->fetchColumn()){
      $array [] = $row;
    }
    return $array;
  }
  public function queryScalar($query, array $params = null){
    $stmt=$this->query($query, $params);
    return $stmt->fetchColumn();
  }
  public function execute($query, array $params = null) {
    $stmt=$this->query($query, $params);
    $count = $stmt->rowCount();
    
    return $count;
  }
  public function getLastQueryTime(): float {
    return $this->sqlTime;
  }
  
}