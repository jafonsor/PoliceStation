<?php

// include Player, ErrorChecker

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
		                   $database->real_escape_string($username) );
		$result = $database->query($query);
		ErrorChecker::isInvalidQueryResult($result,__FILE__,__LINE__,$query);
		if($database->num_rows($result) != 1) {
			throw new NonexistingPlayer();
		}
		$row = $database->fetch_assoc($result); 
		return new Player( $row["id"], $username, $row["password"] );
	}

	/**
	 * gets the new id from the database, and updates the data base.
	 */
	public function generatePlayerId() {
		ErrorChecker::issetSessionVar("database",__FILE__,__LINE__);
		$database = $_SESSION["database"];
		
		//get the nextId
		$query = "SELECT varValue
		          FROM Game
		          WHERE varName='nextPlayerId'";
		$result = $database->query( $query );
		ErrorChecker::isInvalidQueryResult($result,__FILE__,__LINE__,$query);
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

}
?>
