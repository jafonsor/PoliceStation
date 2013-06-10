<?php

class MySqlDatabase extends Database {

	private $openConnection; // boolean that is true if $connection is open and false otherwise.
	private $connection;

	public __construct($username, $password, $dbname, $host, $port) {
	parent::__construct($username, $password, $dbname, $host, $port);
	}
	
	protected setConnection($connection) { $this->connection = $connection; }
	protected getConnection() { return $this->connection; }
	
	protected connectionOpened() { $this->openConnection = true; }
	protected connectionClosed() { $this->openConnection = false; }
	public getOpenConnection() { return $this->openConnection; }

	/**
	 * Connects to the data base. This function may be called serveral times without closing the connections.
	 * I think the code that uses this class wont run if that isn't allowed.
	 * I think this isn't rigth but I don't know how to do it.
	 */
	public function connect() {
		$connection = mysql_connect(getHost().":".getPort(), getUsername(), getPassword()) );
		if($connection == false) {
			ErrorLog::log("database",__DIR__.__FILE__,__LINE__,"failed to connect to server: " . getHost().":".getPort());
		}
		select_db();
		connectionOpened();
	}

	public abstract function close_connection() {
		mysql_close_connection( getConnection() );
		connectionClosed();
	}

	protected function select_db() {
		return mysql_select_db( $this->dbname );
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

	public abstract function start_transaction() {
		return mysql_start_transaction();
	}

	public abstract function commit() {
		return mysql_commit();
	}

}
?>
