<?php
require_once "DBConnectionInterface.php";

class DB implements DBConnectionInterface{
  
  private static $_db = null;
  private $_pdo = null;
  private $_dsn = null;
  private $_username = null;
  private $_password = null;

  private function __construct($dsn, $username, $password)  {
    $this->_dsn = $dsn;
    $this->_username = $username;
    $this->_password = $password;
    $this->_pdo = new PDO($dsn, $username, $password);
    
  }
  
  private function __clone()      { }
  private function __wakeup()     { }
    
  public function close() {
    self::$_db = $this->_dsn = $this->_username = $this->_password = null;
  }

  public function getAttribute($attribute) {
    return $this->_pdo->getAttribute($attribute);
  }

  public function getLastInsertID($sequenceName = ''): string {
    return $this->_pdo->lastInsertId($sequenceName);
  }

  public function getPdoInstance(): \PDO {
    return $this->_pdo;
  }

  public function reconnect() {
    self::$_db = null;
    self::connect($this->_dsn, $this->_username, $this->_password);
  }

  public function setAttribute($attribute, $value): bool {
    return $this->_pdo->setAttribute($attribute,$value);
  }

  public static function connect($dsn, $username = '', $password = '') {
    if (self::$_db === null){   
      
      try {
       self::$_db = new DB($dsn, $username, $password);
       echo '<br>Connected<br>';
         
      } catch (PDOException $e) {
          echo '<br>Connection is broken<br>' . $e->getMessage();
        }
      }
      
    return self::$_db; 
  }

}
  
  
  
