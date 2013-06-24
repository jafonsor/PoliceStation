<?php 

if(!isset($_SESSION["basedir"])){
	echo "To test services run the ServicesTests.php<br>";
	exit();
}
$projbasedir = $_SESSION["basedir"];
echo "projbasedir: " . $projbasedir . "<br>";
require_once($projbasedir."/service/RegisterPlayerService.php");

echo "RegisterPlayerTest<br>";
		
function test($username,$password) {
	$service = new RegisterPlayerService($username,$password);
	
	try {
		$service->excute();
		echo "player succefully registered.";
	} catch(DuplicatedUsernameException $d) {
		echo "player ".$username." alredy exists.";
	}
}


echo "Registering a player: ";
test("joao","pass");
echo "<br>";

echo "Testing duplicate username: ";
test("joao","pass");
echo "<br>";


?>