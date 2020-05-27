<?php
if (stristr($_SERVER['REQUEST_URI'], "config.tematres.php")) {
    die("no access");
}
/*
 *      config.tematres.php
 *
 *      Copyright 2011 diego ferreyra <diego@r020.com.ar>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

// ARCHIVO DE CONFIGURACION == CONFIG FILE
require 'db.tematres.php';

if ($DBCFG["debugMode"]=='1') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', false);
}

require_once T3_ABSPATH . 'common/include/fun.gral.php';

// Conexión con la BD || => proceso de instalación
$DB = DBconnect();

if (!$DB) {
    loadPage('install.php');
}

// Agregado para la version multi
require_once T3_ABSPATH . 'common/include/config.tematres.php';
require_once T3_ABSPATH . 'common/include/session.php';

if (checkAllowPublication(basename($_SERVER['SCRIPT_NAME'])) == 0) {
    loadPage('login.php');
}

// ID del Tesauro por DEFAULT
$CFG["DFT_TESA"] = '1';

// Config Sites availables for URL search
$CFG["SEARCH_URL_SITES"] = array("wikipedia","Google exacto","Google scholar","Google images","Google books");

// List of alias code for hidden non prefered terms
$CFG["HIDDEN_EQ"] = array("MS","SP","H");

// Config URI base for XML URI as identifiers. If null, use URI vocabulary
$CFG["_URI_BASE_ID"] = '';

// Config char beween _URI_BASE_ID and term ID. If null, use '?tema=' for HTTP response
$CFG["_URI_SEPARATOR_ID"] = 'xml.php?skosTema=';

// Config char encode (only can be: utf-8 or iso-8859-1)
$CFG["_CHAR_ENCODE"] = 'utf-8';

// Google Analytics  GA_TRACKING_ID, Default false=0, to add Google Analytics replace 0 with your GA_TRACKING_ID
$CFG["GA_TRACKING_ID"] = '0';

// use term codes to sort the terms: (1 = Yes, 0 = No: default: 0)
// If you use codes as notations, please see _SHOW_CORE param
$CFG["_USE_CODE"] = ($_SESSION[$_SESSION["CFGURL"]]["_USE_CODE"]);

/*
Define specific  Excluded characters from the alphabetic menu
 */
// $CFG["_EXCLUDED_CHARS"]=array("<",">","[","]","(",")");

// Shown term codes in public view (1 = Yes, 0 = No: default: 0)
$CFG["_SHOW_CODE"] = $_SESSION[$_SESSION["CFGURL"]]["_SHOW_CODE"];

// Enable copy the string value of valid terms with on click. Default true=1
$CFG["COPY_CLICK"] = $_SESSION[$_SESSION["CFGURL"]]["COPY_CLICK"];


// Maximum level of depth in the tree of items for display on the same page [Máximo nivel de profundidad en el árbol de temas para la visualización en una misma página]
define('CFG_MAX_TREE_DEEP', $_SESSION[$_SESSION["CFGURL"]]["CFG_MAX_TREE_DEEP"]);

// Status details visible for any users [Detalles del estado de terminos visibles para todos los usurios] 0 => no public details / 1 => public details
define('CFG_VIEW_STATUS', '1');

// Available Web simple web services (1 = Yes, 0 = No: default: 1)
define('CFG_SIMPLE_WEB_SERVICE', $_SESSION[$_SESSION["CFGURL"]]["CFG_SIMPLE_WEB_SERVICE"]);

// Number of terms display by status view
define('CFG_NUM_SHOW_TERMSxSTATUS', $_SESSION[$_SESSION["CFGURL"]]["CFG_NUM_SHOW_TERMSxSTATUS"]);

// Minimum characters for search operations / número mínimo de caracteres para operaciones de búsqueda
define('CFG_MIN_SEARCH_SIZE', $_SESSION[$_SESSION["CFGURL"]]["CFG_MIN_SEARCH_SIZE"]);

// Include or not meta terms in defaults search operations
define('CFG_SEARCH_METATERM', $_SESSION[$_SESSION["CFGURL"]]["CFG_SEARCH_METATERM"]);

// Enable or not SPARQL endpoint. Default is 0 (disable)
define('CFG_ENABLE_SPARQL', $_SESSION[$_SESSION["CFGURL"]]["CFG_ENABLE_SPARQL"]);

// Method to predict search or suggest search terms: by the beginning each word or by the begining of the complete term (concept). Default is by word == 1.
define('CFG_SUGGESTxWORD', $_SESSION[$_SESSION["CFGURL"]]["CFG_SUGGESTxWORD"]);

// Define way to display top terms, 0=AJAX, 1=HTML div, default = 0
$CFG["_TOP_TERMS_BROWSER"] = '0';

// Define char to recognice tag separator in txt import procedure. default = ":"
$CFG["IMP_TAG_SEPARATOR"]  = ':';

// Define char to recognice as tabulator, tabulator is char used in txt import procedure to asig to the term the same relation as previous relation. default = "==="
$CFG["IMP_TAG_TABULATOR"]  = '===';

/* Config here to publish image and fixed link in header:

    URL_IMG= URL for the image.
    URL_LINK= link for the image (optional)

 Example
 $CFG["HEADER_EXTRA"] =array(
     "LINK_IMG"=>'http://vocabularyserver.com/img/tematres-logo.gif',
    "LINK_URL"=>'http://vocabularyserver.com/',
    "LINK_TITLE"=>'TemaTres: open source way to manage formal representations of knowledge'
    );
 */

$CFG["HEADER_EXTRA"] = array(
    "LINK_IMG" => '',
    "LINK_URL" => '',
    "LINK_TITLE" => ''
);

/*  In almost cases, you don't need to touch nothing here!!
 *  Web path to the directory where are located
 */

if (!defined('T3_WEBPATH')) {
    define('T3_WEBPATH', getURLbase().'../common/');
}

require_once T3_ABSPATH . 'common/include/fun.sql.php';
require_once T3_ABSPATH . 'common/include/fun.xml.php';
require_once T3_ABSPATH . 'common/include/fun.html.php';
require_once T3_ABSPATH . 'common/include/fun.html_forms.php';

//////////////////// ADMINISTRACION y GESTION ////////////////////////////
if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) {
    include_once T3_ABSPATH . 'common/include/fun.admin.php';
}
