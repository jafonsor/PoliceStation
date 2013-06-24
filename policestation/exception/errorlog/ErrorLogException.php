<?php
// an exception that should be logged and will cause the end of the program
class ErrorLogException extends Exception {
	
	private $errorType;
	
	const DATABASE = "Database";
	const SESSION = "Session";
	
	public function __construct($type,$message) {
		parent::__construct($message);
		$this->errorType = $type;
	}
	
	public function getErrorType() { return $this->errorType; }
}

?>