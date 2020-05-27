<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

require "config.tematres.php";
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <body>
        <div class="modal-header"><a href="http://www.vocabularyserver.com/" title="TemaTres: vocabulary server" target="_blank">
            <img src="<?php echo T3_WEBPATH;?>/images/tematres-logo.gif" width="42" alt="TemaTres"/></a> <?php echo ucfirst($_SESSION["CFGTitulo"]);?>
        </div>
        <div class="modal-body">
            <?php
            if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) {
                include_once T3_ABSPATH . 'common/include/inc.misTerminos.php';
            } else {
                if ($_POST["task"] == 'user_recovery') {
                    $task_result=recovery($_POST["id_correo_electronico_recovery"]);
                }

                if ((@$_GET["task"]) && ($_GET["task"] == 'recovery')) {
                        echo HTMLformRecoveryPassword();
                } else {
                    if (($_POST["task"] == 'login') && (!$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"])) {
                        $task_result=array("msg"=>t3_messages('no_user'));
                    }
                    echo HTMLformLogin($task_result);
                }
            }
            // if session
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo ucfirst(LABEL_close);?></button>
        </div>
    </body>
</html>
