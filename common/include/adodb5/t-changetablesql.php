<?php
require 'adodb.inc.php';

$db = NewADOConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
/** @var ADODB_DataDict $dict */
$dict = NewDataDictionary($db);

$tabname = "LCTABLE";
$flds = <<<COLDEF
	COL1 C(70) NOTNULL DEFAULT 'abc',
	COL2 int DEFAULT 0,
	COLDEF;

//var_dump($dict->genFieldsArray($flds));
//var_dump($r=lens_ParseArgs($flds, ','),array_filter($r));die;
var_dump($dict->_genFields($flds));die;
//var_dump($dict->parseArgs($flds));die;

$db->debug = true;
$sqlarray = $dict->changeTableSQL($tabname, $flds);
print_r($sqlarray);
$dict->executeSqlArray($sqlarray);

//$dict->executeSqlArray($dict->dropTableSQL($tabname););
