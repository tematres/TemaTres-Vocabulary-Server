<?php
include 'adodb.inc.php';
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = NewADOConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
$dd = newDataDictionary($db);
$dd->debug = true;

$tbl = 'tbl_1035';

$flds = <<<DEF
	id      I     UNSIGNED PRIMARY NOTNULL AUTOINCREMENT,
	COLUMN1 C(60) NOTNULL DEFAULT 'abc',
	NEWCOL        N(20.4),
	`with space`  C(20)
	DEF;

$sqlarray = $dd->changeTableSQL($tbl, $flds, false,true);
print_r( $sqlarray );

die;
$mc = $dd->metaColumns($tbl);
print_r( $mc );
print_r( $dd->_genFields( 'col2 varchar(10) NOT NULL index' ) );
