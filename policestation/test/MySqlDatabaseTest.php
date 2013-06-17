<html><head><meta charset="utf-8"/></head></html>

<?php

//require_once '/var/www/policestation/initConstants.php';
echo APP_DIR;
echo "Teste à class MySqlDatabase:\n";

$_SESSION["database"] = new MySqlDatabase("police","911polICE","police","localhost","3307");

$database = $_SESSION["database"];

echo "A estabelecer ligação\n";
$database->connect();
$query = "Insert into Players (id,username,password,lastTimeLogged)
          values(1,'joao','pass',CURRENT_TIME)";
$result = $database->query($query);
ErrorChecker::isValidQueryResult($result);

$query = "select * form Players";
$result = $database->query( $query );
ErrorChecker::isValidQueryResult($result);


echo "<table>";

if( $database->num_rows( $result ) > 0 ) {
	
	//get the names and the number of fields
	$fieldNames = array();
	$numberOfFields = 0;
	echo "<tr>";
	for( $i=0; $name = $database->field_name($result, $i); $i++) {
		$fieldNames[$i] = $name;
		$numberOfFields++;
		echo "<td>".$name."</td>";
	}
	echo "</tr>";
	
	while( $row = $database->fetch_row($result) ) {
		echo "<tr>";
		for($i=0; $i< numberOfFields; $i++) {
			echo "<td>".$row[$i]."</td>";
		}
		echo "</tr>";
	}
	
	
} else {
	echo "<tr><td>O resultado tem zero linhas</td></tr>";
}
echo "</table>";

$database->close_connection();

?>
