<?php
error_reporting( E_ALL & ~E_DEPRECATED);

include 'adodb.inc.php';
include 'adodb-pager.inc.php';

$driver = 'mysqli';
$host = 'localhost';
$user = 'root';
$password = 'C0yote71';
$database = 'adodb';

$db = ADONewConnection($driver) or die('ARGH');
$db->connect($host, $user, $password, $database) or die('CONNECT FAILED');
$db->setFetchMode(ADODB_FETCH_ASSOC);

//global $gSQLBlockRows;
//$gSQLBlockRows = 2;
$sql = 'select id as "ID", firstname as "First Name", lastname as "Last Name", created as "Date Created" from people';
//$sql = "select 'XSS <script>alert(\"p4wned\")</script>' as htmlCode";
//$pager = new ADODB_Pager($db, $sql, 1, true);
//$pager->rows = 2;
//$pager->htmlSpecialChars = false;
//$pager->Render(5);

$sql1 = 'select id, lastname from people where id = 1';
$sql2 = 'select id, lastname from people where id = ?';

$rs = $db->Execute($sql1);
echo "ADOdb no param: "; var_dump($rs->GetArray());
$rs = $db->Execute($sql2, 1);
echo "ADOdb with param: "; var_dump($rs->GetArray());

$my = new mysqli($host, $user, $password, $database);
echo "mysqli execute_query no param: "; var_dump($my->execute_query($sql1)->fetch_assoc());
echo "mysqli execute_query with param: ";var_dump($my->execute_query($sql2, [1])->fetch_assoc());
echo "mysqli query no param: ";var_dump($my->query($sql1)->fetch_assoc());

$st = $my->prepare($sql2);
$st->execute([1]);
echo "mysqli execute prepared: ";var_dump($st->get_result()->fetch_assoc());