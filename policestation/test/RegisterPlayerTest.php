<?php 

if(!isset($_SESSION["basedir"])){
	echo "To test services run the ServicesTests.php<br>";
	exit();
}
$projbasedir = $_SESSION["basedir"];
echo "projbasedir: " . $projbasedir . "<br>";
require_once($projbasedir."/service/RegisterPlayerService.php");

echo "<br><br> >> RegisterPlayerTest << <br>";
		
function test($username,$password) {
	$service = new RegisterPlayerService($username,$password);
	
	try {
		$service->execute();
		echo "player succefully registered.";
	} catch(DuplicatedUsernameException $d) {
		echo "player ".$username." alredy exists.";
	}
}

$username = "joao";
$password = "pass";

echo "Registering a player: ";
test($username,$password);
echo "<br>";

echo "Testing duplicate username: ";
test($username,$password);
echo "<br>";

echo "Testing null username: ";
test(null, $password);
echo "<br>";

echo "Testing null password: ";
test($username, null);
echo "<br>";

?>