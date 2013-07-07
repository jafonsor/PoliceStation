<?php 
	session_start();
	$projbasedir = $_SESSION["basedir"];
	$commonHeadFile = realpath(projbasedir."/presentation/common/commonHead.html");
	$commonBodyFile = realpath(projbasedir."/presentation/common/commonBody.htm");
?>

<html>
	<head>
		<?php require_once($commonHeadFile);?>
	</head>
	<body>
		<?php require_once($commonBodyFile);?>
		<p class"comfirmMessage">Registo efectuado com sucesso.</p>
		<p>Voltar à <a href="index.php">primeira página</a>.</p>
	</body>
</html>