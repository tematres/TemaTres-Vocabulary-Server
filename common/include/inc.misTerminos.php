<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Include para actualizacion de datos propios. #

$user_id = '0';

$user_id = $_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];



$resumen=ARRAYresumen($_SESSION["id_tesa"],"U",secure_data($user_id,"sql"));

$row_resumen.='<div id="cajaAncha">'."\n\r";
$row_resumen.='<strong>'.ucfirst(LABEL_Acciones).'</strong><dl class="dosCol">'."\n\r";
$row_resumen.='<dt>'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen[cant_total]."&nbsp;</dd>\n\r";
$row_resumen.='<dt>'.ucfirst(LABEL_RelTerminos).'</dt><dd>'.$resumen[cant_rel]."&nbsp;</dd>\n\r";
$row_resumen.='<dt>'.ucfirst(LABEL_TerminosUP).'</dt><dd> '.$resumen[cant_up]."&nbsp;</dd>\n\r";
$row_resumen.='</dl></div>';


if($_POST["taskUser"]=='actuaDatos')
{
	$user_id=admin_users("actua",secure_data($user_id,"sql"));
	$row_log='<p class="alert alert-success" role="alert">'.MSG_ResultCambios.'</p>';
};

$dato_user=ARRAYdatosUser($user_id);


$rows.='<form role="form" name="login" id="form-users" data-toggle="validator" action="login.php" method="post">';
$rows.='	<div class="row">
		<div class="col-sm-12">';
		$rows.=$row_log;
		$rows.='				<legend>'.MENU_MisDatos.'</a></legend>
		</div>
		<!-- panel  -->
			    <div class="col-lg-7">
					<h4>'.ucfirst(LABEL_DatosUser).'</h4>
			        <div class="panel panel-default">
			            <div class="panel-body form-horizontal">';

			$rows.='<div class="form-group">
			           <label for="nombre" class="col-sm-3 control-label">'.ucfirst(LABEL_nombre).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control" required id="nombre" placeholder="'.LABEL_nombre.'" name="'.FORM_LABEL_nombre.'" value="'.$dato_user["nombres"].'">
			                    </div>
			         </div>';
			$rows.='<div class="form-group">
			           <label for="apellido" class="col-sm-3 control-label">'.ucfirst(LABEL_apellido).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control"  id="apellido" required placeholder="'.LABEL_apellido.'" name="'.FORM_LABEL_apellido.'" value="'.$dato_user["apellido"].'">
			                    </div>
			         </div>';
			$rows.='<div class="form-group">
			           <label for="mail" class="col-sm-3 control-label">'.ucfirst(LABEL_mail).'</label>
			                    <div class="col-sm-9">
			                        <input required class="form-control" type="email" id="mail" placeholder="'.LABEL_mail.'" name="'.FORM_LABEL_mail.'" value="'.$dato_user["mail"].'">
			                    </div>
			         </div>';
			$rows.='<div class="form-group">
			           <label for="orga" class="col-sm-3 control-label">'.ucfirst(LABEL_orga).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" required class="form-control" id="orga" placeholder="'.LABEL_orga.'" name="'.FORM_LABEL_orga.'" value="'.$dato_user["orga"].'">
			                    </div>
			         </div>';

			$fillRulePass=($dato_user["id"]) ? '' : 'required';
			$rows.='<div class="form-group">
			           <label for="clave" class="col-sm-3 control-label">'.ucfirst(LABEL_pass).'</label>
			                    <div class="col-sm-9">
			                        <input data-minlength="4" '.$fillRulePass.' class="form-control" id="clave" placeholder="'.LABEL_pass.'" type="password" id="clave" name="'.FORM_LABEL_pass.'" value="">
															<span class="help-block">'.ucfirst(sprintf(MSG_lengh_error,4)).'</span>
			                    </div>
			         </div>';

			$rows.='<div class="form-group">
			           <label for="reclave" class="col-sm-3 control-label">'.ucfirst(LABEL_repass).'</label>
			                    <div class="col-sm-9">
			                        <input data-match="#clave" '.$fillRulePass.' data-match-error="'.ucfirst(MSG_repass_error).'" placeholder="'.LABEL_repass.'" class="form-control" type="password" id="reclave" name="'.FORM_LABEL_repass.'" value="">
															<div class="help-block with-errors"></div>
													</div>
			         </div>';

        $rows.='<div class="form-group">
																	<div class="col-sm-12 text-right">
																	<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
																	<a href="index.php" class="btn btn-default" id="boton_cancelar" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
																	</div>
															</div>';


											$rows.='				</div>
															</div>
													</div>';

											$rows.=$row_resumen;

												$rows.='</div> <!-- / panel  -->';
												$rows.='<input type="hidden" name="taskUser"  value="actuaDatos"/>';
												$rows.='</form>';

												echo $rows;

?>
