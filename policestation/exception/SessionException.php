<?php

$projbasedir = $_SESSION["basedir"];
$ERROR_LOG_EXCEPTION_PHP  = realpath($projbasedir."/exception/ErrorLogException.php");
require_once($ERROR_LOG_EXCEPTION_PHP);

class SessionException extends ErrorLogException {
	public function __construct($var) {
		parent::__construct(ErrorLogException::SESSION,
		                    $var. " var is not set in this SESSION");
	}
}

?>