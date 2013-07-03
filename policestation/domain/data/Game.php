<?php

$projbasedir = $_SESSION["basedir"];
require_once(realpath($projbasedir."/domain/data/Player.php"));
require_once(realpath($projbasedir."/exception/domain/NonexistentPlayerException.php"));

class Game {

	/**
	 * returns the Player witch has the $username.
	 * throws NonexistingPlayer exception if the username doesn't match any player
	 */
	public function getPlayerByName($username) {
		$database = $_SESSION["database"];
		$query = sprintf( "SELECT id, password
		                   FROM Players
		                   WHERE username = '%s'",
		                   $database->real_escape_string($username) );
		$result = $database->query($query);
		if(!$result) {
			throw new DatabaseException($query);
		}
		if($database->num_rows($result) != 1) {
			throw new NonexistentPlayerException();
		}
		$row = $database->fetch_assoc($result); 
		return new Player( $row["id"], $username, $row["password"] );
	}

	/**
	 * gets the new id from the database, and updates the data base.
	 */
	public function generatePlayerId() {
		$database = $_SESSION["database"];
		
		//get the nextId
		$query = "SELECT varValue
		          FROM Game
		          WHERE varName='nextPlayerId'";
		$result = $database->query( $query );
		if(!$result) {
			throw new DatabaseException($query);
		}
		$row = $database->fetch_assoc($result);
		
		$newId = $row["varValue"];
		
		//increment the id on the table
		$query = sprintf("UPDATE Game
		                  SET varValue=%d
		                  WHERE varName='nextPlayerId'",
		                  $newId + 1);
		$database->query( $query );
		
		return $newId;
	}
	
	public function addPlayer($username,$password) {
		Player::insertOnDatabase($this->generatePlayerId(),$username,$password);
	}
	
	/**
	 * Function to be used in login.
	 * returns the Player with the $username corresponds to the $password
	 * throws WrongPasswordException if $password doesn't correspond to $username 
	 */
	public function verifyPassword($username,$password) {
		$player = $this->getPlayerByName($username);
		$player->verifyPassword($password);
	}

}
?>
