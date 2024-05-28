<?php
if ((stristr($_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) {
    die("no access");
}
// TemaTres : aplicación para la gestión de lenguajes documentales #       #
//
// Copyright (C) 2004-2013 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
//
//
// Gestion de sesiones #



// **PREVENTING SESSION HIJACKING**
// Solution from http://stackoverflow.com/questions/22221807/session-cookies-http-secure-flag-how-do-you-set-these
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
//ini_set('session.cookie_secure', 1);
session_start();

$SQL_CFG_LC=SQL("select", "id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base,polijerarquia from $DBCFG[DBprefix]config where id=1");

if (!is_object($SQL_CFG_LC)) {
    header("Location:install.php");
}

$CFG_LC=$SQL_CFG_LC->FetchRow();

$_SESSION["id_tesa"]      =$CFG_LC[0];
$_SESSION["CFGTitulo"]    =$CFG_LC[1];
$_SESSION["CFGAutor"]     =$CFG_LC[2];
$_SESSION["CFGIdioma"]    =$CFG_LC[3];
$_SESSION["CFGCobertura"] =$CFG_LC[4];
$_SESSION["CFGKeywords"]  =$CFG_LC[5];
$_SESSION["CFGTipo"]      =$CFG_LC[6];
$_SESSION["CFGCreacion"]  =$CFG_LC[7];
$_SESSION["CFGURL"]       =$CFG_LC[8];
$_SESSION["CFGPolijerarquia"]  =$CFG_LC[9];
$_SESSION["CFGVersion"]   =$CFG["Version"];

//Load config values
loadConfigValues(1);

$lang_labels=selectLangLabels($_SESSION["CFGIdioma"], $idiomas_disponibles);

//$_SESSION[$_SESSION["CFGURL"]]["lang"]=$lang_labels;

$_GET["setLang"]=array2value("setLang",$_GET);
$_GET["cmdlog"]=array2value("cmdlog",$_GET);
$_POST["id_correo_electronico"]=array2value("id_correo_electronico",$_POST);


    
if ($_GET["setLang"]) {
    //$_SESSION[$_SESSION["CFGURL"]]["lang"]=$idiomas_disponibles[$_GET["setLang"]];
    $lang_labels=selectLangLabels($_GET["setLang"], $idiomas_disponibles);
    $_SESSION[$_SESSION["CFGURL"]]["lang"]=$lang_labels;
}

$_SESSION["CFGIdioma"] = ($_SESSION["CFGIdioma"]) ? $_SESSION["CFGIdioma"] : $idiomas_disponibles[0][2];


if(!isset($_SESSION[$_SESSION["CFGURL"]]["lang"])){
    $_SESSION[$_SESSION["CFGURL"]]["lang"]=$lang_labels;
}
require_once T3_ABSPATH . 'common/lang/'.$_SESSION[$_SESSION["CFGURL"]]["lang"][1];


if ($_GET["cmdlog"]==substr(md5(date("Ymd")), "5", "10")) {
    //Save stadistics
    $stats=doLastModified();
    unset($_SESSION[$_SESSION["CFGURL"]]);
};

if ($_POST["id_correo_electronico"]) {
    $chk_user='';

    $chk_user=ARRAYcheckLogin($_POST["id_correo_electronico"]);
 
    if ($chk_user["user_id"]) {
        //if the hash not hashed because the admin of tematres change the CFG_HASH_PASS config in db.tematres.php
        if (( strlen($chk_user["pass"]) < 34 ) && (CFG_HASH_PASS)) {
            setPassword($chk_user["user_id"], $chk_user["pass"], CFG_HASH_PASS);

            $chk_user=ARRAYcheckLogin($_POST["id_correo_electronico"]);
        }
     
     
        if (check_password($_POST["id_password"], $chk_user["pass"])) {
            //Save stadistics
            $stats=doLastModified();

            $_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]=$chk_user["user_id"];
            $_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]=$chk_user["nivel"];
            $_SESSION[$_SESSION["CFGURL"]]["ssuser_nombre"]=$chk_user["name"];
            //redirigir
            $_SESSION[$_SESSION["CFGURL"]]["user_data"]=ARRAYUserData($chk_user["user_id"]);

            $url_data=extract4url($_SERVER['HTTP_REFERER']);
            $add_param='';
            if (is_numeric($url_data["tema_id"])) {
                 $add_param='?tema='.$url_data["tema_id"];
            } elseif (strlen($url_data["letra"])==1) {
                $add_param='?letra='.$url_data["letra"];
            };

            header("Location: index.php" .$add_param);
        }
    }
}
