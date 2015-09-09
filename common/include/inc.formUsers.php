<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2015 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Include para alta y modificacion de usuarios genericos.

if(is_numeric($_GET["user_id"]))  $dato_user=ARRAYdatosUser($_GET["user_id"]);

if($dato_user["id"]){

	$resumen=ARRAYresumen($_SESSION["id_tesa"],"U",$dato_user["id"]);
	$row_resumen.='<div id="cajaAncha">'."\n\r";
	$row_resumen.='  <div><strong>'.LABEL_Acciones.'</strong></div><dl class="dosCol">'."\n\r";

	if($resumen[cant_total]>0){
		$row_resumen.='<dt><a href="sobre.php?user_id='.$dato_user["id"].'" title="'.LABEL_Terminos.'">'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen[cant_total].'</a>&nbsp;</dd>'."\n\r";
		}else{
		$row_resumen.='<dt>'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen["cant_total"]."&nbsp;</dd>\n\r";
		};
	$row_resumen.='<dt>'.ucfirst(LABEL_RelTerminos).'</dt><dd>'.$resumen["cant_rel"]."&nbsp;</dd>\n\r";
	$row_resumen.='<dt>'.ucfirst(LABEL_TerminosUP).'</dt><dd>'.$resumen["cant_up"]."&nbsp;</dd>\n\r";
	$row_resumen.='</dl></div>';
};

$rows.='<form role="form" name="login" id="form-users" data-toggle="validator" action="admin.php" method="post">';
$rows.='	<div class="row">
		<div class="col-sm-12">
				<legend><a href="admin.php?user_id=list" title="'.LABEL_AdminUser.'">'.LABEL_AdminUser.'</a></legend>
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
							<input type="checkbox" name="isAdmin" id="isAdmin" value="1" '.arrayReplace(array("1","2"),array("checked",""),$dato_user["nivel"]).'/>
							<div class="col-sm-4">
							<label for="isAdmin">'.ucfirst(LABEL_esSuperUsuario).'</label>
								</div>
							</div>';
            if(isset($dato_user["id"]))
            {

							$isAlive=($dato_user["estado"]=='ACTIVO') ? 'checked': '';
							$rows.='<div class="form-group">
											<input type="checkbox" name="isAlive" id="isAlive" value="ACTIVO" '.$isAlive.'/>
											<div class="col-sm-4">
											<label for="isAlive">'.ucfirst(LABEL_User_Habilitado).'</label>
												</div>
											</div>';

						};
											$rows.='<div class="form-group">
																	<div class="col-sm-12 text-right">
																	<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
																	<a href="admin.php" class="btn btn-default" id="boton_cancelar" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
																	</div>
															</div>';


											$rows.='				</div>
															</div>
													</div>';

											$rows.=$row_resumen;

											$rows.='</div> <!-- / panel  -->';
											if(isset($dato_user["id"])){
												$rows.='<input type="hidden" name="useactua" id="useactua" value="'.$dato_user["id"].'"/>';
												$rows.='<input type="hidden" name="userTask" id="userTask" value="M"/>';
											}else {
												$rows.='<input type="hidden" name="userTask" id="userTask" value="A"/>';
											}
												$rows.='<input type="hidden" name="useactua" id="useactua" value="'.$dato_user["id"].'"/>';
												$rows.='</form>';

												echo $rows;
?>
