<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

require "config.tematres.php";

$metadata = do_meta_tag();

 /* term reporter */
if (($_GET["mod"] == 'csv') && (substr($_GET["task"], 0, 3) == 'csv') && ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"])) {
    return wichReport($_GET["task"]);
}

$search_string = '';
$search_string = (doValue($_GET, FORM_LABEL_buscar)) ? XSSprevent(doValue($_GET, FORM_LABEL_buscar)) : '';

echo HEADdocType($metadata);
?>
    <body>
    <?php echo HTMLnavHeader();   ?>
        <div id="wrap" class="container">
            <?php require_once T3_ABSPATH . 'common/include/inc.inicio.php'; ?>
        </div><!-- /.container -->
        <div class="push"></div>

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

        echo '  <a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
        echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
        ?>
    </p>
        <?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
    </div>
</div>
<?php echo HTMLjsInclude();?>
    </body>
</html>
