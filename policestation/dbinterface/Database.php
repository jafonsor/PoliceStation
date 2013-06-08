<?php

//interface to access the database.
abstract class Database {

  private $username;

  private $password;

  private $dbname;

  private $host;

  private $port;
  
  private $connection;

  public abstract function connect();
  public abstract function close_connection();
  public abstract function select_db($dbname);
  public abstract function query($queryStr);
  public abstract function num_rows($cursor);
  public abstract function fetch_array($cursor);
  public abstract function start_transaction();
  public abstract function commit();
}
?>
