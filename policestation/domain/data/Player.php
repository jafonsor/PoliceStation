<?php

namespace policestation\domain\data;

$projbasedir = $_SESSION["basedir"];
require_once($projbasedir."/exception/domain/DuplicatedUsernameException.php");
require_once($projbasedir."/exception/domain/NonexistentPlayerException.php");
require_once($projbasedir."/exception/domain/WrongPasswordException.php");
require_once($projbasedir."/exception/errorlog/DatabaseException.php");
require_once($projbasedir."/utils/SecurityUtils.php");

use policestation\exception\domain\DuplicatedUsernameException as DuplicatedUsernameException;
use policestation\exception\domain\NonexistentPlayerException as NonexistentPlayerException;
use policestation\exception\domain\WrongPasswordException as WrongPasswordException;
use policestation\exception\errorlog\DatabaseException as DatabaseException;
use policestation\utils\SecurityUtils as SecurityUtils;

class Player {
	
	private $id;
	
	public function __construct($id) {
		$this->id = $id;
	}
	
	public static function insertOnDatabase($id,$username,$password) {
		$database = $_SESSION["database"];
		$insUsername = $database->real_escape_string($username);
		$insPassword = SecurityUtils::passwordHash($password, $username);
		
		$query = sprintf("INSERT INTO Players (id,username,password) values(%s,'%s','%s')",
				$id,
				$database->real_escape_string($insUsername),
				$database->real_escape_string($insPassword));
		$result = $database->query($query);
		
		// if the username already exists the $result will be false
		if(!$result) {
			// if the username already exists the error will be ER_DUP_KEY_ENTRY.
			// This error may also be caused by trying to insert a duplicate id
			// but hopefully that wont be the case.
			if($database->errno() == ER_DUP_ENTRY) {
				throw new DuplicatedUsernameException();
			} else {
				throw new DatabaseException($query);
			}
		}
	}
	
	public function verifyPassword($password) {
		$playerHashedPassword = $this->getHashedPassword();
		$hashedPassord = SecurityUtils::passwordHash($password, $this->getUsername());
		if($hashedPassord != $playerHashedPassword) {
			throw WrongPasswordException();
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		$database = $_SESSION["database"];
		
		$query = sprintf("SELECT username FROM Players WHERE id='%s'",
				$database->real_escape_string($this->id));
		$result = $database->query($query);
		
		if(!$result) {
			throw new DatabaseException($query);
		}
		
		if($database->num_rows($result) == 0 ) {
			throw NonexistentPlayerException($this->id);
		}
		
		$row = $database->fetch_assoc($result);
		
		return $row["username"];
	}

 	public function getHashedPassword() {
	  	$database = $_SESSION["database"];
	  	
	  	$query = sprintf("SELECT password FROM Players WHERE id='%s'",
	  			$database->real_escape_string($this->id));
	  	$result = $database->query($query);
	  	
	  	if(!$result) {
	  		throw new DatabaseException($query);
	  	}
	  	
	  	if($database->num_rows($result) == 0 ) {
	  		throw NonexistentPlayerException($this->id);
	  	}
	  	
	  	$row = $database->fetch_assoc($result);
	  	
		return $row["password"];
	}

	public function getMoney() {
	}

	//returns an array with all policeStations of the player
	public function getPoliceStations() {
	}

	public function getPoliceStation($policeStationId) {
	}
}
?>
