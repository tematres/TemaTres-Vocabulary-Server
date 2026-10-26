<?php
/*
 * db.tematres.php for the container: the database settings come from environment variables
 * (TEMATRES_DB_HOST, TEMATRES_DB_NAME, TEMATRES_DB_USER, TEMATRES_DB_PASSWORD, TEMATRES_DB_PREFIX), so no password is stored in the image.
 * Replaces vocab/db.tematres.php in the image (see docker/Dockerfile).
 */
$DBCFG["DBdriver"]  = "mysqli";
$DBCFG["Server"]    = getenv('TEMATRES_DB_HOST') ?: 'db';
$DBCFG["DBName"]    = getenv('TEMATRES_DB_NAME') ?: 'tematres';
$DBCFG["DBLogin"]   = getenv('TEMATRES_DB_USER') ?: 'tematres';
$DBCFG["DBPass"]    = (string) getenv('TEMATRES_DB_PASSWORD'); // not ?:, a password may be "0"
$DBCFG["DBprefix"]  = getenv('TEMATRES_DB_PREFIX') ?: 'lc_';
$DBCFG["DBcharset"] = "utf8";
$DBCFG["debugMode"] = "0";
$DBCFG["DBpersist"] = "0";
// Plain Connect(), not the DSN mode
$DBCFG["DBmodeConnect"] = "";
$DBCFG["DBengine"]  = "InnoDB";
define('CFG_HASH_PASS', '1');
if (!defined('T3_ABSPATH')) {
    define('T3_ABSPATH', dirname(__FILE__) . '/../');
}
