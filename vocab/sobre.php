<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

include "config.tematres.php";

$metadata=do_meta_tag();
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
    <head>
    <?php
        echo HTMLheader($metadata);

        echo '<link rel="stylesheet" type="text/css" href="'.T3_WEBPATH.'jq/chartist-js/chartist.min.css">';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist.min.js"></script>';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist-plugin-axistitle.min.js"></script>';
    ?>
        <style>
            #ct-deep  {
                height: 300px;
                width: 100%;
            }
            #ct-lexical {
                height: 400px;
                width: 100%;

            }
            #ct-logic {
                height: 400px;
                width: 100%;
            }
            .ct-label{
                fill: rgba(0,0,0,.8);
                color: rgba(0,0,0,.8);
                font-size: 1em;
                line-height: 2;
            }
        </style>
    </head>
    <body>
        <?php echo HTMLnavHeader(); ?>
        <div class="container">
            <div class="container sobre " id="bodyText">

            <?php
            echo HTMLsummary();

            if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) {
                //es admin y quiere ver un usuario
                if (($_GET["user_id"]) && ($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"] == 1)) {
                    echo doBrowseTermsFromUser(secure_data($_GET["user_id"], $_GET["ord"]));
                // no es admin y quiere verse a si mismo
                } elseif($_GET["user_id"]) {
                    echo doBrowseTermsFromUser(secure_data($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"], "sql"), secure_data($_GET["ord"], "sql"));
                // quiere ver un año
                } elseif($_GET["y"]) {
                    echo doBrowseTermsFromDate(secure_data($_GET["m"], "sql"), secure_data($_GET["y"], "sql"), secure_data($_GET["ord"], "sql"));
                //ver lista agregada
                } else {
                    echo doBrowseTermsByDate();
                }
            };
            ?>
            </div>
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