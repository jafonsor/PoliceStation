<?php

$projbasedir = $_SESSION["basedir"];
$ERROR_LOG_EXCEPTION_PHP =
	realpath($projbasedir."/exception/ErrorLogException.php");
require_once($ERROR_LOG_EXCEPTION_PHP);

class ErrorLog {
	
	private static function checkAndGetDatabase() {
		if(isset($_SESSION["database"])) {
			return $_SESSION["database"];
		} else {
			exit(ErrorPages::fatalError("can't log!"));
		}
	}
	
	public static function logException(ErrorLogException $e) {
		ErrorLog::log($e->getErrorType(),$e->getFile(),$e->getLine(),$e->getMessage());
	}

	public static function log($type,$file,$line,$message) {
		$database = ErrorLog::checkAndGetDatabase();
		$database->connect();
		$database->start_transaction();
		$query = sprintf("INSERT INTO TABLE ErrorLog (id,date,type,file,line,message) values(%s,%s,%s,%s,%s)",
			          ErrorLog::getLastErrorId(),
			          "CURRENT_TIMESTAMP",
			          $type,
			          $file,
			          $line,
			          $message);
		$_SESSION["database"]->query( $query );
		$database->commit();
		$database->close_connection();
	}
	
	public static function getLastErrorId() {
		$database = ErrorLog::checkAndGetDatabase();
		$query = "SELECT MAX(id) as maxId
		          FROM   ErrorLog";
		$result = $database->query( $query );
		$row = $database->fetch_assoc($result);
		return $row["maxId"];
	}
}

?>
