<?php
include 'adodb.inc.php';
$db = ADONewConnection('mysql');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
$rs = $db->execute('select lastname, firstname from people');
var_dump( $db->getinsertsql($rs, ['lastname'=>'Regad','firstnamE'=>'Damien'] ));
