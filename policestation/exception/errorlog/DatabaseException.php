<?php 



$projbasedir = $_SESSION["basedir"];
$ERROR_LOG_EXCEPTION_PHP  = realpath($projbasedir."/exception/errorlog/ErrorLogException.php");
require_once($ERROR_LOG_EXCEPTION_PHP);

class DatabaseException extends ErrorLogException {
	public function __construct($query) {
		if(isset($_SESSION["database"])) {
			$database = $_SESSION["database"];
			echo "DatabaseException: database defined: " . $database->last_error() . "<br>";
			parent::__construct(ErrorLogException::DATABASE,
					            $database->last_error() ."\nQuery: "  . $query);
		} else {
			//echo "DatabaseException: database undefined<br>";
			parent::__construct(ErrorLogException::DATABASE,
					            "Query: " . $query);
		}
	}
}

?>