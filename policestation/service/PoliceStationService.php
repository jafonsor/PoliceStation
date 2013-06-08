<?php

class PoliceStationService {
	
	public function excute() {
		database = getDatabase();
		
		/*
		   I think there must be a connect for each php page.
		   In order to hide that from the application side i think establishing the connection here is the best choice.
		*/
		database->connect();
		
		database->start_transaction();
		dispatch();
		database->commit();
		database->close_connection();
	}
	
	private function getDatabase() {
		return _SESSION["database"];
	}
	
	public getGame() {
		return getDatabase()->getGame();
	}

	// this function is responsable for closing the connection if any exception is thrown inside it.
	public abstract function dispatch();
}
?>
