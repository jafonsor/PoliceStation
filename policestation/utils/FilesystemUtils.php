<?php

namespace policestation\utils;

class FilesystemUtils {
	
	/**
	 * @param unknown $path
	 * @return Returns the parent directory of the last 
	 */
	public static function cdBack($path) {
		$slash = $_SESSION["systemSlah"];
	
		$pathArray = explode($slash, $path);
		
		$newPathArray = array();
		
		for($i=0; $i < count($pathArray) - 1 ; $i++) {
			$newPathArray[$i] = $pathArray[$i];
		}
		
		$newPath = implode($slash,$newPathArray);

	return $newPath;
}
}
?>