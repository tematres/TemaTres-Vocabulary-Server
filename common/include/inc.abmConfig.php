<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
#

// Preparado de datos para el formulario ///
$arrayLang=array();
foreach ($CFG["ISO639-1"] as $langs) {
	array_push($arrayLang,"$langs[0]#$langs[1]");
	};
$si=LABEL_SI;
$no=LABEL_NO;

if($_GET[vocabulario_id]>0){
	$sql_vocabulario=SQLdatosVocabulario($_GET[vocabulario_id]);
	$array_vocabulario=$sql_vocabulario->FetchRow();
	$fecha_crea=do_fecha($array_vocabulario[cuando]);
	}else{
	$array_vocabulario[vocabulario_id]='NEW';
	}

if($array_vocabulario[vocabulario_id]==1){
	$titulo_formulario=LABEL_vocabulario_principal;

	$ARRAYfetchValues=ARRAYfetchValues('METADATA');
	}else{
	$titulo_formulario=LABEL_vocabulario_referencia;
	}

$array_ano=do_intervalDate("1998",date(Y),FORM_LABEL_FechaAno);
$array_dia=do_intervalDate("1","31",FORM_LABEL_FechaDia);
$array_mes=do_intervalDate("1","12",FORM_LABEL_FechaMes);

$rows.='<form role="form" id="config-vocab" name="abm_config"  data-toggle="validator" action="admin.php" method="post">';
$rows.='	<div class="row">
		<div class="col-sm-12">
				<legend><a href="admin.php" title="'.ucfirst(LABEL_lcConfig).' '.$titulo_formulario.'">'.ucfirst(LABEL_lcConfig).'</a> &middot;  '.ucfirst($titulo_formulario).'</legend>
		</div>
		<!-- panel  -->
			    <div class="col-lg-7">
					<h4>'.ucfirst(LABEL_lcConfig).'</h4>
			        <div class="panel panel-default">
			            <div class="panel-body form-horizontal">';

			$rows.='<div class="form-group">
			           <label for="'.FORM_LABEL_Titulo.'" class="col-sm-3 control-label">'.ucfirst(LABEL_Titulo).'</label>
			                    <div class="col-sm-9">
			                        <input type="text"
															 class="form-control" required
															id="'.FORM_LABEL_Titulo.'"
															placeholder="'.LABEL_Titulo.'"
															name="'.FORM_LABEL_Titulo.'"
															value="'.$array_vocabulario["titulo"].'">
			                    </div>
			         </div>';


			$rows.='<div class="form-group">
				           <label for="'.FORM_LABEL_Autor.'" class="col-sm-3 control-label">'.ucfirst(LABEL_Autor).'</label>
			                    <div class="col-sm-9">
			                       <input type="text"
														 class="form-control" required
														id="'.FORM_LABEL_Autor.'"
														placeholder="'.LABEL_Autor.'"
														name="'.FORM_LABEL_Autor.'"
														value="'.$array_vocabulario["autor"].'">
				                    </div>
			         </div>';

			$rows.='<div class="form-group">
			           <label for="'.FORM_LABEL_Idioma.'" class="col-sm-3 control-label">'.ucfirst(LABEL_Idioma).'</label>
			                    <div class="col-sm-9">
													<select id="'.FORM_LABEL_Idioma.'" name="'.FORM_LABEL_Idioma.'">
														<optgroup label="'.LABEL_Idioma.'">
													'.doSelectForm($arrayLang,$array_vocabulario["idioma"]).'
															</optgroup>
															</select>
			                    </div>
			         </div>';

							$rows.='<div class="form-group">
							           <label for="cobertura" class="col-sm-3 control-label">'.ucfirst(LABEL_Cobertura).'</label>
							                    <div class="col-sm-9">
																	<textarea class="form-control"
																	type="text"
																	rows="3"
																	name="'.FORM_LABEL_Cobertura.'"
																	id="cobertura">'.$array_vocabulario["cobertura"].'</textarea>
							                    </div>
							         </div>';


		//is main vocab
		if($array_vocabulario[vocabulario_id]==1){

			$ARRAYcontactMail=ARRAYfetchValue('CONTACT_MAIL');

			$rows.='<div class="form-group">
			           <label for="dia" class="col-sm-3 control-label">'.ucfirst(LABEL_Fecha).'</label>
			                    <div class="col-sm-9">
													<select id="'.FORM_LABEL_FechaDia.'" name="'.FORM_LABEL_FechaDia.'">
														<optgroup label="'.LABEL_dia.'">
													'.doSelectForm($array_dia,$fecha_crea["dia"]).'
															</optgroup>
															</select>
													<select id="'.FORM_LABEL_FechaMes.'" name="'.FORM_LABEL_FechaMes.'">
														<optgroup label="'.LABEL_mes.'">
													'.doSelectForm($array_mes,$fecha_crea["mes"]).'
															</optgroup>
															</select>
													<select id="'.FORM_LABEL_FechaAno.'" name="'.FORM_LABEL_FechaAno.'">
														<optgroup label="'.LABEL_ano.'">
													'.doSelectForm($array_ano,$fecha_crea["ano"]).'
															</optgroup>
															</select>
			                    </div>
			         </div>';


			$rows.='<div class="form-group">
			           <label for="dccontributor" class="col-sm-3 control-label">'.ucfirst(LABEL_Contributor).'</label>
			                    <div class="col-sm-9">
			                        <input type="text"
															class="form-control"
															id="dccontributor"
															placeholder="'.LABEL_Contributor.'"
															name="dccontributor"
															value="'.$ARRAYfetchValues["dc:contributor"]["value"].'">
			                    </div>
			         </div>';



							$rows.='<div class="form-group">
							           <label for="dcrights" class="col-sm-3 control-label">'.ucfirst(LABEL_Publisher).'</label>
							                    <div class="col-sm-9">
							                        <input type="text" class="form-control"
																			 id="dcpublisher"
																			placeholder="'.LABEL_Publisher.'"
																			name="dcpublisher"
																			value="'.$ARRAYfetchValues["dc:publisher"]["value"].'">
							                    </div>
							         </div>';

			$rows.='<div class="form-group">
			           <label for="dcrights" class="col-sm-3 control-label">'.ucfirst(LABEL_Rights).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control"
															 id="dcrights"
															placeholder="'.LABEL_Rights.'"
															name="dcrights"
															value="'.$ARRAYfetchValues["dc:rights"]["value"].'">
			                    </div>
			         </div>';


							$rows.='<div class="form-group">
							           <label for="contact_mail" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL__contactMail).'</label>
							                    <div class="col-sm-9">
							                        <input type="text"
																			class="form-control"
																			id="contact_mail"
																			placeholder="'.FORM_LABEL__contactMail.'"
																			name="contact_mail"
																			value="'.$ARRAYcontactMail["value"].'" type="email">
							                    </div>
							         </div>';

			$rows.='<div class="form-group">
			           <label for="keywords" class="col-sm-3 control-label">'.ucfirst(LABEL_Keywords).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control"
															 id="keywords"
															placeholder="'.LABEL_Keywords.'"
															name="'.FORM_LABEL_Keywords.'"
															value="'.$array_vocabulario["keywords"].'">
			                    </div>
			         </div>';
			$rows.='<div class="form-group">
			           <label for="tipo_lang" class="col-sm-3 control-label">'.ucfirst(LABEL_TipoLenguaje).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control"
															 id="tipo_lang"
															placeholder="'.LABEL_TipoLenguaje.'"
															name="'.FORM_LABEL_TipoLenguaje.'"
															value="'.$array_vocabulario["tipo"].'">
			                    </div>
			         </div>';

			$rows.='<div class="form-group">
			           <label for="URIt" class="col-sm-3 control-label">'.ucfirst(LABEL_URI).'</label>
			                    <div class="col-sm-9">
			                        <input type="url" class="form-control" required
															 id="URIt"
															placeholder="'.LABEL_URI.'"
															name="'.FORM_LABEL_URI.'"
															value="'.$array_vocabulario["url_base"].'">
			                    </div>
			         </div>';

			$rows.=HTMLformConfigValues($array_vocabulario);
		};//end if main vocab
												$rows.='<div class="form-group">
																		<div class="col-sm-12 text-right">
																		<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
																		<a href="admin.php" class="btn btn-default" id="boton_cancelar" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
																		</div>
																</div>';


												$rows.='				</div>
																</div>
														</div>';

											$rows.='</div> <!-- / panel  -->';
												$rows.='<input type="hidden" name="vocabulario_id" id="vocabulario_id" value="'.$array_vocabulario["vocabulario_id"].'"/>';
												$rows.='<input type="hidden" name="task_config" id="task_config" value="configvocab"/>';
												$rows.='</form>';

													echo $rows;
?>
