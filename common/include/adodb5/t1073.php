<?php
include 'adodb.inc.php';
include 'adodb-active-record.inc.php';
include 'adodb-exceptions.inc.php';

$db = NewADOConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');

//$db = NewADOConnection('sqlite3');
//$db->connect(':memory:');
//$db->Execute("CREATE TABLE persons (id primary key, lastname, firstname)");
//$db->Execute("INSERT INTO persons VALUES (1, 'Doe', 'John')");

ADOdb_Active_Record::SetDatabaseAdapter($db);
class person extends ADOdb_Active_Record {}
$person = new person();


var_dump($person->load("id=1"));
prt($person);
$person->flag = (int)!$person->flag;
//$db->debug=true;
$person->replace();// or die('UPDATE FAILED');
prt($person);

//var_dump($person->lastname);

//var_dump($person->doquote($db, 1, 'N'));

die;


function prt($person)
{
	foreach ($person->getAttributeNames() as $field) {
		echo $person->$field, ' ';
	}
	echo "\n";
}

foreach( [
			'C'=>['', 'aa', "'aa'", "'aa", "aa'", "'",],
			'N'=>[ 0, 1, 2],
			'L'=>[true, false]
		 ] as $type => $list) {
	foreach($list as $val) {
		printf("%-10s: %-10s %-10s %-10s\n",
			var_export($val, true),
			$person->doQuoteOld($db, $val, $type),
			$person->doQuote($db, $val, $type),
			$person->doQuote2($db, $val, $type),
		);
	}
}


function _old($val)
{
	global $db;
	if (strlen($val) > 0 &&
		(strncmp($val, "'", 1) != 0 || substr($val, strlen($val) - 1, 1) != "'")
	) {
		return $db->qstr($val);
	}
	return "($val)";
}


function _new($val)
{
	global $db;
	if (substr($val, 0, 1) != "'" || substr($val, -1) != "'") {
		return $db->qstr($val);
	}
	return "($val)";
}
