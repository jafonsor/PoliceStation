<?php

namespace policestation\exception\errorlog;

$projbasedir = $_SESSION["basedir"];
require_once(realpath($projbasedir."/exception/errorlog/ErrorLogException.php"));

class SessionException extends ErrorLogException {
	public function __construct($var) {
		parent::__construct(ErrorLogException::SESSION,
		                    $var. " var is not set in this SESSION");
	}
}

?>