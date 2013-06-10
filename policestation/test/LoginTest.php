<?php

$username = "joao";
$password = "pass";

ErrorChecker::issetSessionVar("database");
$database = $_SESSION["database"];

$database->start_transaction();
$query = "INSERT INTO Playeres (id,username,password,lastTimeLogged)
          values(1,".$username.",".$password.",CURRENT_TIMESTAMP)";
$database->query( $query );
$database->commit();



//$service = new LoginService($username,SecurityUtils::passwordHash($password,$username));

?>
