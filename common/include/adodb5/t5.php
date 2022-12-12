<?php
/**
 * Testing for missing pgsql php extension
 */
include 'adodb.inc.php';
include 'adodb-error.inc.php';
//include 'adodb-exceptions.inc.php';

$driver = 'pgsql';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'test';

$db = NewADOConnection($driver);
$db->debug=true;
$res = $db->connect($host, $user, $password, $database);
var_dump(get_class($db), $res);
echo "{$db->ErrorMsg()} ({$db->ErrorNo()})\n";

echo $db->MetaErrorMsg($db->ErrorNo());

//$db->execute('select * from test');
