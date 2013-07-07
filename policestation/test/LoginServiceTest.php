<?php

$projbasedir = $_SESSION["basedir"];
require_once(realpath($projbasedir."/service/RegisterPlayerService.php"));
require_once(realpath($projbasedir."/service/LoginService.php"));

echo "<br><br>  >> LoginServiceTest << <br>";

$username = "miguel";
$password = "pass";

$nonexistantUsername = "emptyness";
$wrongPassword = "wrong";

//registers a player to further atempt the login
$registerService = new RegisterPlayerService($username, $password);

echo "Regists the player: ";
try {
	$registerService->execute();
	echo "the player was registered.<br>";
} catch(DuplicatedUsernameException $d) {
	echo "the player already was registered. The password may not be the expected.".
	     " Sugest to clean the database.<br>";
}

echo "Testing noexistante player: ";
$loginService = new LoginService($nonexistantUsername, $password);
try {
	$loginService->execute();
	echo "login successefull. The username doesn't exist. The loging should have failed. [FAIL]<br>";
} catch(NonexistentPlayerException $n) {
	echo "noesitent player. [OK]<br>";
} catch(WrongPasswordException $w) {
	echo "wrong password. It should have throw a NonesitentPlayerException [FAIL]<br>";
}

echo "Testing wrong passord: ";
$loginService = new LoginService($username, $wrongPassword);
try {
	$loginService->execute();
	echo "login successful. The password was wrong. The login should have failed. [FAIL]<br>";
} catch(NonexistentPlayerException $n) {
	echo "noesitent player. The player should exist. [FAIL]<br>";
} catch(WrongPasswordException $w) {
	echo "wrong password. [OK]<br>";
}

echo "Testing login: ";
$loginService = new LoginService($username, $password);
try {
	$loginService->execute();
	echo "login successfull. [OK]<br>";
} catch(NonexistentPlayerException $n) {
	echo "noesitent player. The player should exist. [FAIL]<br>";
} catch(WrongPasswordException $w) {
	echo "wrong password. The password should be rigth. [FAIL]<br>";
}

echo "Testing null username: ";
$loginService = new LoginService(null, $password);
try {
	$loginService->execute();
	echo "login successful. <br>";
} catch(NonexistentPlayerException $n) {
	echo "noesitent player.<br>";
} catch(WrongPasswordException $w) {
	echo "wrong password.<br>";
}

echo "Testing null password: ";
$loginService = new LoginService($username, null);
try {
	$loginService->excute();
	echo "login successful. <br>";
} catch(NonexistentPlayerException $n) {
	echo "noesitent player.<br>";
} catch(WrongPasswordException $w) {
	echo "wrong password.<br>";
}

?>