<?php
include('adodb.inc.php');
$db = @NewADOConnection('oci8');
echo $db->DBDate('2024-10-28') . "\n";
echo $db->DBDate(new DateTimeImmutable()) . "\n";
echo $db->DBDate(time()) . "\n";

echo $db->DBTimeStamp('2024-10-28 12:34:56') . "\n";
echo $db->DBTimeStamp(new DateTimeImmutable()) . "\n";
echo $db->DBTimeStamp(time()) . "\n";
