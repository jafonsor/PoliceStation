<?php 

namespace policestation\presentation;

class InputVerifier {
	public static function validPassword($password) {
		$result = true;
		
		if($password == "" || $password == null)
			$result = false;
		
		return $result;
	}
	
	public static function validUsername($username) {
		$result = true;
		
		if($username == "" || $username == null)
			$result = false;
		
		return $result;
	}
}

?>