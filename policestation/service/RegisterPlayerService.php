<?php

namespace policestation\service;

$projbasedir = $_SESSION["basedir"];
require_once($projbasedir."/service/PoliceStationService.php");

class RegisterPlayerService extends PoliceStationService {
	private $username;
	private $password;
	
	public function __construct($username,$password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	protected function dispatch() {
		$game = $this->getGame();
		
		$game->addPlayer($this->username, $this->password);
	}
}

?>