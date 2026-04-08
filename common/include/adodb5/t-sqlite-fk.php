<?php
include 'adodb.inc.php';
$db = NewADOConnection('sqlite3');
$db->connect('poc.db');
var_export( $db->metaForeignKeys('t2', '', false, false) );

// All foreign key references regex
// (?:\(|,)\s*(?:FOREIGN\s+KEY\s*\(([^\)]+)\)|(\w+).*?)\s*REFERENCES\s+(\w+|"[^"]+")\(([^\)]+)\)
// 1|2 = col(s) name(s)
// 3 parent table
// 4 parent cols
