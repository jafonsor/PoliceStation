<html><head><meta charset="utf-8"/></head></html>

<?php

session_start();

function cdBack($path) {
	$slash = DIRECTORY_SEPARATOR;

	$pathArray = explode($slash, $path);
	
	$newPathArray = array();
	
	for($i=0; $i < count($pathArray) - 1 ; $i++) {
		$newPathArray[$i] = $pathArray[$i];
	}
	
	$newPath = implode($slash,$newPathArray);

	return $newPath;
}

$projbasedir = cdBack(__DIR__);

$_SESSION["basedir"] = $projbasedir;

echo "base dir: " . cdBack(__DIR__) . "<br>";

require_once($projbasedir."/dbinterface/MySqlDatabase.php");
require_once($projbasedir."/utils/ErrorLog.php");
require_once($projbasedir."/utils/ErrorPages.php");
echo "Teste à class PostgresDatabase:<br>";

$user="ist169657"; /* inserir aqui username do sigma */
$host="db.ist.utl.pt";
$port=5432;
$password="vonn4255"; /* inserir aqui password do psql_reset */
$dbname = $user;

$_SESSION["database"] = new PostegresDatabase($user,$password,$dbname,$host,$port);

$database = $_SESSION["database"];

echo "A estabelecer ligação<br>";
$database->connect();

if($database->getConnection()==null)
	echo "ligação a null<br>";
else
	echo "a ligação não é null<br>";

$query = "Insert into Players (id,username,password,lastTimeLogged)
          values(1,'joao','pass',CURRENT_TIMESTAMP)";
$result = $database->query($query);

echo "a verificar o resultado o insert<br>";
if(!$result)
	echo "vai dar erro<br>";
else
	echo "não vai dar erro<br>";

try {
	
if(!$result) {
	throw new DatabaseException($query);
}

echo "insert bem sucedido<br>";

$query = "select * from Players";
$result = $database->query( $query );
if(!$result) {
	echo "invalide select: " . $database->last_error() . "<br>";
	//throw new DatabaseException($query);
}


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

} catch (ErrorLogException $e) {
	$database->close_all_connections();
	ErrorLog::logException($e);
	exit(ErrorPages::databaseErrorPage($e->getMessage()));
}

$database->close_connection();

?>
