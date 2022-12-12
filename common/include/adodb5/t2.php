<?php
include 'adodb.inc.php';
include 'adodb-active-record.inc.php';

define('ADODB_ASSOC_CASE', ADODB_ASSOC_CASE_NATIVE);
//define('ADODB_ASSOC_CASE', ADODB_ASSOC_CASE_LOWER);
//define('ADODB_ASSOC_CASE', ADODB_ASSOC_CASE_UPPER);
$ADODB_QUOTE_FIELDNAMES = 'NATIVE';
//$ADODB_QUOTE_FIELDNAMES = TRUE;

$db = ADOnewConnection('pdo_mysql://root:C0yote71@localhost/test');
//$db->debug = true;

ADOdb_Active_Record::SetDatabaseAdapter($db);

$db->Execute("CREATE TEMPORARY TABLE `people2` (`idNumber` int(10) unsigned NOT NULL)");
//$db->Execute("DELETE FROM `people` WHERE `idNumber` = 3");
class Person extends ADOdb_Active_Record {}

$person = new Person('people2', ['idNumber']);
//$person = new Person('people');

//var_dump($person);
var_dump($person->GetAttributeNames());
exit((int)!property_exists($person, 'idNumber'));


$person->idNumber = 3;
//$person->a = 'titi';
//$person->save();
//
$person->a = 'tutu';
//var_dump($person->save());
//var_dump($person->nameQuoter($db,'x'));

# ------------- #792

//$sql = "SELECT * FROM people WHERE idNumber = 3";
//$rs = $db->Execute($sql);
//print_r( $rs->GetRowAssoc() );

$person->load('`idNumber` = 3');
var_dump($person->a);
//print_r($person);
