<?php

namespace policestation\service;

$projbasedir = $_SESSION["basedir"];
require_once(realpath($projbasedir."/service/PoliceStationService.php"));
require_once(realpath($projbasedir."/exception/domain/WrongPasswordException.php"));

use policestation\exception\domain\WrongPasswordException as WrongPasswordException;

class LoginService extends PoliceStationService {

	private $username;
	private $password;
	private $playerid;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	
	/**
	 * throws NonexistingPlayer if the username doesn't match any player's username.
	 * throws WrongPasswordException if the password is wrong.
	 */
	protected function dispatch() {
		
		$player = $this->getGame()->getPlayerByName($this->username);
		
		$hashedPassword = SecurityUtils::passwordHash($this->password, $this->username);
		if( $hashedPassword != $player->getHashedPassword() ) {
			throw new WrongPasswordException();
		}
	}
	
	public function getId() {
		return $playerid;
	}
}

?>
