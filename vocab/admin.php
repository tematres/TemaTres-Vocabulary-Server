<?php
/*TemaTres : aplicación para la gestión de lenguajes documentales Copyright (C) 2004-2020 Diego Ferreyra tematres@r020.com.ar Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
*/
require "config.tematres.php";

$metadata=do_meta_tag();

if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]!=='1') {
    loadPage('login.php');
};

//Acciones de gestion de usuarios
if ($_POST["userTask"] == 'A') {
    $user_id=admin_users("alta");
    header("Location:admin.php?user_id=list");
}

if ($_POST["useactua"]) {
    $user_id=admin_users("actua", $_POST["useactua"]);
    header("Location:admin.php?user_id=list");
}

if ($_GET["usestado"]) {
    $user_id=admin_users("estado", $_GET["usestado"]);
    header("Location:admin.php?user_id=list");
}

if (($_POST["task_config"] == 'configvocab') && (is_numeric($_POST["vocabulario_id"]))) {
    abm_vocabulario("M", $_POST["vocabulario_id"]);
    header("Location:admin.php?vocabulario_id=list");
}

if ($_POST["task_config"] == 'rem_tvocab') {
    abm_vocabulario("B", $_POST["internal_tvocab_id"]);
    header("Location:admin.php?vocabulario_id=list");
}

if (($_POST["task_config"] == 'configvocab') && ($_POST["vocabulario_id"] == 'NEW')) {
    abm_vocabulario("A");
    header("Location:admin.php?vocabulario_id=list");
}

if (($_POST["doAdmin"] == 'addTargetVocabulary')) {
    abm_targetVocabulary("A");
}

if (($_POST["doAdmin"] == 'saveTargetVocabulary')) {
    abm_targetVocabulary("M", $_POST["tvocab_id"]);
}

if (($_POST["doAdmin"] == 'saveSourceNote')) {
    abm_sources("M", $_POST["src_id"], $_POST);
};

if (($_POST["doAdmin"] == 'addSourceNote')) {
    abm_sources("A", 0, $_POST);
};
if (($_POST["doAdmin"] == 'remSourceNote')) {
    abm_sources("B", $_POST["rem_src_id"]);
};

if (($_POST["doAdmin"] == 'saveUserTypeNote')) {
    abm_UserTypeNote("M", $_POST["tvocab_id"]);
}

if (($_POST["doAdmin"] == 'massrem')) {
    REMmassiveData($_POST);
    loadPage('index.php');
}

if (($_POST["doAdmin"] == 'updateEndpointNow')) {
    doSparqlEndpoint($_POST);
    loadPage('sparql.php');
}

//Acciones de gestion de vocabularios
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
    <head><?php echo HTMLheader($metadata);?></head>
    <body>

    <?php echo HTMLnavHeader(); ?>

    <div class="container">

<?php
if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) {
    if ($_GET["opTbl"] == 'TRUE') {
        echo optimizarTablas();
    }

    if ($_GET["user_id"] == 'list') {
        echo HTMLListaUsers();
    }

    if (is_numeric($_GET["user_id"])) {
        include_once T3_ABSPATH . 'common/include/inc.formUsers.php';
    }

    if ($_GET["user_id"] == 'new') {
        include_once T3_ABSPATH . 'common/include/inc.formUsers.php';
    }

    if (is_numeric($_GET["vocabulario_id"])) {
        include_once T3_ABSPATH . 'common/include/inc.abmConfig.php';
    }

    if (is_numeric($_GET["editsrc_id"])) {
        echo HTMLformSource($_GET["editsrc_id"]);
    }
    if (($_GET["vocabulario_id"] == 'list')||(count($_GET)<1)) {
        echo HTMLlistaVocabularios();
        echo HTMLlistaInternalTargetVocabularios();
        echo HTMLlistaTargetVocabularios();
        echo HTMLformUserNotes();
        echo HTMLformUserRelations();
        echo HTMLformURIdefinition();
        echo HTMLlistSources();
    };

    //Formulario de exportación
    if ($_GET["doAdmin"] == 'export') {
        echo HTMLformExport();
    }

    if ($_GET["doAdmin"] == 'bulkReplace') {
        echo HTMLformBulkReplace($_POST);
    }

    if ($_GET["doAdmin"] == 'glossConfig') {
        echo HTMLbulkGlossTerms($_GET);
        echo HTMLformExportGlossary($_POST);
    }

    //Regenerate indice table
    if ($_GET["doAdmin"] == 'reindex') {
        $sql=SQLreCreateTermIndex();
        echo $sql["cant_terms_index"].' '.LABEL_Terminos;
    }

    if ($_GET["doAdmin"] == 'import' && empty($_REQUEST["taskAdmin"])) { // change Nicolas Poulain, http://tounoki.Org - 2015
        echo HTMLformImport();
    }

    if ($_GET["doAdmin"] == 'massiverem') {
        echo HTMLformMasiveDelete();
    }

    if ($_GET["doAdmin"] == 'updateEndpoint') {
        echo HTMLformUpdateEndpoit();
    }

    //Formulario de import
    if ($_POST["taskAdmin"] == 'importTab') {
        include_once T3_ABSPATH . 'common/include/inc.import.php';
    }

    //Formulario de import
    if ($_POST["taskAdmin"] == 'importTag') {
        include_once T3_ABSPATH . 'common/include/inc.importTXT.php';
    }

    //Formulario de import line 127 after Formulario de exportación
    if ($_POST["taskAdmin"] == 'importSkos') {
        include_once T3_ABSPATH . 'common/include/inc.importSkos.php';
    }

    if ($_POST["taskAdmin"] == 'importXML') {
        include_once T3_ABSPATH . 'common/include/inc.importMARC.php';
    };

    //Form to add / edit foreing target vocabulary
    if ($_GET["doAdmin"] == 'seeformTargetVocabulary') {
        echo HTMLformTargetVocabulary($_GET["tvocab_id"]);
    }

    //Form to add / edit foreing target vocabulary
    if ($_GET["doAdmin"] == 'seeTermsTargetVocabulary') {
        echo HTMLlistaTermsTargetVocabularios($_GET["tvocab_id"], $_GET["f"]);
    }

    //update from tematres 1.1 -> tematres 1.2
    if ($_GET["doAdmin"] == 'updte1_1x1_2') {
        echo updateTemaTres('1_1x1_2');
    }

    //update from tematres 1.1 -> tematres 1.2
    if ($_GET["doAdmin"] == 'updte1x1_2') {
        echo updateTemaTres('1x1_2');
    }

    //update from tematres 1.3 -> tematres 1.4
    if ($_GET["doAdmin"] == 'updte1_3x1_4') {
        echo updateTemaTres('1_3x1_4');
    }

    //update from tematres 1.4 -> tematres 1.5
    if ($_GET["doAdmin"] == 'updte1_4x1_5') {
        echo updateTemaTres('1_4x1_5');
    }

    //update from tematres 1.5 -> tematres 1.6
    if ($_GET["doAdmin"] == 'updte1_5x1_6') {
        echo updateTemaTres('1_5x1_6');
    }

    //update from tematres 1.6 -> tematres 1.7
    if ($_GET["doAdmin"] == 'updte1_6x1_7') {
        echo updateTemaTres('1_6x1_7');
    }
    if ($_GET["doAdmin"]=='updte2_2x3_2') {
        echo updateTemaTres('2_2x3_2');
    }
}
?>

</div><!-- /.container -->

<!-- ###### Footer ###### -->

<div id="footer" class="footer">
    <div class="container">
        <?php
        if (!$_GET["letra"]) {
            echo HTMLlistaAlfabeticaUnica();
        }
        ?>

    <p class="navbar-text pull-left">
        <?php
        //are enable SPARQL
        if (CFG_ENABLE_SPARQL==1) {
            echo '<a class="label label-info" href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
        }

        if (CFG_SIMPLE_WEB_SERVICE==1) {
            echo '  <a class="label label-info" href="'.URL_BASE.'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
        }

        echo '<a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span>RSS</a>';
        echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
        ?>
    </p>
        <?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
    </div>
</div>
<?php echo HTMLjsInclude();?>
    </body>
</html>
