<?php 
	session_start();
	$projbasedir = $_SESSION["basedir"];
	$commonHeadFile = realpath($projbasedir."/presentation/pages/common/commonHead.html");
	$commonBodyFile = realpath($projbasedir."/presentation/pages/common/commonBody.html");
?>

<html>
	<head>
		<?php require_once($commonHeadFile);?>
	</head>
	<body>
		<?php require_once($commonBodyFile);?>
		<a href="register.php">Registar</a>
	</body>
</html>