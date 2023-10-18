<?php
include 'adodb.inc.php';
include 'adodb-pager.inc.php';

$driver = 'mysqli';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'adodb';

$db = ADONewConnection($driver) or die('ARGH');
$db->connect($host, $user, $password, $database) or die('CONNECT FAILED');

//global $gSQLBlockRows;
//$gSQLBlockRows = 2;
$sql = 'select id as "ID", firstname as "First Name", lastname as "Last Name", created as "Date Created" from people';
//$sql = "select 'XSS <script>alert(\"p4wned\")</script>' as htmlCode";
$pager = new ADODB_Pager($db, $sql, 1, true);
//$pager->rows = 2;
$pager->htmlSpecialChars = false;
$pager->Render(5);
