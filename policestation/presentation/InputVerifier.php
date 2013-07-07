<?php 

class InputVerifier {
	public static function validPassword($password) {
		$result = true;
		
		if($password = "")
			$result = false;
		
		return $result;
	}
	
	public static function validUsername($username) {
		$result = true;
		
		if($username == "")
			$result = false;
		
		return $result;
	}
}

?>