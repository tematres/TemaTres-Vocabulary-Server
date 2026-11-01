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
 $mod=array2value("mod", $_GET);
 $task=array2value("task", $_GET);
 
if (($mod == 'csv') && (substr($task, 0, 3) == 'csv') && (@$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"])) {
    return wichReport($task);
}

$search_string = '';
$search_string = (doValue($_GET, FORM_LABEL_buscar)) ? XSSprevent(doValue($_GET, FORM_LABEL_buscar)) : '';
$_letra=array2value("letra", $_GET);
echo HEADdocType($metadata);
?>
    <body>
    <?php echo HTMLnavHeader();   ?>
        <div id="wrap" class="container">
            <?php require_once T3_ABSPATH . 'common/include/inc.inicio.php'; ?>
        </div><!-- /.container -->
        <div class="push"></div>

<!-- ###### Footer ###### -->

<?php echo HTMLfooter(array("letra"=>$_letra,"term_id"=>array2value("tema", $_GET)));?>
<?php echo HTMLjsInclude();?>
</body>
</html>
