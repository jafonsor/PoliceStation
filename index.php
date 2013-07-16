<?php
	session_start(); // it's needed for initConstants
	set_include_path(__DIR__);
	require_once(realpath(__DIR__."/policestation/initConstants.php"));
	if($_SESSION["debug"] == true) {
		echo "<a href=\"/policestation/presentation/pages/index.php\">index<a>";
	} else {
		header("Location: /policestation/presentation/pages/index.php");
	}
?>