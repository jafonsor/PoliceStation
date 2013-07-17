<?php
	namespace policestation\presentation\pages;
	//------------------  autoload class ---------------------------------//
	function remove_until_match($match,$string) {
		$string_length = strlen( $string );
		$match_length = strlen( $match );
	
		$i = $string_length - 1;
		$k = $match_length - 1;
		while( $i > 0 && $k >= 0 ) {
			if( $match[$k] == $string[$i] ) {
				$k--;
			} else {
				$k = $match_length - 1;
			}
			$i--;
		}
	
		if( $k < 0 ) {
			$result = substr($string,0,$i+1);
		} else {
			$result = null;
		}
	
		return $result;
	}
	
	function loadClass($className) {
		echo "a carregar classe: " . $className . "<br>";
		$basedir = remove_until_match("policestation",__FILE__);
		$unrealPath = $basedir . str_replace("\\", "/",$className.".php");
		$path = realpath($unrealPath);
		require_once( $path );
		echo "classe carregada com sucesso!<br>";
	}
	
	spl_autoload_register(__NAMESPACE__.'\loadClass');
	//------------------  autoload class ---------------------------------//

	namespace policestation\presentation\pages;

	session_start();	
	$projbasedir = $_SESSION["basedir"];
	require_once( realpath($projbasedir."/service/RegisterPlayerService.php") );
	require_once( realpath($projbasedir."/presentation/InputVerifier.php") );
	
	use policestation\service\RegisterPlayerService as RegisterPlayerService;
	use policestation\presentation\InputVerifier as InputVerifier;
	use policestation\exception\domain\DuplicatedUsernameException as DuplicatedUsernameException;
	
	$commonHeadFile = realpath($projbasedir."/presentation/pages/common/commonHead.html");
	$commonBodyFile = realpath($projbasedir."/presentation/pages/common/commonBody.html");
	
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
					echo "vai executar o serviço! " . $_POST["password"] . "<br>";
					$service = new RegisterPlayerService($_POST["username"], $_POST["password"]);
					$service->execute();
					
					//the user was successfully registered
					header("Location: /policestation/presentation/pages/successfullRegistry.php");
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
		<?php require_once($commonHeadFile); ?>
	</head>
	<body>
		<?php require_once($commonBodyFile); ?>
		<form action="register.php" method="post">
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
			<tr>
				<td></td>
				<td><input type="submit"/></td>
				<td></td>
			</tr>
			</table>
		</form>
	</body>
</html>