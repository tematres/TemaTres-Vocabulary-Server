<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2020 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */
require "config.tematres.php";

$schema=array2value("schema",$_GET);
$schema=configValue($schema, '', array('skos','zthes','vdex','bs8723','mads','xtm','dc','json','jsonld','rss','tbx'));

if(strlen($schema)>0){
    $term_id=array2value("term_id",$_GET);
    echo selectSchema($schema,$term_id);
}

$skosMeta=array2value("skosMeta",$_GET);
$skosNode=array2value("skosNode",$_GET);

if ($skosMeta==1) {
    header('Content-Type: text/xml');
    echo do_skos("", true);
} elseif ($skosNode) {
    header('Content-Type: text/xml');
    echo do_skosNode(do_nodo_skos($skosNode));
}   

if ((evalUserLevel($_SESSION[$_SESSION["CFGURL"]])==1) && ($_GET["dis"])) {
    switch ($_GET["dis"]) {
        case 'zline':
            return doTotalZthes("line");
        break;

        case 'zfile':
            return doTotalZthes("file");
        break;

        case 'moodfile':
            return doTotalMoodle("file");
        break;

        case 'rline':
            return doTotalSkos("line");
        break;

        case 'rfile':
            $params=array("hasTopTerm" => $_GET["hasTopTermSKOS"]);
            return doTotalSkos("file", $params);
        break;

        case 'vfile':
            return doTotalVDEX("file");
        break;

        case 'siteMap':
            return do_sitemap("file");
        break;

        case 'rxtm':
            return doTotalTopicMap("file");
        break;

        case 'lxtm':
            return doTotalTopicMap("line");
        break;

        case 'BSfile':
            return doTotalBS8723("file");
        break;

        case 'madsFile':
            return doTotalMADS("file");
        break;

        case 'marc':
            echo autoridadesMarcXML();
            break;

        case 'wxr':
            echo doTotalWXR("file");
            break;

        case 'txt':
            header('Content-Type: text/plain');
            $params=array("hasTopTerm" => $_GET["hasTopTerm"],
                      "includeNote" => $_GET["includeNote"],
                      "includeCreatedDate" => $_GET["includeCreatedDate"],
                      "includeTopTerm" => $_GET["includeTopTerm"],
                      "includeModDate" => $_GET["includeModDate"]);
            echo txtAlfabetico($params);
            break;

        case 'termAlpha':
            header('Content-Type: text/plain');
            echo TXTalphaList4term(
                $_GET["term_id"],
                array(
                "includeNote" => array(),
                "includeCreatedDate" => '0',
                "includeTopTerm" => '0',
                "includeModDate" => '0')
            );
            break;

        case 'termTree':
            header('Content-Type: text/plain');
            echo TXTtreeList4term($_GET["term_id"]);
            break;

        case 'jtxt':
            header('Content-Type: text/plain');
            echo txtJerarquico();
            break;

        case 'rsql':
            echo do_mysql_dump();
            break;

        case 'rpdf':
            $params=array("hasTopTerm" => $_GET["hasTopTerm"],
                      "includeNote" => $_GET["includeNote"],
                      "includeCreatedDate" => $_GET["includeCreatedDate"],
                      "includeTopTerm" => $_GET["includeTopTerm"],
                      "includeModDate" => $_GET["includeModDate"]);
            echo do_pdfAlpha($params);
            break;

        case 'spdf':
            $params =array("hasTopTerm" => $_GET["hasTopTerm"]);
            echo do_pdfSist($params);
            break;

        case 'jglossary':
            header('Content-type: application/json');
            $filname = string2url($_SESSION["CFGTitulo"]).'.json';
            return sendFile(makeGlossary($_GET["note4gloss"], array("altTerms" => $_GET["includeAltLabel"])), "$filname");
        break;

        case 'fdspace':
            echo Do_Dspace();
        break;

        case 'ftbx':
            echo doTotalTBX_basic();
            //echo doTotalTBX();
        break;
    }
};