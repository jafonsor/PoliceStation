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
		echo $path . "<br>";
		require_once( $path );
		echo "classe carregada com sucesso!<br>";
	}
	
	spl_autoload_register(__NAMESPACE__.'\loadClass');
	//------------------  autoload class ---------------------------------//

	namespace policestation\presentation\pages;

	session_start();
	
	$database = $_SESSION["database"];
	$_SESSION["database"]->connect();
	$result = $_SESSION["database"]->query("SELECT * FROM Players");
	echo "<table>";

	if( $database->num_rows( $result ) > 0 ) {
		
		//get the names and the number of fields and displays them in the top row of the table.
		$numberOfFields = $database->num_fields($result);
		echo "<tr>";
		for( $i=0; $i < $numberOfFields; $i++) {
			$name = $database->field_name($result, $i);
			echo "<td>".$name."</td>";
		}
		echo "</tr>";
		
		while( $row = $database->fetch_row($result) ) {
			echo "<tr>";
			for($i=0; $i< $numberOfFields; $i++) {
				echo "<td>".$row[$i]."</td>";
			}
			echo "</tr>";
		}
		
		
	} else {
		echo "<tr><td>O resultado tem zero linhas</td></tr>";
	}
	echo "</table>";
	$_SESSION["database"]->close_connection();
	
	die();
	
	echo "not dead!<br>";
	
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
	if(isset($_GET["username"]) && isset($_GET["password"]) && isset($_GET["repassword"])) {
		$username = $_GET["username"];
		
		$badUsernameFormat = !InputVerifier::validUsername($_GET["username"]);
		$badPasswordFormat = !InputVerifier::validPassword($_GET["password"]);
		
		if( !$badUsernameFormat && !$badUsernameFormat) {
			if($_GET["password"] == $_GET["repassword"]) {
				
				try {
					echo "vai executar o serviço! " . $_GET["password"] . "<br>";
					$service = new RegisterPlayerService($_GET["username"], $_GET["password"]);
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
		<form action="register.php" method="get">
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