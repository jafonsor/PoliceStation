<?php

namespace policestation\exception\domain;

class WrongPasswordException extends \Exception {
	public function __construct() {
		parent::__construct("WrongPasswordException: the password is incorrect!");
	}
}

?>