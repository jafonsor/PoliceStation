<?php

//interface to access the database.
abstract class Database {
  public abstract function connect($host, $username, $password);
  public abstract function select_db($dbname);
  public abstract function query($queryStr);
  public abstract function num_rows($cursor);
  public abstract function fetch_array($cursor);
  private $username;

  private $password;

  private $dbname;

  private $host;

  private $port;

}
?>
