<style>
	.adodb-debug-trace table {
		border-spacing: 0;
		border: 1px solid;
	}
	.adodb-debug-trace th, .adodb-debug-trace td {
		border: 1px solid;
		padding: 2px 6px;
	}
	.adodb-debug-trace thead {
		background-color: darkgray;
	}
</style>
<?php
/** 
 * Testing for debug mode formatting
 */
include 'adodb.inc.php';
$db = adonewconnection('mysqli');
$db->connect('localhost', 'root', 'C0yote71', 'bugtracker');

//test('Successful statement', 'select * from mantis_project_table');
//test('No match param', 'select * from mantis_project_table where id = ?', [1,2]);
test('Non-existing table', 'select * from xxx');
1/0;

function test($title, $sql, $param = null) {
	global $db;
	prt($title);
	foreach([true, -1, -99, 99] as $mode) {
		prt("######## DEBUG MODE $mode", 2);
		$db->debug = $mode;
		if ($param) {
			$db->query($sql, $param);
		} else {
			$db->query($sql);
		}
		echo "\n";
	}
}

function prt($title, $level = 1) {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		echo "<h$level>$title</h$level>";
	} else {
		echo $title;
	}
	echo PHP_EOL;
}
