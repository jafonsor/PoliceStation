<?php 

class WrogPasswordException extends Exception {
	public function __construct() {
		parent::__construct("WrongPasswordException: the password is incorrect!");
	}
}

?>