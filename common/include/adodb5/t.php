<?php
include 'adodb.inc.php';
//include 'adodb-exceptions.inc.php';
error_reporting(E_ALL & ~E_DEPRECATED);

$driver = 'mysqli';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'adodb';

$sql = "insert into people (id, name) values (1, 'dupe')";
$param = [];
$sql = "insert into people (id, name) values (?, ?)";
//$param = [1, 'dupe'];
$sql = "select * from people";

$db = ADONewConnection($driver) or die('ARGH');
$db->debug = true;
$db->connect($host, $user, $password, $database) or die('CONNECT FAILED');
$db->setFetchMode(ADODB_FETCH_ASSOC);
//$db->debug=true;

$db->Execute($sql, $param);
var_dump($db->ErrorNo());
var_dump($db->ErrorMsg());

