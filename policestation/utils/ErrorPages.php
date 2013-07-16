<?php

namespace policestation\utils;

class ErrorPages {

	public static function databaseErrorPage($message) {
		echo "Database error page: " . $message;
	}
	
	public static function sessionErrorPage($message) {
		echo "Session error page: " . $message;
	}

}

?>
