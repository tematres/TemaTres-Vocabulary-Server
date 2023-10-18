<?php
include 'adodb.inc.php';

$driver = 'mysqli';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'adodb';

$sql = "select * from people where id = 1";
//define('ADODB_ASSOC_CASE', ADODB_ASSOC_CASE_LOWER);

$db = ADONewConnection($driver) or die('ARGH');
//$db->debug = true;
$db->connect($host, $user, $password, $database) or die('CONNECT FAILED');
$db->setFetchMode(ADODB_FETCH_ASSOC);

$rs = $db->Execute($sql);
//print_r($rs->fieldTypesArray());
print_r($rs->fields);

//$rs->MoveNext();

foreach ([
	"FetchObj", "FetchObject",
// 	'fetchNextObj', 'fetchnextobject'
		 ] as $fn) {
	echo "$fn - "; var_dump($rs->$fn());
}

