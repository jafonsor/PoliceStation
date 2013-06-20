<?php

class FatalErrorLog {
	public static function logException(ErrorLogException $e) {
		FatalErrorLog::logWithTrace($e->getErrorType(),
		                            $e->getFile(),
		                            $e->getLine(),
		                            $e->getMessage(),
		                            $e->getTraceAsString());
	}
	
	public static function log($taype,$file,$line,$message) {
		FatalErrorLog::logWithTrace($type, $file, $line, $message, "NULL");
	}
	
	public static function logWithTrace($type,$file,$line,$message,$trace) {
		
	}
}

?>