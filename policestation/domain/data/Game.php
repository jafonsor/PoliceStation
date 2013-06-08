<?php

// include Player, ErrorLog, ErrorPages

class Game {

	/**
	 * returns the Player witch has the $username.
	 * throws NonexistingPlayer exception if the username doesn't match any player
	 */
	public function getPlayerByName($username) {
		ErrorChecker::issetSessionVar("database",__FILE__,__LINE__);
		$database = $_SESSION["database"];
		$query = sprintf( "SELECT id, password
		                   FROM Player
		                   WHERE username = %s",
		                   database->real_escape_string($username) );
		$result = $database->query($query);
		ErrorChecker::isInvalidQueryResult($result,__FILE__,__LINE__,$query)
		if($database->num_rows($result) != 1) {
			throw new NonexistingPlayer();
		}
		$row = $database->fetch_assoc($result); 
		return new Player( $row["id"], $username, $row["password"] );
	}

	public function generatePlayerId() {	
	}

}
?>
