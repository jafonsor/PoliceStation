<?php
	define("APP_DIR", __DIR__);
	$_SESSION["basedir"] = __DIR__;
	$projbasedir = __DIR__;
	
	require_once($projbasedir."/dbinterface/MySqlDatabase.php");
	require_once($projbasedir."/domain/data/Game.php");
	
	$_SESSION["database"] = new MySqlDatabase("police","911polICE","police","localhost","3307");
	$_SESSION["game"] = new Game();
?>
