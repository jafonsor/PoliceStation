<?php 

namespace policestation\exception\domain;

class DuplicatedUsernameException extends \Exception {
	public function __construct() {
		parent::__construct("DuplicatedUsernameException: there is another player with the same username.");
	}
}

?>