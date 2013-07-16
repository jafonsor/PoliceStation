<?php

namespace policestation\utils;

class SecurityUtils {
	public static function passwordHash($password, $username) {
		return crypt( $password, $username);
	}
}

?>
