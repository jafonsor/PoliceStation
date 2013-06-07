<?php

class PoliceStationService {
	
	public function excute() {
		database = getDataBase();
		database->startTransaction();
		dispatch();
		database->commit();
	}
	
	private function getDataBase() {
		return _SESSION["database"];
	}
	
	public getGame() {
		return getDataBase()->getGame();
	}

	public abstract function dispatch();
}
?>
