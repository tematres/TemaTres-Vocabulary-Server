<?php
require_once 'adodb.inc.php';
require_once 'adodb-datadict.inc.php';

$hostname = 'localhost';
$username = 'root';
$password = 'C0yote71';
$database = 'adodb';
$tbl      = 'tbl_1035';

$db = ADONewConnection ('mysqli');
$db->Connect ($hostname, $username, $password, $database) ;
$dict = newDataDictionary($db);

$db->execute("DROP TABLE $tbl");
$sql = $dict->createTableSQL($tbl, <<<DEF
	id       I     NOTNULL AUTO KEY,
	column1  C(30) NOTNULL,
	column2  N(10),
	txt      X
	DEF);
//print_r($sql);
if ( $dict->executeSQLArray($sql) != 2) {
	echo $db->ErrorMsg();
	die;
}
echo "Test table created \n";

$dict->debug = true;
$sql = $dict->changeTableSQL($tbl, <<<DEF
	id       I     NOTNULL AUTO KEY,
	column1  C(40) NOTNULL
	DEF,
	false, false);

var_dump($sql);
