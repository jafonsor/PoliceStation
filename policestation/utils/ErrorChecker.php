<?php

session_start();

$projbasedir = $_SESSION["basedir"];
$DATABASE_EXCEPTION_PHP =
	realpath($projbasedir."/exception/DatabaseException.php");
$SESSION_EXCEPTION_PHP =
	realpath($projbasedir."/exception/SessionException.php");
require_once($DATABASE_EXCEPTION_PHP);
require_once($SESSION_EXCEPTION_PHP);

class ErrorChecker {
	
	/**
	 *  Verifies if isset($_SESSION[$var]). if false throws SessionException.
	 *  $file and $line are for error loging.
	 */
	public static function issetSessionVar($var, $file, $line) {
		if(!isset($_SESSION[$var])) {
			throw new DatabaseException($file,$line,$var);
		}
	}
	
	/**
	 *  Verifies if !$result. if true then the $result is invalid and the function throws DatabaseException.
	 *  $file, $line and $query are for loging information.
	 */
	public static function isInvalidQueryResult($result, $file, $line, $query) {
		if(!$result) {
			throw new SessionException($file,$line,$query);
		}
	}
}

?>
