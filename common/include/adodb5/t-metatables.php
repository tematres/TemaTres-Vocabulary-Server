<?php
include 'adodb.inc.php';
$db = ADONewConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');
//print_r( $db->metatables(false, false) );
print_r( $db->metatables('T', true) );
print_r( $db->metatables('V', true) );
