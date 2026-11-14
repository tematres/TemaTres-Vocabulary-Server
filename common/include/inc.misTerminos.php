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
// Include para actualizacion de datos propios. #

$user_id = 0;

$user_id = $_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];



$resumen=ARRAYresumen($_SESSION["id_tesa"], "U", secure_data($user_id, "sql"));

$row_resumen.='<div id="cajaAncha" class="col-xl-5">'."\n\r";
$row_resumen.='<strong>'.mb_ucfirst(LABEL_Acciones).'</strong><dl class="dosCol">'."\n\r";
$row_resumen.='<dt>'.mb_ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen["cant_total"]."&nbsp;</dd>\n\r";
$row_resumen.='<dt>'.mb_ucfirst(LABEL_RelTerminos).'</dt><dd>'.$resumen["cant_rel"]."&nbsp;</dd>\n\r";
$row_resumen.='<dt>'.mb_ucfirst(LABEL_TerminosUP).'</dt><dd> '.$resumen["cant_up"]."&nbsp;</dd>\n\r";
$row_resumen.='</dl></div>';


$_POST["taskUser"]=array2value("taskUser", $_POST);

if ($_POST["taskUser"]=='actuaDatos') {
    $user_id=admin_users("actua", secure_data($user_id, "sql"));
    $row_log='<p class="alert alert-success" role="alert">'.MSG_ResultCambios.'</p>';
};

$dato_user=ARRAYdatosUser($user_id);


$rows.='<form role="form" name="login" id="form-users" data-toggle="validator" action="login.php" method="post">';
$rows.='    <div class="row">
        <div class="col-md-12">';
        $rows.=$row_log;
        $rows.='                <legend>'.MENU_MisDatos.'</a></legend>
        </div>
        <!-- panel  -->
                <div class="col-xl-7">
                    <h4>'.mb_ucfirst(LABEL_DatosUser).'</h4>
                    <div class="card">
                        <div class="card-body">';

            $rows.='<div class="row mb-3">
                        <label for="nombre" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_nombre).'</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required id="nombre" placeholder="'.LABEL_nombre.'" name="nombres" value="'.$dato_user["nombres"].'">
                                </div>
                    </div>';
            $rows.='<div class="row mb-3">
                        <label for="apellido" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_apellido).'</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"  id="apellido" required placeholder="'.LABEL_apellido.'" name="apellido" value="'.$dato_user["apellido"].'">
                                </div>
                    </div>';
            $rows.='<div class="row mb-3">
                        <label for="mail" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_mail).'</label>
                                <div class="col-md-9">
                                    <input required class="form-control" type="email" id="mail" placeholder="'.LABEL_mail.'" name="mail" value="'.$dato_user["mail"].'">
                                </div>
                    </div>';
            $rows.='<div class="row mb-3">
                        <label for="orga" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_orga).'</label>
                                <div class="col-md-9">
                                    <input type="text" required class="form-control" id="orga" placeholder="'.LABEL_orga.'" name="orga" value="'.$dato_user["orga"].'">
                                </div>
                    </div>';

            $fillRulePass=($dato_user["id"]) ? '' : 'required';
            $rows.='<div class="row mb-3">
                        <label for="clave" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_pass).'</label>
                                <div class="col-md-9">
                                    <input minlength="4" '.$fillRulePass.' class="form-control" id="clave" placeholder="'.LABEL_pass.'" type="password" id="clave" name="pass" value="">
                                                            <span class="form-text">'.mb_ucfirst(sprintf(MSG_lengh_error, 4)).'</span>
                                </div>
                    </div>';

            $rows.='<div class="row mb-3">
                        <label for="reclave" class="col-md-3 col-form-label">'.mb_ucfirst(LABEL_repass).'</label>
                                <div class="col-md-9">
                                    <input data-match="#clave" '.$fillRulePass.' data-match-error="'.mb_ucfirst(MSG_repass_error).'" placeholder="'.LABEL_repass.'" class="form-control" type="password" id="reclave" name="reclave" value="">
                                                            <div class="form-text with-errors"></div>
                                                    </div>
                    </div>';

        $rows.='<div class="row mb-3">
                                                                    <div class="col-md-12 text-end">
                                                                    <input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.mb_ucfirst(LABEL_Guardar).'"/>
                                                                    <a href="index.php" class="btn btn-secondary" id="boton_cancelar" title="'.mb_ucfirst(LABEL_Cancelar).'">'.mb_ucfirst(LABEL_Cancelar).'</a>
                                                                    </div>
                                                            </div>';


                                            $rows.='                </div>
                                                            </div>
                                                    </div>';

                                            $rows.=$row_resumen;

                                                $rows.='</div> <!-- / panel  -->';
                                                $rows.='<input type="hidden" name="taskUser"  value="actuaDatos"/>';
                                                $rows.='</form>';

                                                echo $rows;
