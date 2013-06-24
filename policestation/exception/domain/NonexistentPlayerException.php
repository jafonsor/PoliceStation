<?php 

class NonexistentPlayerException extends Exception {
	
	private $id = -1;
	
	public function __construct($id = null) {
		if($id == null) {
			parent::__construct("NonexistentPlayerException: that player doesn't exist.");
		} else {
			parent::__construct("NonexistentPlayerException: the player with id ".$id."doesn't exist.");
			$this->id = $id;
		}
	}
}

?>