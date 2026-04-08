<?php
include 'adodb.inc.php';
include 'adodb-exceptions.inc.php';

$db = NewADOConnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');

$db->execute('create table if not exists t1075 (id int not null auto_increment primary key, ts timestamp)');

class DT extends DateTime {
	function __toString() { return $this->format('Y-m-d H:i:s'); }
}

$db->debug = true;
$sql = 'INSERT INTO t1075 (ts) VALUES (?)';
$db->Execute($sql, [new DT()]);
