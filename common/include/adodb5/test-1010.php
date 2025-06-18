<?php
require 'adodb.inc.php';
require 'adodb-xmlschema03.inc.php';

$hostname = 'localhost';
$username = 'root';
$password = 'C0yote71';
$database = 'adodb';

$TABLE = 'tbl_1010';
$xml1 = <<<END
	<schema version="0.3">
		<table name="$TABLE">
			<descr>test table</descr>
			<field name="id"            type="I" size="10"   ><NOTNULL/></field>
			<field name="column1"       type="C" size="30"   ><NOTNULL/></field>
		</table>
	</schema>
	END;
$xml2 = <<<END
	<schema version="0.3">
		<table name="$TABLE">
			<descr>test table</descr>
			<field name="id"            type="I" size="10"   ><NOTNULL/></field>
			<field name="column1"       type="C" size="30"   ><NOTNULL/></field>
			<field name="column2"       type="C" size="30"   ><NOTNULL/></field>
			<field name="column3"       type="C" size="30"   ><NOTNULL/></field>
		</table>
	</schema>
	END;

$db = ADONewConnection ('mysqli');
$db->Connect ($hostname, $username, $password, $database) ;
//$db->debug = true;

// Drop & recreate the table
$db->Execute('DROP TABLE tbl_1010');
run($xml1) or die(1);

//$db->Execute('ALTER TABLE tbl_1010 ADD extra INT NOT NULL');
run($xml1) or die(1);
//$db->Execute('ALTER TABLE tbl_1010 DROP COLUMN column2');
//$db->Execute('ALTER TABLE tbl_1010 DROP COLUMN column3');
//$db->Execute('ALTER TABLE tbl_1010 ADD extra INT NOT NULL');

run($xml2) or die(1);

function run($xml) {
	global $db;

	$schema = new adoSchema($db);
	$schema->SetUpgradeMethod ('BEST') ;
	$schema->continueOnError = false;
	$schema->executeInline(false);

	$sql = $schema->parseSchemaString($xml);
	echo "Generated SQL: "; print_r($sql);

	$result = $schema->ExecuteSchema();
	echo "Execute: $result\n";
	echo $db->ErrorMsg();

	return $result == 2;
}
