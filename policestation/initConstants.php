<?php
	define("APP_DIR", __DIR__);
	$_SESSION["basedir"] = __DIR__;
	$projbasedir = __DIR__;
	
	$_SESSION["debug"] = true;
	require_once($projbasedir."/dbinterface/MySqlDatabase.php");
	require_once($projbasedir."/domain/data/Game.php");
	
	$_SESSION["database"] = new policestation\dbinterface\MySqlDatabase("police","911polICE","police","localhost","3307");
	$_SESSION["game"] = new policestation\domain\data\Game();
	
	if($_SESSION["debug"] == true) {
		$_SESSION["database"]->connect();
		$_SESSION["database"]->close_connection();
	}
	
?>
