<?php

// include Player, ErrorLog, ErrorPages

class Game {

	/**
	 * returns the Player witch has the $username.
	 * throws NonexistingPlayer exception if the username doesn't match any player
	 */
	public function getPlayerByName($username) {
		if(!isset($_SESSION["database"]) {
			ErrorLog::log(ErrorLog::SESSION,__DIR__ . __FILE__,__LINE__,"database var is not set in this SESSION");
			exit(ErrorPages::sessionErrorPage());
		}
		$database = $_SESSION["database"];
		$query = sprintf( "SELECT id, password
		                   FROM Player
		                   WHERE username = %s",
		                   database->real_escape_string($username) );
		$result = $database->query($query);
		if(!$result) {
			ErrorLog::log(ErrorLog::DATABASE,__DIR__.__FILE__,__LINE__,"Query: " . PHP_EOL . $query);
			exit(ErrorPages::databaseErrorPage());
		}
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
