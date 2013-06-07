<?php

class LoginService extends PoliceStationService {

	private $username;
	private $password;
	private $playerid;

	public function __construct($username, $password) {
		$this->username = username;
		$this->password = password;
	}
	
	
	/**
	 * throws NonexistingPlayer if the username doesn't match any player's username.
	 * throws WrongPasswordException if the password is wrong.
	 */
	public function dispatch() {
		$player = getGame()->getPlayerByName($this->username);
		$hashedPassword = passwordHashFunction($password, $player->getId());
		if( $hashedPassword != $player->getPassword() )
			throw new WrongPasswordException(); 
	}
	
	public function getId() {
		return $playerid;
	}
}

?>
