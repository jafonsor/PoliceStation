<?php 



$projbasedir = $_SESSION["basedir"];
$ERROR_LOG_EXCEPTION_PHP  = realpath($projbasedir."/exception/ErrorLogException.php");
require_once($ERROR_LOG_EXCEPTION_PHP);

class DatabaseException extends ErrorLogException {
	public function __construct($query) {
		if(isset($_SESSION["database"])) {
			$database = $_SESSION["database"];
			parent::__construct(ErrorLogException::DATABASE,
					            $database->last_error() ."\nQuery: " . PHP_EOL . $query);
		} else {
			parent::__construct(ErrorLogException::DATABASE,
					            "Query: " . PHP_EOL . $query);
		}
	}
}

?>