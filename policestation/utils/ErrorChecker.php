<?php

class ErrorChecker {
	
	/**
	 *  Verifies if isset($_SESSION[$var]). if it is not set the function aborts the script and logs the error.
	 *  $file and $line are for error loging.
	 */
	public static function issetSessionVar($var, $file, $line) {
		if(!isset($_SESSION[$var]) {
			ErrorLog::log(ErrorLog::SESSION,$file,$line, $var " var is not set in this SESSION");
			exit(ErrorPages::sessionErrorPage());
		}
	}
	
	/**
	 *  Verifies if !$result. if true then the $result is invalid and the function aborts the script and logs the error.
	 *  $file, $line and $query are for loging information.
	 */
	public static function isInvalidQueryResult($result, $file, $line, $query) {
		if(!$result) {
			ErrorLog::log(ErrorLog::DATABASE,$file,$line,"Query: " . PHP_EOL . $query);
			exit(ErrorPages::databaseErrorPage());
		}
	}
}

?>
