<?php
include 'adodb.inc.php';

$db = newAdoConnection('firebird');
$db->dialect = 3;
$db->connect("localhost:/tmp/test.fdb", 'SYSDBA', 'C0yote71');
if(!$db->isConnected()){
    var_dump($db);
    exit(0);
}
//$db->debug = true;
$query  = "UPDATE test set txt = 'toto5' where id = 1";
$rs = $db->execute($query);
var_dump($rs, $db->_errorMsg);
