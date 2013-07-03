<?php

$projbasedir = $_SESSION["basedir"];
require_once($projbasedir."/dbinterface/Database.php");
require_once($projbasedir."/utils/ErrorPages.php");


class MySqlDatabase extends Database {

	private $openedConnection; // boolean that is true if $connection is open and false otherwise.
	private $connection;
	private $numberOfConnections; // counter of the number of connects without a close.

	public function __construct($username, $password, $dbname, $host, $port) {
		parent::__construct($username, $password, $dbname, $host, $port);
		$this->openedConnection = false;
		$this->connection = null;
		$this->resetNumberOfConnections();
	}
	
	protected function setConnection($connection) { $this->connection = $connection; }
	public function getConnection() { return $this->connection; }
	
	protected function connectionOpened() { $this->openedConnection = true; }
	protected function connectionClosed() { $this->openedConnection = false; }
	public function getOpenedConnection() { return $this->openedConnection; }
	
	public function getNumberOfConnections() { return $this->numberOfConnections; }
	protected function incrementNumberOfConnections() { $this->numberOfConnections++; }
	protected function decrementNumberOfConnections() { $this->numberOfConnections--; }
	protected function resetNumberOfConnections() { $this->numberOfConnections = 0; }

	/**
	 * Connects to the data base. This function may be called serveral times without closing the connections.
	 * I think the code that uses this class wont run if that isn't allowed.
	 * I think this isn't rigth but I don't know how to do it.
	 */
	public function connect() {
		
		if($_SESSION["debug"] == true)
			echo "<br>[DEBUG] --connect--<br>";
		
		$this->incrementNumberOfConnections();
		if(!$this->getOpenedConnection()) {
			$connection = mysql_connect(
					$this->getHost().":".$this->getPort(),
					$this->getUsername(),
					$this->getPassword());
			$this->setConnection($connection);
		
			if($connection == false) {
				if($_SESSION["debug"] == true)
					echo "[DEBUG] The connection failled!\n";
				
				exit(ErrorPages::databaseErrorPage("Connection to host failed: " . mysql_error()));
			}
		
			$this->select_db();
			$this->connectionOpened();
		}
	}

	public function close_connection() {
		
		if($_SESSION["debug"] == true)
			echo "[DEBUG] closed connection. " . ($this->getNumberOfConnections() - 1) . " connections to go. <br>";
		
		if($this->getNumberOfConnections() <= 1) {
			
			if($_SESSION["debug"] == true)
				echo "[DEBUG] complitly closed<br>";
			
			mysql_close( $this->getConnection() );
			$this->connectionClosed();
			$this->resetNumberOfConnections();
		} else {
			$this->decrementNumberOfConnections();
		}
	}
	
	public function close_all_connections() {
		
		if($_SESSION["debug"] == true)
			echo "[DEBUG] closed all connections <br>";
		
		if($this->getOpenedConnection()) {
			mysql_close( $this->getConnection() );
			$this->connectionClosed();
			$this->resetNumberOfConnections();
		}
	}

	protected function select_db() {
		return mysql_select_db( $this->getDBName() );
	}

	public function query($queryStr) {
		return mysql_query( $queryStr );
	}

	public function num_rows($result) {
		return mysql_num_rows($result);
	}

	public function fetch_array($result) {
		return mysql_fetch_array($result);
	}

	public function fetch_assoc($result) {
		return mysql_fetch_assoc($result);
	}  

	public function start_transaction() {
		mysql_query("SET AUTOCOMMIT=0");
		return mysql_query("START TRANSACTION");
	}

	public function commit() {
		return mysql_query("COMMIT");
	}
	
	public function rollback() {
		return mysql_query("ROLLBACK");
	}

	public function field_name( $result, $indice ) {
		return mysql_field_name($result, $indice);
	}
	
	public function num_fields($result) {
		return mysql_num_fields($result);
	}
	
	public function fetch_row($result) {
		return mysql_fetch_row($result);
	}
	
	public function last_error() {
		return mysql_error();
	}
	
	public function errno() {
		return mysql_errno();
	}
	
	public function real_escape_string($str) {
		return mysql_real_escape_string($str);
	}
}
?>
