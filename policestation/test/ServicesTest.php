<?php

session_start();

function cdBack($path) {
	$slash = DIRECTORY_SEPARATOR;

	$pathArray = explode($slash, $path);

	$newPathArray = array();

	for($i=0; $i < count($pathArray) - 1 ; $i++) {
		$newPathArray[$i] = $pathArray[$i];
	}

	$newPath = implode($slash,$newPathArray);

	return $newPath;
}

$projbasedir = cdBack(__DIR__);
$_SESSION["basedir"] = $projbasedir;

require_once($projbasedir."/initConstants.php");
require_once($projbasedir."/test/RegisterPlayerTest.php");

?>