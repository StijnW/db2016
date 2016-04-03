<?php
// create a PDO object
include('configuration.php');
$PDO = new \PDO( $config["dsn"], $config["username"], $config["password"] );
$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

// execute a query using PDO
$stmt = $PDO->prepare("SELECT * FROM country where iso_code = ? ");
$myWriterUri = "BE";
$stmt->execute(array($myWriterUri));
$res = $stmt->fetchAll( \PDO::FETCH_ASSOC );

foreach($res as $row) {
  print $row['name'];
}
?>
