<?php
/**
 * Testing for missing pgsql php extension
 */
include 'adodb.inc.php';
//include 'adodb-error.inc.php';
//include 'adodb-exceptions.inc.php';

$driver = 'pgsql';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'dregad';

//define('ADODB_ASSOC_CASE', ADODB_ASSOC_CASE_UPPER);

$db = NewADOConnection($driver);
//$db->debug=true;
$res = $db->connect($host, $user, $password, $database);
//var_dump(get_class($db), $res);
//echo "{$db->ErrorMsg()} ({$db->ErrorNo()})\n";
//
//echo $db->MetaErrorMsg($db->ErrorNo());

//$db->execute('select * from test');


$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

//print_r($db->metaColumns('Test4', false));

$rs = $db->Execute('select * from myschema.test2');
//print_r($rs->fields);
//print_r((object)$rs->fields);
//print_r( $rs->FetchObj() );
var_dump( $rs->fetchObj() );
$exp = var_export( $rs->fetchObj(), true );
echo $exp;
eval('$new = ' . $exp . ';');
var_dump($new);
die;

print_r( $rs->FetchNextObj() ?: 'false'); var_dump($rs->EOF);
print_r( $rs->FetchNextObj() ?: 'false'); var_dump($rs->EOF);
print_r( $rs->FetchNextObj() ?: 'false'); var_dump($rs->EOF);
print_r( $rs->FetchNextObj() ?: 'false'); var_dump($rs->EOF);
//print_r( $rs->FetchObject() );
