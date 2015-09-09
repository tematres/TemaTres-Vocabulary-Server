<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de vocabularios controlados#       #
#   TemaTres : web application to manage controlled vocabularies
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Funciones para presentar formularios HTML. #
#


function HTMLformAssociateExistTerms($taskterm,$ARRAYtermino,$term_id="0")
{
	GLOBAL $new_relacion;

	switch ($taskterm)
	{
		case 'addRT':
		$nombre_pantalla=ucfirst(LABEL_AgregarRTexist).' <a title="'.$ARRAYtermino["titTema"].'" href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>';
		break;

		case 'addBT':
		$nombre_pantalla=sprintf(LABEL_AgregarTG,'<a title="'.$ARRAYtermino["titTema"].'" href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>');
		break;

		case 'addFreeUF':
		$nombre_pantalla=sprintf(LABEL_existAgregarUP,'<a  title="'.$ARRAYtermino["titTema"].'" href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>');
		break;

		case 'addFreeNT':
		$nombre_pantalla=sprintf(LABEL_existAgregarTE,'<a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>');
		break;

		default: '';
	}

	if((doValue($_POST,FORM_LABEL_buscarTermino)) || ($_GET["showFreeTerms"]==1)){

		$expresBusca=doValue($_POST,FORM_LABEL_buscarTermino);

		if($_GET["showFreeTerms"]==1)
		{
			$sql_busca=SQLverTerminosLibres();
			$cant_result=SQLcount($sql_busca);
			$search_leyenda='<h3>'.$cant_result.' '.LABEL_terminosLibres.'</h3>'."\n\r";
		}//seleccionar SQL adecuado a la operacion
		elseif(($taskterm=='addFreeNT') || ($taskterm=='addFreeUF'))
		{
			$sql_busca=SQLsearchFreeTerms($expresBusca,$ARRAYtermino["idTema"]);
			$cant_result=SQLcount($sql_busca);
			$search_leyenda='<h3>'.$cant_result.' '.MSG_ResultBusca.' <i>'.$expresBusca.'</i>.</h3>'."\n\r";
		}
		else
		{
			$sql_busca=SQLbuscaTR($ARRAYtermino["idTema"],"$expresBusca");
			$cant_result=SQLcount($sql_busca);
			$search_leyenda='<h3>'.$cant_result.' '.MSG_ResultBusca.' <i>'.$expresBusca.'</i>.</h3>'."\n\r";
		}


		if($cant_result>0)
		{
			$rows_busca.='<div><input id="filter" type="text" class="form-control" placeholder="'.ucfirst(LABEL_type2filter).'"></div>';
			$rows_busca.='<form role="form" class="form-inline" role="form" name="addRelations" id="addRelations" action="index.php" method="get" >';
			$rows_busca.='<div class="table-responsive"> ';
			$rows_busca.='<table class="table table-striped table-bordered table-condensed table-hover"">';
			$rows_busca.='<thead>
			<tr><th>';

			//
			//$rows_busca.=($taskterm=='addBT') ? '':'<input name="checktodos" type="checkbox" title="'.LABEL_selectAll.'"/>';

			$rows_busca.='</th><th>'.ucfirst(LABEL_Termino).'</th>
			<th>'.ucfirst(LABEL_Fecha).'</th>
			</tr>
			</thead>
			<tbody class="searchable">';

			while($resulta_busca=$sql_busca->FetchRow()){

				$css_class_MT=($resulta_busca["isMetaTerm"]==1) ? ' class="metaTerm" ' : '';

				//prevenir que no seleccione el mismo término que esta mirando
			if($resulta_busca["tema_id"]!==$ARRAYtermino["idTema"]){

					if($taskterm=='addBT'){
						$rows_busca.= '<tr>';
						$rows_busca.=  '     <td align="center"><input type="radio" name="rema_id" id="rema_'.$resulta_busca["tema_id"].'" title="'.$resulta_busca["tema"].'" value="'.$resulta_busca["tema_id"].'" /> </td>';
						$rows_busca.=  '     <td><label class="check_label" for="rema_'.$resulta_busca["tema_id"].'" '.$css_class_MT.'> '.$resulta_busca["tema"].'</label> </td>';
						$rows_busca.=  '      <td>'.$resulta_busca["cuando"].'</td>';
						$rows_busca.=  '  </tr>';

					}			else 			{
						$rows_busca.= '<tr>';
						$rows_busca.=  '     <td align="center"><input type="checkbox" name="rema_id[]" id="rema_'.$resulta_busca["tema_id"].'" title="'.$resulta_busca["tema"].'" value="'.$resulta_busca["tema_id"].'" /> </td>';
						$rows_busca.=  '     <td><label class="check_label" for="rema_'.$resulta_busca["tema_id"].'" '.$css_class_MT.'> '.$resulta_busca["tema"].'</label> </td>';
						$rows_busca.=  '      <td>'.$resulta_busca["cuando"].'</td>';
						$rows_busca.=  '  </tr>';
					}

				};
			}
			$rows_busca.='        </tbody>';
			$rows_busca.='<tfoot>
			<tr>
			<td colspan=3>';
			$rows_busca.=' <input type="hidden" name="tema" id="tema" value="'.$ARRAYtermino["idTema"].'"/>';
			$rows_busca.=' <input type="hidden" name="taskterm" id="taskterm" value="'.$taskterm.'"/>	  ';
			$rows_busca.=' <input type="hidden" name="taskrelations" id="taskrelations" value="'.$taskterm.'"/>	  ';
			$rows_busca.= '		</td>
			</tr>
			</tfoot>

			</table>	</div>';
			//no es subordinar término y hay resultados
			if($cant_result>0)
			{
				$rows_busca.='<div class="submit_form" align="center">';
				$rows_busca.='  <button type="submit" class="btn btn-primary">'.LABEL_Agregar.'</button>';
				$rows_busca.='</div>';
			}
			$rows_busca.='</form>';

		}//if cant

		$rows_busca.='</div>';

		$rows_busca.='<script type="text/javascript">
		$(document).ready(function(){
			//Checkbox
			$("input[name=checktodos]").change(function(){
				$("input[type=checkbox]").each( function() {
					if($("input[name=checktodos]:checked").length == 1){
						this.checked = true;
					} else {
						this.checked = false;
					}
				});
			});

		});
		</script>';
	};//fin de if buscar

	$rows.='<div class="container" id="bodyText">
	<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.' ('.$ARRAYtermino["tema"].')">'.LABEL_Anterior.'</a>
	<h3>'.LABEL_EditorTermino.'</h3>';

	if ($new_relacion["log"]==true)
	{
		$rows.='<p class="success">'.ucfirst(LABEL_saved).'</p>';
	}

	$rows.=' <form class="form-inline" role="form" name="busca_rel" action="index.php?taskterm='.$taskterm.'&amp;tema='.$ARRAYtermino["idTema"].'" method="post">';
	$rows.='  <fieldset>
	<legend>'.$nombre_pantalla.'</legend>
	<input class="form-inline input_ln form-control" name="'.FORM_LABEL_buscarTermino.'" type="search" id="addExistTerm" maxlength="50"/>
	<button type="submit" class="btn btn-primary">'.LABEL_Buscar.'</button>
	 <button type="button" class="btn btn-info" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'&amp;taskterm='.$taskterm.'&amp;showFreeTerms=1\'"/>'.ucfirst(LABEL_showFreeTerms).'</button>
	 <button type="button" class="btn btn-default" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'">'.ucfirst(LABEL_Cancelar).'</button>
	<input type="hidden" name="tema" value="'.$ARRAYtermino["idTema"].'"/>
	<input type="hidden" name="taskterm" value="'.$taskterm.'"/>
	</form>';

	if(in_array($taskterm, array("addFreeUF","addFreeNT"))) 		$rows.='<p class="text-warning">'.LABEL_helpSearchFreeTerms.'</p>';

	$rows.='</fieldset>';

	$rows.=$search_leyenda;
	$rows.=$rows_busca;
	$rows.='   </div>';

	return $rows;
}


/*
* Form for edit or add terms
3 casos:
- Alta y edici�n de un t�rmino nuevo.
- Alta de un t�rmino no preferido de un t�rmino preferido.
- Alta de un t�rmino subordinado a un t�rmino.
*
*/
function HTMLformEditTerms($taskterm,$ARRAYtermino="0")
{
	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	switch($taskterm)
	{
		case 'addTerm':// add term
		$nombre_pantalla=LABEL_AgregarT;
		$hidden='<input type="hidden"  name="alta_t" value="new" />';

		$hidden.='<div><input type="checkbox" name="estado_id" id="estado_id" value="12" alt="'.ucfirst(LABEL_Candidato).'" /> <label for="estado_id" accesskey="e">'.ucfirst(LABEL_Candidato).'</label></div>';
		$hidden.='<div><input type="checkbox" name="isMetaTerm" id="isMetaTerm" value="1" alt="'.ucfirst(LABEL_meta_term).'" /> <label for="isMetaTerm" accesskey="e">'.ucfirst(LABEL_meta_term).'</label>
			<div class="alert alert-info" role="alert">'.NOTE_isMetaTermNote.'</div>
			</div>';


		$help_rows='<p class="text-primary">'.HELP_variosTerminos.'</p>';
		$extra_button='<a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=addTermSuggested" title="'.ucfirst(LABEL__getForRecomendation).'">'.ucfirst(LABEL__getForRecomendation).'</a>';
		break;

		case 'editTerm'://Edici�n de un t�rmino $edit_id
		$nombre_pantalla=LABEL_editT.' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>';
		$vista_titulo_tema=$ARRAYtermino["titTema"];
		$vista_desc_tema=$ARRAYtermino[descTema];
		$hidden='<input type="hidden"  name="edit_id_tema" value="'.$ARRAYtermino["idTema"].'" />';
		break;

		case 'addNT':// add narowwer term
		$nombre_pantalla=LABEL_AgregarTE.' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>';
		$hidden.='<input type="hidden"  name="id_termino_sub" value="'.$ARRAYtermino["idTema"].'" />';
		$help_rows='<p class="text-primary">'.HELP_variosTerminos.'</p>';
		$extra_button='<a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=addFreeNT&amp;tema='.$ARRAYtermino["idTema"].'" title="'.ucfirst(MENU_AgregarTEexist).'">'.ucfirst(MENU_AgregarTEexist).'</a>';
		$extra_button.=' <a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=findSuggestionTargetTerm&amp;tema='.$ARRAYtermino["idTema"].'&amp;t_relation=3" title="'.ucfirst(LABEL__getForRecomendation).'">'.ucfirst(LABEL__getForRecomendation).'</a>';
		$t_relation='3';
		break;

		case 'addUF'://Alta de un t�rmino no preferido a $id_uf
		$nombre_pantalla=LABEL_AgregarUP.' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>';
		$hidden='<input type="hidden"  name="id_termino_uf" value="'.$ARRAYtermino["idTema"].'" />';
		$help_rows='<p class="text-primary">'.HELP_variosTerminos.'</p>';
		$extra_button='<a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=addFreeUF&amp;tema='.$ARRAYtermino["idTema"].'" title="'.ucfirst(MENU_AgregarUPexist).'">'.ucfirst(MENU_AgregarUPexist).'</a>';
		$extra_button.=' <a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=findSuggestionTargetTerm&amp;tema='.$ARRAYtermino["idTema"].'&amp;t_relation=4" title="'.ucfirst(LABEL__getForRecomendation).'">'.ucfirst(LABEL__getForRecomendation).'</a>';
		$t_relation='4';
		break;

		case 'addRTnw'://Alta de un término RT
		$nombre_pantalla=LABEL_AgregarTR.' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a>';
		$hidden='<input type="hidden"  name="id_termino_rt" value="'.$ARRAYtermino["idTema"].'" />';
		$help_rows='<p class="text-primary">'.HELP_variosTerminos.'</p>';
		$extra_button='<a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=addRT&amp;tema='.$ARRAYtermino["idTema"].'" title="'.ucfirst(MENU_selectExistTerm).'">'.ucfirst(MENU_selectExistTerm).'</a>';
		$extra_button.=' <a class="btn btn-second btn-xs" role="button" href="index.php?taskterm=findSuggestionTargetTerm&amp;tema='.$ARRAYtermino["idTema"].'&amp;t_relation=2" title="'.ucfirst(LABEL__getForRecomendation).'">'.ucfirst(LABEL__getForRecomendation).'</a>';

		$t_relation='2';

		break;
	};

	$rows.='<div class="container" id="bodyText">';
	$rows.='<div class="row">';
	$rows.='<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>
		<h3>'.LABEL_EditorTermino .'</h3>';
	$rows.='<form class="form-horizontal col-xs-12 col-md-8" role="form" id="alta_t" name="alta_t" action="index.php" method="post">
		<fieldset>
		<legend>'.$nombre_pantalla.'</legend>

		<div class="form-group form-group-chk">
		<label for="'.FORM_LABEL_termino .'" accesskey="t">'.LABEL_Termino.'</label>
		'.$extra_button.'
		<textarea class="form-control" type="text" required autofocus rows="2" cols="60" name="'.FORM_LABEL_termino.'" id="addTerms">'.$vista_titulo_tema.'</textarea>';
	$rows.=$help_rows;

	$rows.=$extra_tag;
	$rows.='</div>';


		if(in_array($t_relation,array(2,3,4)))
		{
			$SQLtypeRelations=SQLtypeRelations($t_relation);

			if(SQLcount($SQLtypeRelations)>0)
			{
				while($ARRAYtypeRelations=$SQLtypeRelations->FetchRow())
				{
					$arraySelectTypeRelations[]=$ARRAYtypeRelations[rel_rel_id].'#'.$ARRAYtypeRelations[rr_value];
					$neutralLabel=LABELrelTypeSYS($ARRAYtypeRelations[t_relation]);
				}


				$rows.='<div class="form-group"><label for="rel_rel_id" accesskey="r">'.ucfirst(LABEL_relationSubType).'<span class="small">('.LABEL_optative.')</span></label>';
				$rows.='<select class="form-control" id="t_rel_rel_id" name="t_rel_rel_id"><option>'.ucfirst(LABEL_seleccionar).'</option>';
				$rows.=doSelectForm($arraySelectTypeRelations,"");
				$rows.='</select>';
				$rows.='</div>';
			}
		}


		$rows.='<div class="text-center">';
			$rows.='<input type="submit" class="btn btn-primary" role="button" name="boton" value="'.LABEL_Enviar.'"/>';
			$rows.=' <input type="button" class="btn btn-default" role="button" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>';
		$rows.='</div>';

		$rows.=$hidden;

		$rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
		$rows.='  </fieldset>';
		$rows.='</form>';
		$rows.='		</div>';//row
		$rows.='</div>';//container

		return $rows;
}



/*
* Form for edit or add terms
1 caso:
- Alta de un t�rmino nuevo.
*
*/
function HTMLformSuggestTerms($ARRAYtargetVocabulary=array())
{
	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$sql=SQLtargetVocabulary("1");

	$rows='<div class="container" id="bodyText">';
	$rows.='<a class="topOfPage" href="index.php?taskterm=addTerm" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';
	if(SQLcount($sql)=='0'){
		//No hay vocabularios de referencia, solo vocabulario principal
		$rows.=HTMLalertNoTargetVocabulary();
	} else {
		//Hay vobularios de referencia
		$array_vocabularios=array();
		while($array=$sql->FetchRow())
		{
			if($array[vocabulario_id]!=='1')
			{
				//vocabularios que no sean el vocabulario principal
				array_push($array_vocabularios,$array[tvocab_id].'#'.FixEncoding($array[tvocab_label]));
			}
		};

		$searchType=(!$_GET["tvocab_id"]) ? 1 : $_GET["searchType"];
		$string2search = XSSprevent(trim($_GET[string2search]));

		$rows.='<form class="" role="form" name="alta_tt" id="alta_tt" action="index.php#suggestResult" method="get">';
		$rows.='	<div class="row">
        <div class="col-sm-12">
            <legend>'.ucfirst(LABEL_EditorTermino).'</legend>
        </div>
        <!-- panel  -->

        <div class="col-lg-7">
            <h4>'.ucfirst(LABEL__getForRecomendation).'</h4>
            <div class="panel panel-default">
                <div class="panel-body form-horizontal">

								<div class="form-group">
								<label for="tvocab_id" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_nombre_vocabulario).'</label>
										<div class="col-sm-9">
												<select class="form-control" id="tvocab_id" name="tvocab_id">
												'.doSelectForm($array_vocabularios,$_GET["tvocab_id"]).'
												</select>
										</div>
								</div>
                    <div class="form-group">
                        <label for="string2search" class="col-sm-3 control-label">'.ucfirst(LABEL_Buscar).'</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required autofocus type="search" id="string2search" name="string2search" value="'.$string2search.'">
                        </div>
                    </div>
										<div class="form-group">
										<input type="checkbox" name="searchType" id="searchType" value="1" alt="'.ucfirst(LABEL_esFraseExacta).'" '.do_check(1,$searchType,'checked').'  />
										<div class="col-sm-4">
										<label for="searchType">'.ucfirst(LABEL_esFraseExacta).'</label>
											</div>
										</div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
												 <button type="submit" class="btn btn-primary" value="'.LABEL_Buscar.'"/>'.ucfirst(LABEL_Buscar).'</button>
												  <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?taskterm=addTerm&tema=0\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- / panel  -->';
		$rows.='<input type="hidden" name="taskterm" value="addTermSuggested"/>';
		$rows.='</form>';
	}

	if(($string2search) && ($_GET["tvocab_id"])){

		require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;

		$arrayVocab=ARRAYtargetVocabulary($_GET["tvocab_id"]);

		$task=($_GET["searchType"]==1) ? 'fetch' : 'search';

		$dataTterm=getURLdata($arrayVocab[tvocab_uri_service].'?task='.$task.'&arg='.urlencode($string2search));

		if($dataTterm->resume->cant_result > "0")	{

			$arrayTtermData = array();

			foreach ($dataTterm->result->term as $value){

				$i=++$i;
				$term_id=(int) $value->term_id;
				$string=(string) $value->string;
				$arrayTtermData[$term_id]=array("term_id"=>$term_id,
				"string"=>$string,
				"source_string"=>$string,
				"source_term_id"=>$term_id
			);
		};
	}

	//null for t_relation
	$t_relation=0;
	$rows.='   </div>';//row

	$rows.=HTMLformTargetVocabularySuggested($arrayTtermData,$t_relation,$string2search,$arrayVocab,$ARRAYtermino["idTema"]);


};//fin de if buscar
$rows.='   </div>';//container

return $rows;

}



/*
* Form for edit or add terms
3 casos:
- Alta y edici�n de un t�rmino relacionado.
- Alta de un t�rmino no preferido de un t�rmino preferido.
- Alta de un t�rmino subordinado a un t�rmino.
*
*/
function HTMLformSuggestTermsXRelations($ARRAYtermino,$ARRAYtargetVocabulary=array())
{
	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$sql=SQLtargetVocabulary("1");

	$rows='<div class="container" id="bodyText">';
	$rows.='<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';
	$rows.='<h3><a href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.$ARRAYtermino["titTema"].'">'.$ARRAYtermino["titTema"].'</a></h3>';

	if(SQLcount($sql)=='0'){
		//No hay vocabularios de referencia, solo vocabulario principal
		$rows.=HTMLalertNoTargetVocabulary();
	} else {
		//Hay vobularios de referencia
		$array_vocabularios=array();
		while($array=$sql->FetchRow())
		{
			if($array[vocabulario_id]!=='1')
			{
				//vocabularios que no sean el vocabulario principal
				array_push($array_vocabularios,$array[tvocab_id].'#'.FixEncoding($array[tvocab_label]));
			}
		};

		//Configurar opcion búsqueda por código
		$arrayOptions= array('3#'.ucfirst(TE_termino),'4#'.ucfirst(UP_termino),'2#'.ucfirst(TR_termino));
		$string2search = ($_GET[string2search]) ? XSSprevent(trim($_GET[string2search])) : $ARRAYtermino["titTema"];
		$searchType=(!$_GET["tvocab_id"]) ? 1 : $_GET["searchType"];

		$rows.='<form class="" role="form" name="alta_tt" id="alta_tt" action="index.php#suggestResult" method="get">';
		$rows.='	<div class="row">
        <div class="col-sm-12">
            <legend>'.ucfirst(LABEL_EditorTermino).'</legend>
        </div>
        <!-- panel  -->

        <div class="col-lg-7">
            <h4>'.ucfirst(LABEL__getForRecomendation).'</h4>
            <div class="panel panel-default">
                <div class="panel-body form-horizontal">

								<div class="form-group">
								<label for="tvocab_id" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_nombre_vocabulario).'</label>
										<div class="col-sm-9">
												<select class="form-control" id="tvocab_id" name="tvocab_id">
												'.doSelectForm($array_vocabularios,$_GET["tvocab_id"]).'
												</select>
										</div>
								</div>

								<div class="form-group">
								<label for="t_relation" class="col-sm-3 control-label">'.ucfirst(LABEL_relationSubType).'</label>
										<div class="col-sm-9">
												<select class="form-control" id="t_relation" name="t_relation">
												'.doSelectForm($arrayOptions,$_GET["t_relation"]).'
												</select>
										</div>
								</div>
                    <div class="form-group">
                        <label for="string2search" class="col-sm-3 control-label">'.ucfirst(LABEL_Buscar).'</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  type="search" required autofocus id="string2search" name="string2search" value="'.$string2search.'">
                        </div>
                    </div>

										<div class="form-group">
										<input type="checkbox" name="searchType" id="searchType" value="1" alt="'.ucfirst(LABEL_esFraseExacta).'" '.do_check(1,$searchType,'checked').'  />
										<div class="col-sm-4">
										<label for="searchType">'.ucfirst(LABEL_esFraseExacta).'</label>
											</div>
										</div>

                    <div class="form-group">
                        <div class="col-sm-12 text-right">
												 <button type="submit" class="btn btn-primary" value="'.LABEL_Buscar.'"/>'.ucfirst(LABEL_Buscar).'</button>
												  <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- / panel  -->';
		$rows.='<input type="hidden" name="tema" value="'.$ARRAYtermino["idTema"].'"/>';
		$rows.='<input type="hidden" name="taskterm" value="findSuggestionTargetTerm"/>';
		$rows.='</form>';
	}

	$rows.='</div>';
	$t_relation=(in_array($_GET["t_relation"], array("4","3","2","0"))) ? $_GET["t_relation"] : '';


	if(($string2search) && ($_GET["tvocab_id"])){

		require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;

		$arrayVocab=ARRAYtargetVocabulary($_GET["tvocab_id"]);

		$task=($_GET["searchType"]==1) ? 'fetch' : 'search';

		$dataTterm=getURLdata($arrayVocab[tvocab_uri_service].'?task='.$task.'&arg='.urlencode($string2search));

		if($dataTterm->resume->cant_result > "0")	{

			$array_terms=array();

			foreach ($dataTterm->result->term as $value){

				array_push($array_terms, array("term_id"=>(int) $value->term_id,
				"string"=>(string) $value->string));
				$tterms_id.=(int) $value->term_id.',';
			};
		}

		switch ($t_relation) {

			case '2'://RT
			$arrayTterm=getForeingStrings($arrayVocab[tvocab_uri_service],'fetchRelated',$array_terms);

			break;

			case '3'://BT/NT
			$arrayTterm=getForeingStrings($arrayVocab[tvocab_uri_service],'fetchDown',$array_terms);
			break;


			case '4'://UF
			$arrayTterm=getForeingStrings($arrayVocab[tvocab_uri_service],'fetchAlt',$array_terms);
			break;

			default :
			break;
		}

		$rows.=HTMLformTargetVocabularySuggested($arrayTterm,$t_relation,$string2search,$arrayVocab,$ARRAYtermino["idTema"]);


	};//fin de if buscar
	$rows.='   </div>';

	return $rows;

}




/*
Advanced search form
*
*/
function HTMLformAdvancedSearch($array)
{

	GLOBAL $CFG;

	$array=XSSpreventArray($array);

	$rows.='<div class="row">';
	$rows.='	<div class="col-md-6 col-md-offset-3">';

	$rows.=' <h3>'.ucfirst(LABEL_BusquedaAvanzada).'</h3>';

	$rows.='<form  class="col-xs-8 form-horizontal" role="form" name="advancedsearch" action="index.php#xstring" method="get">';
	$rows.='<fieldset>';

	$LABEL_Termino=ucfirst(LABEL_Termino);
	$LABEL_esNoPreferido=ucfirst(LABEL_esNoPreferido);
	$LABEL_CODE=ucfirst(LABEL_CODE);
	$LABEL_NOTE=ucfirst(LABEL_nota);
	$LABEL_META_TERM=ucfirst(LABEL_meta_term);
	$LABEL_TARGET_TERM=ucfirst(LABEL_TargetTerm);

	$arrayWS=array("t#$LABEL_Termino","mt#$LABEL_META_TERM");

	$arrayVocabStats=ARRAYresumen($_SESSION[id_tesa],"G","");

	if($arrayVocabStats["cant_up"]>0)
	{
		array_push($arrayWS,"uf#$LABEL_esNoPreferido");
	}

	if($arrayVocabStats["cant_notas"]>0)
	{
		array_push($arrayWS,"n#$LABEL_NOTE");
	}

	if($CFG["_SHOW_CODE"]=='1')
	{
		array_push($arrayWS,"c#$LABEL_CODE");
	}

	if($arrayVocabStats["cant_term2tterm"])
	{
		array_push($arrayWS,"tgt#$LABEL_TARGET_TERM");
	}

	/*
	solo si hay m�s de un opci�n
	*/
	if(count($arrayWS)>1)
	{
		$rows.='<div class="form-group"><label class="label_ttl control-label" for="ws" accesskey="f">'.ucfirst(LABEL_QueBuscar).'</label>';
		$rows.='<select class="select_ttl form-control" id="ws" name="ws">';
		$rows.=doSelectForm($arrayWS,"$_GET[ws]");
		$rows.='</select>';
		$rows.='</div>';
	}

	$rows.='<div class="form-group"><label class="label_ln control-label" for="xstring" accesskey="s">'.ucfirst(LABEL_BuscaTermino).'</label>';

	$rows.='<input name="xstring" class="input_ln form-control" required type="search" id="xstring" size="25" maxlength="50" value="'.$array["xstring"].'"/>';

	$rows.='	<div class="checkbox-inline" ><label class="btn btn-default" for="isExactMatch" accesskey="f">';
	$rows.='	<input name="isExactMatch" type="checkbox" id="isExactMatch" value="1" '.do_check('1',$_GET["isExactMatch"],"checked").'/>'.ucfirst(LABEL_esFraseExacta).'</label>';
	$rows.=' 	</div>';
	$rows.='</div>';

	$rows.='<div class="collapse" id="masOpcionesBusqueda">';

	//Evaluar si hay top terms
	$sqlTopTerm=SQLverTopTerm();

	if(SQLcount($sqlTopTerm)>0)
	{
		while ($arrayTopTerms=$sqlTopTerm->FetchRow())
		{
			$formSelectTopTerms[]=$arrayTopTerms["tema_id"].'#'.$arrayTopTerms[tema];
		}
		$rows.='<div class="form-group"><label class="label_ttl control-label" for="hasTopTerm" accesskey="t">'.ucfirst(LABEL_TopTerm).'</label>';
		$rows.='<select class="select_ttl form-control" id="hasTopTerm" name="hasTopTerm">';
		$rows.='<option value="">'.ucfirst(LABEL_Todos).'</option>';
		$rows.=doSelectForm($formSelectTopTerms,"$_GET[hasTopTerm]");
		$rows.='</select>';
		$rows.='</div>';
	}

	//Evaluar si hay notas
	if (is_array($arrayVocabStats["cant_notas"]))
	{

		$LabelNB='NB#'.LABEL_NB;
		$LabelNH='NH#'.LABEL_NH;
		$LabelNA='NA#'.LABEL_NA;
		$LabelNP='NP#'.LABEL_NP;
		$LabelNC='NC#'.LABEL_NC;

		$sqlNoteType=SQLcantNotas();
		$arrayNoteType=array();

		while ($arrayNotes=$sqlNoteType->FetchRow()){
			if($arrayNotes[cant]>0)
			{

				//nota privada no
				if(($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]) || ($arrayNotes["value_id"]!=='11'))
				{
					$varNoteType=(in_array($arrayNotes["value_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array($LabelNA,$LabelNH,$LabelNB,$LabelNP,$LabelNC),$arrayNotes["value_id"]) : $arrayNotes["value_code"].'#'.$arrayNotes["value"];
					$varNoteType.=' ('.$arrayNotes[cant].')';
					array_push($arrayNoteType, $varNoteType);
				}
			}
		};


		/*
		Si hay m�s de un tipo de nota
		*/
		if(count($arrayVocabStats["cant_notas"])>0)
		{
			$rows.='<div class="form-group"><label class="label_ttl control-label" for="hasNote" accesskey="n">'.ucfirst(LABEL_tipoNota).'</label>';
			$rows.='<select class="select_ttl form-control" id="hasNote" name="hasNote">';
			$rows.='<option value="">'.ucfirst(LABEL_Todos).'</option>';
			$rows.=doSelectForm($arrayNoteType,"$_GET[hasNote]");
			$rows.='</select>';
			$rows.='</div>';
		}
	}


	//Evaluar si hay terminos
	$sqlTermsByDates=SQLtermsByDate();

	if(SQLcount($sqlTermsByDates)>0)
	{
		GLOBAL $MONTHS;
		while ($arrayTermsByDates=$sqlTermsByDates->FetchRow())
		{
			//normalizacion de fechas
			$arrayTermsByDates[months]=(strlen($arrayTermsByDates[months])==1) ? '0'.$arrayTermsByDates[months] : $arrayTermsByDates[months];

			$formSelectByDate[]=$arrayTermsByDates[years].'-'.$arrayTermsByDates[months].'#'.$MONTHS["$arrayTermsByDates[months]"].'/'.$arrayTermsByDates[years].' ('.$arrayTermsByDates[cant].')';
		}

		$rows.='<div class="form-group"><label class="label_ttl control-label" for="fromDate" accesskey="d">'.ucfirst(LABEL_DesdeFecha).'</label>';
		$rows.='<select class="select_ttl form-control" id="fromDate" name="fromDate">';
		$rows.='<option value="">'.ucfirst(LABEL_Todos).'</option>';
		$rows.=doSelectForm($formSelectByDate,"$_GET[fromDate]");
		$rows.='</select>';
		$rows.='</div>';
	};

	//terms by deep
	$sqlTermsByDeep=SQLTermDeep();

	if(SQLcount($sqlTermsByDeep)>1)
	{
		while ($arrayTermsByDeep=$sqlTermsByDeep->FetchRow())
		{
			$formSelectByDeep[]=$arrayTermsByDeep[tdeep].'#'.$arrayTermsByDeep[tdeep].' ('.$arrayTermsByDeep[cant].')';
		}
		$rows.='<div class="form-group"><label class="label_ttl control-label" for="termDeep" accesskey="e">'.ucfirst(LABEL_ProfundidadTermino).'</label>';
		$rows.='<select class="select_ttl form-control" id="termDeep" name="termDeep">';
		$rows.='<option value="">'.ucfirst(LABEL_Todos).'</option>';
		$rows.=doSelectForm($formSelectByDeep,"$_GET[termDeep]");
		$rows.='</select>';
		$rows.='</div>';
	};

	$rows.='</div>';//hide div

	$rows.='<div class="btn-group">';
	$rows.='<input type="submit"  id="boton" name="boton" class="btn btn-primary" value="'.LABEL_Enviar.'"/>';
	$rows.=' <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#masOpcionesBusqueda" aria-expanded="false" aria-controls="masOpcionesBusqueda">'.ucfirst(LABEL_Opciones).'</button>';
	//$rows.='<input type="button" class="btn btn-default" name="cancelar" type="button" onClick="location.href=\'index.php\'" value="'.ucfirst(LABEL_Cancelar).'"/>';
	$rows.='</div>';

	$rows.='<input type="hidden"  name="xsearch" id="xsearch" value="1"/>';


	$rows.='  </fieldset>';
	$rows.='</form>';

	$rows.='</div>';//div row
	$rows.='</div>';//div col
	$rows.='<div class="push"></div>';

	if($_GET[boton]==LABEL_Enviar)
	{
		$rows.=HTMLadvancedSearchResult($array);
	}


	return $rows;
}


/*
Term Report form
*
*/
function HTMLformAdvancedTermReport($array)
{

	GLOBAL $CFG;

	$LABEL_Termino=ucfirst(LABEL_Termino);
	$LABEL_esNoPreferido=ucfirst(LABEL_esNoPreferido);
	$LABEL_CODE=ucfirst(LABEL_CODE);
	$LABEL_NOTE=ucfirst(LABEL_nota);
	$LABEL_TARGET_TERM=ucfirst(LABEL_TargetTerm);
	$LABEL_haveEQ=LABEL_haveEQ;
	$LABEL_nohaveEQ=LABEL_nohaveEQ;
	$LABEL_start=LABEL_start;
	$LABEL_end=LABEL_end;
	$LABEL_equalThisWord=LABEL_equalThisWord;

	$arrayVocabStats=ARRAYresumen($_SESSION["id_tesa"],"G","");


		$arrayWS=array("t#$LABEL_Termino");

		if($arrayVocabStats["cant_up"]>0)
		{
			array_push($arrayWS,"uf#$LABEL_esNoPreferido");
		}


		//Notes
		if($arrayVocabStats["cant_notas"]>0)
		{
			array_push($arrayWS,"n#$LABEL_NOTE");

			$LabelNB='NB#'.LABEL_NB;
			$LabelNH='NH#'.LABEL_NH;
			$LabelNA='NA#'.LABEL_NA;
			$LabelNP='NP#'.LABEL_NP;
			$LabelNC='NC#'.LABEL_NC;

			$sqlNoteType=SQLcantNotas();
			$arrayNoteType=array();

			while ($array=$sqlNoteType->FetchRow()){
				if($array[cant]>0)
				{
					$varNoteType=(in_array($array["value_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array($LabelNA,$LabelNH,$LabelNB,$LabelNP,$LabelNC),$array["value_id"]) : $array["value_code"].'#'.$array["value"];
					$varNoteType.=' ('.$array["cant"].')';

					array_push($arrayNoteType, $varNoteType);
				}
			};

		}


		//target vocabularies
		if($arrayVocabStats["cant_term2tterm"])
		{
			$sql=SQLtargetVocabulary("1");
			$array_vocabularios=array();
			while($array=$sql->FetchRow())
			{
					//vocabularios que no sean el vocabulario principal
					array_push($array_vocabularios,$array[tvocab_id].'#'.FixEncoding($array[tvocab_label]));
			};
		}

		//Evaluar si hay top terms
		$sqlTopTerm=SQLverTopTerm();
		if(SQLcount($sqlTopTerm)>0)
		{
			while ($arrayTopTerms=$sqlTopTerm->FetchRow())
			{
				$formSelectTopTerms[]=$arrayTopTerms["tema_id"].'#'.$arrayTopTerms[tema];
			}
		}

		//Evaluar si hay terminos
		$sqlTermsByDates=SQLtermsByDate();
		if(SQLcount($sqlTermsByDates)>0)
		{
			GLOBAL $MONTHS;
			while ($arrayTermsByDates=$sqlTermsByDates->FetchRow())
			{
				//normalizacion de fechas
				$arrayTermsByDates[months]=(strlen($arrayTermsByDates[months])==1) ? '0'.$arrayTermsByDates[months] : $arrayTermsByDates[months];
				$formSelectByDate[]=$arrayTermsByDates["years"].'-'.$arrayTermsByDates["months"].'#'.$MONTHS["$arrayTermsByDates[months]"].'/'.$arrayTermsByDates["years"].' ('.$arrayTermsByDates["cant"].')';
			}
		};

	//internal reference vocabularies
	$sql=SQLdatosVocabulario();
	if(SQLcount($sql)>'1'){
		//Hay vobularios de referencia
		$array_ivocabularios=array();
		while($array=$sql->FetchRow()){
			if($array[vocabulario_id]!=='1')
			{
				//vocabularios que no sean el vocabulario principal
				array_push($array_ivocabularios,$array[vocabulario_id].'#'.$array[titulo]);
			}
		};
	};

	$rows='<form class="form-horizontal" role="form" name="advancedreport" action="index.php#csv" method="get">
<fieldset>

<!-- Form Name -->
<legend>'.ucfirst(LABEL_FORM_advancedReport).'</legend>';
if(SQLcount($sqlTopTerm)>0)
{
$rows.='<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="hasTopTerm">'.ucfirst(LABEL_TopTerm).'</label>
  <div class="col-md-5">
    <select id="hasTopTerm" name="hasTopTerm" class="form-control">
		<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
		'.doSelectForm($formSelectTopTerms,$_GET["hasTopTerm"]).'
    </select>
  </div>
</div>';
};
if($arrayVocabStats["cant_notas"]>0)
{
$rows.='<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="hasNote">'.ucfirst(LABEL_FORM_haveNoteType).'</label>
  <div class="col-md-4">
    <select id="hasNote" name="hasNote" class="form-control">
		<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
		'.doSelectForm($arrayNoteType,$_GET["hasNote"]).'
    </select>
  </div>
</div>';
};

$rows.='<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="fromDate">'.ucfirst(LABEL_DesdeFecha).'</label>
  <div class="col-md-3">
    <select id="fromDate" name="fromDate" class="form-control">
		<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
		'.doSelectForm($formSelectByDate,$_GET["fromDate"]).'    </select>
  </div>
</div>';

//target vocabularies
if($arrayVocabStats["cant_term2tterm"]){

$rows.='<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="csv_tvocab_id">'.ucfirst(LABEL_TargetTerms).'</label>
  <div class="col-md-3">
    <select id="csv_tvocab_id" name="csv_tvocab_id" class="form-control">
		<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
		'.doSelectForm($array_vocabularios,$_GET["csv_tvocab_id"]).'
    </select>
  </div>
  <div class="col-md-3">
    <select id="mapped" name="mapped" class="form-control">
		'.doSelectForm(array("y#$LABEL_haveEQ","n#$LABEL_nohaveEQ"),$_GET["mapped"]).'
    </select>
  </div>
</div>';
};

if(SQLcount($sql)>'1'){
$rows.='<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="csv_itvocab_id">'.ucfirst(LABEL_vocabulario_referencia).'</label>
  <div class="col-md-3">
    <select id="csv_itvocab_id" name="csv_itvocab_id" class="form-control">
		<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
		'.doSelectForm($array_ivocabularios,$_GET["csv_itvocab_id"]).'
    </select>
  </div>
	<div class="col-md-3">
    <select id="int_mapped" name="int_mapped" class="form-control">
		'.doSelectForm(array("y#$LABEL_haveEQ","n#$LABEL_nohaveEQ"),$_GET["int_mapped"]).'
    </select>
  </div>
</div>';
};

//only for admin
if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1')
{
	$sqlUsers=SQLdatosUsuarios();
	if(SQLcount($sqlUsers)>1)
	{
		while ($arrayUsers=$sqlUsers->FetchRow())
		{
			$formSelectUsers[]=$arrayUsers[id].'#'.$arrayUsers[apellido].', '.$arrayUsers[nombres];
		}
		$rows.='<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="byuser_id">'.ucfirst(MENU_Usuarios).'</label>
		  <div class="col-md-4">
		    <select id="user_id" name="byuser_id" class="form-control">
				<option value="">'.ucfirst(LABEL_FORM_nullValue).'</option>
				'.doSelectForm($formSelectUsers,$_GET["byuser_id"]).'
		    </select>
		  </div>
		</div>';
	}
}

$rows.='<div class="form-group">
  <label class="col-md-4 control-label" for="w_string">'.ucfirst(LABEL_haveWords).'</label>
  <div class="col-md-3">
    <select id="w_string" name="w_string" class="form-control">
		'.doSelectForm(array("x#$LABEL_equalThisWord","s#$LABEL_start","e#$LABEL_end"),$_GET["w_string"]).'
    </select>
  </div>
	<div class="col-md-3">
		<input id="csvstring" name="csvstring" class="form-control" placeholder="'.LABEL_haveWords.'" type="text">
  </div>
</div>


<!--  Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="csv_encodeAdvance">'.ucfirst(LABEL_encode).' latin1</label>
  <div class="col-md-4">
      <input name="csv_encode" id="csv_encodeAdvance" value="latin1" type="checkbox">
  </div>
</div>

<!-- Button -->
<div class="form-group">
<div class="text-center">
	<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
	</div>
</div>
<input type="hidden"  name="mod" id="mod" value="csv"/><input type="hidden"  name="task" id="mod" value="csv1"/>
</fieldset>
</form>
';
	return $rows;
}



/*
Simple Term report by
*/
function HTMLformSimpleTermReport($array)
{

	GLOBAL $CFG;

	$LABEL_FreeTerms=ucfirst(LABEL_terminosLibres);
	$LABEL_DuplicatedTerms=ucfirst(LABEL_terminosRepetidos);
	$LABEL_PoliBT=ucfirst(LABEL_poliBT);
	$LABEL_candidate=ucfirst(LABEL_Candidato);
	$LABEL_rejected=ucfirst(LABEL_Rechazado);
	$LABEL_termsxNTterms=ucfirst(LABEL_termsxNTterms);
	$LABEL_termsXcantWords=ucfirst(LABEL_termsXcantWords);
	$LABEL_termsIsMetaTerms=ucfirst(LABEL_meta_terms);
	$LABEL_termsXrelatedTerms=ucfirst(LABEL_relatedTerms);
	$LABEL_termsXnonPreferedTerms=ucfirst(LABEL_nonPreferedTerms);
	$LABEL_preferedTerms=ucfirst(LABEL_preferedTerms);

	$rows.='<form role="form" name="simprereport" id="simprereport" action="index.php" method="get">';

	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(LABEL_FORM_simpleReport).'</legend>
	    </div>
	    <!-- panel  -->

	    <div class="col-lg-7">
	        <div class="panel panel-default">
	            <div class="panel-body form-horizontal">';


	$rows.='<div class="form-group">
						<label for="simpleReport" accesskey="s" class="col-sm-3 control-label">'.ucfirst(LABEL_seleccionar).'</label>';

	$rows.='	<div class="col-sm-9"><select class="form-control" id="task" name="task">';
	$rows.='	<option value="">'.ucfirst(LABEL_seleccionar).'</option>';
	$rows.=doSelectForm(array("csv2#$LABEL_FreeTerms","csv3#$LABEL_DuplicatedTerms","csv4#$LABEL_PoliBT","csv7#$LABEL_termsxNTterms","csv8#$LABEL_termsXcantWords","csv9#$LABEL_termsIsMetaTerms","csv10#$LABEL_termsXrelatedTerms","csv13#$LABEL_preferedTerms", "csv11#$LABEL_termsXnonPreferedTerms", "csv5#$LABEL_candidate","csv6#$LABEL_rejected"),"$_GET[task]");
	$rows.='	</select></div>';
	$rows.='</div>';


	if ($CFG["_CHAR_ENCODE"]=='utf-8')
	{
		$rows.='<div class="form-group">
		<input type="checkbox" name="csv_encode" id="csv_encodeSimple" value="latin1"/>
		<div class="col-sm-4">
		<label for="csv_encodeSimple">'.ucfirst(LABEL_encode).' latin1</label>
			</div>
		</div>';
	}

	$rows.='<div class="form-group">
							<div class="col-sm-12 text-center">
							<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
							</div>
					</div>';



		$rows.='				</div>
						</div>
				</div>
			</div> <!-- / panel  -->';
			$rows.='<input type="hidden" name="mod" id="mod" value="csv"/>';
			$rows.='</form>';
	return $rows;
}



/*
Simple Term report for mapped terms
*/
function HTMLformMappedTermReport($array)
{

	GLOBAL $CFG;

	$rows.='<form class="" role="form" name="mappedreport" id="mappedreport" action="index.php" method="get">';
	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(LABEL_FORM_mappedTermReport).'</legend>
	    </div>
	    <!-- panel  -->

	    <div class="col-lg-7">
	        <div class="panel panel-default">
	            <div class="panel-body form-horizontal">';


	$SQLtvocabs=SQLtargetVocabulary();

	while($ARRAYtvocabs=$SQLtvocabs->FetchRow()){

		$i_tvocab=++$i_tvocab;
		$rows.='<div class="form-group">
		<input name="tvocabs[]" type="checkbox" id="tvocab_id'.$ARRAYtvocabs["tvocab_id"].'" value="'.$ARRAYtvocabs["tvocab_id"].'" />
		<div class="col-sm-4">
		<label for="tvocab_id'.$ARRAYtvocabs["tvocab_id"].'">'.$ARRAYtvocabs["tvocab_label"].'</label>
			</div>
		</div>';
	}


	$rows.='	<div class="form-group">
	  <label class="col-md-4 control-label" for="csv_encodeTargetVocab">'.ucfirst(LABEL_encode).' latin1</label>
	  <div class="col-md-4">
	      <input name="csv_encode" id="csv_encodeTargetVocab" value="latin1" type="checkbox">
	  </div>
	</div>';


	$rows.='<div class="form-group">
							<div class="col-sm-12 text-center">
							<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
							</div>
					</div>';
	$rows.='				</div>
					</div>
			</div>
		</div> <!-- / panel  -->';
		$rows.='<input type="hidden"  name="mod" id="mod" value="csv"/>';
		$rows.='<input type="hidden"  name="task" id="simpleMappedTermReport" value="csv12"/>';
		$rows.='</form>';


	if($i_tvocab>0)	return $rows;
}



/*
Simple Term report for notes
*/
function HTMLformNullNotesTermReport($array)
{

	GLOBAL $CFG;

	$LabelNB=LABEL_NB;
	$LabelNH=LABEL_NH;
	$LabelNA=LABEL_NA;
	$LabelNP=LABEL_NP;
	$LabelNC=LABEL_NC;

	$rows.='<form class="" role="form" name="NULLnotesreport" id="NULLnotesreport" action="index.php" method="get">';
	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(LABEL_FORM_NULLnotesTermReport).'</legend>
	    </div>
	    <!-- panel  -->
			<div class="col-lg-7">
	        <div class="panel panel-default">
	            <div class="panel-body form-horizontal"><div class="panel-heading">'.ucfirst(MSG_FORM_NULLnotesTermReport).'</div>';



	$sqlNoteType=SQLcantNotas();

	while($ARRAYnoteType=$sqlNoteType->FetchRow()){

		$i_note=++$i_note;

		$varNoteType=(in_array($ARRAYnoteType["value_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array($LabelNA,$LabelNH,$LabelNB,$LabelNP,$LabelNC),$ARRAYnoteType["value_id"]) : $ARRAYnoteType["value"];

		$rows.='<div class="form-group">
		<div class="col-sm-4">
		<label for="note_type'.$ARRAYnoteType["value_id"].'">'.$varNoteType.'</label>
		</div>
		<div class="col-sm-2">
		<input name="note_type_null" type="radio" id="note_type'.$ARRAYnoteType["value_id"].'" value="'.$ARRAYnoteType["tipo_nota"].'" />
			</div>
		</div>';
	}

	$rows.='<div class="form-group">
	<div class="col-sm-4">
	<label for="note_typeNULL0">'.ucfirst(LABELnoNotes).'</label>
	</div>
	<div class="col-sm-2">
	<input name="note_type_null" type="radio" id="note_typeNULL0" value="0" />
		</div>
	</div>';


		$rows.='	<div class="form-group">
		  <label class="col-md-4 control-label" for="csv_encodeNotes">'.ucfirst(LABEL_encode).' latin1</label>
		  <div class="col-md-4">
		      <input name="csv_encode" id="csv_encodeNotes" value="latin1" type="checkbox">
		  </div>
		</div>';

	$rows.='<div class="form-group">
							<div class="col-sm-12 text-center">
							<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
							</div>
					</div>';
	$rows.='				</div>
					</div>
			</div>
		</div> <!-- / panel  -->';
		$rows.='<input type="hidden"  name="mod" id="mod" value="csv"/>';
		$rows.='<input type="hidden"  name="task" id="simpleMappedTermReport" value="csv14"/>';
		$rows.='</form>';


	return $rows;
}




/*
Register web services provider
*
*/
function HTMLformTargetVocabulary($tvocab_id="0")
{

	GLOBAL $CFG;

	$array=($tvocab_id>0) ? ARRAYtargetVocabulary($tvocab_id) : array();

	$array[tvocab_status] = (is_numeric($array[tvocab_status])) ? $array[tvocab_status] : '1';

	$doAdmin= ($array[tvocab_id]>0) ? 'saveTargetVocabulary' : 'addTargetVocabulary';

	// Preparado de datos para el formulario ///
	$arrayLang=array();
	foreach ($CFG["ISO639-1"] as $langs) {
		array_push($arrayLang,"$langs[0]#$langs[1]");
	};

	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['TGET_SEND_KEY']=md5(uniqid(rand(), true));

			$rows.='<form role="form" id="form-tvocab" data-toggle="validator" name="abmTargetVocabulary" action="admin.php" method="post">';
			$rows.='	<div class="row">
			    <div class="col-sm-12">
					<legend><a href="admin.php?vocabulario_id=list">'.ucfirst(LABEL_lcConfig).'</a> &middot; '.ucfirst(LABEL_TargetVocabularyWS).'</legend>
			    </div>
			    <!-- panel  -->
			    <div class="col-lg-7">
			        <div class="panel panel-default">
			            <div class="panel-body form-horizontal">';

								if($array["tvocab_id"])
								{
									$link2tterms='(<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$array["tvocab_id"].'">'.$array["cant"].' '.LABEL_Terminos.'</a>)';

									$rows.='<div class="form-group"><label class="col-sm-3 control-label" for="tvocab_label">'.ucfirst(LABEL_Titulo).'</label>';
									$rows.='	<div class="col-sm-9"><a id="tvocab_title" href="'.$array["tvocab_url"].'">'.$array["tvocab_title"].'</a> '.$link2tterms.' ';
									$rows.='	</div>';
									$rows.='</div>';

								}

			$rows.='	 <div class="form-group">
			            <label for="tvocab_label" accesskey="l" class="col-sm-3 control-label">'.ucfirst(LABEL_tvocab_label).'</label>
			                <div class="col-sm-9">
											<input type="text" required placeholder="'.LABEL_tvocab_label.'" class="form-control" name="tvocab_label" id="tvocab_label" value="'.$array["tvocab_label"].'"/>
			                </div>
			            </div>
			             <div class="form-group">
			                    <label for="tvocab_lang" class="col-sm-3 control-label">'.ucfirst(LABEL_Idioma).'</label>
			                    <div class="col-sm-9">
													<select class="form-control" id="tvocab_lang" name="tvocab_lang">
			                    '.doSelectForm($arrayLang,$array["tvocab_lang"]).'
			                    </select>
			             				</div>
			             </div>

									<div class="form-group">
											<label for="tvocab_tag" accesskey="l" class="col-sm-3 control-label">'.ucfirst(LABEL_tvocab_tag).'</label>
			                <div class="col-sm-9">
											<input type="text" class="form-control"  required placeholder="'.ucfirst(LABEL_tvocab_tag).'" name="tvocab_tag" id="tvocab_tag" value="'.$array["tvocab_tag"].'"/>
											<span class="help-block">'.ucfirst(LABEL_defaultEQmap).'</span>
											</div>
			            </div>

									<div class="form-group">
										<label for="tvocab_uri_service" accesskey="l" class="col-sm-3 control-label">'.ucfirst(LABEL_tvocab_uri_service).'</label>
			                <div class="col-sm-9">';
											if($array[tvocab_id])
													{
														$rows.='<span id="tvocab_uri_service">'.$array["tvocab_uri_service"].'</span>';
													}
													else
													{
														$rows.='<input type="url" required placeholder="'.LABEL_tvocab_uri_service.'"  class="form-control" name="tvocab_uri_service" id="tvocab_uri_service" value="'.$array["tvocab_uri_service"].'"/>';
														$rows.='<span class="help-block">'.ucfirst(LINK_publicKnownVocabularies).'</span>';

													};
									$rows.='    </div>
			            </div>

			                <div class="form-group">
			                <input type="checkbox" name="tvocab_status" id="tvocab_status" value="1" alt="'.ucfirst(LABEL_enable).'" '.do_check(1,$array["tvocab_status"],'checked').'  />
			                <div class="col-sm-4">
			                <label for="tvocab_status">'.ucfirst(LABEL_enable).'</label>
			                  </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-sm-12 text-right">
			                     <button type="submit" class="btn btn-primary" id="boton" name="botonTargetVocabulary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
			                      <a type="button" class="btn btn" name="cancelar" type="button" href="admin.php" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div> <!-- / panel  -->';
					$rows.='<input type="hidden"  id="tvocab_id" name="tvocab_id" value="'.$array[tvocab_id].'"/>';
					$rows.='<input type="hidden"  name="doAdmin" id="doAdmin" value="'.$doAdmin.'"/>';
					$rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["TGET_SEND_KEY"].'"/>';
			$rows.='</form>';

			return $rows;
}


/*
Asociaci�n con datos provistos por web services terminol�gicos TemaTres
*/
function HTMLformAssociateTargetTerms($ARRAYtermino,$term_id="0")
{

	$sql=SQLtargetVocabulary("1");

	$rows='<div class="container" id="bodyText">';
	$rows.='<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';

	if(SQLcount($sql)=='0'){
		//No hay vocabularios de referencia, solo vocabulario principal
		$rows.=HTMLalertNoTargetVocabulary();
	} else {
		//Hay vobularios de referencia
		$array_vocabularios=array();
		while($array=$sql->FetchRow())
		{
			if($array[vocabulario_id]!=='1')
			{
				//vocabularios que no sean el vocabulario principal
				array_push($array_vocabularios,$array[tvocab_id].'#'.FixEncoding($array[tvocab_label]));
			}
		};

		$arrayOptions=(strlen($ARRAYtermino["code"])>0) ? array('string#'.ucfirst(LABEL_string2search),'reverse#'.ucfirst(LABEL_reverseMappign),'code#'.LABEL_CODE) : array('string#'.ucfirst(LABEL_string2search),'reverse#'.ucfirst(LABEL_reverseMappign));
		$display=(in_array($_GET[search_by],array('reverse','code'))) ? 'style="display: none;"' : '';
		$string2search = ($_GET[string2search]) ? XSSprevent($_GET[string2search]) : $ARRAYtermino["titTema"];

		$rows.='<form class="" role="form" name="alta_tt" id="alta_tt" action="index.php" method="get">';
		$rows.='	<div class="row">
		    <div class="col-sm-12">
		        <legend>'.ucfirst(LABEL_relacion_vocabulario).' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a></legend>
		    </div>
		    <!-- panel  -->

		    <div class="col-lg-7">
		        <div class="panel panel-default">
		            <div class="panel-body form-horizontal">

		            <div class="form-group">
		            <label for="tvocab_id" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_nombre_vocabulario).'</label>
		                <div class="col-sm-9">
		                    <select class="form-control" id="tvocab_id" name="tvocab_id">
		                    '.doSelectForm($array_vocabularios,$_GET["tvocab_id"]).'
		                    </select>
		                </div>
		            </div>';
		//Configurar opcion búsqueda por código
		$rows.='<div class="form-group">
		<label for="search_by" class="col-sm-3 control-label">'.ucfirst(LABEL_selectMapMethod).'</label>
				<div class="col-sm-9">
						<select class="form-control" id="search_by" name="search_by" onChange="mostrar(this.value);">
						'.doSelectForm($arrayOptions,$_GET["search_by"]).'
						</select>
				</div>
		</div>';

		 $rows.='<div id="by_string" class="form-group" '.$display.'>
		                    <label for="string2search" class="col-sm-3 control-label">'.ucfirst(LABEL_Buscar).'</label>
		                    <div class="col-sm-9">
		                        <input type="text" class="form-control" required type="search" required id="string2search" name="string2search" value="'.$string2search.'">
		                    </div>
            </div>

		                <div class="form-group">
		                    <div class="col-sm-12 text-right">
		                     <button type="submit" class="btn btn-primary" value="'.LABEL_Buscar.'"/>'.ucfirst(LABEL_Buscar).'</button>
		                      <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div> <!-- / panel  -->';
		$rows.='<input type="hidden" name="tema" value="'.$ARRAYtermino["idTema"].'"/>
				<input type="hidden" name="taskterm" value="findTargetTerm"/>';
		$rows.='</form>';
	}

	$rows.='</div>';

	if(($string2search) && ($_GET["tvocab_id"])){
		require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;

		$arrayVocab=ARRAYtargetVocabulary($_GET["tvocab_id"]);

		switch ($_GET["search_by"]) {
			case 'string':
			$dataTerm=getURLdata($arrayVocab[tvocab_uri_service].'?task=search&arg='.urlencode($string2search));
			break;

			case 'code':
			$dataTerm=getURLdata($arrayVocab[tvocab_uri_service].'?task=fetchCode&arg='.urlencode($ARRAYtermino["code"]));
			break;

			case 'reverse':
			$dataTerm=getURLdata($arrayVocab[tvocab_uri_service].'?task=fetchSourceTerms&arg='.rawurlencode($ARRAYtermino["titTema"]));
			break;

			default :
			$dataTerm=getURLdata($arrayVocab[tvocab_uri_service].'?task=search&arg='.urlencode($string2search));

			break;
		}


		$rows.=HTMLtargetVocabularySearchResult($dataTerm,$_GET[string2search],$arrayVocab,$ARRAYtermino["idTema"]);


	};//fin de if buscar
	$rows.='   </div>';

	$rows.='<script type="text/javascript">
	function mostrar(id) {
		((id == "string") ?	$("#by_string").show() : $("#by_string").hide());
	}
	</script>';
	return $rows;
}





function HTMLtargetVocabularySearchResult($dataTerm,$string_search,$arrayVocab,$tema_id){

	//SEND_KEY to prevent duplicated
	session_start();

	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$tag_type='ol';

	$rows.='<h3>'.$dataTerm->resume->cant_result.' '.MSG_ResultBusca.' <i>'.$string_search.'</i>  ('.FixEncoding($arrayVocab[tvocab_title]).')</h3>'."\n\r";


	if($dataTerm->resume->cant_result > "0")	{

		$rows.='<'.$tag_type.'>';

		foreach ($dataTerm->result->term as $value){
			$rows.='<li>';
			$rows.='<a title="" href="index.php?tema='.$tema_id.'&amp;tvocab_id='.$arrayVocab["tvocab_id"].'&amp;tgetTerm_id='.(int) $value->term_id.'&amp;taskrelations=addTgetTerm&amp;ks='.$_SESSION["SEND_KEY"].'">'.FixEncoding((string) $value->string).'</a>';
			$rows.='</li>';

		};

		$rows.='</'.$tag_type.'>';
	}


	return $rows;
}


function HTMLformTargetVocabularySuggested($arrayTterm,$t_relation,$string_search,$arrayVocab,$tema_id){

	//SEND_KEY to prevent duplicated
	session_start();

	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$label_relation=ucfirst(arrayReplace(array('0','2','3','4'),array(LABEL_Termino,TR_termino,TE_termino,UP_termino),$t_relation));

	$rows.='<h3 id="suggestResult">'.FixEncoding($arrayVocab["tvocab_title"]).'</h3>';

	if(count($arrayTterm) > 0)	{

		$rows.='<form role="form" name="select_multi_term" action="index.php" method="post">';
		$rows.='	<div class="row">
		    <div class="col-lg-10">
		        <legend class="alert alert-info"> '.$label_relation.': '.count($arrayTterm).' '.MSG_ResultBusca.' <i>'.$string_search.'</i></legend>
		    </div>
		    <!-- panel  -->

		    <div class="col-lg-10">
		        <div class="panel panel-default">
		            <div class="panel-body form-horizontal">';

		$rows.='<div><input id="filter" type="text" class="form-control" placeholder="'.ucfirst(LABEL_type2filter).'"></div>';

		$rows.='<div class="table-responsive"> ';
		$rows.='<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
		<tr>
			<th align="center"></th>
			<th>'.ucfirst(LABEL_Termino).'</th>
		</tr>
		</thead>
		<tbody class="searchable">';

		foreach ($arrayTterm as $value){

			$rows.= '<tr>';
			$rows.=  '     	<td align="center"><input type="checkbox" name="selectedTerms[]" id="tterm_'.$value["term_id"].'" title="'.$value["source_string"].' ('.$label_relation.')" value="'.$value["string"].'|tterm_|'.$value["term_id"].'" /> </td>';
			$rows.=  '      <td><label class="check_label" title="'.$value["source_string"].' ('.$label_relation.')" for="tterm_'.$value["term_id"].'">'.$value["string"].' <span style="font-weight:normal;">[<a href="'.$arrayVocab["tvocab_url"].'?tema='.$value["source_term_id"].'" title="'.$value["source_string"].' ('.$label_relation.')" target="_blank">'.LABEL_Detalle.'</a>]</span></label></td>';
			$rows.=  '</tr>';
		};

		$rows.='        </tbody>		</table>';
		$rows.='        </div>';

		if($t_relation!=="4")
		{
			$ARRAYuriReference=ARRAYfetchValue("URI_TYPE","exactMatch");

			$rows.='<div class="form-group">
			<input type="checkbox" name="addLinkReference" id="addLinkReference" value="'.$ARRAYuriReference["value_id"].'" alt="'.ucfirst(LABEL_addExactLink).'" />
			<div class="col-sm-4">
			<label for="addLinkReference">'.ucfirst(LABEL_addExactLink).'</label>
				</div>
			</div>';

			$rows.='<div class="form-group">
			<input type="checkbox" name="addMappReference" id="addMappReference" value="1" alt="'.ucfirst(LABEL_addMapLink).' ('.ucfirst($arrayVocab["tvocab_label"]).'" checked />
			<div class="col-sm-4">
			<label for="addMappReference">'.ucfirst(LABEL_addMapLink).'</label>
				</div>
			</div>';

			$rows.='<div class="form-group">
			<input type="checkbox" name="addNoteReference" id="addNoteReference" value="1" alt="'.ucfirst(LABEL_addSourceNote).'" checked  />
			<div class="col-sm-4">
			<label for="addNoteReference">'.ucfirst(LABEL_addSourceNote).'</label>
				</div>
			</div>';
		}

		$rows.='	<div class="form-group">
				<div class="col-sm-12 text-center">
				<button type="submit" class="btn btn-primary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
				 <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
				</div>
		</div>
	</div>
	</div>
	</div> <!-- / panel  -->';
	$rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
	$rows.='<input type="hidden"  name="tema" value="'.$tema_id.'" />';
	$rows.='<input type="hidden" id="t_relation" name="t_relation" value="'.$t_relation.'"/>';
	$rows.='<input type="hidden" id="taskterm" name="taskterm" value="addSuggestedTerms"/>';
	$rows.='<input type="hidden" name="tvocab_id" name="tvocab_id" value="'.$arrayVocab["tvocab_id"].'"/>';
	$rows.='</form>';

	}//end of if result
	else{

		$rows.='<p class="alert alert-danger"> '.$label_relation.': '.count($arrayTterm).' '.MSG_ResultBusca.' <i>'.$string_search.'</i></p>';

	}


	return $rows;
}




function HTMLformAltaEquivalenciaTermino($ARRAYTermino){

	$LabelEE=id_EQ.'#'.LABEL_termino_equivalente;
	$LabelIE=id_EQ_PARCIAL.'#'.LABEL_termino_parcial_equivalente;
	$LabelNE=id_EQ_NO.'#'.LABEL_termino_no_equivalente;

	$sql=SQLdatosVocabulario();

	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$rows='<div class="container" id="bodyText">';
	$rows.='<script type="text/javascript">$("#form-tvocab").validate({});</script>';

		$rows.='<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';

		if(SQLcount($sql)=='1'){
			//No hay vocabularios de referencia, solo vocabulario principal
			$rows.=HTMLalertNoTargetVocabulary();
		} else {
			//Hay vobularios de referencia
			$array_vocabularios=array();
			while($array=$sql->FetchRow())
			{
				if($array[vocabulario_id]!=='1')
				{
					//vocabularios que no sean el vocabulario principal
					array_push($array_vocabularios,$array[vocabulario_id].'#'.$array[titulo]);
				}
			};

			$rows.='<form class="" role="form"  name="alta_eqt" id="alta_eqt" action="index.php" method="post">';
			$rows.='	<div class="row">
			    <div class="col-sm-12">
			        <legend>'.ucfirst(LABEL_relacion_vocabulario).' <a href="index.php?tema='.$ARRAYTermino["idTema"].'">'.$ARRAYTermino["titTema"].'</a></legend>
			    </div>
			    <!-- panel  -->

			    <div class="col-lg-7">
			        <div class="panel panel-default">
			            <div class="panel-body form-horizontal">

			            <div class="form-group">
			            <label for="'.ref_vocabulario_id.'" accesskey="v" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_nombre_vocabulario).'</label>
			                <div class="col-sm-9">
			                    <select class="form-control" id="ref_vocabulario_id" name="ref_vocabulario_id">
			                    '.doSelectForm($array_vocabularios,$_GET["tvocab_id"]).'
			                    </select>
			                </div>
			            </div>
			                <div class="form-group">
			                    <label class="col-sm-3 control-label" for="'.FORM_LABEL_termino.'" accesskey="t">'.ucfirst(LABEL_Termino).'</label>
			                    <div class="col-sm-9">
			                        <input type="text" class="form-control" required name="'.FORM_LABEL_termino.'" id="'.FORM_LABEL_termino.'"/>
			                    </div>
			                </div>

											<div class="form-group">
					            <label for="tipo_equivalencia" accesskey="q" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_tipo_equivalencia).'</label>
					                <div class="col-sm-9">
					                    <select class="form-control" id="tipo_equivalencia" name="tipo_equivalencia">
					                    '.doSelectForm(array("$LabelEE","$LabelIE","$LabelNE"),"").'
					                    </select>
					                </div>
					            </div>
			                <div class="form-group">
			                    <div class="col-sm-12 text-right">
			                     <button type="submit" class="btn btn-primary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
			                      <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYTermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div> <!-- / panel  -->';
			$rows.='<input type="hidden"  name="id_termino_eq" value="'.$ARRAYTermino["idTema"].'" />';
			$rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
			$rows.='</form>';


			$rows.='<script id="tvocab_script" type="text/javascript">
			$(document).ready(function() {
				var validator = $("#alta_eqt").validate({
					rules: {\''.FORM_LABEL_termino.'\':  {required: true},
				},
				debug: true,
				errorElement: "label",
				submitHandler: function(form) {
					form.submit();
				}

			});
		});
		</script>	';
	}
	$rows.='</div>';

	return $rows;
}



//View and edit config options
function HTMLformConfigValues($array_vocabulario){

	$si=LABEL_SI;
	$no=LABEL_NO;

	GLOBAL $arrayCFGs;

	$sql=SQLconfigValues();

	$NEWarrayCFGs=array();
	while ($array=$sql->FetchRow()){
		$NEWarrayCFGs[$array["value"]]= $array["value_code"];
	}



	$rows.='<div class="form-group">';
	$rows.='<label class="col-sm-3 control-label" for="'.FORM_LABEL_jeraquico.'">'.ucfirst(FORM_LABEL_jeraquico).'</label>';
	$rows.='<div class="col-sm-9">    <select id="'.FORM_LABEL_jeraquico.'" name="'.FORM_LABEL_jeraquico.'">';
	$rows.=	doSelectForm(array("1#$si","2#$no"),$array_vocabulario["polijerarquia"]);
	$rows.='</select><span class="help-block">'.ucfirst(LABEL_jeraquico).'</span></div>';
	$rows.='</div>';


	foreach ($arrayCFGs as $key => $value) {
		switch ($key){
			case 'CFG_MAX_TREE_DEEP':
			$rows.='<div class="form-group">';
			$rows.='<label class="col-sm-5 control-label" for="'.$key.'">'.$key.'</label>';
			$rows.='<div class="col-sm-5">    <select id="'.$key.'" name="'.$key.'">';
			$rows.=	doSelectForm(array("1#1","2#2","3#3","4#4","5#5","6#6"),$NEWarrayCFGs[$key]);
			$rows.='</select>';
			$rows.='<span class="help-block">'.ucfirst(LABEL_CFG_MAX_TREE_DEEP).'</span></div>';
			$rows.='</div>';
			break;

			case 'CFG_MIN_SEARCH_SIZE':
			$rows.='<div class="form-group">';
			$rows.='<label class="col-sm-5 control-label" for="'.$key.'" >'.$key.'</label>';
			$rows.='<div class="col-sm-5">     <select id="'.$key.'" name="'.$key.'">';
			$rows.=	doSelectForm(array("1#1","2#2","3#3","4#4","5#5","6#6"),$NEWarrayCFGs[$key]);
			$rows.='</select>';
			$rows.='<span class="help-block">'.ucfirst(LABEL_CFG_MIN_SEARCH_SIZE).'</span></div>';
			$rows.='</div>';
			break;

			case 'CFG_NUM_SHOW_TERMSxSTATUS':
			$rows.='<div class="form-group">';
			$rows.='<label class="col-sm-5 control-label" for="'.$key.'">'.$key.'</label>';
			$rows.='<div class="col-sm-5">     <select id="'.$key.'" name="'.$key.'">';
			$rows.=	doSelectForm(array("50#50","100#100","150#150","200#200","250#250"),$NEWarrayCFGs[$key]);
			$rows.='</select>';
			$rows.='<span class="help-block">'.ucfirst(LABEL_CFG_NUM_SHOW_TERMSxSTATUS).'</span></div>';
			$rows.='</div>';
			break;

			case 'CFG_SEARCH_METATERM':
			$rows.='<div class="form-group">';
			$rows.='<label class="col-sm-5 control-label" for="'.$key.'">'.$key.'</label>';
			$rows.='<div class="col-sm-5">     <select id="'.$key.'" name="'.$key.'">';
			$rows.=	doSelectForm(array("1#$si","00#$no"),$NEWarrayCFGs[$key]);
			$rows.='</select>';
			$rows.='<span class="help-block">'.ucfirst(NOTE_isMetaTermNote).'</span></div>';
			$rows.='</div>';
			break;

			default:

			$rows.='<div class="form-group">';
			$rows.='<label class="col-sm-5 control-label" for="'.$key.'">'.$key.'</label>';
			$rows.='<div class="col-sm-5">     <select id="'.$key.'" name="'.$key.'">';
			$rows.=	doSelectForm(array("1#$si","00#$no"),$NEWarrayCFGs[$key]);
			$rows.='</select>';
			$rows.='<span class="help-block">'.ucfirst(arrayReplace(array('_USE_CODE','_SHOW_CODE','CFG_VIEW_STATUS','CFG_SIMPLE_WEB_SERVICE','_SHOW_TREE','_PUBLISH_SKOS','CFG_ENABLE_SPARQL'),array(LABEL__USE_CODE,LABEL__SHOW_CODE,LABEL_CFG_VIEW_STATUS,LABEL_CFG_SIMPLE_WEB_SERVICE,LABEL__SHOW_TREE,LABEL__PUBLISH_SKOS,LABEL__ENABLE_SPARQL),$key)).'</span></div>';
			$rows.='</div>';

		}
	}
	return $rows;
}


function HTMLformImport()
{
		$LABEL_importTab=ucfirst(LABEL_importTab);
		$LABEL_importTag=ucfirst(LABEL_importTag);
		$LABEL_importSkos=ucfirst(LABEL_importSkos);

	$rows.='<form enctype="multipart/form-data" role="form" method="post" action="admin.php?doAdmin=import">';
	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(IMPORT_form_legend).'</legend>
	    </div>
	    <!-- panel  -->

				    <div class="col-lg-7">
				        <div class="panel panel-default">
				            <div class="panel-body form-horizontal">';

	$rows.='            <div class="form-group">
	            <label for="simpleReport" class="col-sm-3 control-label">'.ucfirst(FORM_LABEL_format_import).'</label>
	                <div class="col-sm-9">
	                    <select class="form-control" id="taskAdmin" name="taskAdmin">
	                    '.doSelectForm(array("importTab#$LABEL_importTab","importTag#$LABEL_importTag","importSkos#$LABEL_importSkos"),$_POST["doAdmin"]).'
	                    </select>
	                </div>
	            </div>';

							$rows.='<div class="form-group">
							           <label for="reclave" class="col-sm-3 control-label">'.ucfirst(IMPORT_form_label).'</label>
							                    <div class="col-sm-9">
							                        <input placeholder="'.LABEL_repass.'"
																			class="form-control"
																			type="file"
																			id="file"
																			name="file">
																			<div class="help-block with-errors"></div>
																	</div>
							         </div>';


	$rows.='<div class="form-group">
							<div class="col-sm-12 text-right">
							<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Guardar).'"/>
							</div>
					</div>';


	$rows.='				</div>
					</div>
			</div>
		</div> <!-- / panel  -->';
		$rows.='<input type="hidden" name="doAdmin" id="taskterm" value="import"/>';
		$rows.='<input type="hidden" name="doAdmin" id="sendfile" value="Ok"/>';
		$rows.='</form>';


	$rows.='<p>'.ucfirst(LABEL_importTab).':<pre>
	South America
			Argentina
				Buenos Aires
			Brazil
			Uruguay</pre></p>';

	$rows.='<p>'.ucfirst(LABEL_importTag).':<pre>
	South America
	BT: America
	NT: Argentina
	UF: South-america
	RT: Latin America</pre></p>';

	$rows.='<p>'.ucfirst(LABEL_importSkos).': <a href="http://www.w3.org/TR/skos-reference/" title="SKOS Simple Knowledge Organization System">http://www.w3.org/TR/skos-reference/</a></p>';


	return $rows;
}


function HTMLformURI4term($ARRAYtermino)
{
	//SEND_KEY to prevent duplicated
	session_start();
	$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

	$SQLURIdefinition=SQLURIdefinition();

	if(SQLcount($SQLURIdefinition)>0)
	{
		while($ARRAYURIdefinition=$SQLURIdefinition->FetchRow())
		{
			$arraySelectURItype[]=$ARRAYURIdefinition["uri_type_id"].'#'.$ARRAYURIdefinition["uri_value"];
		}


	$rows.='<div class="container" id="bodyText">';

	$rows.='<a class="topOfPage" href="index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';

		$rows.='<form class="" role="form" name="altaURI" id="altaURI" action="index.php" method="post">';
		$rows.='	<div class="row">
		    <div class="col-sm-12">
		        <legend>'.ucfirst(LABEL_URIEditor).' <a href="index.php?tema='.$ARRAYtermino["idTema"].'">'.$ARRAYtermino["titTema"].'</a></legend>
		    </div>
		    <!-- panel  -->

		    <div class="col-lg-7">
		        <div class="panel panel-default">
		            <div class="panel-body form-horizontal">

		            <div class="form-group">
								<label for="uri_type_id" class="col-sm-3 control-label accesskey="u">'.ucfirst(LABEL_URItype).'</label>
		                <div class="col-sm-9">
		                    <select class="form-control" id="uri_type_id" name="uri_type_id">
		                    '.doSelectForm($arraySelectURItype,"").'
		                    </select>
		                </div>
		            </div>
		                <div class="form-group">
		                    <label for="uri" class="col-sm-3 control-label">'.ucfirst(LABEL_URI2termURL).'</label>
		                    <div class="col-sm-9">
		                        <input type="text" class="form-control"  type="url" required autofocus id="uri" name="uri"/>
		                    </div>
		                </div>

		                </div>
		                <div class="form-group">
		                    <div class="col-sm-12 text-right">
		                     <button type="submit" class="btn btn-primary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
		                      <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div> <!-- / panel  -->';
			$rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
			$rows.='<input type="hidden"  name="tema_id" value="'.$ARRAYtermino["idTema"].'" />';
			$rows.='<input type="hidden"  name="taskURI" value="addURI" />';
		$rows.='</form>';
		}

		$rows.='</div>';
	return $rows;
}



function HTMLconfirmDeleteTerm($ARRAYtermino)
{


	$rows.='<form class="form-inline" role="form" name="deleteTerm" action="index.php" method="post">';
	$rows.='  <fieldset id="borrart" style="display:none;">';
	$rows.='	<legend>'.ucfirst(MENU_BorrarT).'</legend>';
	$rows.= '<p class="alert alert-danger" role="alert">'.sprintf(MSG__warningDeleteTerm,$ARRAYtermino["titTema"]).'</p>';
	$rows.= '<p class="alert alert-warning" role="alert">'.MSG__warningDeleteTerm2row.'</p>';

	$rows.='<div class="submit_form"  align="center" role="group">';

	$rows.='<button type="submit"   class="btn btn-danger" name="boton" value="'.ucfirst(MENU_BorrarT).'">'.ucfirst(MENU_BorrarT).'</button>';
	$rows.=' <button type="button"  class="btn btn-default"  name="cancelar" onClick="javascript:expandLink(\'borrart\')" value="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</button>';
	$rows.='</div>';
	$rows.='<input type="hidden"  name="tema_id" value="'.$ARRAYtermino["tema_id"].'" />';
	$rows.='<input type="hidden"  name="task" value="remterm" />';
	$rows.='  </fieldset>';
	$rows.='</form>';



	return $rows;
}


function HTMLformMasiveDelete()
{
	$rows.='<form class="" role="form" name="massive_delete" action="admin.php" method="post">';
	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(MENU_massiverem).'</legend>
	    </div>
	    <!-- panel  -->

	    <div class="col-lg-7">
			<p class="alert alert-danger" role="alert">'.LABEL_warningMassiverem.'.</p>
	        <div class="panel panel-default">
	            <div class="panel-body form-horizontal">';


	$rows.='<div class="form-group">';
	$rows.='<input type="checkbox" name="massrem_teqterms" id="massrem_teqterms" value="1" alt="'.ucfirst(LABEL_target_terms).'" /> ';
	$rows.='<div class="col-sm-4"><label for="massrem_teqterms">'.ucfirst(LABEL_target_terms).'</label></div>';
	$rows.='</div>';

	$rows.='<div class="form-group">';
	$rows.='<input type="checkbox" name="massrem_url" id="massrem_url" value="1" alt="'.ucfirst(LABEL_URI2terms).'" /> ';
	$rows.='<div class="col-sm-4"><label for="massrem_url">'.ucfirst(LABEL_URI2terms).'</label></div>';
	$rows.='</div>';

	$rows.='<div class="form-group">';
	$rows.='<input type="checkbox" name="massrem_notes" id="massrem_notes" value="1" alt="'.ucfirst(LABEL_notes).'" /> ';
	$rows.='<div class="col-sm-4"><label for="massrem_notes">'.ucfirst(LABEL_notes).'</label></div>';
	$rows.='</div>';

	$rows.='<div class="form-group">';
	$rows.='<input class="checkall"  type="checkbox" name="massrem_terms" id="massrem_terms" value="1" alt="'.ucfirst(LABEL_Terminos).'" /> ';
	$rows.='<div class="col-sm-4"><label for="massrem_terms">'.ucfirst(LABEL_Terminos).'</label></div>';
	$rows.='</div>';

	$rows.='<div class="form-group">
							<div class="col-sm-12 text-center">
							<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_Enviar).'"/>
							 <a href="index.php" class="btn btn-default" id="boton_cancelar" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
							</div>
					</div>';
	$rows.='				</div>
					</div>
			</div>';

	$rows.='</div> <!-- / panel  -->';
	$rows.='<input type="hidden" name="doAdmin" id="doAdmin" value="massrem"/>';
	$rows.='</form>';

	return $rows;
}


function HTMLformUpdateEndpoit()
{

	$ARRAYlastUpdateEndpoint=fetchlastUpdateEndpoint();

	$msg_update=($ARRAYlastUpdateEndpoint["value"]) ? '<br/>'.MSG__dateUpdatedEndpoint.': '.$ARRAYlastUpdateEndpoint["value"].'.' : '';

	$rows.='<form class="" role="form" name="updateEndpoint" action="admin.php" method="post">';
	$rows.='	<div class="row">
	    <div class="col-sm-12">
	        <legend>'.ucfirst(LABEL_updateEndpoint).'</legend>
	    </div>
	    <!-- panel  -->

	    <div class="col-lg-7">
			<p class="alert alert-warning" role="alert">'.MSG__updateEndpoint.' '.$msg_update.'</p>
	        <div class="panel panel-default">
	            <div class="panel-body form-horizontal">';

							$rows.='<div class="form-group">
													<div class="col-sm-12 text-center">
													<input type="submit" class="btn btn-primary" id="boton" name="boton" value="'.ucfirst(LABEL_actualizar).'"/>
													 <a href="index.php" class="btn btn-default" id="boton_cancelar" title="'.ucfirst(LABEL_Cancelar).'">'.ucfirst(LABEL_Cancelar).'</a>
													</div>
											</div>';
							$rows.='				</div>
											</div>
									</div>';

							$rows.='</div> <!-- / panel  -->';
							$rows.='<input type="hidden" name="doAdmin" id="doAdmin" value="updateEndpointNow"/>';
							$rows.='</form>';



	return $rows;
}


function HTMLformLogin($task_result)
{
	if(is_array($task_result))
	{
		$rows.='<div>'.$task_result["msg"].'</div>';
	}


	$rows.='  <form class="form-horizontal form-signin" role="form" id="mylogin" name="mylogin" action="login.php" method="post">';
	$rows.='<h2 class="form-signin-heading">'.ucfirst(LABEL_login).'</h2>';

	$rows.='<div class="form-group"><label  class="sr-only" for="mail" accesskey="u">'.ucfirst(LABEL_mail).'</label>';
	$rows.='<input type="email" class="form-control"  name="id_correo_electronico" placeholder="'.ucfirst(LABEL_mail).'" required autofocus  id="mail" size="11"/>';
	$rows.='</div>';

	$rows.='<div class="form-group"><label for="id_password" class="sr-only" accesskey="p">'.ucfirst(LABEL_pass).'</label>';
	$rows.='<input type="password" name="id_password" class="form-control" placeholder="'.ucfirst(LABEL_pass).'" required id="id_password" size="11"/>';
	$rows.='	</div>';

	$rows.='<div class="col-lg-offset-2 col-lg-10 style="margin-left:15em" align="center">';
	$rows.='<input type="hidden"  name="task" value="login" />';
	$rows.='<button class="btn btn-lg btn-primary btn-block" type="submit">'.LABEL_Enviar.'</button>';
	$rows.='</div>';

	$rows.='	<div class="form-group">
	<div class="row">
	<div class="col-lg-12">
	<div class="text-center">
	<a href="login.php?task=recovery" tabindex="5" class="forgot-password" title="'.LABEL_user_lost_password.'">'.LABEL_user_lost_password.'</a>
	</div>
	</div>
	</div>
	</div>	';
	$rows.='</form>';

	return $rows;
}



function HTMLformRecoveryPassword($user_name="")
{

	$rows='<form class="form-horizontal" id="myRecovery" name="myRecovery" action="login.php" method="post">
<fieldset>
<legend>'.LABEL_user_recovery_password.'</legend>
<div class="form-group">
  <label class="col-md-4 control-label" for="id_correo_electronico_recovery" >'.ucfirst(LABEL_mail).'</label>
  <div class="col-md-4">
  <input id="id_correo_electronico_recovery" name="id_correo_electronico_recovery" placeholder="'.ucfirst(LABEL_mail).'" class="form-control input-md" required="" type="email">
  </div>
</div>

<div class="form-group">
  <div class="col-md-8 text-center">
    <button id="button1id" type="submit" name="button1id" class="btn btn-primary">'.LABEL_Enviar.'</button>
     <a href="login.php" class="btn btn-inverse">'.ucfirst(LABEL_Cancelar).'</a>
  </div>
</div>
<input type="hidden"  name="task" value="user_recovery" />
</fieldset>
</form>';

	return $rows;
}


#
# Vista de términos libres
#

function HTMLformVerTerminosLibres($taskterm='null',$freeTerms_id=array()){


	//borrado masivo de términos libres
	if($taskterm=='deleteFreeTerms'){
		$task=REMTerms($freeTerms_id,1);
	}
	$sql=SQLverTerminosLibres();

	$rows.='<div>';
	$rows.='<h3>'.ucfirst(LABEL_terminosLibres).' ('.SQLcount($sql).') </h3>';

	if(is_array($task)){
		if($task["error"]>0)
		{
			$rows.='<p class="error">'.$task["error"].' '.MSG_termsNoDeleted.' </p>';
		}else{
			$rows.='<p class="success">'.$task["success"].' '.MSG_termsDeleted.' </p>';
		}

	}

	if(SQLcount($sql)>0){
		$rows.='<div><input id="filter" type="text" class="form-control" placeholder="'.ucfirst(LABEL_type2filter).'"></div>';
		$rows.='<form  role="form"  id="delete_free_terms" name="delete_free_terms" action="index.php?verT=L" method="post">';
		$rows.='<div class="table-responsive"> ';
		$rows.='<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
		<tr>
			<th></th>
			<th>'.ucfirst(LABEL_Termino).'</th>
			<th>'.ucfirst(LABEL_Fecha).'</th>
		</tr>
		</thead>
		<tbody class="searchable">';
		while ($array = $sql->FetchRow()){
			$css_class_MT=($array["isMetaTerm"]==1) ? ' class="metaTerm" ' : '';
			$rows.= '<tr>';
			$rows.=  '     	<td align="center"><input type="checkbox" name="deleteFreeTerms_id[]" id="freeTerm_'.$array["tema_id"].'" title="'.ucfirst(MENU_BorrarT).' '.$array["tema"].' " value="'.$array["tema_id"].'" /></td>';
			$rows.=  '     	<td><label class="check_label" value="'.$value["tema_id"].'  title="'.$value["tema"].' " for="freeTerm_'.$array["tema_id"].'"><a '.$css_class_MT.' title="'.$array["tema"].'" href="index.php?tema='.$array["tema_id"].'" >'.$array["tema"].'</a></label></td>';
			$rows.=  '      <td>'.$array["cuando"].'</td>';
			$rows.=  '  </tr>';

		};
		$rows.='        </tbody>		</table>';
		$rows.='        </div>';

		$rows.='<div class="submit_form" align="center">';
		$rows.= '<p class="warning">'.MSG__warningDeleteTerm2row.'</p>';

		$rows.='	<input type="hidden" id="taskterm" name="taskterm" value="deleteFreeTerms"/>';
		$rows.='  	<input  class="submit ui-corner-all" type="submit" name="boton" value="'.ucfirst(MENU_BorrarT).'"/>';
		$rows.='</div>';

		$rows.='</form>';
	}//if cant

	$rows.='</div>';

	return $rows;
};


#
# Vista de términos repetidos
#

function HTMLformVerTerminosRepetidos(){

	$sql=SQLverTerminosRepetidos();

	$rows.='<div><h3>'.ucfirst(LABEL_terminosRepetidos).' ('.SQLcount($sql).') </h3>';
	$rows.='<ul>';

	if(SQLcount($sql)==0){
		$rows.='<li>'.ucfirst(MSG_noTerminosRepetidos).'</li>';
	}else{
		while($array = $sql->FetchRow()){
			$i=++$i;

			if($string_term!==$array["string_term"])
			{
				if(!$i!==0)
				{
					$rows.='</ul></li>';
				}
				$rows.='<li>'.$array["string_term"].' ('.$array["cant"].')<ul>';
			}

			$css_class_MT=($array["isMetaTerm"]==1) ? ' class="metaTerm" ' : '';
			$rows.='<li> <a '.$css_class_MT.' title="'.$array["tema"].'" href="index.php?tema='.$array["tema_id"].'">'.$array["tema"].'</a></li>';

			$string_term=$array["string_term"];
		}

		$rows.='</ul></li>';
	};
	$rows.='</ul>';
	$rows.='</div>';


	return $rows;
};



#
# Vista de términos sin relaciones jer�rquicas // preferred and accepted terms without hierarchical relationships
#

function HTMLformVerTerminosSinBT($taskterm='null',$terms_id=array()){

	//borrado masivo de términos libres
	if($taskterm=='deleteTerms'){

		$task=REMTerms($terms_id,0);
	}


	//tesauro_id = 1;
	$sql=SQLtermsNoBT(1);

	$rows.='<div>';
	$rows.='<h3>'.ucfirst(LABEL_termsNoBT).' ('.SQLcount($sql).') </h3>';

	if(is_array($task)){
		if($task["error"]>0)
		{
			$rows.='<p class="error">'.$task["error"].' '.MSG_termsNoDeleted.' </p>';
		}else{
			$rows.='<p class="success">'.$task["success"].' '.MSG_termsDeleted.' </p>';
		}

	}


	if(SQLcount($sql)>0){

		$rows.='<div><input id="filter" type="text" class="form-control" placeholder="'.ucfirst(LABEL_type2filter).'"></div>';

		$rows.='<form role="form"  id="delete_free_terms" name="delete_free_terms" action="index.php?verT=NBT" method="post">';

		$rows.='<div class="table-responsive"> ';
		$rows.='<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
		<tr>
			<th></th>
			<th>'.ucfirst(LABEL_Termino).'</th>
			<th>'.ucfirst(LABEL_nonPreferedTerms).'</th>
			<th>'.ucfirst(LABEL_relatedTerms).'</th>
		</tr>
		</thead>
		<tbody class="searchable">';

		while ($array = $sql->FetchRow()){
			$css_class_MT=($array["isMetaTerm"]==1) ? ' class="metaTerm" ' : '';
			$rows.= '<tr>';
			$rows.=  '     <td align="center"><input type="checkbox" name="deleteTerms_id[]" id="term_'.$array["tema_id"].'" title="'.ucfirst(MENU_BorrarT).' '.$array["tema"].' " value="'.$array["tema_id"].'" /></td>';
			$rows.=  '     <td><label class="check_label" title="'.$value["tema"].' " for="term_'.$array["tema_id"].'"><a '.$css_class_MT.' title="'.$array[tema].'" href="index.php?tema='.$array["tema_id"].'">'.$array[tema].'</a></label> </td>';
			$rows.=  '      <td>'.$array["cant_UF"].'</td>';
			$rows.=  '      <td>'.$array["cant_RT"].'</td>';
			$rows.=  '  </tr>';

		};

		$rows.='        </tbody></table>';
		$rows.='</div>';

		$rows.= '<p class="warning">'.MSG__warningDeleteTerm2row.'</p>';
		$rows.='<div class="submit_form" align="center">';
		$rows.='	<input type="hidden" id="taskterm" name="taskterm" value="deleteTerms"/>';
		$rows.='  	<input  class="submit ui-corner-all" type="submit" name="boton" value="'.ucfirst(MENU_BorrarT).'"/>';
		$rows.='</div>';


		$rows.='</form>';

	}//if cant

	$rows.='</div>';

	return $rows;
};


function HTMLalertNoTargetVocabulary(){

	if($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]=='1'){
		$help_msg='<a href="admin.php?tvocabulario_id=0&doAdmin=seeformTargetVocabulary" title="'.ucfirst(LABEL_addTargetVocabulary).'">'.ucfirst(LABEL_addTargetVocabulary).'</a>.';
	}else {
		$help_msg=ucfirst(MSG_contactAdmin).'.';
	}

	return '<p class="alert alert-danger" role="alert">'.ucfirst(LABEL_NO_vocabulario_referencia).'. '.$help_msg.'</p>';

}

?>
