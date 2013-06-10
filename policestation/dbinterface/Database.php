<?php

//interface to access the database.
abstract class Database {

  private $username;

  private $password;

  private $dbname;

  private $host;

  private $port;s
  
  public __construct($username, $password, $dbname, $host, $port) {
  	$this->username = $username;
  	$this->password = $password;
  	$this->dbname = $dbname;
  	$this->host = $host;
  	$this->port = $port;
  }
  
  public function setUsername( $username ) { $this->username = $username; }
  public function getUsername() { return $this->username; }
  public function setPassword( $password ) { $this->password = $password; }
  public function getPassword() { return $this->password; }
  public function setDBName( $dbname ) { $this->dbname = $dbname; }
  public function getDBName() { return $this->dbname; }
  public function setHost( $host ) { $this->host = $host; }
  public function getHost() { return $this->host; }
  public function setPort( $port ) { return $this->port; }
  public function getPort() { return $this->port; }

  public abstract function connect();
  public abstract function close_connection();
  protected abstract function select_db($dbname);
  public abstract function query($queryStr);
  public abstract function num_rows($result);
  public abstract function fetch_array($result);
  public abstract function fetch_assoc($result);
  public abstract function start_transaction();
  public abstract function commit();
}
?>
