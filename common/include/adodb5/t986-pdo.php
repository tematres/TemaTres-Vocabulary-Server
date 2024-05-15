<?php
include 'adodb.inc.php';
$db = ADONewConnection('pdo');
$db->connect('mysql:host=localhost;dbname=adodb;charset=utf8mb4', 'root', 'C0yote71');

try {
	$r = $db->getall('select * from people where id=:id', ['id' => 45]);
}
catch( Exception $e) {
	echo $e->getMessage() . PHP_EOL;
	echo $e->getTraceAsString();
	exit(0);
}
print_r($r);
exit(1);
