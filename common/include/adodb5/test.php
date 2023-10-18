<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
	# Print stylesheet
?>
<style>
.adodb-debug-trace table {
    border-spacing: 0;
    border: 1px solid;
}
.adodb-debug-trace thead {
    background-color: darkgray;
}
.adodb-debug-trace th, .adodb-debug-trace td {
    border: 1px solid;
    padding: 2px 6px;
}
.adodb-debug-sql code {
    font-size: large;
}
.adodb-debug-errmsg {
    font-weight: bold;
    color: red;
}
</style>
<?php
}

/**
 * Testing for debug mode formatting
 */
include 'adodb.inc.php';
$db = adonewconnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'adodb');

$db->debug=true;
//$db->execute('select * from product');
$db->execute('SELECT * FRO products WHERE id = ?', [1]);
die;

test('Successful statement', 'select * from mantis_project_table');
test('Successful statement with param', 'select * from mantis_project_table where id = ?', [1]);
test('No match param', 'select * from mantis_project_table where id = ?', [1,2]);
test('Non-existing table', 'select * from xxx');
//1/0;

function test($title, $sql, $param = null) {
	global $db;
	prt($title);
	foreach([false, true, -1, 99, -99] as $mode) {
		prt("######## DEBUG MODE $mode", 2);
		$db->debug = $mode;
		if ($param) {
			$db->query($sql, $param);
		} else {
			$db->query($sql);
		}
		echo "\n\n";
	}
}

function prt($title, $level = 1) {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		if ($level == 1) {
			echo "<hr><hr>";
		}
		echo "<h$level>$title</h$level>";
	} else {
		if ($level == 1) {
			echo str_repeat('=', 80) . PHP_EOL;
		}
		echo $title . PHP_EOL;
	}
	echo PHP_EOL;
}
