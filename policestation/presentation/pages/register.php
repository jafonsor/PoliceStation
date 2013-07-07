<?php
	session_start();
	$projbasedir = $_SESSION["basedir"];
	
	require_once( realpath($projbasedir."/service/RegisterService.php"));
	require_once( realpath($projbasedir."/presentation/InputVerifier.php"));
	
	
	$commonHeaderFile = realpath(projbasedir."/presentation/pages/common/CommonHead.html");
	$commonBodyFile = realpath(projbasedir."/presentation/pages/common/CommonBody.html");
	
	$usernameAlreadyExists = false;
	$badUsernameFormat = false;
	$diferentPassword = false;
	$badPasswordFormat = false;
	
	$username = "";
	
	//verify form data
	if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["repassword"])) {
		$username = $_POST["username"];
		
		$badUsernameFormat = !InputVerifier::validUsername($_POST["username"]);
		$badPasswordFormat = !InputVerifier::validPassword($_POST["password"]);
		
		if( !$badUsernameFormat && !$badUsernameFormat) {
			if($_POST["password"] == $_POST["repassword"]) {
				
				try {
					$service = new RegisterPlayerService($_POST["username"], $_POST["password"]);
					$service->execute();
					
					//the user was successfully registered
					header("Location: /presentation/pages/successfullRegistry.php");
					die();
				} catch (DuplicatedUsernameException $e) {
					$usernameAlreadyExists = true;	
				}
			} else {
				$diferentPassword = true;
			}
		}
	}
?>

<html>
	<head>
		<?php require_once($commonHeaderFile); ?>
	</head>
	<body>
		<?php require_once($commonBodyFile); ?>
		<form action="register.php" method="post"/>
			<table>
			<tr> 
				<td>Username:</td>
				<td><input type="text" name="username" value=<?php echo "\"".$username."\""; ?>/></td>
				<td>
					<?php
						if($usernameAlreadyExists) {
							echo "<div class=\"errorMessage\">Já existe um utilizador com esse username.</div>";
						} else if($badUsernameFormat) {
							echo "<div class=\"errorMessage\">Formato de username errado.</div>";
						}
					?>
				</td> 
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"/></td>
				<td>
					<?php
						if($diferentPassword) {
							echo "<div class=\"errorMessage\">Passwords diferents.</div>";
						} else if($badPasswordFormat) {
							echo "<div class=\"errorMessage\">Formato de password errado.</div>";
						}
					?>
				</td> 
			</tr>
			<tr>
				<td>Rescrever password:</td>
				<td><input type="password" name="repassword"/></td>
				<td></td>
			</tr>
			<input type="submit">
			</table>
		</form>
	</body>
</html>