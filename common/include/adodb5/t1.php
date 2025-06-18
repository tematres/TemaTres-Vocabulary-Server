<?php
$user = 'root';
$pass = 'C0yote71';
$dbname = 'bugtracker';
include 'adodb.inc.php';
$db = adonewconnection('pgsql');
$db->connect('localhost', $user, $pass, $dbname);

print_r($db->ServerInfo());
//$db->debug = true;
//print_r($db->MetaTables());
print_r($db->MetaTables('TABLES'));
//print_r($db->MetaTables('VIEWS'));
