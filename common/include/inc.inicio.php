<?php
if ((stristr($_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) {
    die("no access");
}
// TemaTres : aplicación para la gestión de lenguajes documentales #       #
//
// Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
//
//
// Include para seleccionar include o función de visualizaicon de listas de términos #

//Antes de desplegar cotenidos => Echo mensajes de error
echo @$MSG_PROC_ERROR["html"];
$letra=isValidLetter(array2value("letra",$_GET));
$_GET["taskterm"]=array2value("taskterm",$_GET);
$_GET["xsearch"]=array2value("xsearch",$_GET);
$_GET["s"]=array2value("s",$_GET);
$_GET["estado_id"]=array2value("estado_id",$_GET);
$_GET["src_id"]=array2value("src_id",$_GET);
$_GET["mod"]=array2value("mod",$_GET);
$_GET["tvocab_id"]=array2value("tvocab_id",$_GET);
$_GET["verT"]=array2value("verT",$_GET);
$_GET["letra2trad"]=array2value("letra2trad",$_GET);
$_GET["filterEQ"]=array2value("filterEQ",$_GET);

if ((strlen($letra)>0) && (strlen($letra)<5)) {
    echo '<div class="container" id="bodyText">';
    echo '<div class="row">';
    echo HTMLlistaAlfabeticaUnica($letra);
    echo HTMLterminosLetra($letra);
    echo '</div>';
    echo '</div>';
} elseif (strlen($search_string)>0) {
    //check again
    $search_string=XSSprevent($search_string);
    echo resultaBusca($search_string, $_GET["tipo"]);
} //Mostrar ficha de termino o crear término
elseif ((is_numeric(@$metadata["arraydata"]["tema_id"]))
    || ($_GET["taskterm"]=='addTerm')
    || ($_GET["taskterm"]=='addTermSuggested')
    || ($_GET["taskterm"]=='findTermNews')
) {
    include_once T3_ABSPATH . 'common/include/inc.vistaTermino.php';
} //Vista de términos según estados
elseif (is_numeric($_GET["estado_id"]) && (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0)) {
    echo '<div class="container" id="bodyText">';
    echo HTMLlistaTerminosEstado($_GET["estado_id"], CFG_NUM_SHOW_TERMSxSTATUS);
    echo '</div>';
} //Vista de términos según estados
elseif ($_GET["s"]=='n') {
    echo '<div class="container" id="bodyText">';
    echo HTMLlistaTerminosFecha();
    echo '</div>';
} //Vista de busqueda avanzada
elseif (($_GET["xsearch"]=='1')) {
    echo '<div class="container" id="bodyText">';
    echo HTMLformAdvancedSearch($_GET);
    echo '</div>';
} //Vista de busqueda avanzada
elseif (($_GET["src_id"]>0)) {
    echo '<div class="container" id="bodyText">';
    echo HTMLterms4source($_GET["src_id"]);
    echo '</div>';
} //Vista de reporteador
elseif (($_GET["mod"]=='csv') && (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0)) {
    echo '<div id="bodyText">';
    echo HTMLformSimpleTermReport($_GET);

    echo HTMLformAdvancedTermReport($_GET);

    echo HTMLformNullNotesTermReport($_GET);

    echo HTMLformMappedTermReport($_GET);

    echo '</div>';
} //esta login y mod traductor
elseif ((evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0)&&($_GET["mod"]=='trad')) {

    $_POST["task"]=array2value("task",$_POST);
    $_POST["map4localTargetVocab"]=array2value("map4localTargetVocab",$_POST);
    $_POST["tvocab_id"]=array2value("tvocab_id",$_POST);
    $_POST["deleteFreeTerms_id"]=array2value("deleteFreeTerms_id",$_POST);
    $_POST["massive_task_freeterms"]=array2value("massive_task_freeterms",$_POST);
    $_POST["freeTerms_id"]=array2value("freeTerms_id",$_POST);
    $_POST["deleteTerms_id"]=array2value("deleteTerms_id",$_POST);
    $_POST["taskterm"]=array2value("taskterm",$_POST);

    if ($_POST["task"]=='map4localTargetVocab') {
        $tasks=addLocalTargetTerms($_POST["tvocab_id"], $_POST);
    }

    $tvocab_id=($_GET["tvocab_id"]>1) ? $tvocab_id : 0;
    
    if ($tvocab_id>0) {
        //Mostrar alfabeto
        if ($_GET["letra2trad"]) {    // sanitice $letra
            $letra=isValidLetter($_GET["letra2trad"]);
        }


        echo FORMtransterm4char4map($tvocab_id, $_GET["filterEQ"], $letra);
    } else {
        echo HTMLselectTargetVocabulary();
    }
} //Esta login y mostrar terminios libres o repetidos
elseif ((evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0)&&($_GET["verT"])) {
    echo '<div class="container" id="bodyText">';
    switch ($_GET["verT"]) {
        case 'L':
            if ($_POST["massive_task_freeterms"]=='assocfreeTerm') {
                echo HTMLformAssociateFreeTerms($_POST["deleteFreeTerms_id"], "");
            } else {
                echo HTMLformVerTerminosLibres($_POST["massive_task_freeterms"], $_POST["deleteFreeTerms_id"]);
            }
            break;

        case 'LA':
            echo HTMLformAssociateFreeTerms($_POST["freeTerms_id"], $_POST["taskterm"]);
            break;

        case 'R':
            echo HTMLformVerTerminosRepetidos();
            break;

        case 'NBT':
            echo HTMLformVerTerminosSinBT($_POST["taskterm"], $_POST["deleteTerms_id"]);
            break;
    };
    echo '</div>';
} else {
    echo '<div class="container" id="bodyText">';
    echo HTMLlistaAlfabeticaUnica($letra);
    if ($_SESSION[$_SESSION["CFGURL"]]["_SHOW_RANDOM_TERM"]!=='0') {
        echo HTMLdisplayRandomTerm($_SESSION[$_SESSION["CFGURL"]]["_SHOW_RANDOM_TERM"]);
    }
    if ($_SESSION[$_SESSION["CFGURL"]]["_SHOW_TREE"]=='1') {
        echo HTMLtopTerms($letra);
    }
    echo '</div>';
}
