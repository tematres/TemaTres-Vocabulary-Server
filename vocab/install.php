<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2020 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */
if (!defined('T3_WEBPATH')) {
    define('T3_WEBPATH', getURLbaseInstall().'../common/');
}

$CFG["_CHAR_ENCODE"] ='utf-8';

$page_encode = (in_array($CFG["_CHAR_ENCODE"], array('utf-8','iso-8859-1'))) ? $CFG["_CHAR_ENCODE"] : 'utf-8';

header('Content-type: text/html; charset='.$page_encode.'');

//Config lang
$lang='';
$tematres_lang='';
$lang_install=(isset($_GET["lang_install"])) ? $_GET["lang_install"] : 'en-EN';

$lang = $tematres_lang=(in_array($lang_install, array('ca-ES','de-DE','en-EN','es-ES','fr-FR','it-IT','nl-NL','pt-PT','pt-BR'))) ? $lang_install : 'en-EN';
  //1. check if config file exist
if (!file_exists('db.tematres.php')) {
    return message('<div class="error">Configuration file <code>db.tematres.php</code> not found!</div><br/>');
} else {
    include 'db.tematres.php';
    include_once T3_ABSPATH . 'common/include/config.tematres.php';
}


require_once T3_ABSPATH . 'common/lang/'.$lang.'-utf-8.inc.php' ;

function message($mess)
{
    echo "" ;
    echo XSSprevent($mess) ;
    echo "<br/>" ;
}


// Return base URL of the current URL or instance of vocabulary
function getURLbaseInstall()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : (($_SERVER["HTTPS"] == "on") ? "s" : "");
    $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    $uri = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    $segments = explode('?', $uri, 2);
    $url = $segments[0];

    $url_base=substr($url, 0, strripos($url, "/")+1);

    return $url_base;
}


//check install data
function checkDataInstall($array = array())
{

    $installData=array();

    if (strlen($array["title"])>1) {
        $installData["title"]=$array["title"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_Titulo.'</strong></p>';
    };

    if (strlen($array["author"])>1) {
        $installData["author"]=$array["author"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_Autor.'</strong></p>';
    }

    if (strlen($array["name"])>1) {
        $installData["name"]=$array["name"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_nombre.'</strong></p>';
    }
    if (strlen($array["s_name"])>1) {
        $installData["s_name"]=$array["s_name"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_apellido.'</strong></p>';
    }

    if (filter_var($array["mail"], FILTER_VALIDATE_EMAIL)) {
        $installData["mail"]=$array["mail"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_mail.'</strong></p>';
    }
    if ((strlen($array["mdp"])>4) && ($array["mdp"]==$array["password"])) {
        $installData["password"]=$array["password"];
    } else {
        $instalChk["error_msg"].='<p class="alert alert-danger" role="alert">'.MSG_errorPostData.': <strong>'.LABEL_pass.'</strong></p>';
    }
      $installData["lang"]=$array["lang"];
      $installData["kos_type"]=$array["kos_type"];

    if ($instalChk["error_msg"]) {
        return $instalChk;
    }

      return $installData;
}


//check install environment
function checkInstall($lang)
{
    global $install_message;

    $conf_file_path =  str_replace("install.php", "db.tematres.php", "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);

    //1. check if config file exist
    if (!file_exists('db.tematres.php')) {
        return message('<div class="alert alert-danger" role="alert">'.sprintf($install_message["201"], $conf_file_path).'</div><br/>');
    } else {
        include 'db.tematres.php';
    }


    if ($DBCFG["debugMode"]==0) {
        //silent warnings
        error_reporting(0);
        $label_login='';
        $label_dbname='';
        $label_server='';
    } else {
        $label_login=$DBCFG["DBLogin"];
        $label_dbname=$DBCFG["DBName"];
        $label_server=$DBCFG["Server"];
    };
    //2. check connection to server

    include_once T3_ABSPATH . 'common/include/adodb5/adodb.inc.php';

    //default driver
    $DBCFG["DBdriver"]=($DBCFG["DBdriver"]) ? $DBCFG["DBdriver"] : "mysqli";

    $DB = NewADOConnection($DBCFG["DBdriver"]);

    if (!$DB->Connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"])) {
        return message('<div class="alert alert-danger" role="alert">'.sprintf($install_message["203"], $label_server, $label_login, $conf_file_path).'</div><br/>');
    }

    //~
    //3. check connection to database
    if (!$DB->Connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"], $DBCFG["DBName"])) {
        return message('<div class="alert alert-danger" role="alert">'.sprintf($install_message["205"], $label_dbname, $label_server, $conf_file_path).'</div><br/>');
    }


    //4. check tables

    $sqlCantTables=$DB->Execute('SHOW TABLES from `'.$DBCFG["DBName"].'` where `tables_in_'.$DBCFG["DBName"].'` in (\''.$DBCFG["DBprefix"].'config\',\''.$DBCFG["DBprefix"].'indice\',\''.$DBCFG["DBprefix"].'notas\',\''.$DBCFG["DBprefix"].'tabla_rel\',\''.$DBCFG["DBprefix"].'tema\',\''.$DBCFG["DBprefix"].'usuario\',\''.$DBCFG["DBprefix"].'values\')');
    $cantTables=(is_object($sqlCantTables)) ? $sqlCantTables->RecordCount() : 0;

    if ($cantTables=='7') {
        return message('<div class="alert alert-danger" role="alert">'.$install_message["301"].'</div>');
    } else {

        //Final step: dump or form
        if (isset($_POST['send'])) {
            $arrayInstallData=checkDataInstall($_POST);
            if (count($arrayInstallData)==8) {
                SQLtematres($DBCFG, $DB, $arrayInstallData);
            } else {
                echo $arrayInstallData["error_msg"];
                echo HTMLformInstall($lang);
            }
        } else {
            echo HTMLformInstall($lang);
        }
    }
}


function SQLtematres($DBCFG, $DB, $arrayInstallData = array())
{
    include_once T3_ABSPATH . 'common/include/fun.gral.php';

    /** Si se establecio un charset para la conexion */
    $dbcharset = (@$DBCFG["DBcharset"]) ? (@$DBCFG["DBcharset"]) : 'utf8';
    
    $DB->Execute("SET NAMES $dbcharset");

    $prefix=$DBCFG["DBprefix"] ;
    
    $engine = (array_key_exists("DBengine", $DBCFG)) ?  $DBCFG["DBengine"]: 'MyISAM';
    $engine = (in_array($engine, array('MyISAM','InnoDB'))) ? $engine : 'MyISAM' ;


    $result1 = $DB->Execute(
        "CREATE TABLE `".$prefix."config` (
      `id` int(5) unsigned NOT NULL auto_increment,
      `titulo` varchar(255) NOT NULL default '',
      `autor` varchar(255) NOT NULL default '',
      `idioma` char(5) NOT NULL default 'es',
      `cobertura` text,
      `keywords` varchar(255) default NULL,
      `tipo` varchar(100) default NULL,
      `polijerarquia` tinyint(1) NOT NULL default '1',
      `cuando` date NOT NULL ,
      `observa` text,
      `url_base` varchar(255) default NULL,
      PRIMARY KEY  (`id`)
    ) DEFAULT CHARSET=$dbcharset ENGINE=$engine ;"
    );
 
    //If create table --> insert data
    if ($result1) {
        $today = date("Y-m-d");
        $http = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';

        $url =  str_replace("install.php", "", $http.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
        $title = ($arrayInstallData['title']) ? $DB->qstr(trim($arrayInstallData["title"])) : "'TemaTres'";
        $author = ($arrayInstallData['author']) ? $DB->qstr(trim($arrayInstallData["author"])) : "'TemaTres'";
        $kos_type = ($arrayInstallData['kos_type']) ? $DB->qstr(trim($arrayInstallData["kos_type"])) : "'list'";
        $tematres_lang=$DB->qstr(trim($arrayInstallData["lang"]));
        $tematres_lang=($tematres_lang) ?  $tematres_lang : 'es';
        

        $comment = '';


        $result2 = $DB->Execute(
            "INSERT INTO `".$prefix."config`
      (`id`, `titulo`, `autor`, `idioma`,  `tipo`, `polijerarquia`, `cuando`, `observa`, `url_base`)
      VALUES (1, $title, $author, $tematres_lang, $kos_type, '1', '$today', NULL, '$url');"
        );
    }
    $result3 = $DB->Execute(
        "CREATE TABLE `".$prefix."indice` (
          `tema_id` int(11) NOT NULL default '0',
          `indice` varchar(250) NOT NULL default '',
          PRIMARY KEY  (`tema_id`),
          KEY `indice` (`indice`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine COMMENT='indice de temas';"
    );

    $result4 = $DB->Execute(
        "CREATE TABLE `".$prefix."notas` (
          `id` int(11) NOT NULL auto_increment,
          `id_tema` int(11) NOT NULL ,
          `tipo_nota` char(3) NOT NULL default 'NA',
          `lang_nota` varchar(7) default NULL,
          `nota` mediumtext NOT NULL,
          `cuando` datetime NOT NULL ,
          `uid` int(22) NOT NULL default '0',
            `src_id` int(22) DEFAULT NULL,          
          PRIMARY KEY  (`id`),
          KEY `id_tema` (`id_tema`),
          KEY `orden_notas` (`tipo_nota`,`lang_nota`),
            KEY `src_id` (`src_id`),          
          FULLTEXT `notas` (`nota`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine ;"
    );

    $result5 = $DB->Execute(
        "CREATE TABLE `".$prefix."tabla_rel` (
          `id_mayor` int(5) NOT NULL default '0',
          `id_menor` int(5) NOT NULL default '0',
          `t_relacion` tinyint(1) unsigned NOT NULL ,
          `rel_rel_id` int(22) NULL,
          `id` int(9) unsigned NOT NULL auto_increment,
          `uid` int(10) unsigned NOT NULL default '0',
          `cuando` datetime NOT NULL ,
          PRIMARY KEY  (`id`),
          UNIQUE KEY `NewIndex` (`id_mayor`,`id_menor`),
          KEY `unico` (`t_relacion`),
          KEY `id_menor` (`id_menor`),
          KEY `id_mayor` (`id_mayor`),
          KEY `rel_rel_id` (`rel_rel_id`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine ;"
    );

    $result6 = $DB->Execute(
        "CREATE TABLE `".$prefix."tema` (
          `tema_id` int(10) NOT NULL auto_increment,
          `code` VARCHAR( 150 ) NULL COMMENT 'code_term' ,
          `tema` varchar(250) default NULL,
          `tema_hash` varchar(12) DEFAULT NULL,          
          `tesauro_id` int(5) NOT NULL ,
          `uid` tinyint(3) unsigned NOT NULL ,
          `cuando` datetime NULL ,
          `uid_final` int(5) unsigned default NULL,
          `cuando_final` datetime default NULL,
          `estado_id` int(5) NOT NULL default 13,
          `cuando_estado` datetime NOT NULL ,
          `isMetaTerm` BOOLEAN NOT NULL DEFAULT FALSE,
          PRIMARY KEY  (`tema_id`),
          UNIQUE KEY `ndx_hash` (`tema_hash`),          
          KEY ( `code` ),
          FULLTEXT KEY `tema` (`tema`),
          KEY `cuando` (`cuando`,`cuando_final`),
          KEY `uid` (`uid`,`uid_final`),
          KEY `tesauro_id` (`tesauro_id`),
          KEY `estado_id` (`estado_id`),
          KEY `isMetaTerm` (`isMetaTerm`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine ;"
    );

    $result61 = $DB->Execute(
        "CREATE TABLE IF NOT EXISTS `".$prefix."term2tterm` (
         `tterm_id` int(22) NOT NULL AUTO_INCREMENT,
          `tvocab_id` int(22) NOT NULL,
          `tterm_url` varchar(200) NOT NULL,
          `tterm_uri` varchar(200) NOT NULL,
          `tterm_string` varchar(250) NOT NULL,
          `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `cuando_last` timestamp NULL DEFAULT NULL,
          `uid` int(22) NOT NULL,
          `tema_id` int(22) NOT NULL,
          PRIMARY KEY (`tterm_id`),
          KEY `tvocab_id` (`tvocab_id`,`cuando`,`cuando_last`,`uid`),
          KEY `tema_id` (`tema_id`),
            KEY `target_terms` (`tterm_string`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine;"
    );

    $result62 = $DB->Execute(
        "CREATE TABLE IF NOT EXISTS `".$prefix."tvocab` (
         `tvocab_id` int(22) NOT NULL AUTO_INCREMENT,
          `tvocab_label` varchar(150) NOT NULL,
          `tvocab_tag` varchar(20) NOT NULL,
          `tvocab_lang` VARCHAR( 5 ),
          `tvocab_title` varchar(200) NOT NULL,
          `tvocab_url` varchar(250) NOT NULL,
          `tvocab_uri_service` varchar(250) NOT NULL,
          `tvocab_status` tinyint(1) NOT NULL,
          `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `uid` int(22) NOT NULL,
          PRIMARY KEY (`tvocab_id`),
          KEY `uid` (`uid`),
          KEY `status` (`tvocab_status`)
        ) ENGINE=$engine DEFAULT CHARSET=$dbcharset;"
    );

    $result7 = $DB->Execute(
        "CREATE TABLE `".$prefix."usuario` (
          `APELLIDO` varchar(150) default NULL,
          `NOMBRES` varchar(150) default NULL,
          `uid` int(9) unsigned default NULL,
          `cuando` date default NULL,
          `id` int(11) unsigned NOT NULL auto_increment,
          `mail` varchar(255) default NULL,
          `pass` varchar(60) NOT NULL ,
          `orga` varchar(255) default NULL,
          `nivel` tinyint(1) unsigned NOT NULL default 2,
          `estado` set('ACTIVO','BAJA') NOT NULL default 'BAJA',
          `hasta` datetime NOT NULL  ,
          `user_activation_key` varchar(60) DEFAULT NULL,
          PRIMARY KEY  (`id`),
          UNIQUE KEY `mail` (`mail`),
          KEY `pass` (`pass`),
          KEY `user_activation_key` (`user_activation_key`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine ;"
    );

    $result9 = $DB->Execute(
        "CREATE TABLE `".$prefix."values` (
          `value_id` int(11) NOT NULL auto_increment,
          `value_type` varchar(64) NOT NULL default '0',
          `value` longtext default NULL ,
          `value_order` tinyint(4) default NULL,
          `value_code` varchar(20) default NULL,
          PRIMARY KEY  (`value_id`),
          KEY `value_type` (`value_type`)
        ) DEFAULT CHARSET=$dbcharset ENGINE=$engine COMMENT='general values table';"
    );

    $result10 = $DB->Execute(
        "CREATE TABLE `".$prefix."uri` (
        `uri_id` int(22) NOT NULL AUTO_INCREMENT,
        `tema_id` int(22) NOT NULL,
        `uri_type_id` int(22) NOT NULL,
        `uri` tinytext NOT NULL,
        `uid` int(22) NOT NULL,
        `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`uri_id`),
        KEY `tema_id` (`tema_id`)
      ) CHARSET=$dbcharset ENGINE=$engine  COMMENT='external URIs associated to terms';"
    );

    $result10a = $DB->Execute(
        "CREATE TABLE `".$prefix."sources` (
        `src_id` int(11) NOT NULL AUTO_INCREMENT,
        `src_alias` varchar(50) NOT NULL,
        `src_note` tinytext,
        `src_url` tinytext,
        `src_uri` varchar(255) DEFAULT NULL,
        `src_status` tinyint(1) DEFAULT NULL,
        `create_date` datetime NOT NULL,
        `mod_date` datetime DEFAULT NULL,
        `user_id` int(5) NOT NULL DEFAULT '0',
        PRIMARY KEY (`src_id`),
          KEY `src_alias` (`src_alias`)        
      ) ENGINE=$engine CHARSET=$dbcharset COMMENT='Normalized authority sources for notes';"
    );



    $local_naan=hashmaker(NAAN, NAAN.getURLbaseInstall());

    $result10b = $DB->Execute(
        "INSERT INTO `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES (2, 't_relacion', 'Termino relacionado', NULL, 'TR'),
        (3, 't_relacion', 'Termino superior', NULL, 'TG'),
        (4, 't_relacion', 'Usado por', NULL, 'UP'),
        (5, 't_relacion', 'Equivalencia parcial', NULL, 'EQ_P'),
        (6, 't_relacion', 'Equivalencia total', NULL, 'EQ'),
        (7, 't_relacion', 'No equivalencia', NULL, 'EQ_NO'),
        (8, 't_nota', 'Nota de alcance', 1, 'NA'),
        (9, 't_nota', 'Nota histórica', 2, 'NH'),
        (10, 't_nota', 'Nota bibliografica', 3, 'NB'),
        (11, 't_nota', 'Nota privada', 4, 'NP'),
        (1, 't_usuario', 'Admin', NULL, 'admin'),
        (12, 't_estado', 'termino candidato', 1, 'C'),
        (13, 't_estado', 'termino activo', 2, 'A'),
        (14, 't_estado', 'termino rechazado', 3, 'R'),
        (15, 't_nota', 'Nota catalográfica', 2, 'NC'),
        (16, 'config', '_USE_CODE', 1, '0'),
        (17, 'config', '_SHOW_CODE', 1, '0'),
        (18, 'config', 'CFG_MAX_TREE_DEEP', NULL, '3'),
        (19, 'config', 'CFG_VIEW_STATUS', NULL, '0'),
        (20, 'config', 'CFG_SIMPLE_WEB_SERVICE', NULL, '1'),
        (21, 'config', 'CFG_NUM_SHOW_TERMSxSTATUS', NULL, '200'),
        (22, 'config', 'CFG_MIN_SEARCH_SIZE', NULL, '2'),
        (23, 'config', '_SHOW_TREE', '1', '1'),
        (24, 'config', '_PUBLISH_SKOS', '1', '0'),
        (25,'4', 'Spelling variant', NULL, 'SP'),
        (26,'4', 'MisSpelling', NULL, 'MS'),
        (27,'3', 'Partitive', NULL, 'P'),
        (28,'3', 'Instance', NULL, 'I'),
        (30,'4', 'Abbreviation', NULL, 'AB'),
        (31,'4', 'Full form of the term', NULL, 'FT'),
        (32,'URI_TYPE', 'broadMatch', NULL, 'broadMatch'),
        (33,'URI_TYPE', 'closeMatch', NULL, 'closeMatch'),
        (34,'URI_TYPE', 'exactMatch', NULL, 'exactMatch'),
        (35,'URI_TYPE', 'relatedMatch', NULL, 'relatedMatch'),
        (36,'URI_TYPE', 'narrowMatch', NULL, 'narrowMatch'),
        (37,'DATESTAMP',now(), NULL,'NOTE_CHANGE'),
        (38,'DATESTAMP',now(), NULL,'TERM_CHANGE'),
        (39,'DATESTAMP',now(), NULL,'TTERM_CHANGE'),
        (40,'DATESTAMP',now(), NULL,'THES_CHANGE'),
        (41,'METADATA',NULL, 2,'dc:contributor'),
        (42,'METADATA',NULL, 5,'dc:publisher'),
        (43,'METADATA',NULL, 9,'dc:rights'),
        (44,'4', 'Hidden', NULL, 'H'),
        (45, 'config', 'CFG_SEARCH_METATERM', NULL, '0'),
        (46, 'config', 'CFG_ENABLE_SPARQL', NULL, '0'),
        (47, 'config', 'CFG_SUGGESTxWORD', NULL, '1'),
        (48, 't_nota', 'Definition note', 5, 'DF'),
        (49, 'config', 'CFG_PUBLISH', NULL, '1'),
        (50, 'config', 'CFG_ALLOW_DUPLICATED', NULL, '0'),
        (51, 't_nota', 'Example note', 6, 'EX'),
        (52, 'config', 'COPY_CLICK', NULL, '1'),
        (53, 'METADATA', '$local_naan', NULL, 'CFG_ARK_NAAN');"
    );

    //If create table --> insert data
    if (is_object($result7)) {
        $admin_mail=($arrayInstallData['mail']) ? $DB->qstr(trim($arrayInstallData['mail'])) : "'admin@r020.com.ar'";
        $admin_name=($arrayInstallData['name']) ? $DB->qstr(trim($arrayInstallData['name'])) : "'admin name'";
        $admin_surname=($arrayInstallData['s_name']) ? $DB->qstr(trim($arrayInstallData['s_name'])) : "'admin sur name'";


        $admin_pass=($arrayInstallData['password']) ? trim($arrayInstallData['password']) : "'admin'";

        include_once T3_ABSPATH . 'common/include/fun.gral.php';

        $admin_pass_hash=(CFG_HASH_PASS==1) ? t3_hash_password($admin_pass) : $admin_pass;

        $admin_pass_hash=($admin_pass_hash) ? $DB->qstr(trim($admin_pass_hash)) : "'admin'";


        $result8=$DB->Execute(
            "INSERT INTO
      `".$prefix."usuario` (`APELLIDO`, `NOMBRES`, `uid`, `cuando`, `id`, `mail`, `pass`, `orga`, `nivel`, `estado`, `hasta`)
      VALUES
      ($admin_surname,$admin_name, 1, now(), 1, $admin_mail,$admin_pass_hash, 'TemaTres', 1, 'ACTIVO', now())"
        );

        //echo $DB->ErrorMsg();

        //Tematres installed
        if (is_object($result8)) {
            global $install_message;

            $return_true = '<div>';
            $return_true .= '<h3>'.ucfirst(LABEL_bienvenida).'</h3>' ;
            $return_true .= '<p class="alert alert-success" role="alert">'.$install_message["306"].'</p>' ;
            $return_true .='</div>';

            message($return_true);
        }
    }
}


function HTMLformInstall($lang_install)
{
    global $CFG,$install_message;

    include_once T3_ABSPATH . 'common/include/config.tematres.php';
    include_once T3_ABSPATH . 'common/include/fun.gral.php';

    $arrayLang=array();

    foreach ($CFG["ISO639-1"] as $langs) {
        array_push($arrayLang, "$langs[0]#$langs[1]");
    };

    $array_kos_types=array(KOS_categorization_scheme.'#'.KOS_categorization_scheme,KOS_classification_scheme.'#'.KOS_classification_scheme,KOS_dictionary.'#'.KOS_dictionary,KOS_gazetteer.'#'.KOS_gazetteer,KOS_glossary.'#'.KOS_glossary,KOS_list.'#'.KOS_list,KOS_name_authority_list.'#'.KOS_name_authority_list,KOS_ontology.'#'.KOS_ontology,KOS_semantic_network.'#'.KOS_semantic_network,KOS_subject_heading_scheme.'#'.KOS_subject_heading_scheme,KOS_taxonomy.'#'.KOS_taxonomy,KOS_terminology.'#'.KOS_terminology,KOS_thesaurus.'#'.KOS_thesaurus);


    $rows='<form class="form-horizontal" id="formulaire" name="formulaire" method="post" action="install.php">
    <fieldset>
    <!-- Form Name -->
    <legend>'.ucfirst(LABEL_lcDatos).'</legend>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="title">'.ucfirst(LABEL_Titulo).'</label>
      <div class="col-md-5">
      <input id="title" name="title" placeholder="'.ucfirst(LABEL_Titulo).'" class="form-control input-md" required="" type="text">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="author">'.ucfirst(LABEL_Autor).'</label>
      <div class="col-md-5">
      <input id="author" name="author" placeholder="'.ucfirst(LABEL_Autor).'" class="form-control input-md" required="" type="text">
      </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="lang">'.ucfirst(LABEL_Idioma).'</label>
      <div class="col-md-4">
        <select id="lang" name="lang" class="form-control">
        '.doSelectForm($arrayLang, $lang_install).'
        </select>
      </div>
    </div>


    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="tipo">'.ucfirst(LABEL_TipoLenguaje).'</label>
      <div class="col-md-4">
        <select id="tipo_lang" name="kos_type" class="form-control">
        '.doSelectForm($array_kos_types, "").'
        </select>                       
        </div>
    </div>

    </fieldset>

    <fieldset>
    <!-- Form Name -->
    <legend>'.ucfirst(MENU_NuevoUsuario).'</legend>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="name">'.ucfirst(LABEL_nombre).'</label>
      <div class="col-md-4">
      <input id="name" name="name" placeholder="'.ucfirst(LABEL_nombre).'" class="form-control input-md" required="" type="text">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="s_name">'.ucfirst(LABEL_apellido).'</label>
      <div class="col-md-4">
      <input id="s_name" name="s_name" placeholder="'.ucfirst(LABEL_apellido).'" class="form-control input-md" required="" type="text">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="mail">'.ucfirst(LABEL_mail).'</label>
      <div class="col-md-4">
      <input id="mail" name="mail" placeholder="'.ucfirst(LABEL_mail).'" class="form-control input-md" required="" type="email">
      </div>
    </div>

    <!-- Password input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="mdp">'.ucfirst(LABEL_pass).'</label>
      <div class="col-md-4">
        <input id="mdp" name="mdp"  data-minlength="4" placeholder="'.ucfirst(LABEL_pass).'" class="form-control input-md" required="" type="password">
        <span class="help-block">'.ucfirst(sprintf(MSG_lengh_error, 4)).'</span>
      </div>
    </div>

    <!-- rePassword input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="password">'.ucfirst(LABEL_repass).'</label>
      <div class="col-md-4">
        <input id="password" name="password" data-match="#mdp" data-match-error="'.ucfirst(MSG_repass_error).'"  placeholder="'.ucfirst(LABEL_repass).'" class="form-control input-md" required="" type="password">
        <div class="help-block with-errors"></div>
      </div>
    </div>

    <!-- Button -->
    <div class="form-group">
    <div class="text-center">
        <button type="submit" name="send" id="singlebutton" name="singlebutton" class="btn btn-primary">'.ucfirst(LABEL_Enviar).'</button>
      </div>
    </div>

    </fieldset>
    </form>';

    return $rows;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title><?php echo $install_message["101"]; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/submenu/css/bootstrap-submenu.min.css" rel="stylesheet">
   <link href="<?php echo T3_WEBPATH;?>css/t3style.css" rel="stylesheet">

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="<?php echo T3_WEBPATH;?>bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jqtree.css" />
   <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/submenu/js/bootstrap-submenu.min.js"></script>
   <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/bootstrap-tabcollapse.js"></script>

    <link type="text/css" src="<?php echo T3_WEBPATH;?>bootstrap/forms/css/styles.css"/>

  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>forms/jquery.validate.min.js"></script>

  <link type="image/x-icon" href="<?php echo T3_WEBPATH;?>images/tematres.ico" rel="icon" />
  <link type="image/x-icon" href="<?php echo T3_WEBPATH;?>images/tematres.ico" rel="shortcut icon" />
</head>
 <body>
<div class="container">
  <div class="header">
    <h1>    <a href="https://www.vocabularyserver.com/" title="TemaTres: vocabulary server"><img src="<?php echo T3_WEBPATH;?>/images/tematres-logo.gif"  alt="TemaTres"/></a>
<?php echo $install_message["101"];?></h1>
 </div>
</div>



<div id="wrap" class="container">
  <div id="bodyText">

      <div id="select_lang">
        <form class="form-horizontal" action="install.php" method="get" name="lang" id="lang">
        <fieldset>
        <legend><?php echo LABEL_Idioma;?></legend>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="selectbasic"><?php echo LABEL_Idioma;?></label>
          <div class="col-md-4">
            <select id="lang_install" name="lang_install" onChange="document.lang.submit()" class="form-control">
              <option><?php echo LABEL_Idioma;?></option>
              <option value="ca-ES">català</option>
              <option value="en-EN">english</option>
              <option value="es-ES">español</option>
              <option value="fr-FR">fran&ccedil;ais</option>
              <option value="pt-PT">portugu&ecirc;s (Portugal)</option>
              <option value="pt-BR">portugu&ecirc;s (Brasil)</option>
            </select>
          </div>
        </div>

        </fieldset>
        </form>


    <div class="clear">
    <?php
    echo checkInstall($lang);
    ?>
    </div>


</div><!-- /.container -->
<div class="push"></div>
<!-- ###### Footer ###### -->
<div id="footer" class="footer">
      <div class="container">
    <a href="https://vocabularyserver.com/" title="TemaTres: vocabulary server"><img src="<?php echo T3_WEBPATH;?>/images/tematres-logo.gif"  alt="TemaTres"/></a>
    <strong><?php echo LABEL_Version ?>: </strong>
    <span class="footerCol2"><a href="https://vocabularyserver.com/" title="TemaTres: vocabulary server"><?php echo $CFG["Version"];?></a></span>
      </div>
  </div>
    </body>
</html>
