<?php

class PostgresDatabase extends Database {
  public function connect(){ }
  public function close_connection(){ }
  public function close_all_connections(){ }
  protected function select_db(){ }
  public function query($queryStr){ }
  public function num_rows($result){ }
  public function fetch_array($result){ }
  public function fetch_assoc($result){ }
  public function start_transaction(){ }
  public function commit(){ }
  public function rollback(){ }
  public function field_name($result, $indice){ }
  public function num_fields($result){ }
  public function fetch_row($result){ }
  public function last_error(){ }
  public function errno(){ }
  public function real_escape_string($str){ }
}
?>
