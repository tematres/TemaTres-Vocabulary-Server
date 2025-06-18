<?php
include("adodb.inc.php");
include_once "session/adodb-session2.php";

$hostname = 'localhost';
$username = 'root';
$password = 'C0yote71';
$database = 'adodb';

//$lifetime = 23328000;
$lifetime = 600;
$conn = newADOConnection('mysqli');
if ( !$conn->Connect ($hostname, $username, $password, $database) ) {
	echo "down.php";
	die();
}

$conn->setCharset('utf8');
//$ADODB_SESS_DEBUG = true;
ADOdb_Session::lifetime($lifetime);
ADOdb_Session::config("mysqli", $hostname, $username, $password, $database, false);

ini_set('session.name', 'hrintranet');
ini_set('session.use_cookies', 1);
ini_set('session.gc_maxlifetime', $lifetime);
ini_set('session.cookie_lifetime', $lifetime);
ini_set("session.cookie_httponly", 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_start();
echo '<pre>';

if (!isset($_SESSION['count'])) {
	$_SESSION['count'] = 0;
} else {
	$_SESSION['count']++;
}

$id = session_id();
echo "\nSession Id: $id - count ${_SESSION['count']} - " .sys_get_temp_dir() . PHP_EOL;
session_gc();
