<?php
include 'adodb.inc.php';
include 'adodb-csvlib.inc.php';

$db = newAdoConnection('mysqli');
$db->connect("localhost", 'root', 'C0yote71', 'adodb');
if(!$db->isConnected()){
    var_dump($db);
    exit(0);
}
//$db->debug = true;
$query  = "SELECT * FROM toto";
$rs = $db->execute($query);
$serial = _rs2serialize($rs);
var_dump($serial);
