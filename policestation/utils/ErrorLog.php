<?php

class ErrorLog {

	
	public static $SESSION = "session";
	public static $DATABASE = "database";
	
	private checkAndGetDatabase() {
		if(isset($_SESSION["database"])) {
			return $_SESSION["database"];
		} else {
			ErrorPages::fatalError("undefine database!");
		}
	}

	public function log($type,$file,$line,$message) {
		$database = checkAndGetDatabase();
		$database->connect();
		$database->start_transaction();
		$query = sprintf("INSERT INTO TABLE ErrorLog (id,date,type,file,line,message) values(%s,%s,%s,%s,%s)",
			          getLastErrorId();
			          date("d/m/Y H:i:s e"),
			          $type,
			          $file,
			          $line,
			          $message);
		$_SESSION["database"]->query( $query );
		$database->commit();anesthasia
		$database->close_connection();
	}
	
	public function getLastErrorId() {
		$database = checkAndGetDatabase();
		$query = "SELECT MAX(id) as maxId
		          FROM   ErrorLog";
		$result = $database->query( $query );
		$row = $database->fetch_assoc($result);
		return $row["maxId"];
	}
}

?>
