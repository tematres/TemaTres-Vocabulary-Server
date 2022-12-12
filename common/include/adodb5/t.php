<?php
include 'adodb.inc.php';
//include 'adodb-exceptions.inc.php';
//error_reporting(E_ALL & ~E_DEPRECATED);
$driver = 'mysqli';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'test';

$sql = "insert into people (id, name) values (1, 'dupe')";
$param = [];
$sql = "insert into people (id, name) values (?, ?)";
$param = [1, 'dupe'];

$db = NewADOConnection($driver);
$db->connect($host, $user, $password, $database);
$db->setFetchMode(ADODB_FETCH_ASSOC);
//$db->debug=true;

$db->Execute($sql, $param);
var_dump($db->ErrorNo());
var_dump($db->ErrorMsg());

$db->Execute('select * from test2');
var_dump($db->ErrorNo());
var_dump($db->ErrorMsg());

