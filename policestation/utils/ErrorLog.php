<?php

$projbasedir = $_SESSION["basedir"];
require_once($projbasedir."/exception/errorlog/ErrorLogException.php");
require_once($projbasedir."/utils/FatalErrorLog.php");

class ErrorLog {
	
	private static function checkAndGetDatabase() {
		if(isset($_SESSION["database"])) {
			return $_SESSION["database"];
		} else {
			exit(ErrorPages::fatalError("can't log!"));
		}
	}
	
	public static function logException(ErrorLogException $e) {
		ErrorLog::log($e->getErrorType(),
		              $e->getFile(),
		              $e->getLine(),
		              $e->getMessage(),
		              $e->getTraceAsString());
	}
	
	public static function log($type,$file,$line,$message) {
		ErrorLog::logWithTrace($type,$file,$line,$message,"NULL");
	}

	public static function logWithTrace($type,$file,$line,$message,$trace) {
		$database = ErrorLog::checkAndGetDatabase();
		$database->connect();
		$database->start_transaction();
		$query = sprintf("INSERT INTO ErrorLog (id,logDate,type,fileName,line,message,trace)
				          VALUES(%s,%s,'%s','%s',%s,'%s',%s)",
			          ErrorLog::getLastErrorId(),
			          "CURRENT_TIMESTAMP",
			          $type,
			          $file,
			          $line,
			          $database->real_escape_string($message),
		              $trace);
		$result = $database->query( $query );
		if($result==false) {
			$database->rollback();
			$database->close_all_connections();
			$e = new DatabaseException($query);
			FatalErrorLog::logException($e);
			exit(ErrorPages::databaseErrorPage($e->getMessage()));
		}
		$database->commit();
		echo "o log foi commitado<br>";
		$database->close_connection();
	}
	
	public static function getLastErrorId() {
		$database = ErrorLog::checkAndGetDatabase();
		$query = "SELECT MAX(id) as maxId
		          FROM   ErrorLog";
		$result = $database->query( $query );
		
		if($result==false) {
			$database->rollback();
			$database->close_all_connections();
			$e = new DatabaseException($query);
			FatalErrorLog::logException($e);
			exit(ErrorPages::databaseErrorPage($e->getMessage()));
		}
		$row = $database->fetch_assoc($result);
		
		if($row["maxId"] == null) {
			// there are no logs in the table so there isn't a max id.
			$finalResult = 1;
		} else {
			$finalResult = $row["maxId"];
		}
		return $finalResult+1;
	}
}

?>
