<?php
if ((stristr( $_SsRVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# llamada de funciones de gestion de terminos
#

if($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]>0){

//prevent duplicate in create terms functions
if ($_GET["tcode"]){
	do_target_temaXcode($_GET["tema_id"], $_GET["tcode"], $_GET["tvocab_id"]);
	}


# Borrado y edición de término
# no control if resend.
if($_POST[task]=='remterm'){
	borra_t($_POST["tema_id"]);
	};

# Modificación de término
if($_POST["edit_id_tema"]){
		$proc=modTerm(doValue($_POST,FORM_LABEL_termino),$_POST["edit_id_tema"]);
		$tema=$proc["tema_id"];
		if($proc["log"]==false){
			$MSG_PROC_ERROR=HTMLduplicatedTermsAlert(array($proc["tema_id"] => $proc["term_original"]));
		}
	};
### ### ### ### ### ###
###  resend control ###
### ### ### ### ### ###
if(isset($_SESSION['SEND_KEY'])) {
	$sendkey=$_POST['ks'];
	if(strcasecmp($sendkey,$_SESSION['SEND_KEY'])===0) {

	#alta de términos sugeridos
	if($_POST["taskterm"]=='addSuggestedTerms'){

		$ARRAYtema=ARRAYverTerminoBasico($_POST["tema"]);

		$tema=$ARRAYtema["tema_id"];

		if(($_POST["addNoteReference"]==1) || ($_POST["addLinkReference"]>0) || ($_POST["addMappReference"]==1))		{
			$ARRAYtargetVocabulary=ARRAYtargetVocabulary($_POST["tvocab_id"]);
		}

		switch ($_POST["t_relation"]) {
			case '0':

				for($i=0; $i<sizeof($selectedTerms);++$i){
					//parse string and term_id
					$arrayNewTerm=explode('|tterm_|', $selectedTerms[$i]);
					$tema=abm_tema('alta',$arrayNewTerm[0]);

					//add reference
					ADDreferencesSuggestedTerm($tema,$arrayNewTerm[1],$ARRAYtargetVocabulary,$options=array("addNoteReference"=>$_POST["addNoteReference"],"addLinkReference"=>$_POST["addLinkReference"],"addMappReference"=>$_POST["addMappReference"]));
				}
				break;

			case '2':

				for($i=0; $i<sizeof($selectedTerms);++$i){
					//parse string and term_id
					$arrayNewTerm=explode('|tterm_|', $selectedTerms[$i]);
					$relative_term_id=abm_tema('alta',$arrayNewTerm[0]);

					//associate terms
					$new_relacion=do_terminos_relacionados($relative_term_id,$ARRAYtema["tema_id"]);

					//add reference
					ADDreferencesSuggestedTerm($relative_term_id,$arrayNewTerm[1],$ARRAYtargetVocabulary,$options=array("addNoteReference"=>$_POST["addNoteReference"],"addLinkReference"=>$_POST["addLinkReference"],"addMappReference"=>$_POST["addMappReference"]));
				}
				break;

			case '3':
				for($i=0; $i<sizeof($selectedTerms);++$i){
					//parse string and term_id
					$arrayNewTerm=explode('|tterm_|', $selectedTerms[$i]);
					$relative_term_id=abm_tema('alta',$arrayNewTerm[0]);

					//associate terms
					$new_relacion=do_r($ARRAYtema["tema_id"],$relative_term_id,"3");

					//add reference
					ADDreferencesSuggestedTerm($relative_term_id,$arrayNewTerm[1],$ARRAYtargetVocabulary,$options=array("addNoteReference"=>$_POST["addNoteReference"],"addLinkReference"=>$_POST["addLinkReference"],"addMappReference"=>$_POST["addMappReference"]));
				}
				break;

			case '4':
				for($i=0; $i<sizeof($selectedTerms);++$i){
					//parse string and term_id
					$arrayNewTerm=explode('|tterm_|', $selectedTerms[$i]);
					$relative_term_id=abm_tema('alta',$arrayNewTerm[0]);

					//associate terms
					$new_relacion=do_r($relative_term_id,$ARRAYtema["tema_id"],"4");
				}
				break;


		}

	}


	# Alta de término subordinado
	if($_POST[id_termino_sub])	{
		$proc=associateTerms($_POST["id_termino_sub"],doValue($_POST,FORM_LABEL_termino),"3",$_POST["t_rel_rel_id"]);
		$tema=$proc["last_term_id"];
		if(count($proc["arrayDupliTerms"])>0){
			$MSG_PROC_ERROR=HTMLduplicatedTermsAlert($proc["arrayDupliTerms"]);
		}
	}

	# Alta de término no preferido
	if($_POST[id_termino_uf]){
		$proc=associateTerms($_POST["id_termino_uf"],doValue($_POST,FORM_LABEL_termino),"4",$_POST["t_rel_rel_id"]);
		$tema=$proc["last_term_id"];
		if(count($proc["arrayDupliTerms"])>0){
			$MSG_PROC_ERROR=HTMLduplicatedTermsAlert($proc["arrayDupliTerms"]);
		}
	}

	# Alta de término relacionado
	if($_POST[id_termino_rt]){
		$proc=associateTerms($_POST["id_termino_rt"],doValue($_POST,FORM_LABEL_termino),"2",$_POST["t_rel_rel_id"]);
		$tema=$proc["last_term_id"];
		if(count($proc["arrayDupliTerms"])>0){
			$MSG_PROC_ERROR=HTMLduplicatedTermsAlert($proc["arrayDupliTerms"]);
		}
	}


	# Alta de término equivalente
	#1. Alta de término
	#2. Alta de relaci�n
	if($_POST["id_termino_eq"]){
		$new_termino=abm_tema('alta',doValue($_POST,FORM_LABEL_termino));
		$new_relacion=do_r($new_termino,$_POST["id_termino_eq"],$_POST["tipo_equivalencia"],$_POST["t_rel_rel_id"]);
		$tema=$_POST["id_termino_eq"];
		$_GET["id_eq"]='';
	}


	# Alta de término
	if($_POST["alta_t"]=='new'){
		$proc=createTerms(doValue($_POST,FORM_LABEL_termino),$_POST["isMetaTerm"]);

		$tema=$proc["last_term_id"];

		if(count($proc["arrayDupliTerms"])>0){
			$MSG_PROC_ERROR=HTMLduplicatedTermsAlert($proc["arrayDupliTerms"]);
		}
	};


	# Alta de nota
	if($_POST["taskNota"]=='alta'){
		$tema=abmNota('A',$_POST["idTema"],doValue($_POST,FORM_LABEL_tipoNota),doValue($_POST,FORM_LABEL_Idioma),doValue($_POST,FORM_LABEL_nota));
	};

	#Alta URI
	if($_POST["taskURI"]=='addURI'){
		$tema=abmURI('A',$_POST["tema_id"],$_POST);
	};

	//prevent duplicate
	unset($_SESSION['SEND_KEY']);
	}

}//END PREVENT DUPLICATED TERMS


switch ($_GET["taskrelations"])
{
	case 'addTgetTerm'://agregar un término de WS
		$new_relacion=abm_target_tema("A",$_GET["tema"],$_GET["tvocab_id"],$_GET["tgetTerm_id"]);
	break;

	case 'delTgetTerm'://eliminar un término de WS
		$del_relacion=abm_target_tema("B",$_GET["tema"],$_GET["tvocab_id"],$_GET["tgetTerm_id"],$_GET["tterm_id"]);
	break;

	case 'delURIterm'://eliminar una URL
		$del_relacion=abmURI("B",$_GET["tema"],array(),$_GET["uri_id"]);
	break;

	case 'updTgetTerm'://actualiza término de WS
		$up_relacion=abm_target_tema("U",$_GET["tema"],$_GET["tvocab_id"],$_GET["tgetTerm_id"],$_GET["tterm_id"]);
	break;

	case 'addRT':
		for($i=0; $i<sizeof($_GET["rema_id"]);++$i){
			$new_relacion=do_terminos_relacionados($_GET["rema_id"][$i],$_GET["tema"]);
			}
		$tema=$_GET["tema"];
	break;

	case 'addBT':
		$new_relacion=do_r($_GET["rema_id"],$_GET["tema"],"3");
		$tema=$_GET["rema_id"];
		$tema=$new_relacion["id_menor"];

		if ($new_relacion["log"]==true)	loadPageTerm($tema);

		$MSG_ERROR_RELACION=$new_relacion["msg_error"];
	break;

	case 'addFreeUF':
		for($i=0; $i<sizeof($_GET["rema_id"]);++$i){
			$new_relacion=do_r($_GET["rema_id"][$i],$_GET["tema"],"4");
			//DATESTAMP change term for the non-prefered term.
			updateTermDate($_GET["rema_id"][$i]);
			}

		$tema=$_GET["tema"];

		if ($new_relacion["log"]==true)	loadPageTerm($tema);

		$MSG_ERROR_RELACION=$new_relacion["msg_error"];
	break;

	case 'addFreeNT':
		for($i=0; $i<sizeof($_GET[rema_id]);++$i){
			$new_relacion=do_r($_GET[tema],$_GET[rema_id][$i],"3");
			}
		$tema=$_GET["tema"];

		if ($new_relacion["log"]==true)	loadPageTerm($tema);

		$MSG_ERROR_RELACION=$new_relacion["msg_error"];
	break;

	//assign multiple free terms to relation
	case 'freeTermsAssoc':
		freeTermsAssoc($_POST["rema_id"],$_POST["rel_free_term"],$_POST["freeTerms_id"]);

		//if ($new_relacion["log"]==true)	loadPageTerm($tema);
		loadPageTerm($_POST["rema_id"]);
	break;

	default:
}

	# Alta de relaci�n entre término
	if($_GET["sel_idtr"])	{
		$new_relacion=do_terminos_relacionados($_GET["sel_idtr"],$_GET["tema"]);
		$_GET["sel_idtr"]='';
		$MSG_ERROR_RELACION=$new_relacion["msg_error"];
	}

	# Subordinaci�n de un término a otro
	if($_GET["sel_idsuptr"])	{
		$new_relacion=do_r($_GET["sel_idsuptr"],$tema,"3");
		$tema=$_GET["sel_idsuptr"];
		$_GET["sel_idsuptr"]='';
		$MSG_ERROR_RELACION=$new_relacion["msg_error"];
	};


	# Borrado de  relaci�n
	if($_GET["ridelete"])	{
		borra_r($_GET["ridelete"]);
	};




	#Operaciones Mod y Borrado de notas
	# Modificaci�n de nota
		if($_POST["taskNota"]=='edit')	{
			$tema=abmNota('M',$_POST["idTema"],doValue($_POST,FORM_LABEL_tipoNota),doValue($_POST,FORM_LABEL_Idioma),doValue($_POST,FORM_LABEL_nota),$_POST["idNota"]);
		};

		# Borrado de nota
		if($_GET["taskNota"]=='rem')		{
			$tema=abmNota('B',$_GET["idTema"],"","","",$_GET["idNota"]);
		};


	# Cambio de estado de un término
	if(($_GET["estado_id"])&&($_GET["tema"]))	{
		$cambio_estado=cambio_estado($_GET["tema"],$_GET["estado_id"]);
		$tema=$cambio_estado["tema_id"];
		$MSG_ERROR_ESTADO=$cambio_estado["msg_error"];
	};

	#turn to metaterm or term
	if(($_GET["taskterm"]=='metaTerm') && ($_GET["tema"]))	{
		$task=setMetaTerm($_GET["tema"],$_GET["mt_status"]);
	}


//////////////////////////////////////////////////////////////////////////
///////////////////// functions //////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
/*
function to select wich report download
*/
function wichReport($task){
	switch ($task) {

	//advanced report
	case 'csv1':
	$sql=SQLadvancedTermReport($_GET);
	break;

	//free terms
	case 'csv2':
	$sql=SQLverTerminosLibres();
	break;

	//duplicated terms
	case 'csv3':
	$sql=SQLverTerminosRepetidos();
	break;

	//polit BT terms
	case 'csv4':
	$sql=SQLpoliBT();
	break;

	//candidate terms
	case 'csv5':
	$sql=SQLtermsXstatus($_SESSION["id_tesa"],"12");
	break;

	//rejected terms
	case 'csv6':
	$sql=SQLtermsXstatus($_SESSION["id_tesa"],"14");
	break;

	//preferred and accepted terms without hierarchical relationships
	case 'csv7':
	$sql=SQLtermsXcantNT();
	break;

	//preferred and accepted terms with words count
	case 'csv8':
	$sql=SQLtermsXcantWords($_SESSION["id_tesa"]);
	break;

	//meta terms
	case 'csv9':
	$sql=SQLtermsIsMetaTerms($_SESSION["id_tesa"]);
	break;

	//Terms with related terms
	case 'csv10':
	$sql=SQLtermsXrelatedTerms($_SESSION["id_tesa"]);
	break;

	//Terms with non prefered terms
	case 'csv11':
	$sql=SQLtermsXNonPreferedTerms($_SESSION["id_tesa"]);
	break;

	//Comparative report about mapped terms
	case 'csv12':
	$sql=SQLreportTargetTerms($_GET["tvocabs"]);
	break;

	//Preferred terms
	case 'csv13':
	$sql=SQLreportTerminosPreferidos();
	break;

	//Terms without note o note type
	case 'csv14':
	$sql=SQLreportNullNotes($_GET["note_type_null"]);
	break;

	//All accepted Terms (prefered and no-preferd without distinction)
	case 'csv15':
	$sql=SQLreportAllTerms($_SESSION["id_tesa"]);
	break;

	//All relations for all accepted terms
	case 'csv16':
	$sql=SQLreportAllRelations($_SESSION["id_tesa"]);
	break;

	//All notes for all accepted terms
	case 'csv17':
	$sql=SQLreportAllNotes($_SESSION["id_tesa"]);
	break;

	default :

	break;
}

return sql2csv($sql,string2url($_SESSION["CFGTitulo"]).'.csv',$_GET["csv_encode"]);
}




};// fin de llamdas de funciones de gestion



###################################################################################
##################      FUNCIONES DE ABM TERMINOS   ###############################
###################################################################################



//create and delete target terms
function addLocalTargetTerms($tvocab_id,$data=array()){

	$ARRAYvocabulario=ARRAYvocabulario($tvocab_id);
	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

	GLOBAL $DBCFG;

	if($ARRAYvocabulario["vocabulario_id"]>1){
		//delete equivalences
		for($i=0; $i<sizeof($data["remove_tterm_rel"]);++$i){
			borra_r($data["remove_tterm_rel"][$i]);

		}

		//add equivalences
		for($i=0; $i<sizeof($data["term_id"]);++$i){
			if(strlen($data["tterm_string"][$i])>1) {
				$tterm_id=addTerm($data["tterm_string"][$i],$ARRAYvocabulario["vocabulario_id"],'13');
				$tterm_rel=do_r($tterm_id,$data["term_id"][$i],$data["tipo_equivalencia"][$i],"");
			}
		}
	}

};


function doArrayNota($array){
$arrayDatos=array("idTermino"=> doValue($array,"idTermino"),
		"idNota"=> doValue($array,"idNota"),
		"tipoNota"=> doValue($array,FORM_LABEL_tipoNota),
		"nota"=>doValue($array,FORM_LABEL_nota),
		);
return $arrayDatos;
};

function doArrayDatosUser($array){

$arrayDatos=array("nombres"=> doValue($array,FORM_LABEL_nombre),
		"apellido"=> doValue($array,FORM_LABEL_apellido),
		"mail"=>doValue($array,FORM_LABEL_mail),
		"pass"=> doValue($array,FORM_LABEL_pass),
		"orga"=> doValue($array,FORM_LABEL_orga),
		"isAdmin"=> doValue($array,"isAdmin"),
		"isAlive"=> doValue($array,"isAlive"),
		"id"=>doValue($array,FORM_LABEL_idUser)
		);
return $arrayDatos;
};


function doArrayDatosTesauro($array){

if(!doValue($array,FORM_LABEL_URI)){
	$array[FORM_LABEL_URI]="http://" . $_SERVER['HTTP_HOST']. rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	};

$arrayDatos=array("titulo"=>doValue($array,FORM_LABEL_Titulo),
		"autor"=>doValue($array,FORM_LABEL_Autor),
		"idioma"=>doValue($array,FORM_LABEL_Idioma),
		"cobertura"=>doValue($array,FORM_LABEL_Cobertura),
		"keywords"=> doValue($array,FORM_LABEL_Keywords),
		"tipo"=> doValue($array,FORM_LABEL_TipoLenguaje),
		"url_base"=> doValue($array,FORM_LABEL_URI),
		"polijerarquia"=> doValue($array,FORM_LABEL_jeraquico),
		"cuando"=>doValue($array,FORM_LABEL_FechaAno).'-'.doValue($array,FORM_LABEL_FechaMes).'-'.doValue($array,FORM_LABEL_FechaDia),
		"id"=>doValue($array,FORM_LABEL_idTes)
		);

return $arrayDatos;
};


#
# ALTA DE TERMINOS RELACIONADOS (solo TR)
#
function do_terminos_relacionados($id_mayor,$id_menor,$rel_rel_id=0){

$evalRecursividad_ida=evalRelacionSuperior($id_mayor,'0',$id_menor);

$evalRecursividad_vuelta=evalRelacionSuperior($id_menor,'0',$id_mayor);

if(($evalRecursividad_ida==TRUE)&&($evalRecursividad_vuelta==TRUE)){
	#1. Alta de relaci�n de ida
	#2. Alta de relaci�n de vuelta
	$new_relacionIda=do_r($id_mayor,$id_menor,"2",$rel_rel_id);
	$new_relacionVuelta=do_r($id_menor,$id_mayor,"2",$rel_rel_id);
	$msg='';
	$log=true;
}else{
	$msg='<p class="error">'.MSGL_relacionIlegal.'</p>';;
	$log=false;
}

return array("id_tema"=>$id_menor,"msg_error"=>$msg,"log"=>$log);
};

#
# ALTA DE TERMINOS RELACIONADOS (todo tipo de relacion)
#
function do_r($id_mayor,$id_menor,$t_relacion,$rel_rel_id=0){

GLOBAL $DBCFG;

$tema_id=secure_data($_POST["id_tema"],"int");

$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

// Evaluar recursividad
$evalRecursividad=evalRelacionSuperior($id_mayor,'0',$id_menor);

// Evaluar si son valores numericos
if(	(is_numeric($id_menor) && 	is_numeric($id_mayor) && is_numeric($t_relacion) )	)	{
	$okValues = TRUE;
	};
	//si es una relación consigo mismo
	if($id_mayor==$id_menor) return array("id_tema"=>$id_mayor,"msg_error"=>'<p class="error">'.MSGL_relacionIlegal.'</p>',"log"=>"false");


# NO es una relacion recursiva
if(($evalRecursividad == TRUE) && ($okValues == TRUE)){

		$rel_rel_id=(is_numeric($rel_rel_id)) ? $rel_rel_id : 0;

		$sql=SQL("insert","into $DBCFG[DBprefix]tabla_rel (id_mayor,id_menor,t_relacion,rel_rel_id,uid,cuando)
			values
			('$id_mayor','$id_menor','$t_relacion','$rel_rel_id','$userId',now())");
		//es TG y hay que actualizar el arbol
		if($t_relacion=='3'){		actualizaListaArbolAbajo($id_menor);		}

		$msg='';
		$log=true;
	}else{
		$msg='<p class="error">'.MSGL_relacionIlegal.'</p>';
		$log=false;
	};

return array("id_tema"=>$tema_id,
						"id_mayor"=>$id_mayor,
						"id_menor"=>$id_menor,
						 "msg_error"=>$msg,"log"=>$log);
};



function actualizaListaArbolAbajo($tema_id){

$tema_id=secure_data($tema_id,"int");

$sql=actualizaArbolxTema($tema_id);

$sqlTerminosAfectados=SQLtieneTema($tema_id);

//Hay algo que actualizar
if(SQLcount($sqlTerminosAfectados)>'0')
	{
		while($array=$sqlTerminosAfectados->FetchRow())
		{
			actualizaArbolxTema($array[0]);
		};
	}
return $tema_id;
};


#
# BAJA FISICA DE TERMINOS
#
function borra_t($id_t){
GLOBAL $DBCFG;

$id_t=secure_data($id_t,"int");

	$delete=SQL("delete","from $DBCFG[DBprefix]term2tterm where tema_id='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where '$id_t' in (id_menor,id_mayor)");
	$delete=SQL("delete","from $DBCFG[DBprefix]indice where tema_id='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]notas where id_tema='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]uri where tema_id='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]tema where tema_id='$id_t'");
};


#
# BAJA DE RELACIONES ENTRE TERMINOS
#
function borra_r($id_r){

GLOBAL $DBCFG;

$id_r=secure_data($id_r,"int");

$sql_dator=SQL("select","$DBCFG[DBprefix]tabla_rel.id,id_mayor,id_menor,t_relacion from $DBCFG[DBprefix]tabla_rel where id='$id_r'");

$dator=$sql_dator->FetchRow();

switch($dator[t_relacion]){
	case '2':
	$sql_id_delete=SQL("select","$DBCFG[DBprefix]tabla_rel.id
		from $DBCFG[DBprefix]tabla_rel
		where
		id_menor in ('$dator[id_menor]','$dator[id_mayor]')
		and id_mayor in ('$dator[id_menor]','$dator[id_mayor]')
		and t_relacion='$dator[t_relacion]'");

	while($id_delete=$sql_id_delete->FetchRow()){
		$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_delete[0]'");
		}
	break;

	case '3':
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	actualizaListaArbolAbajo($dator[id_menor]);
	break;


	case '4': //UF
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	break;

	case '5': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar tambi�n el término
	borra_t($dator["id_mayor"]);
	break;

	case '6': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar tambi�n el término
	borra_t($dator["id_mayor"]);
	break;

	case '7': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar tambi�n el término
	borra_t($dator["id_mayor"]);
	break;


	case '8': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar tambi�n el término
	borra_t($dator["id_mayor"]);
	break;
	};

};

#
# devuelve una lista separada por | del arbol/indice de un tema
#
function generaIndices($tema_id){

	$tema_id=secure_data($tema_id,"int");

	$indice_temas=bucle_arriba($tema_id.'|',$tema_id);
	return $indice_temas;
};



#
# actualiza la situacion de tema en el arbol/indice
#
function actualizaArbolxTema($tema_id){
	GLOBAL $DBCFG;

	$tema_id=secure_data($tema_id,"int");
	$este_tema_id=$tema_id;
	//Obtengo una cadena separada con | con el arbol inverso de un tema
	$tema_ids_inverso=generaIndices($tema_id);
	//Convierto en array y ordeno el arbol inverso de un tema
	$tema_ids_derecho=array_reverse(explode("|",$tema_ids_inverso));
	//Vuelvo a convertir en cadena separada por | con el arbol ordenado del termino
	foreach($tema_ids_derecho as $tema_id_cadena){
		$indice[$este_tema_id].='|'.$tema_id_cadena;
		}
	//Saco el ultimo caracter
	$esteindice=substr($indice[$este_tema_id],1);

	$sql=SQL("insert","into $DBCFG[DBprefix]indice values ('$tema_id','$esteindice')");

	if(@$sql[error])		{
		$sql=SQL("update","$DBCFG[DBprefix]indice set indice='$esteindice' where tema_id='$tema_id'");
		}

return $tema_id;
};



##
# ALTA DE TERMINOS
#
function addTerm($string,$tesauro_id,$estado_id=13){

GLOBAL $DBCFG;

GLOBAL $DB;

$titu_tema=$DB->qstr($titu_tema,get_magic_quotes_gpc());

$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

$sql=SQLo("insert","into $DBCFG[DBprefix]tema (tema,tesauro_id,uid,cuando,estado_id,cuando_estado,cuando_final,uid_final)
			values (?,?,?,now(),?,now(),null,null)",array($string,$tesauro_id,$userId,$estado_id));

return $sql["cant"];

};




#
# ALTA Y MODIFICACION DE TERMINOS
#
function abm_tema($do,$titu_tema,$tema_id=""){

GLOBAL $DBCFG;

GLOBAL $DB;

$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

//Es un término del vocabulario o una referencia a un término mapeado de otro vocabulario.
$tesauro_id = (secure_data($_POST["ref_vocabulario_id"],"int")) ? $_POST["ref_vocabulario_id"] : $_SESSION["id_tesa"];


$titu_tema=trim($titu_tema);

//no string
if(strlen($titu_tema)<1) return ;


$tesauro_id=secure_data($tesauro_id,"int");

switch($do){
		case 'alta':
		$estado_id = (@$_POST["estado_id"]) ? $_POST["estado_id"] : '13';

		$tema_id=addTerm($titu_tema,$tesauro_id,$estado_id);
		break;

		case 'mod':
		$tema_id=secure_data($tema_id,"int");
		$titu_tema=$DB->qstr($titu_tema,get_magic_quotes_gpc());

		$sql=SQLo("update","$DBCFG[DBprefix]tema set
		tema=$titu_tema ,uid_final= ?,cuando_final=now() where tema_id= ?",
		array($userId,$tema_id));
		break;
		};

return $tema_id;
};




#update date for a term
function updateTermDate($tema_id)
{
	$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];
	$tema_id=secure_data($tema_id,"int");

	GLOBAL $DBCFG;

	$sql=SQL("update","$DBCFG[DBprefix]tema set uid_final='$userId',cuando_final=now() where tema_id='$tema_id' ");

	return $tema_id;
}

#
# ALTA Y baja DE target TERMINOS externos
#
function abm_target_tema($do,$tema_id,$tvocab_id,$tgetTerm_id,$tterm_id="0")
{
GLOBAL $DBCFG;
GLOBAL $DB;

$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

$tema_id=secure_data($tema_id,"int");

$tvocab_id=secure_data($tvocab_id,"int");

$arrayVocab=ARRAYtargetVocabulary($tvocab_id);

$sendkey='';

if(is_array($arrayVocab)){

	switch($do){
		case 'A':
		//prevent duplicate
		require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;

		$dataTterm=getURLdata($arrayVocab["tvocab_uri_service"].'?task=fetchTerm&arg='.$tgetTerm_id);

		$arrayTterm["tterm_uri"]=$arrayVocab["tvocab_uri_service"].'?task=fetchTerm&arg='.$tgetTerm_id;

		$arrayTterm["tterm_url"]=$arrayVocab["tvocab_url"].'?tema='.$tgetTerm_id;

		$arrayTterm["tterm_string"]=$DB->qstr(trim((string) $dataTterm->result->term->string),get_magic_quotes_gpc());

		$sql=SQLo("insert","into $DBCFG[DBprefix]term2tterm (tema_id,tvocab_id,tterm_url,tterm_uri,tterm_string,cuando,uid)
					values (?,?,?,?,$arrayTterm[tterm_string],now(),?)",
					array($tema_id,$arrayVocab[tvocab_id],$arrayTterm[tterm_url],$arrayTterm[tterm_uri],$userId));

		$target_relation_id=$sql[cant];

		break;

		case 'B'://delete
		$sql=SQLo("delete","from $DBCFG[DBprefix]term2tterm where tterm_id=? and tema_id=? and tvocab_id=? limit 1",array($tterm_id,$tema_id,$tvocab_id));
		$target_relation_id="0";
		break;

		case 'U'://update data

		require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;
		//obtener datos locales del término
		$arrayTterm=ARRAYtargetTerm($tema_id,$tgetTerm_id);

		//obtener datos externos del término
		$dataTterm=getURLdata($arrayTterm["tterm_uri"]);

		$arrayTterm["tterm_string"]=$DB->qstr(trim((string) $dataTterm->result->term->string),get_magic_quotes_gpc());

		$sql=SQLo("update","$DBCFG[DBprefix]term2tterm set
		tterm_string=$arrayTterm[tterm_string],
		cuando_last=now(),
		uid=?
		where tterm_id=? and tema_id=? and tvocab_id=? limit 1",
		array($userId,$tterm_id,$tema_id,$tvocab_id));

		$target_relation_id=$sql[cant];

		break;
		};
	};

return $target_relation_id;
};


#
# Cambio de estado de un término
#
function cambio_estado($tema_id,$estado_id)
{
GLOBAL $DBCFG;
$tema_id=secure_data($tema_id,"int");

$estado_id=secure_data($estado_id,"int");

$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

switch($estado_id)	{
	case '13'://Aceptado / Aceptado
	//todos pueden ser aceptados
	$sql=SQL("update","$DBCFG[DBprefix]tema set estado_id='13' ,uid_final='$userId',cuando_estado=now() where tema_id='$tema_id' ");
	break;

	default :// '12' Candidato / Candidate o '14'://Rechazado / rejected
	// s�lo términos libres / only free terms
	$sqlCtrl=SQLcheckFreeTerm($tema_id);
	if(SQLcount($sqlCtrl)=='1')		{
		$sql=SQL("update","$DBCFG[DBprefix]tema set estado_id='$estado_id' ,uid_final='$userId',cuando_estado=now() where tema_id='$tema_id'");
		}		else		{
		$msg_error = 	$msg='<p class="error">'.MSG_ERROR_ESTADO.'</p>';
		}
	break;
	}

return array("tema_id"=>$tema_id,"msg_error"=>$msg_error);
};


#
# ALTA, BAJA Y MODIFICACION DE NOTAS
#
function abmNota($do,$idTema,$tipoNota,$langNota,$nota,$idNota=""){

GLOBAL $DBCFG;
GLOBAL $DB;


$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

$tipoNota=$DB->qstr(trim($tipoNota),get_magic_quotes_gpc());
$langNota=$DB->qstr(trim($langNota),get_magic_quotes_gpc());
$nota=$DB->qstr(trim($nota),get_magic_quotes_gpc());
//prevent encoding proble
//$nota=utf8_encode($nota);
//$nota=$DB->qstr(trim($nota)),get_magic_quotes_gpc());


switch($do){
	case 'A':
	$sql=SQL("insert","into $DBCFG[DBprefix]notas
	(id_tema,tipo_nota,lang_nota,nota,cuando,uid)
	values ($idTema,$tipoNota,$langNota,$nota,now(),$userId)");
	break;

	case 'M':

	$sql=SQL("update","$DBCFG[DBprefix]notas
	set tipo_nota=$tipoNota,
	lang_nota=$langNota,
	nota=$nota,
	cuando=now() ,
	uid=$userId
	where id=$idNota");
	break;

	case 'B':
	$idNota=secure_data($idNota,"int");
	$sql=SQL("delete","from $DBCFG[DBprefix]notas where id='$idNota'");
	break;
	};

return $idTema;
};


#
# ALTA, BAJA de URIs
#
function abmURI($do,$tema_id,$array=array(),$uri_id=0){

GLOBAL $DBCFG;
GLOBAL $DB;

$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

$tema_id=secure_data($tema_id,"int");
$uri_type_id=secure_data($array["uri_type_id"],"int");


switch($do){
	case 'A':
	$parse_uri=parse_url($array["uri"]);
	//check if is a valid URI
	if(strlen($parse_uri["scheme"])>1)	{
		$uri=$DB->qstr($array["uri"],get_magic_quotes_gpc());
		$sql=SQL("insert","into $DBCFG[DBprefix]uri
			(tema_id,uri_type_id,uri,uid,cuando)
			values ($tema_id,$uri_type_id,$uri,$userId,now())");
	}
	break;

	case 'B':
	$uri_id=secure_data($uri_id,"int");
	$sql=SQL("delete","from $DBCFG[DBprefix]uri where uri_id='$uri_id'");
	break;
	};

return $tema_id;
};


#
# alta y modificaci�n de c�digo de términos
#
function edit_single_code($tema_id,$code)
{
	GLOBAL $DBCFG;
	GLOBAL $DB;

	$code=trim($code);
	$tema_id=secure_data($tema_id,"int");


	$ARRAYCode=ARRAYCode($code);

	//No cambi� nada
	if($ARRAYCode[tema_id]==$tema_id)	{
		//sin cambios
		$ARRAYCode["log"]='0';
		return $ARRAYCode;

	}	elseif($ARRAYCode[tema_id])	{
		//error
		$ARRAYCode["log"]='-1';
		return $ARRAYCode;
	}	else	{
		//cambios

		if(strlen($code)<1)		{
			$sql=SQL("update","$DBCFG[DBprefix]tema set code=NULL where tema_id=$tema_id");
		}		else		{
			$code=$DB->qstr($code,get_magic_quotes_gpc());
			$sql=SQL("update","$DBCFG[DBprefix]tema set code=$code where tema_id=$tema_id");

		}

		$ARRAYCode=ARRAYverTerminoBasico($tema_id);

		$ARRAYCode["log"]='1';
		return $ARRAYCode;
	}

}



function admin_users($do,$user_id=""){

	GLOBAL $DBCFG;

	GLOBAL $DB;

	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

	if (is_numeric($user_id))	{
		$arrayUserData=ARRAYdatosUser($user_id);

		if($arrayUserData["nivel"]=='1'){
			//Cehcquear que sea ADMIN
			$sqlCheckAdmin=SQL("select","count(*) as cant from $DBCFG[DBprefix]usuario where nivel='1' and estado='ACTIVO'");
			$arrayCheckAdmin=$sqlCheckAdmin->FetchRow();
			}
	}

	
	$POSTarrayUser=doArrayDatosUser($_POST);

//Normalice admin 
	//nivel submit is 1 and is admin

	$nivel=(($POSTarrayUser["isAdmin"]==1) && ($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]=='1')) ? '1' : '2';
	//Check have one admin user
	$nivel=(($arrayUserData["nivel"]=='1') && ($arrayCheckAdmin["cant"]==1)) ? '1' : $nivel;

	
	switch($do){
		case 'actua':
		$POSTarrayUser["apellido"]=trim($POSTarrayUser[apellido]);
		$POSTarrayUser["nombres"]=trim($POSTarrayUser[nombres]);
		$POSTarrayUser["mail"]=trim($POSTarrayUser[mail]);
		$POSTarrayUser["pass"]=trim($POSTarrayUser[pass]);
		$POSTarrayUser["orga"]=trim($POSTarrayUser[orga]);

		$POSTarrayUser["apellido"]=$DB->qstr($POSTarrayUser[apellido],get_magic_quotes_gpc());
		$POSTarrayUser["nombres"]=$DB->qstr($POSTarrayUser[nombres],get_magic_quotes_gpc());
		$POSTarrayUser["mail"]=$DB->qstr($POSTarrayUser[mail],get_magic_quotes_gpc());
		$POSTarrayUser["orga"]=$DB->qstr($POSTarrayUser[orga],get_magic_quotes_gpc());
		$POSTarrayUser["pass"]=trim($POSTarrayUser[pass]);

		$POSTarrayUser["status"]=($POSTarrayUser["isAlive"]=='ACTIVO') ? 'ACTIVO' : 'BAJA';

		//Check have one admin user
		if (($POSTarrayUser["status"]=='BAJA') &&
			($arrayUserData["nivel"]=='1') &&
			($arrayCheckAdmin["cant"]=='1')
			)		{
			$POSTarrayUser["status"]='ACTIVO';
		}
		//eviatar auto-deshabilitado
		if($arrayUserData["user_id"]==$userId) $POSTarrayUser["status"]='ACTIVO';

		$sql=SQL("update","$DBCFG[DBprefix]usuario
			SET apellido=$POSTarrayUser[apellido],
			nombres= $POSTarrayUser[nombres],
			mail=$POSTarrayUser[mail],
			uid='$userId',
			orga= $POSTarrayUser[orga]
			WHERE id= '$arrayUserData[user_id]'");

			//set password
			if(strlen($POSTarrayUser[pass])>0)				{
					setPassword($arrayUserData["user_id"],$POSTarrayUser[pass],CFG_HASH_PASS);
				}

		//only admin
		if($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]=='1')			{
				$sql=SQL("update","$DBCFG[DBprefix]usuario
				SET estado='$POSTarrayUser[status]',
				nivel='$nivel',
				uid='$userId',
				hasta=now()
				WHERE id='$arrayUserData[user_id]'");
			}

		break;

		case 'estado':
		$new_estado = ($POSTarrayUser["status"]=='ACTIVO') ?  'ACTIVO': 'BAJA';

		//Check have one admin user && you do not disable yourself
		if($new_estado=='BAJA'){

			if(($arrayUserData["nivel"]=='1' && $arrayCheckAdmin["cant"]=='1') || 
			($arrayUserData["user_id"]==$userId)){
				$new_estado='ACTIVO';
				}
		} 


		$sql=SQL("update","$DBCFG[DBprefix]usuario
			SET estado='$new_estado',
			uid='$userId',
			hasta=now()
			WHERE id='$arrayUserData[user_id]'
			");
		break;


		case 'alta':
		$POSTarrayUser["apellido"]=trim($POSTarrayUser[apellido]);
		$POSTarrayUser["nombres"]=trim($POSTarrayUser[nombres]);
		$POSTarrayUser["mail"]=trim($POSTarrayUser[mail]);
		$POSTarrayUser["pass"]=trim($POSTarrayUser[pass]);
		$POSTarrayUser["orga"]=trim($POSTarrayUser[orga]);

		//prevent empty password
		if(strlen($POSTarrayUser["pass"])<5) return;

		$POSTarrayUser["apellido"]=$DB->qstr($POSTarrayUser[apellido],get_magic_quotes_gpc());
		$POSTarrayUser["nombres"]=$DB->qstr($POSTarrayUser[nombres],get_magic_quotes_gpc());
		$POSTarrayUser["mail"]=$DB->qstr($POSTarrayUser[mail],get_magic_quotes_gpc());
		$POSTarrayUser["orga"]=$DB->qstr($POSTarrayUser[orga],get_magic_quotes_gpc());
		$user_pass=(CFG_HASH_PASS==1) ? t3_hash_password($POSTarrayUser["pass"]) : $POSTarrayUser["pass"];

		$sql=SQLo("insert","into $DBCFG[DBprefix]usuario
			(apellido, nombres, uid, cuando, mail,  orga, nivel,pass, estado, hasta)
			VALUES
			($POSTarrayUser[apellido], $POSTarrayUser[nombres], ?, now(), $POSTarrayUser[mail], $POSTarrayUser[orga], ?,'$user_pass', 'ACTIVO', now())",
			array( $userId,  $nivel));
		$user_id=$sql["cant"];

		break;
		};
return $user_id;
};// fin de la funcion de administacion de usuarios

// fin de la funcion de datos propios de usuario


#
# # # # funciones de administracion # # # #
#

if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){


# cambios de configuracion y registro de vocabularios de referencia
function abm_vocabulario($do,$vocabulario_id=""){

GLOBAL $DBCFG;
GLOBAL $DB;

$arrayTesa=doArrayDatosTesauro($_POST);

	$POSTarrayUser[orga]=trim($POSTarrayUser[orga]);
	$arrayTesa[titulo]=trim($arrayTesa[titulo]);
	$arrayTesa[autor]=trim($arrayTesa[autor]);
	$arrayTesa[idioma]=trim($arrayTesa[idioma]);
	$arrayTesa[cobertura]=trim($arrayTesa[cobertura]);
	$arrayTesa[keywords]=trim($arrayTesa[keywords]);
	$arrayTesa[tipo]=trim($arrayTesa[tipo]);
	$arrayTesa[polijerarquia]=trim($arrayTesa[polijerarquia]);
	$arrayTesa[url_base]=trim($arrayTesa[url_base]);
	$arrayTesa[cuando]=trim($arrayTesa[cuando]);

	$POSTarrayUser["orga"]=$DB->qstr($POSTarrayUser[orga],get_magic_quotes_gpc());
	$arrayTesa["titulo"]=$DB->qstr($arrayTesa[titulo],get_magic_quotes_gpc());
	$arrayTesa["autor"]=$DB->qstr($arrayTesa[autor],get_magic_quotes_gpc());
	$arrayTesa["idioma"]=$DB->qstr($arrayTesa[idioma],get_magic_quotes_gpc());
	$arrayTesa["cobertura"]=$DB->qstr($arrayTesa[cobertura],get_magic_quotes_gpc());
	$arrayTesa["keywords"]=$DB->qstr($arrayTesa[keywords],get_magic_quotes_gpc());
	$arrayTesa["tipo"]=$DB->qstr($arrayTesa[tipo],get_magic_quotes_gpc());
	$arrayTesa["polijerarquia"]= (in_array($arrayTesa["polijerarquia"],array("1","0"))) ? $arrayTesa["polijerarquia"] : 0;
	$arrayTesa["url_base"]=(isset($arrayTesa["url_base"])) ? $DB->qstr($arrayTesa["url_base"],get_magic_quotes_gpc()) : $_SESSION["CFGURL"];
	$arrayTesa["cuando"]=(check2Date($arrayTesa["cuando"])) ? $arrayTesa["cuando"] : date("Y-m-d");
	$arrayTesa["contact_mail"]=$_POST["contact_mail"];



	$vocabulario_id=secure_data($vocabulario_id,"int");

switch($do){
	case 'A':
	//Alta de vocabulario de referencia
	$sql=SQL("insert","into $DBCFG[DBprefix]config (titulo,autor,idioma,cobertura,url_base,cuando)
	values
	($arrayTesa[titulo],$arrayTesa[autor],$arrayTesa[idioma],$arrayTesa[cobertura], $arrayTesa[url_base],now())");
	break;

	case 'M':
	//Modificacion de vocabulario de referencia y principal
	$sql=SQL("update","$DBCFG[DBprefix]config SET titulo=$arrayTesa[titulo],
				autor=$arrayTesa[autor],
				idioma=$arrayTesa[idioma],
				cobertura=$arrayTesa[cobertura],
				keywords= $arrayTesa[keywords],
				tipo= $arrayTesa[tipo],
				polijerarquia=  '$arrayTesa[polijerarquia]',
				url_base= $arrayTesa[url_base],
				cuando='$arrayTesa[cuando]'
				where id= '$vocabulario_id'");

	//It is the main vocabulary => change config values
	if($vocabulario_id=='1'){
		$sql=SQL("select","v.value_id,v.value_type,v.value,v.value_code,v.value_order
						from $DBCFG[DBprefix]values v
						where v.value_type='config'");

		while ($array=$sql->FetchRow()){
			$value_code=($_POST[$array["value"]]=='00') ? '0' : secure_data($_POST[$array["value"]],"alnum");
			$sql_update=SQL("update","$DBCFG[DBprefix]values set value_code='$value_code' where value_type='config' and value='$array[value]'");
		}

		//Update from 1.72=> check if CFG_SUGGESTxWORD is defined
		$ctrl=ARRAYfetchValueXValue('config','CFG_SUGGESTxWORD');
		$ctrl20a=ARRAYfetchValueXValue('config','CFG_PUBLISH');
		$ctrl20b=ARRAYfetchValueXValue('config','CFG_ALLOW_DUPLICATED');
		$ctrl202a=ARRAYfetchValueXValue('config','_SHOW_RANDOM_TERM');
		$ctrl202b=ARRAYfetchValueXValue('config','_GLOSS_NOTES');

		/*add condig opotion for 3.2 version*/
		$ctrl32=ARRAYfetchValueXValue('config','COPY_CLICK');


		if(!$ctrl["value_id"])			{
				$value_code=($_POST["CFG_SUGGESTxWORD"]=='00') ? '0' : secure_data($_POST["CFG_SUGGESTxWORD"],"int");
				$sql1_6x1_7b=SQL("insert","into `".$DBCFG[DBprefix]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', 'CFG_SUGGESTxWORD', NULL, '$value_code')");
			}

		//Update to 2.1=> check if CFG_PUBLISH is defined
		if(!$ctrl20a["value_id"])			{
				$value_code=($_POST["CFG_PUBLISH"]=='00') ? '0' : secure_data($_POST["CFG_PUBLISH"],"int");
				$sql20x201a=SQL("insert","into `".$DBCFG[DBprefix]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', 'CFG_PUBLISH', NULL, '$value_code')");
			}

		if(!$ctrl20b["value_id"])			{
				$value_code=($_POST["CFG_ALLOW_DUPLICATED"]=='00') ? '0' : secure_data($_POST["CFG_ALLOW_DUPLICATED"],"int");
				$sql20x201a=SQL("insert","into `".$DBCFG[DBprefix]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', 'CFG_ALLOW_DUPLICATED', NULL, '$value_code')");
			}

		if(!$ctrl202a["value_id"])			{
				$value_code=($_POST["_SHOW_RANDOM_TERM"]=='00') ? '0' : secure_data($_POST["_SHOW_RANDOM_TERM"],"alpha");
				$sql20x202=SQL("insert","into `".$DBCFG["DBprefix"]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', '_SHOW_RANDOM_TERM', NULL, '$value_code')");
			}

		if(!$ctrl202b["value_id"])			{
				$sql20x202=SQL("insert","into `".$DBCFG["DBprefix"]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', '_GLOSS_NOTES', NULL, '$_GLOSS_NOTES')");
			}

		if(!$ctrl32["value_id"])			{
				$value_code=($_POST["COPY_CLICK"]=='00') ? '0' : '1';
				$sql32=SQL("insert","into `".$DBCFG["DBprefix"]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('config', 'COPY_CLICK', NULL, '$value_code')");
			}

		//Update to 1.73=> check if CONTACT_MAIL is defined
		if(ARRAYfetchValue('CONTACT_MAIL'))		{
			$ADDcontactMail=ABM_value("MOD_SINGLE_VALUE",array("value_type"=>'CONTACT_MAIL',"value_code"=>'NULL',"value"=>$arrayTesa["contact_mail"]));
		}		else		{
			$ADDcontactMail=ABM_value("ADD_VALUE",array("value_type"=>'CONTACT_MAIL',"value_code"=>'NULL',"value"=>$arrayTesa["contact_mail"]));
		}


		$MODdccontributor=ABM_value("MOD_VALUE",array("value_type"=>'METADATA',"value_code"=>'dc:contributor',"value"=>$_POST["dccontributor"]));
		$MODdcpublisher=ABM_value("MOD_VALUE",array("value_type"=>'METADATA',"value_code"=>'dc:publisher',"value"=>$_POST["dcpublisher"]));
		$MODdcrights=ABM_value("MOD_VALUE",array("value_type"=>'METADATA',"value_code"=>'dc:rights',"value"=>$_POST["dcrights"]));

	}
	break;

	case 'B':
	//Eliminacion de un vocabulario de REFERENCIA
	//no es el vocabulario por defecto
	if($vocabulario_id>1){
		$SQLlistTerms=SQLreportAllTerms($vocabulario_id);
		while($listTerms=$SQLlistTerms->FetchRow()){
				$remRelations=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id_menor=$listTerms[term_id]");
				$remNotes=SQL("delete","from $DBCFG[DBprefix]notas where id_tema=$listTerms[term_id]");
		}
		$sql=SQLo("delete","from $DBCFG[DBprefix]tema where tesauro_id=?",array($vocabulario_id));
		$sql=SQLo("delete","from $DBCFG[DBprefix]config where id=?",array($vocabulario_id));
	}

	break;
	}
return array("vocabulario_id"=>$vocabulario_id);
};


# cambios de configuracion y registro de vocabularios de referencia v�a web services
function abm_targetVocabulary($do,$tvocab_id="0"){

GLOBAL $DBCFG;

GLOBAL $DB;

$user_id=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

switch($do){
	case 'A':
	//Alta de vocabulario de referencia
		//prevent duplicate
		$sendkey=$_POST['ks'];

		if(isset($_SESSION['TGET_SEND_KEY'])) {

			if(strcasecmp($sendkey,$_SESSION['TGET_SEND_KEY'])===0) {
			require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;
			$arrayVocab["tvocab_uri_service"]=$_POST["tvocab_uri_service"];

			$dataVocab=getURLdata($arrayVocab["tvocab_uri_service"].'?task=fetchVocabularyData');

		/*
			Check web services
		*/
			if($dataVocab->result->vocabulary_id=='1')
			{
				$array["tvocab_label"]=$DB->qstr(trim($_POST["tvocab_label"]),get_magic_quotes_gpc());
				$array["tvocab_tag"]=$DB->qstr(trim($_POST["tvocab_tag"]),get_magic_quotes_gpc());
				$array["tvocab_lang"]=$DB->qstr(trim($_POST["tvocab_lang"]),get_magic_quotes_gpc());
				$array["tvocab_title"]=$DB->qstr(trim($dataVocab->result->title),get_magic_quotes_gpc());
				$array["tvocab_uri"]=$DB->qstr(trim($dataVocab->result->uri),get_magic_quotes_gpc());
				$array["tvocab_uri_service"]=$DB->qstr(trim($_POST["tvocab_uri_service"]),get_magic_quotes_gpc());
				$array["tvocab_status"]= ($_POST["tvocab_status"]==1) ? 1 : 0;


				$sql=SQL("insert","into $DBCFG[DBprefix]tvocab (tvocab_label, tvocab_tag,tvocab_lang, tvocab_title, tvocab_url, tvocab_uri_service, tvocab_status, cuando, uid)
				VALUES
				($array[tvocab_label], $array[tvocab_tag], $array[tvocab_lang], $array[tvocab_title], $array[tvocab_uri], $array[tvocab_uri_service], $array[tvocab_status], now(), $user_id)");

				$tvocab_id=$sql[cant];
			}
			else
			{
				return false;
			}

		//prevent duplicate
		unset($_SESSION['TGET_SEND_KEY']);
		}
	  }
	break;

	case 'M':
	require_once(T3_ABSPATH . 'common/include/vocabularyservices.php');

	$tvocab_id=secure_data($tvocab_id,"int");

	$arrayVocab=ARRAYtargetVocabulary($tvocab_id);

	$dataVocab=getURLdata($arrayVocab["tvocab_uri_service"].'?task=fetchVocabularyData');

/*
	Check web services
*/
	if($dataVocab->result->vocabulary_id=='1')
	{
		$array["tvocab_label"]=$DB->qstr(trim($_POST["tvocab_label"]),get_magic_quotes_gpc());
		$array["tvocab_tag"]=$DB->qstr(trim($_POST["tvocab_tag"]),get_magic_quotes_gpc());
		$array["tvocab_lang"]=$DB->qstr(trim($_POST["tvocab_lang"]),get_magic_quotes_gpc());
		$array["tvocab_title"]=$DB->qstr(trim($dataVocab->result->title),get_magic_quotes_gpc());
		$array["tvocab_uri"]=$DB->qstr(trim($dataVocab->result->uri),get_magic_quotes_gpc());
		$array["tvocab_uri_service"]=$DB->qstr(trim($_POST["tvocab_uri_service"]),get_magic_quotes_gpc());
		$array["tvocab_status"]= ($_POST["tvocab_status"]==1) ? 1 : 0;


		$sql=SQL("update","$DBCFG[DBprefix]tvocab set
		tvocab_label=$array[tvocab_label],
		tvocab_tag=$array[tvocab_tag],
		tvocab_lang=$array[tvocab_lang],
		tvocab_title=$array[tvocab_title],
		tvocab_url= $array[tvocab_uri],
		tvocab_status=$array[tvocab_status],
		cuando=now(),
		uid=$user_id
		where tvocab_id='$tvocab_id'");
	 }
	 else
	 {
		 //actualiza solo datos consignados

		$array[tvocab_label]=$DB->qstr($_POST[tvocab_label]);
		$array[tvocab_tag]=$DB->qstr($_POST[tvocab_tag]);
		$array[tvocab_status]=$DB->qstr($_POST[tvocab_status]);

		$array[tvocab_label]=$DB->qstr($_POST[tvocab_label],get_magic_quotes_gpc());
		$array[tvocab_tag]=$DB->qstr($_POST[tvocab_tag],get_magic_quotes_gpc());
		$array[tvocab_status]=$DB->qstr($_POST[tvocab_status],get_magic_quotes_gpc());


		$sql=SQL("update","$DBCFG[DBprefix]tvocab set
		tvocab_label=$array[tvocab_label],
		tvocab_tag=$array[tvocab_tag],
		tvocab_status=$array[tvocab_status],
		cuando=now(),
		uid=$user_id
		where tvocab_id='$tvocab_id'");
	 }
	break;

	case 'B':
	//Eliminacion de un vocabulario de REFERENCIA

	//delete referenced terms from the service
	$sql=SQLo("delete","from $DBCFG[DBprefix]term2tterm where tvocab_id=?",array($tvocab_id));

	//delete referenced service
	$sql=SQLo("delete","from $DBCFG[DBprefix]tvocab where tvocab_id=?",array($tvocab_id));

	break;
	}

return array("tvocab_id"=>$tvocab_id);
};




function optimizarTablas(){

	GLOBAL $DBCFG;
	$sql=SQLoptimizarTablas("`$DBCFG[DBprefix]notas` , `$DBCFG[DBprefix]tabla_rel` , `$DBCFG[DBprefix]tema`,`$DBCFG[DBprefix]indice`,`$DBCFG[DBprefix]term2tterm`,`$DBCFG[DBprefix]tvocab`");

	$rows.='<div id="NA">';
	$rows.='<dl>';
	while($array=$sql->FetchRow()){
	$rows.='<dt>'.$array[Table].'</dt><dd> '.$array[Msg_text].'</dd>';
	}
	$rows.='</dl>';
	$rows.='</div>';

return $rows;
};






function updateTemaTres($ver2ver)
{

GLOBAL $install_message;


switch ($ver2ver) {
	case '1_6x1_7':
		$task=SQLupdateTemaTresVersion('1_6x1_7');
		$rows=($task["1_6x1_7"]!==0) ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>'.print_r($task);
	break;
	case '1_5x1_6':
		$task=SQLupdateTemaTresVersion('1_5x1_6');

		$rows=($task["1_5x1_6"]!==0) ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>'.print_r($task);
	break;
	case '1_4x1_5':
		$task=SQLupdateTemaTresVersion('1_4x1_5');

		$rows=($task["1_3x1_4"]!==0) ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>'.print_r($task);
	break;

	case '1_3x1_4':
		$task=SQLupdateTemaTresVersion('1_3x1_4');

		$rows=($task["$ver2ver"]=='0') ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>'.$task["$ver2ver"];
	break;


	case '1_1x1_2':
		$task=SQLupdateTemaTresVersion('1_1x1_2');

		$rows=($task["$ver2ver"]=='3') ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>';
	break;

	case '1x1_2':
		$task=SQLupdateTemaTresVersion('1x1_2');

		$rows=($task["$ver2ver"]=='5') ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>';
	break;

	default :

	break;
	}

return $rows;

}

}; // fin funciones de administracion



###########################################################################
##########  HTML DE GESTION #############################################
###########################################################################
#
# Armado de tabla de términos seg�n usuarios
#
function doBrowseTermsFromUser($user_id,$ord=""){

GLOBAL $MONTHS;

$sql=SQLlistTermsfromUser($user_id,$ord);

$rows.='<div class="table-responsive"> ';
$rows.='<table id="termaudit" class="table table-striped table-bordered table-condensed table-hover" summary="'.ucfirst(LABEL_auditoria).'">';

$rows.='<tbody>';
while($array=$sql->FetchRow()){
	$user_id=$array["id_usuario"];
	$apellido=$array["apellido"];
	$nombres=$array["nombres"];
	$fecha_termino=do_fecha($array["cuando"]);
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="index.php?tema='.$array["id_tema"].'" title="'.LABEL_verDetalle.LABEL_Termino.'">'.$array[tema].'</a></td>';
	$rows.='<td>'.$fecha_termino["dia"].' / '.$fecha_termino["descMes"].' / '.$fecha_termino["ano"].'</td>';
	$rows.='</tr>';
	};
$rows.='</tbody>';

$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="3"><a href="sobre.php">'.ucfirst(LABEL_auditoria).'</a> &middot; <a href="admin.php?user_id='.$user_id.'"  title="'.LABEL_verDetalle.$apellido.', '.$nombres.'">'.$apellido.', '.$nombres.'</a>: '.SQLcount($sql).' '.LABEL_Terminos.'.</th>';
$rows.='</tr>';

$rows.='<tr>';
$rows.='<th><a href="sobre.php?user_id='.$user_id.'&ord=T" title="'.LABEL_ordenar.' '.LABEL_Termino.'">'.ucfirst(LABEL_Termino).'</a></th>';
$rows.='<th><a href="sobre.php?user_id='.$user_id.'&ord=F" title="'.LABEL_ordenar.' '.LABEL_Fecha.'">'.ucfirst(LABEL_Fecha).'</a></th>';
$rows.='</tr>';
$rows.='</thead>';


$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td class="izq">'.ucfirst(LABEL_TotalTerminos).'</td>';
$rows.='<td>'.SQLcount($sql).'</td>';
$rows.='</tr>';
$rows.='</tfoot>';

$rows.='</table> </div>       ';
return $rows;
};


#
# Lista de usuarios
#
function HTMLListaUsers(){

$sqlListaUsers=SQLdatosUsuarios();

$rows.='<div class="table-responsive"> ';
$rows.='<table id="tableusers" class="table table-striped table-bordered table-condensed table-hover" summary="'.MENU_Usuarios.'">';

$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="4">'.MENU_Usuarios.' &middot; <a class="btn btn-primary btn-xs" href="admin.php?user_id=new" title="'.MENU_NuevoUsuario.'">'.MENU_NuevoUsuario.'</a></th>';
$rows.='</tr>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_apellido).', '.ucfirst(LABEL_nombre).'</th>';
$rows.='<th>'.ucfirst(LABEL_orga).'</th>';
$rows.='<th>'.ucfirst(LABEL_Fecha).'</th>';
$rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
$rows.='</tr>';
$rows.='</thead>';

$rows.='<tbody>';

while($listaUsers=$sqlListaUsers->FetchRow()){
	$fecha_alta=do_fecha($listaUsers[cuando]);
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="admin.php?user_id='.$listaUsers[id].'" title="'.LABEL_detallesUsuario.'">'.$listaUsers[apellido].', '.$listaUsers[nombres].'</a></td>';
	$rows.='<td class="izq">'.$listaUsers[orga].'</td>';
	$rows.='<td>'.$fecha_alta[dia].'-'.$fecha_alta[descMes].'-'.$fecha_alta[ano].' ('.arrayReplace(array("ACTIVO","BAJA"),array(LABEL_User_Habilitado,LABEL_User_NoHabilitado),$listaUsers[estado]). ')</td>';
	if($listaUsers[cant_terminos]>0){
		$rows.='<td><a href="sobre.php?user_id='.$listaUsers[id].'" title="'.LABEL_Detalle.'">'.$listaUsers[cant_terminos].'</a></td>';
		}else{
		$rows.='<td>'.$listaUsers[cant_terminos].'</td>';
		}
	$rows.='</tr>';
	};

$rows.='</tbody>';
$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td class="izq">'.ucfirst(LABEL_TotalUsuarios).'</td>';
$rows.='<td colspan="3">'.SQLcount($sqlListaUsers).'</td>';
$rows.='</tr>';
$rows.='</tfoot>';

$rows.='</table> </div>       ';

return $rows;
};


#
# lista de vocabularios
#
function HTMLlistaVocabularios(){

$sql=SQLdatosVocabulario(1);

$rows.='<div class="table-responsive"> ';
$rows.='<h3>'.ucfirst(LABEL_lcConfig).' </h3>';

$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.LABEL_lcConfig.'">';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_Titulo).'</th>';
$rows.='<th>'.ucfirst(LABEL_Autor).'</th>';
$rows.='<th>'.ucfirst(LABEL_tipo_vocabulario).'</th>';
$rows.='</tr>';
$rows.='</thead>';
$rows.='<tbody>';

while($array=$sql->FetchRow()){
	$fecha_alta=do_fecha($listaUsers[cuando]);
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="admin.php?vocabulario_id='.$array[vocabulario_id].'" title="'.MENU_DatosTesauro.' '.$array[titulo].'">'.$array[titulo].'</a> / '.$array[idioma].'</td>';
	$rows.='<td class="izq">'.$array[autor].'</td>';
	if($array[vocabulario_id]=='1'){
		$rows.='<td>'.LABEL_vocabulario_principal.'</td>';
		}else{
		$rows.='<td>'.LABEL_vocabulario_referencia.'</td>';
		}
	$rows.='</tr>';
	};

$rows.='</tbody>';
$rows.='</table>  </div>      ';

return $rows;
};

#
# lista de vocabularios
#
function HTMLlistaInternalTargetVocabularios(){

$sql=SQLinternalTargetVocabs();

$rows.='<div class="table-responsive"> ';
$rows.='<h3>'.ucfirst(LABEL_vocabulario_referencia).' ('.SQLcount($sql).') <a class="btn btn-primary btn-xs" href="admin.php?vocabulario_id=0" title="'.MENU_NuevoVocabularioReferencia.'">'.ucfirst(LABEL_Agregar.' '.LABEL_vocabulario_referencia).'</a></h3>';

if(SQLcount($sql)>0)	{

$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.LABEL_lcConfig.'">';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_Titulo).'</th>';
$rows.='<th>'.ucfirst(LABEL_Autor).'</th>';
$rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
$rows.='</tr>';
$rows.='</thead>';
$rows.='<tbody>';

while($array=$sql->FetchRow()){
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="admin.php?vocabulario_id='.$array["tvocab_id"].'" title="'.MENU_DatosTesauro.' '.$array["titulo"].'">'.$array["titulo"].'</a> / '.$array["idioma"].'</td>';
	$rows.='<td class="izq">'.$array["autor"].'</td>';
	$rows.='<td>'.$array["cant"].'</td>';
	$rows.='</tr>';
	};
$rows.='</tbody>';
$rows.='</table>';
}//fin if count
$rows.='  </div>      ';

return $rows;
};


#
# lista de vocabularios referidos v�a web services
#
function HTMLlistaTargetVocabularios(){

$sql=SQLtargetVocabulary("0");


$rows.='<div class="table-responsive"> ';
$rows.='<h3>'.ucfirst(LABEL_vocabulario_referenciaWS).' ('.SQLcount($sql).') <a class="btn btn-primary btn-xs" href="admin.php?tvocabulario_id=0&doAdmin=seeformTargetVocabulary" title="'.ucfirst(LABEL_addTargetVocabulary).'">'.ucfirst(LABEL_addTargetVocabulary).'</a></h3>';

if(SQLcount($sql)>0){
$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.LABEL_lcConfig.'">';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_tvocab_label).'</th>';
$rows.='<th>'.ucfirst(LABEL_Titulo).'</th>';
$rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
$rows.='</tr>';
$rows.='</thead>';
$rows.='<tbody>';

while($array=$sql->FetchRow()){
	$fecha_alta=do_fecha($listaUsers[cuando]);

	$label_tvocab_status=($array[tvocab_status]=='1') ? ucfirst(LABEL_enable) : ucfirst(LABEL_disable);

	$rows.='<tr>';
	$rows.='<td class="izq"><a href="admin.php?tvocab_id='.$array[tvocab_id].'&amp;doAdmin=seeformTargetVocabulary" title="'.MENU_DatosTesauro.' '.$array[tvocab_title].'">'.FixEncoding($array[tvocab_label]).'</a> ('.FixEncoding($array[tvocab_tag]).')</td>';
	$rows.='<td class="izq"><a href="'.$array[tvocab_url].'" title="'.LABEL_vocabulario_referenciaWS.' '.FixEncoding($array[tvocab_title]).'">'.FixEncoding($array[tvocab_title]).'</a></td>';

	//hay términos y esta habilitado
	if ($array[cant]>0)	{
		$rows.='<td><a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$array[tvocab_id].'">'.$label_tvocab_status.': '.$array[cant].'</a></td>';
	}
	$rows.='</tr>';
	};

$rows.='</tbody>';
$rows.='</table>        ';
}; //fin if count
$rows.='</div>        ';

return $rows;
};

#
# lista de términos de un vocabulario referido v�a web services
#
function HTMLlistaTermsTargetVocabularios($tvocab_id,$from="0"){

$ARRAYtargetVocabulary=ARRAYtargetVocabulary($tvocab_id);

$from=(is_numeric($from)) ? $from : '0';
$from=($from<$ARRAYtargetVocabulary[cant]) ? $from : '0';

if($ARRAYtargetVocabulary[cant]>20)
{
	$linkMore=($from<($ARRAYtargetVocabulary[cant]-20)) ? '<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.($from+20).'"> + 20</a>' : "";

	$linkLess=($from>0) ? '<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.($from-20).'"> - 20</a>' : "";

	$linkFirst= ($from>0) ? '<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f=0"><<</a> &middot; ' : "";

	$linkLast= ($from<($ARRAYtargetVocabulary[cant]-20)) ? ' &middot; <a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.($ARRAYtargetVocabulary[cant]-20).'">>></a>' : "";

	$next20= (($from+20)<$ARRAYtargetVocabulary[cant]) ? $from+20 :  $ARRAYtargetVocabulary[cant];

	$labelShow=($from>0) ? ' | '.$from.' - '.($next20).' | ' : $from.' - '.($next20).' | ';
};


$sql=SQLtargetTermsVocabulary($tvocab_id,$from);


$rows.='<tbody>';



while($array=$sql->FetchRow()){

	$last_term_update=($array[cuando_last]) ? $array[cuando_last] : $array[cuando];

	if($_GET["doAdmin2"]=='checkDateTermsTargetVocabulary')
	{
		$iUpd=0;

		$dataSimpleChkUpdateTterm=dataSimpleChkUpdateTterm("tematres",$array[tterm_uri]);
/*
		El término no existe m�s en el vocabulario de destino
*/
		if(!$dataSimpleChkUpdateTterm->result->term->tema_id)
		{
			$linkUpdateTterm["$array[tterm_uri]"].= '<ul class="errorNoImage">';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li><strong>'.ucfirst(LABEL_notFound).'</strong></li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '</ul>';
		}
/*
		hay actualizacion del término
*/
		elseif ($dataSimpleChkUpdateTterm->result->term->date_mod > $last_term_update)
		{
			$iUpd=++$iUpd;
			$ARRAYupdateTterm["$array[tterm_uri]"]["string"]=FixEncoding((string) $dataSimpleChkUpdateTterm->result->term->string);
			$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"]=$dataSimpleChkUpdateTterm->result->term->date_mod;

			$linkUpdateTterm["$array[tterm_uri]"].= '<ul class="warningNoImage">';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li><strong>'.$ARRAYupdateTterm["$array[tterm_uri]"]["string"].'</strong></li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>'.$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"].'</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tgetTerm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=updTgetTerm" title="'.ucfirst(LABEL_actualizar).'">'.ucfirst(LABEL_actualizar).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '</ul>';
		}

	}

	$rows.='<tr>';

	$rows.='<td class="izq"><a href="index.php?tema='.$array[tema_id].'" title="'.LABEL_verDetalle.' '.$array[tema].'">'.$array[tema].'</a></td>';
	$rows.='<td class="izq">';

	$rows.='<a href="'.$array[tterm_url].'" title="'.LABEL_verDetalle.' '.FixEncoding($array[tterm_string]).'" >'.FixEncoding($array[tterm_string]).'</a>';

	$rows.=' '.$linkUpdateTterm["$array[tterm_uri]"].'</td>';
	$rows.='<td class="izq">'.$last_term_update.'</td>';
	$rows.='</tr>';
	};

$rows.='</tbody>';

$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td class="izq" colspan="3">'.$ARRAYtargetVocabulary[cant].' '.FORM_LABEL_Terminos.': '.$linkFirst.$linkLess.' '.$labelShow.' '.$linkMore.$linkLast.' ';

if($ARRAYtargetVocabulary[cant]>0)
{
	$rows.='&middot;  <a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'">'.ucfirst(LABEL_ShowTargetTermsforUpdate).'</a>';
}


if(isset($iUpd))
{
	$rows.=': '.$iUpd.' '.LABEL_targetTermsforUpdate;
}

$rows.='</td>';
$rows.='</tr>';
$rows.='</tfoot>';
$rows.='</table> </div>       ';


$thead.='<div class="table-responsive"> ';
$thead.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.LABEL_lcConfig.'">';

$thead.='<thead>';
$thead.='<tr>';
$thead.='<th class="izq" colspan="3"><a href="admin.php" title="'.ucfirst(LABEL_lcConfig).'">'.ucfirst(LABEL_lcConfig).'</a> &middot; '.$ARRAYtargetVocabulary[tvocab_title].' &middot '.(($ARRAYtargetVocabulary["tvocab_status"]=='1') ? LABEL_enable : LABEL_disable).'</th>';
$thead.='</tr>';
$thead.='<tr>';
$thead.='<th class="izq" colspan="3">'.$ARRAYtargetVocabulary[cant].' '.FORM_LABEL_Terminos.': '.$linkFirst.$linkLess.' '.$labelShow.' '.$linkMore.$linkLast.' ';

if($ARRAYtargetVocabulary[cant]>0)
{
	$thead.='&middot;  <a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'">'.ucfirst(LABEL_ShowTargetTermsforUpdate).'</a>';
}

if(isset($iUpd))
{
	$thead.=': '.$iUpd.' '.LABEL_targetTermsforUpdate;
}

$thead.='</th>';
$thead.='</tr>';
$thead.='<tr>';
$thead.='<th>'.ucfirst(LABEL_Termino).'</th>';
$thead.='<th>'.ucfirst($ARRAYtargetVocabulary[tvocab_label]).'</th>';
$thead.='<th>'.ucfirst(LABEL_Fecha).'</th>';
$thead.='</tr>';
$thead.='</thead>';

$rows=$thead.$rows;

return $rows;
};


//
// Exportaciones totales del vocabularios
//

function doTotalZthes($tipoEnvio){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

switch($tipoEnvio){
	case 'line':
	$sql=SQLIdTerminosValidos();

		header ('content-type: text/xml');
		outputCosas('<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>');
		outputCosas('<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/xml/zthes-05.dtd">');
		outputCosas('<?xml-stylesheet href="http://'.$_SERVER['HTTP_HOST']. rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/../common/css/zthes.xsl" type="text/xsl"?>');
		outputCosas('        <Zthes>');

		while($array=$sql->FetchRow())
		{
			outputCosas(do_nodo_zthes($array[0],"TRUE"));
		};
		outputCosas('</Zthes>');

	break;

	#enviar como archivo  !!!no implementado!!!
	case 'file':

	$sql=SQLIdTerminosValidos();
	while($array=$sql->FetchRow()){

		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

		$zthes.=do_nodo_zthes($array[0],"TRUE");
	};

		$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
		$meta_tag.='<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/xml/zthes-05.dtd">';
		$meta_tag.='<Zthes>';
		$meta_tag.=$zthes;
		$meta_tag.='</Zthes>';

	$filname=string2url($_SESSION[CFGTitulo]).'.xml';
	return sendFile("$meta_tag","$filname");

	break;
	};

};

function doTotalMADS($tipoEnvio){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

switch($tipoEnvio){
	case 'line':
	break;

	#enviar como archivo  !!!no implementado!!!
	case 'file':

	$sql=SQLIdTerminosValidos();
	while($array=$sql->FetchRow()){

		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

		$mads_nodes.=do_nodo_mads($array[0],"TRUE");
	};

	$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$meta_tag.='<mads xmlns="http://www.loc.gov/mads/" xmlns:mods="http://www.loc.gov/mods/v3" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.loc.gov/mads/
	mads.xsd">';

	$meta_tag.=$mads_nodes;

	$meta_tag.='</mads>';

	$filname=string2url($_SESSION[CFGTitulo]).'.xml';
	return sendFile("$meta_tag","$filname");

	break;
	};

};


/*
 * Exportaci�n total seg�n esquema BS8723
*/
function doTotalBS8723($tipoEnvio){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

switch($tipoEnvio){
	#enviar como archivo
	case 'file':
	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$xml.='<Thesaurus
		xmlns="http://schemas.bs8723.org/XmlSchema/"
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:dcterms="http://purl.org/dc/terms/"
		xmlns:eGMS="http://www.govtalk.gov.uk/CM/gms"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://schemas.bs8723.org/XmlSchema/DD8723-5.xsd">';
	$xml.='	 <dc:identifier>'.$_URI_BASE_ID.'</dc:identifier>';
	$xml.='  <dc:title>'.xmlentities($_SESSION[CFGTitulo]).'</dc:title>';
	$xml.='  <dc:creator>'.xmlentities($_SESSION[CFGAutor]).'</dc:creator>';
	$xml.='  <dc:subject>'.xmlentities($_SESSION[CFGKeywords]).'</dc:subject>';
	$xml.='  <dc:description>'.xmlentities($_SESSION[CFGCobertura],true).'</dc:description>';
	$xml.='  <dc:publisher>'.xmlentities($_SESSION[CFGAutor]).'</dc:publisher>';
	$xml.='  <dc:date>'.xmlentities($_SESSION[CFGCreacion]).'</dc:date>';
	$xml.='  <dc:language>'.LANG.'</dc:language>';

	// consulta muy costosa
	//$sql=SQLIdTerminosValidos();

	// consulta menos costosa
	$sql=SQLIdTerminosIndice();

	while($array=$sql->FetchRow())
	{

		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

		$xml.=do_nodo_BS8723($array[0],"TRUE");
	}

	$xml.='</Thesaurus>';


	$filname=string2url($_SESSION[CFGTitulo]).'_BS8723.xml';

	sendFile("$xml","$filname");
	break;
	};

};



function doTotalSkos($tipoEnvio,$params=array()){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

switch($tipoEnvio){
	case 'line':

	# Top term del esquema
	$sqlTT=SQLverTopTerm();
	while ($arrayTT=$sqlTT->FetchRow())
	{
		$skos_TT.='<skos:hasTopConcept rdf:nodeID="tema'.$arrayTT[id].'"/>';
	};

		header ('content-type: text/xml');
		outputCosas('<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>');
		outputCosas('<rdf:RDF');
		outputCosas('        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"');
		outputCosas('        xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"');
		outputCosas('        xmlns:skos="http://www.w3.org/2004/02/skos/core#"');
		outputCosas('        xmlns:dct="http://purl.org/dc/terms/"');
		outputCosas('        xmlns:dc="http://purl.org/dc/elements/1.1/">');
		outputCosas('<skos:ConceptScheme rdf:nodeID="tematres">');
		outputCosas('     <dc:title>'.$_SESSION[CFGTitulo].'</dc:title>');
		outputCosas('     <dc:creator>'.$_SESSION[CFGAutor].'</dc:creator>');
		outputCosas('     <dc:subject>'.$_SESSION[CFGKeywords].'</dc:subject>');
		outputCosas('     <dc:description>'.$_SESSION[CFGCobertura].'</dc:description>');
		outputCosas('     <dc:publisher>'.$_SESSION[CFGAutor].'</dc:publisher>');
		outputCosas('     <dc:date>'.$_SESSION[CFGCreacion].'</dc:date>');
		outputCosas('     <dc:language>'.LANG.'</dc:language>');
		outputCosas($skos_TT);
		outputCosas('</skos:ConceptScheme>');

$sql=SQLIdTerminosValidos();

while($array=$sql->FetchRow())
	{
	outputCosas(do_nodo_skos($array[0]));
	};

outputCosas('</rdf:RDF>');
break;

#enviar como archivo  !!!no implementado!!!
case 'file':


	if($params["hasTopTerm"]>0)
	{
		$skosNodos.=do_nodo_skos($params["hasTopTerm"]);
		$sql=SQLlistaTemas($params["hasTopTerm"]);
	}
	else
	{
		$sql=SQLIdTerminosValidos();
	}


	while($array=$sql->FetchRow()){

	#Mantener vivo el navegador
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	$skosNodos.=do_nodo_skos($array[0]);
	};

	$meta_tag=do_skos($skosNodos,true);

	$filname=string2url($_SESSION[CFGTitulo]).'.rdf';
	return sendFile("$meta_tag","$filname");
	break;
	};

};



function doTotalMoodle($params=array()){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

 $sql=SQLIdTerminosValidos();

	while($array=$sql->FetchRow()){

		#Mantener vivo el navegador
		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

		$moodleNodos.=do_nodo_moodle($array[0]);
	};

	$composeMoodle=do_moodle($moodleNodos);

	$filename=string2url($_SESSION["CFGTitulo"]).'.xml';

	return sendFile($composeMoodle,$filename);
};



function doTotalTopicMap($tipoEnvio){

$time_start = time();

@set_time_limit(900);

GLOBAL $CFG;

switch($tipoEnvio){
	case 'line':
	$sql=SQLIdTerminosValidos();

	header ('content-type: text/xml');
	outputCosas('<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>');
	outputCosas(XTMheader);
	outputCosas(doTerminosXTM());
	outputCosas(doRelacionesXTM());
	outputCosas('</topicMap>');
	break;

	#enviar como archivo
	case 'file':
	header ('content-type: text/xml');
	$row.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$row.=XTMheader;

	$rowTerminos=doTerminosXTM($tema_id);
	$rowRelaciones=doRelacionesXTM($tema_id);
	$rowFinal='</topicMap>';

	$rows=$row.$rowTerminos.$rowRelaciones.$rowFinal;

	$filname=string2url($_SESSION[CFGTitulo]).'.xtm';
	sendFile("$rows","$filname");
	break;
	};

};




function doTotalVDEX($tipoEnvio='file'){

$time_start = time();

@set_time_limit(900);

	#enviar como archivo
GLOBAL $CFG;

$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	header ('content-type: text/xml');
	$row.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>
			<vdex xmlns="http://www.imsglobal.org/xsd/imsvdex_v1p0" orderSignificant="false" language="'.$_SESSION["CFGIdioma"].'">
    		<vocabIdentifier>'.$_URI_BASE_ID.'</vocabIdentifier>';

	$rowTerminos=doTerminosVDEX($tema_id);
	$rowRelaciones=doRelacionesVDEX($tema_id);
	$rowFinal='</vdex>';

	$rows=$row.$rowTerminos.$rowRelaciones.$rowFinal;

	$filname=string2url($_SESSION[CFGTitulo]).'.vdex';
	sendFile("$rows","$filname");

};




#
# Armado de salida SiteMap Google
#
function do_sitemap(){

$time_start = time();
@set_time_limit(900);

header ('content-type: text/xml');
$rows='<?xml version="1.0" encoding="UTF-8"?>';
$rows.='<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';


// consulta muy costosa
//$sql=SQLIdTerminosValidos();

$sql=SQLIdTerminosIndice();

while ($array=$sql->FetchRow()){

	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	($array[cuando_final]>0) ? $fecha = do_fecha($array[cuando_final]) : $fecha = do_fecha($array[cuando]);


	//valores posibles para prioridad
    $priority_values=array("0.0", "0.1", "0.2", "0.3", "0.4", "0.5", "0.6", "0.7", "0.8", "0.9", "1.0");

    $term_distance=substr_count($array[indice],'|');

	//C�lculo de prioridad
	$priority=($term_distance<='10') ? $priority_values[$term_distance] : $priority_values[10];

	$rows.='<url>';
	$rows.='    <loc>'.$_SESSION[CFGURL].'?tema='.$array[id].'</loc>';
	$rows.='    <lastmod>'.$fecha[ano].'-'.$fecha[mes].'-'.$fecha[dia].'</lastmod>';
	$rows.='    <changefreq>weekly</changefreq>';
	$rows.='    <priority>0.7</priority>';
	$rows.='</url>';
	};
$rows.=' </urlset>';

$filname=string2url($_SESSION[CFGTitulo]).'_sitemap.xml';
sendFile("$rows","$filname");
};


function doTotalWXR($tipoEnvio='file'){

    header ('content-type: text/xml');
    $rows='<?xml version="1.0" encoding="UTF-8" ?>
	<!-- generator="'.$_SESSION["CFGVersion"].'" created="'.date("Y m d H:i:s").'" -->
	<rss version="2.0"
			xmlns:dc="http://purl.org/dc/elements/1.1/"
			xmlns:wp="http://wordpress.org/export/1.1/"
	>

	<channel>
        <title>'.xmlentities($_SESSION["CFGTitulo"]).'</title>
        <link>'.$_SESSION["CFGURL"].'</link>
        <description>'.xmlentities($_SESSION[CFGCobertura]).'</description>
        <pubDate>'.date('D, d M Y H:i:s T').'</pubDate>
        <language>'.$_SESSION[CFGIdioma].'</language>
        <wp:wxr_version>1.1</wp:wxr_version>';

	$sql=SQLverTopTerm();

	while($arrayTema=$sql->FetchRow())
	{

		#Mantener vivo el navegador
		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

			$rows.='<wp:category>
					<wp:term_id>'.$arrayTema[id].'</wp:term_id>
					<wp:category_nicename>'.xmlentities(strtolower($arrayTema[tema])).'</wp:category_nicename>
					<wp:cat_name><![CDATA['.xmlentities($arrayTema[tema]).']]></wp:cat_name>
			</wp:category>';


			$rows.=WXRverTE($arrayTema[id],$arrayTema);
    };

    $rows.='<generator>'.$_SESSION["CFGURL"].'</generator>
	</channel>
	</rss>';

    $filname=string2url($_SESSION[CFGTitulo]).'_wxr.xml';

    sendFile("$rows","$filname");
}


//do nodes for WXR export format
function WXRverTE($tema_id,$parent_category){

	GLOBAL $CFG;
	$sql=SQLverTerminosE($tema_id);
	while($array=$sql->FetchRow())
	{
		//si tiene TEs
		if($array[id_te]){
			$rows.='<wp:category>
						<wp:term_id>'.$array[id_tema].'</wp:term_id>
						<wp:category_nicename>'.xmlentities(strtolower($array[tema])).'</wp:category_nicename>
						<wp:category_parent>'.xmlentities(strtolower($parent_category[tema])).'</wp:category_parent>
						<wp:cat_name><![CDATA['.xmlentities($array[tema]).']]></wp:cat_name>
					</wp:category>';

			$rows.=WXRverTE($array[id_tema],$array);

		}else{
			$rows.='<wp:category>
						<wp:term_id>'.$array[id_tema].'</wp:term_id>
						<wp:category_nicename>'.xmlentities(strtolower($array[tema])).'</wp:category_nicename>
						<wp:category_parent>'.xmlentities(strtolower($parent_category[tema])).'</wp:category_parent>
						<wp:cat_name><![CDATA['.xmlentities($array[tema]).']]></wp:cat_name>
					</wp:category>';
		};
	};

return $rows;
};


function txtAlfabetico($params=array()){

GLOBAL $CFG;

$txt=ucfirst(LABEL_Titulo).': '.$_SESSION["CFGTitulo"]."\r\n";
$txt.=ucfirst(LABEL_Autor).': '.$_SESSION["CFGAutor"]."\r\n";
$txt.=ucfirst(LABEL_Keywords).': '.$_SESSION["CFGKeywords"]."\r\n";
$txt.=ucfirst(LABEL_Cobertura).': '.$_SESSION["CFGCobertura"]."\r\n";
$txt.=LABEL_URI.': '.$_SESSION["CFGURL"]."\r\n";
$txt.=ucfirst(LABEL_Version).': '.$_SESSION["CFGVersion"]."\r\n";
$txt.="__________________________________________________________________________\r\n";

//Lista de todos los términos
$sql=SQLlistaTemas($params["hasTopTerm"]);


if($params["hasTopTerm"]>0){
	$txt.=txt4term($params["hasTopTerm"],$params);
}


while($arrayTema=$sql->FetchRow()){

	#Mantener vivo el navegador
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	// Diferenciar entre términos preferidos y términos no preferidos o referencias
	if($arrayTema["t_relacion"])// Si es no preferido o refencia: mostrar preferido y referido
	{
		//Remisiones de equivalencias y no preferidos
		$sqlNoPreferidos=SQLterminosValidosUF($arrayTema[id]);
		while($arrayNoPreferidos=$sqlNoPreferidos->FetchRow()){

		$acronimo=arrayReplace ( array("4","5","6","7"),array(USE_termino,EQP_acronimo,EQ_acronimo,NEQ_acronimo),$arrayNoPreferidos["t_relacion"]);

		$referencia_mapeo = ($arrayNoPreferidos["vocabulario_id"]!=='1') ? ' ('.$arrayNoPreferidos["titulo"].')' : ''."\r\n";

		$txt.="\n".$arrayTema["tema"] . $referencia_mapeo."\n";
		$txt.='	'.$acronimo.$arrayNoPreferidos["rr_code"].': '.$arrayNoPreferidos["tema_pref"]."\r\n";
		};


	}	else	{
	// Si es preferido: mostar notas y relaciones
	$txt.="\n".$arrayTema["tema"]."\r\n";

	//show code
	$txt.=(($CFG["_SHOW_CODE"]==1) && (strlen($arrayTema["code"])>0)) ? '	'.ucfirst(LABEL_CODE).': '.$arrayTema["code"]."\r\n" : "";


	$label_target_vocabulary='';


	$txt.=($params["includeCreatedDate"]==1) ? LABEL_fecha_creacion.': '.$arrayTema[cuando]."\r\n" : '';

	if(($arrayTema[cuando_final]>$arrayTema[cuando]) && ($params["includeModDate"]==1))	{$txt.=LABEL_fecha_modificacion.': '.$arrayTema[cuando_final]."\r\n";};


	if($params["includeTopTerm"]==1){
		$arrayMyTT=ARRAYmyTopTerm($arrayTema[id]);
		$txt.=($arrayMyTT["tema_id"]!==$arrayTema[id]) ? '	TT: '.$arrayMyTT["tema"]."\r\n" : '';
	}


	//include or not notes
	if(is_array($params["includeNote"])){
		//Notas
		$sqlNotas=SQLdatosTerminoNotas($arrayTema[id]);

			while($arrayNotas=$sqlNotas->FetchRow()){

				$arrayNotas[label_tipo_nota]=(in_array($arrayNotas[ntype_id],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$arrayNotas[ntype_id]) : $arrayNotas[ntype_code];

				if(($arrayNotas[tipo_nota]!=='NP') && (in_array($arrayNotas[tipo_nota], $params["includeNote"]))){
					$txt.='	'.$arrayNotas[label_tipo_nota].': '.html2txt($arrayNotas[nota])."\r\n";
				}
			};
	}


	//Relaciones
    #Fetch data about associated terms (BT,RT,UF)
    //Relaciones
    $sqlRelaciones=SQLdirectTerms($arrayTema["id"]);

    $arrayRelacionesVisibles=array(2,3,4,5,6,7); // TG/TE/UP/TR

    while($arrayRelaciones=$sqlRelaciones->FetchRow()){

        $acronimo=arrayReplace ( $arrayRelacionesVisibles,array(TR_acronimo,TG_acronimo,UP_acronimo,EQP_acronimo,EQ_acronimo,NEQ_acronimo),$arrayRelaciones["t_relacion"]);

        if($arrayRelaciones["t_relacion"]==4){
            # is UF and not hidden UF
            if (!in_array($arrayRelaciones["rr_code"],$CFG["HIDDEN_EQ"])){
				$txt.='	'.UP_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["uf_tema"]."\r\n";
            }
        }

        if($arrayRelaciones["t_relacion"]==3){
            if($arrayRelaciones["bt_tema"]){
				$txt.='	'.TG_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["bt_tema"]."\r\n";
            }
            if($arrayRelaciones["nt_tema"]){
				$txt.='	'.TE_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["nt_tema"]."\r\n";
                }
         }

            if($arrayRelaciones["t_relacion"]==2){
            if($arrayRelaciones["rt_tema"]){
				$txt.='	'.TR_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["rt_tema"]."\r\n";
                }
            }
    }


    //internal target terms
    $SQLiTargetTerms=SQLtermsInternalMapped($arrayTema["id"]);

    while($ARRAYiTargetTerms=$SQLiTargetTerms->FetchRow()){
        $acronimoTterm=arrayReplace (array(5,6,7),array(EQP_acronimo,EQ_acronimo,NEQ_acronimo),$ARRAYiTargetTerms["t_relacion"]);
		$txt.='	'.$acronimoTterm.': '.$ARRAYiTargetTerms["tema"].' ('.$ARRAYiTargetTerms["titulo"].') '."\r\n";
    };

	$txt.=$label_target_vocabulary;
	//Terminos equivalentes web services
	$SQLtargetTerms=SQLtargetTerms($arrayTema["id"]);
	while($arrayTT=$SQLtargetTerms->FetchRow()){
			$txt.='	'.FixEncoding(ucfirst($arrayTT[tvocab_label])).': '.FixEncoding($arrayTT[tterm_string])."\r\n";
		};


	}
}

$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaAbc).'.txt';

return sendFile("$txt","$filname");
};




//Create txt node for one term
function txt4term($tema_id,$params=array())
{

	$arrayTema=ARRAYverTerminoBasico($tema_id);

	$txt.="\n".$arrayTema[tema]."\r\n";

	$label_target_vocabulary='';

	$txt.=($params["includeCreatedDate"]==1) ? LABEL_fecha_creacion.': '.$arrayTema[cuando]."\r\n" : '';

	if(($arrayTema[cuando_final]>$arrayTema[cuando]) && ($params["includeModDate"]==1))	{$txt.=LABEL_fecha_modificacion.': '.$arrayTema[cuando_final]."\r\n";};

	//Notas
	$sqlNotas=SQLdatosTerminoNotas($arrayTema[tema_id]);

		while($arrayNotas=$sqlNotas->FetchRow())
		{

			$arrayNotas[label_tipo_nota]=(in_array($arrayNotas[ntype_id],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$arrayNotas[ntype_id]) : $arrayNotas[ntype_code];

			if(($arrayNotas[tipo_nota]!=='NP') && (in_array($arrayNotas[tipo_nota], $params["includeNote"])))
			{
				$txt.='	'.$arrayNotas[label_tipo_nota].': '.html2txt($arrayNotas[nota])."\r\n";
			}
		};

    #Fetch data about associated terms (BT,RT,UF)
    //Relaciones
    $sqlRelaciones=SQLdirectTerms($arrayTema["tema_id"]);

    $arrayRelacionesVisibles=array(2,3,4,5,6,7); // TG/TE/UP/TR

    while($arrayRelaciones=$sqlRelaciones->FetchRow()){

        if($arrayRelaciones["t_relacion"]==4){
            # is UF and not hidden UF
            if (!in_array($arrayRelaciones["rr_code"],$CFG["HIDDEN_EQ"])){
				$txt.='	'.UP_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["uf_tema"]."\r\n";
            }
        }

        if($arrayRelaciones["t_relacion"]==3){
            if($arrayRelaciones["bt_tema"]){
				$txt.='	'.TG_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["bt_tema"]."\r\n";
            }

            if($arrayRelaciones["nt_tema"]){
				$txt.='	'.TE_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["nt_tema"]."\r\n";
                }
         }
            if($arrayRelaciones["t_relacion"]==2){
            if($arrayRelaciones["rt_tema"]){
				$txt.='	'.TR_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["rt_tema"]."\r\n";
                }
            }
    }

    //internal target terms
    $SQLiTargetTerms=SQLtermsInternalMapped($arrayTema["tema_id"]);

    while($ARRAYiTargetTerms=$SQLiTargetTerms->FetchRow()){
        $acronimoTterm=arrayReplace (array(5,6,7),array(EQP_acronimo,EQ_acronimo,NEQ_acronimo),$ARRAYiTargetTerms["t_relacion"]);
		$txt.='	'.$acronimoTterm.': '.$ARRAYiTargetTerms["tema"].' ('.$ARRAYiTargetTerms["titulo"].') '."\r\n";
    };

	$txt.=$label_target_vocabulary;

	//Terminos equivalentes web services
	$SQLtargetTerms=SQLtargetTerms($arrayTema["tema_id"]);
	while($arrayTT=$SQLtargetTerms->FetchRow())
		{
			$txt.='	'.FixEncoding(ucfirst($arrayTT[tvocab_label])).': '.FixEncoding($arrayTT[tterm_string])."\r\n";
		};


		return $txt;
}

function txtJerarquico(){

$txt=ucfirst(LABEL_Titulo).': '.$_SESSION["CFGTitulo"]."\r\n";
$txt.=ucfirst(LABEL_Autor).': '.$_SESSION["CFGAutor"]."\r\n";
$txt.=ucfirst(LABEL_Keywords).': '.$_SESSION["CFGKeywords"]."\r\n";
$txt.=ucfirst(LABEL_Cobertura).': '.$_SESSION["CFGCobertura"]."\r\n";
$txt.=LABEL_URI.': '.$_SESSION["CFGURL"]."\r\n";
$txt.=ucfirst(LABEL_Version).': '.$_SESSION["CFGVersion"]."\r\n";
$txt.="__________________________________________________________________________\r\n";

//Lista de términos topes
$sql=SQLverTopTerm();

while($arrayTema=$sql->FetchRow()){

#Mantener vivo el navegador
$time_now = time();
if ($time_start >= $time_now + 10) {
	$time_start = $time_now;
	header('X-pmaPing: Pong');
};
// es preferido

// $txt.="\n".$arrayTema[tema]."\r\n";
$txt.=$arrayTema[tema]."\r\n";
//Terminos especificos
$txt.=TXTverTE($arrayTema[id],"0");
}

$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaSis).'.txt';

return sendFile("$txt","$filname");
};


function TXTverTE($tema_id,$i_profundidad){

GLOBAL $CFG;
$i_profundidad=++$i_profundidad;

$sql=SQLverTerminosE($tema_id);

//Contador de profundidad de TE desde la ra�z
	while($array=$sql->FetchRow()){
		//calculo de sangría
		$sangria='';
		for($i="1"; $i<="$i_profundidad"; ++$i){
			$sangria.=' .'."\t";
			};

		//si tiene TEs
		if($array[id_te]){
			$txt.=$sangria.$array[tema]."\r\n";
			$txt.=TXTverTE($array[id_tema],$i_profundidad);
		}else{
		$txt.=$sangria.$array[tema]."\r\n";
		};
	};
	return $txt;
};



/*
 * Backup tematres tables
 * inspired by http://davidwalsh.name/backup-mysql-database-php
 * */
function do_mysql_dump($encode="utf8")
{
	GLOBAL $DBCFG;

	$tables= $DBCFG[DBprefix].'config,'.$DBCFG[DBprefix].'tema,'.$DBCFG[DBprefix].'tabla_rel,'.$DBCFG[DBprefix].'indice,'.$DBCFG[DBprefix].'usuario,'.$DBCFG[DBprefix].'notas,'.$DBCFG[DBprefix].'values,'.$DBCFG[DBprefix].'tvocab,'.$DBCFG[DBprefix].'term2tterm,'.$DBCFG[DBprefix].'uri';

	/*
	 * To UTF-8 databases
	*/
	if($encode=='utf8'){
		$setUTF=SQL("SET NAMES","utf8");
		$setUTF1=SQL("SET CHARACTER SET","utf8");
	}
	//get  the tables
		$tables =  explode(',',$tables);

	//cycle through
	foreach($tables as $table){
		$result = SQL('SELECT',' * FROM '.$table);
		$num_fields = $result->_numOfFields;


		$return.= 'DROP TABLE IF EXISTS '.$table.'; ';
		$row2query = SQL('SHOW CREATE TABLE', $table);
		$row2data=$row2query->FetchRow();

		$return.= "\n\n".$row2data["Create Table"].";\n\n";

		for ($i = 0; $i < $num_fields; $i++)
		{
			while($row = $result->FetchRow())
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++)
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = $data = arrayReplace ( array("\n"), array("\\n"),$row[$j]);


					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}

	sendFile($return,string2url('TemaTres-'.$_SESSION[CFGTitulo]).'.sql');
}


/*
User note editor. Create and edit uset definition notes
*/
function abm_userNotes($do,$array,$value_id="0")
{
	GLOBAL $DBCFG;
	GLOBAL $DB;

	$array["value"]=$DB->qstr(trim($array["value"]),get_magic_quotes_gpc());
	$array["alias"]=$DB->qstr(trim($array["alias"]),get_magic_quotes_gpc());
	$array["orden"]=secure_data(trim($array["orden"]),"int");


	switch ($do)
	{
		case 'A':
		if(strlen($array["value"])>0)
			{
			//default type no is scope note
			$array["alias"]= (strlen($array["alias"])>0) ? $array["alias"] : 'NA';
			//default order 10
			$array["orden"]= ($array["orden"]>0) ? $array["orden"] : '10' ;

			$sql=SQL("insert","into $DBCFG[DBprefix]values
				(value_type, value, value_order, value_code)
				values
				('t_nota',$array[value],'$array[orden]',$array[alias])
				");
			$value_id=$sql[cant];
			}

		break;

		case 'M':

		$value_id=secure_data($value_id,"int");

		if((strlen($array["value"])>0) // must be  string
			&& (!in_array($value_id,array(8,9,10,11,15))) // not can be SYSTEM default notes
			&& ($value_id>0) // must be int
			)
			{
			//default type no is scope note
			$array["alias"]= (strlen($array["alias"])>0) ? $array["alias"] : 'NA';
			//default order 10
			$array["orden"]= ($array["orden"]>0) ? $array["orden"] : '10' ;

			$sql=SQL("update"," $DBCFG[DBprefix]values
				set value=$array[value],
				value_order='$array[orden]',
				value_code=$array[alias]
				where value_id='$value_id'
				and value_type='t_nota'
				");
			};
		break;

		case 'B':

		$value_id=secure_data($value_id,"int");

		if((!in_array($value_id,array(8,9,10,11,15))) // not can be SYSTEM default notes
			&& ($value_id>0) // must be int
			)
			{
			$sql=SQL("delete"," from $DBCFG[DBprefix]values
				where value_id='$value_id'
				and value_type='t_nota'");
			$sql=array();
			};


		break;

	}


	return array("cant"=>$sql[cant],
				 "value_id"=>$value_id
				);

}


/*
User relations editor. Create and edit user define relations
*/
function abm_userRelations($do,$array,$value_id="0")
{
	GLOBAL $DBCFG;

	$array["rr_value"]=secure_data($array["rr_value"],"ADOsql");
	$array["rr_code"]=secure_data($array["rr_code"],"ADOsql");
	//$array["rel_id"]=secure_data(trim($array["rel_id"]),"int");
	$array["t_relacion"]=(in_array($array["t_relacion"],array(2,3,4))) ? $array["t_relacion"] : '0';


	//Default value (RT|some relation)
	$array["rr_value"]=(strlen($array["rr_value"])>0) ? $array["rr_value"] : 'some relation';
	$array["rr_code"]=(strlen($array["rr_code"])>0) ? $array["rr_code"] : 'S';
	$array["rr_ord"]=	secure_data(trim($array["rr_ord"]),"int");


	//If MOD or DEL => get relation data
	if($value_id>0)
	{
		$value_id=secure_data($value_id,"int");
		$sqlDataRelation=SQLtypeRelations(0,$value_id,true);
		$arrayDataRelation=$sqlDataRelation->FetchRow();
		$array["t_relacion"]=$arrayDataRelation[t_relation];
	}
	if(in_array($array["t_relacion"],array(2,3,4)))
	{

		switch ($do)
		{
			case 'A':
				$sql=SQL("insert","into $DBCFG[DBprefix]values
					(value_type, value,value_order, value_code)
					values
					('$array[t_relacion]',$array[rr_value],$array[rr_ord],$array[rr_code])
					");
				$value_id=$sql[cant];
			break;

			case 'M':

			$sql=SQL("update"," $DBCFG[DBprefix]values
					set value=$array[rr_value],
					value_order=$array[rr_ord],
					value_code=$array[rr_code]
					where value_id='$arrayDataRelation[rel_rel_id]'");
			break;

			case 'B':

			if($arrayDataRelation[cant]==0)
				{

				$sql=SQL("delete"," from $DBCFG[DBprefix]values
					where value_id='$arrayDataRelation[rel_rel_id]'");
				$sql=array();
				};


			break;

			}
		}

	return array("cant"=>$sql[cant],
				 "value_id"=>$value_id
				);

}


/*
create/delete/mod to External URI definition
*/
function abm_URIdefinition($do,$array,$value_id="0")
{
	GLOBAL $DBCFG;
	GLOBAL $DB;

	$array["uri_value"]=$DB->qstr(trim($array["uri_value"]),get_magic_quotes_gpc());
	$array["uri_code"]=$DB->qstr(trim($array["uri_code"]),get_magic_quotes_gpc());


	//If MOD or DEL => get relation data
	if($value_id>0)	{
		$value_id=secure_data($value_id,"int");
		$sqlURIdefinition=SQLURIdefinition($value_id);
		$arrayURIdefinition=$sqlURIdefinition->FetchRow();
	}

	switch ($do)	{
		case 'A':
			$sql=SQL("insert","into $DBCFG[DBprefix]values
				(value_type, value, value_code)
				values
				('URI_TYPE',$array[uri_value],$array[uri_code])
				");
			$value_id=$sql[cant];
		break;

		case 'M':

		$sql=SQL("update"," $DBCFG[DBprefix]values
				set value=$array[uri_value],
				value_code=$array[uri_code]
				where value_id='$arrayURIdefinition[uri_type_id]'");
		break;

		case 'B':

		if($arrayURIdefinition[cant]==0)
			{

			$sql=SQL("delete"," from $DBCFG[DBprefix]values
				where value_id='$arrayURIdefinition[uri_type_id]'");
			$sql=array();
			};


		break;

		}

	return array("cant"=>$sql[cant],
				 "value_id"=>$value_id
				);

}

/*
update config values
*/
function ABM_value($do,$arrayValue)
{
	GLOBAL $DBCFG;
	GLOBAL $DB;
	GLOBAL $CFG;


	$arrayValue["value_code"]=$DB->qstr(trim($arrayValue["value_code"]),get_magic_quotes_gpc());

	$arrayValue["value"]=$DB->qstr(trim($arrayValue["value"]),get_magic_quotes_gpc());

	$arrayValues["value_type"]=(in_array($arrayValues["value_type"],$CFG["CONFIG_VAR"])) ? $arrayValues["value_type"]  : '';

	switch ($do) {
		case 'MOD_VALUE':
		$sql=SQL("update","$DBCFG[DBprefix]values
				set value=$arrayValue[value]
				where value_type='$arrayValue[value_type]'
				and value_code=$arrayValue[value_code]");
		break;

		case 'MOD_SINGLE_VALUE':
		$sql=SQL("update","$DBCFG[DBprefix]values
				set value=$arrayValue[value]
				where value_type='$arrayValue[value_type]'
				");
		break;

		case 'ADD_VALUE':

		$sql=SQL("insert","into `".$DBCFG[DBprefix]."values` (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('$arrayValue[value_type]', $arrayValue[value], NULL, $arrayValue[value_code])");

		break;
	}

	return $arrayValues;
}



/*
alta y baja de relaciones de usuario
*/

function abm_rel_rel($do,$rel_id,$rel_type_id)
{

	GLOBAL $DBCFG;

	//sanitize
	$rel_id=secure_data($rel_id,"int");
	$rel_type_id=secure_data($rel_type_id,"int");

	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

	switch ($do)
		{
		case 'ALTA':
			//check if the type relation exist
			$ARRAYdataRelation=ARRAYdataRelation($rel_id);

			$ARRAYtypeRelations=ARRAYtypeRelations($ARRAYdataRelation["t_relacion"],$rel_type_id);

			if(count($ARRAYtypeRelations["$ARRAYdataRelation[t_relacion]"])=='1'){

				$sql=SQL("update"," $DBCFG[DBprefix]tabla_rel set rel_rel_id='$rel_type_id', cuando=now(),uid='$userId' where id='$rel_id'");
			}

		break;

		case 'BAJA':

			$sql=SQL("update"," $DBCFG[DBprefix]tabla_rel set rel_rel_id=NULL, cuando=now(),uid='$userId' where id='$rel_id'");
		break;

		default:
		}
return array("rel_id"=>$rel_id);
}



//View notes type and edit/create/delete user-defined notes
function HTMLformUserNotes(){


	//ALTA
	if ($_POST['value']!='' and $_POST['orden']!='' and $_POST['alias']!='' and $_POST['doAdmin']=='' ) {

		$arrayValues=array("value"=>$_POST['value'],
						   "orden"=>$_POST['orden'],
						   "alias"=>$_POST['alias']);

		$task=abm_userNotes("A",$arrayValues);
		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";
	}

	//MOD
	if ($_POST['doAdmin']=='modUserNotes' ) {

		$arrayValues=array("value"=>$_POST['value'],
							"orden"=>$_POST['orden'],
							"alias"=>$_POST['alias']);
		$task=abm_userNotes("M",$arrayValues,$_POST['valueid']);
		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";

		$_POST['value']='';
		$_POST['orden']='';
		$_POST['alias']='';
		$_POST['ac']='';
	}

	//BAJA
	if ($_POST['doAdmin']=='deleteUserNotes' ) {
		$task=abm_userNotes("B",array(),$_POST['value']);
		 }

	$sql=SQLcantNotas();

	$rows.='<form id="morenotas" name="morenotas" method="POST" action="admin.php?vocabulario_id=list#morenotas">';
	$rows.='<input type="hidden" name="doAdmin" id="doAdmin" value="">  ';
	$rows.=' <input type="hidden" name="valueid" id="valueid"> ';

	$rows.='<div class="table-responsive"> ';
	$rows.='<h3>'.ucfirst(LABEL_configTypeNotes).' </h3>';
	$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.ucfirst(LABEL_configTypeNotes).'">';
	$rows.='<thead>';
	$rows.='<tr>';
	$rows.=' <th>'.ucfirst(LABEL_tipoNota).'</th>';
	$rows.= '<th>'.ucfirst(alias).':</th>';
	$rows.= '<th>'.ucfirst(orden).'</th>';
	$rows.= '<th></th>';
	$rows.= '</tr>';

	$rows.='<tr>';

	$rows.='<th class="izq"><input type="text" name="value" id="value"/></td>';
	$rows.='<th class="izq"><input type="text" name="alias" size="2" id="alias"/></td>';
	$rows.='<th class="izq"><input type="text" name="orden" size="2"  id="orden"/></td>';
	$rows.='<th><a onclick="envianota()" href="#"><strong>'.ucfirst(LABEL_Enviar).'</strong></a></td>';
	$rows.='</tr>';

	$rows.=' </thead>';
	$rows.=' <tbody>';

	while ($array=$sql->FetchRow()){
		$i=++$i;
		if(in_array($array["value_id"],array(8,9,10,11,15))) // not can be SYSTEM default notes
		{
			$array["value"]=(in_array($array["value_id"],array(8,9,10,11))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$array["value_id"]) : $array["value"];
			$rows.='<tr>';
			$rows.=' <td class="izq">'.$array["value"].'</a></td>';
			$rows.= '<td>'.$array["value_code"].'</td>';
			$rows.= '<td>'.$array["value_order"].'</td>';
			$rows.= '<td>'.$array["cant"].' '.LABEL_notes.'</td>';
			$rows.= '</tr>';
		}
		else
		{
			$rows.='<tr>';
			$rows.=' <td class="izq"><a title="'.$array["value"].'"  href="javascript:recargaedit(\''.$array["value"].'\',\''.$array["value_order"].'\',\''.$array["value_code"].'\',\''.$array["value_id"].'\')">'.$array["value"].'</a></td>';
			$rows.= '<td>'.$array["value_code"].'</td>';
			$rows.= '<td>'.$array["value_order"].'</td>';
			$rows.= ($array["cant"]>0) ? '<td>'.$array["cant"].' '.LABEL_notes.'</td>' : '<td><a onclick=preparaborrado2(\''.$array["value_id"].'\') title="'.ucfirst(borrar).'" href="#")><strong>'.ucfirst(borrar).'</strong></a></td>';
			$rows.= '</tr>';
		}

	}

	$rows.=' </tbody>';

	$rows.='<tfoot>';
	$rows.='<tr><td colspan="4">'.$i.'</th></tr>';
	$rows.='</tfoot>';
	$rows.='</table> </div>';
	$rows.='</form>';

return $rows;
}

//View relations type and edit/create/delete user-defined relations
function HTMLformUserRelations(){

	//ALTA
	if ($_POST['rr_value']!='' and $_POST['t_relacion']!='' and $_POST['rr_code']!='' and $_POST['rr_id']=='' ) {

		$arrayValues=array("rr_value"=>$_POST['rr_value'],
						   "t_relacion"=>$_POST['t_relacion'],
						   "rr_ord"=>$_POST['rr_ord'],
						   "rr_code"=>$_POST['rr_code']);

		$task=abm_userRelations("A",$arrayValues);

		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";
	}

	//MOD
	if ($_POST['doAdminR']=='modUserRelations') {

		$arrayValues=array("rr_value"=>$_POST['rr_value'],
						   "t_relacion"=>$_POST['t_relacion'],
   						   "rr_ord"=>$_POST['rr_ord'],
						   "rr_code"=>$_POST['rr_code']);

		$task=abm_userRelations("M",$arrayValues,$_POST['rr_id']);
		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";

		$_POST['rr_value']='';
		$_POST['t_relation']='';
		$_POST['rr_code']='';
		$_POST['rr_ord']='';
		$_POST['ac']='';
	}

	//BAJA
	if ($_POST['doAdminR']=='deleteUserRelations' ) {
			$task=abm_userRelations("B",array(),$_POST['rr_id']);
		 }

	$sql=SQLtypeRelations(0,0,true);

	$LABEL_RT=TR_acronimo;
	$LABEL_BT=TG_acronimo.'/'.TE_acronimo;
	$LABEL_UP=UP_acronimo.'/'.USE_termino;

	$arrayLABEL=array("2"=>$LABEL_RT,"3"=>$LABEL_BT,"4"=>$LABEL_UP);

	$rows.='<form id="morerelations" name="morerelations" method="POST" action="admin.php?vocabulario_id=list#morerelations">';
	$rows.='<input type="hidden" name="doAdminR" id="doAdminR" value=""> ';
	$rows.='<input type="hidden" name="rr_id" id="rr_id"> ';

	$rows.='<div class="table-responsive"> ';
	$rows.='<h3>'.ucfirst(LABEL_relationEditor).' </h3>';
	$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.ucfirst(LABEL_relationEditor).'">';
	$rows.='<thead>';
	$rows.='<tr>';
	$rows.=' <th>'.ucfirst(LABEL_relationSubType).'</th>';
	$rows.= '<th>'.ucfirst(LABEL_relationSubTypeLabel).':</th>';
	$rows.= '<th>'.ucfirst(LABEL_relationSubTypeCode).'</th>';
	$rows.= '<th>'.ucfirst(orden).'</th>';
	$rows.= '<th></th>';
	$rows.= '</tr>';

	$rows.='<tr>';
	$rows.='<th class="izq">';
	$rows.='<select id="t_relacion" name="t_relacion">';
	$rows.=doSelectForm(array("3#$LABEL_BT","4#$LABEL_UP","2#$LABEL_RT"),"$_GET[t_relation]");
	$rows.='</select>';
	$rows.='<th class="izq"><input type="text" name="rr_value" id="rr_value"/></td>';
	$rows.='<th class="izq"><input type="text" name="rr_code" size="2" maxlength="2" id="rr_code"/></td>';
	$rows.='<th class="izq"><input type="text" name="rr_ord" size="2" maxlength="2" id="rr_ord"/></td>';
	$rows.='<th><a onclick="enviaRel()" href="#"><strong>'.ucfirst(LABEL_Enviar).'</strong></a></td>';
	$rows.='</tr>';
	$rows.=' </thead>';
	$rows.=' <tbody>';




	while ($array=$sql->FetchRow()){
		$i=++$i;
			$rows.='<tr>';
			$rows.= '<td>'.$arrayLABEL[$array["t_relation"]].'</td>';
			$rows.=' <td class="izq"><a title="'.$array["rr_value"].'"  href="javascript:recargaeditRel(\''.$array["rr_value"].'\',\''.$array["t_relation"].'\',\''.$array["rr_code"].'\',\''.$array["rel_rel_id"].'\',\''.$array["rr_ord"].'\')">'.$array["rr_value"].'</a></td>';
			$rows.= '<td>'.$array["rr_code"].'</td>';
			$rows.= '<td>'.$array["rr_ord"].'</td>';
			$rows.= ($array["cant"]>0) ? '<td>'.$array["cant"].'</td>' : '<td><a onclick=preparaborradoRel(\''.$array["rel_rel_id"].'\') title="'.ucfirst(borrar).'" href="#")><strong>'.ucfirst(LABEL_relationDelete).'</strong></a></td>';
			$rows.= '</tr>';
		}

	$rows.=' </tbody>';

	$rows.='<tfoot>';
	$rows.='<tr><td colspan="5">'.$i.'</th></tr>';
	$rows.='</tfoot>';
	$rows.='</table></div> ';
	$rows.='</form>';

return $rows;
}


//View relations types for URIS associated to terms and edit/create/delete user-defined URIs relations
function HTMLformURIdefinition(){

	//ALTA
	if ($_POST['uri_value']!='' and  $_POST['uri_code']!='' and $_POST['uri_type_id']=='' ) {

		$arrayValues=array("uri_value"=>$_POST['uri_value'],
						   "uri_code"=>$_POST['uri_code']);

		$task=abm_URIdefinition("A",$arrayValues);

		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";
	}

	//MOD
	if ($_POST['doAdminU']=='modURIdefinition') {

		$arrayValues=array("uri_value"=>$_POST['uri_value'],
						   "uri_code"=>$_POST['uri_code']);

		$task=abm_URIdefinition("M",$arrayValues,$_POST['uri_type_id']);
		if ($task[cant]>0)
		echo "<script>javascript:alert('".ucfirst(LABEL_saved)."');</script>";

		$_POST['uri_value']='';
		$_POST['uri_code']='';
	}

	//BAJA
	if ($_POST['doAdminU']=='deleteURIdefinition' ) {
			$task=abm_URIdefinition("B",array(),$_POST['uri_type_id']);
		 }

	$sql=SQLURIdefinition();

	$rows.='<form id="moreURI" name="moreURI" method="POST" action="admin.php?vocabulario_id=list#moreuri">';
	$rows.='<input type="hidden" name="doAdminU" id="doAdminU" value=""> ';
	$rows.='<input type="hidden" name="uri_type_id" id="uri_type_id"> ';

	$rows.='<div class="table-responsive"> ';
	$rows.='<h3>'.ucfirst(LABEL_URItypeEditor).' </h3>';
	$rows.='<table class="table table-striped table-bordered table-condensed table-hover"  summary="'.ucfirst(LABEL_URItypeEditor).'">';
	$rows.='<thead>';
	$rows.='<tr>';
	$rows.= '<th>'.ucfirst(LABEL_URItypeLabel).':</th>';
	$rows.= '<th>'.ucfirst(LABEL_URItypeCode).'</th>';
	$rows.= '<th></th>';
	$rows.= '</tr>';

	$rows.='<tr>';
	$rows.='<th class="izq"><input type="text" name="uri_value" id="uri_value"/></td>';
	$rows.='<th class="izq"><input type="text" name="uri_code" size="10" id="uri_code"/></td>';
	$rows.='<th><a onclick="enviaURI()" href="#"><strong>'.ucfirst(LABEL_Enviar).'</strong></a></td>';
	$rows.='</tr>';
	$rows.=' </thead>';
	$rows.=' <tbody>';




	while ($array=$sql->FetchRow()){
		$i=++$i;
			$rows.='<tr>';
			$rows.=' <td class="izq"><a title="'.$array["uri_value"].'"  href="javascript:recargaeditURI(\''.$array["uri_value"].'\',\''.$array["uri_code"].'\',\''.$array["uri_type_id"].'\')">'.$array["uri_value"].'</a></td>';
			$rows.= '<td>'.$array["uri_code"].'</td>';
			$rows.= ($array["uri_cant"]>0) ? '<td>'.$array["uri_cant"].'</td>' : '<td><a onclick=preparaborradoURI(\''.$array["uri_type_id"].'\') title="'.ucfirst(borrar).'" href="#moreURI")><strong>'.ucfirst(LABEL_URItypeDelete).'</strong></a></td>';
			$rows.= '</tr>';
		}

	$rows.=' </tbody>';

	$rows.='<tfoot>';
	$rows.='<tr><td colspan="4">'.$i.'</th></tr>';
	$rows.='</tfoot>';
	$rows.='</table> </div>';
	$rows.='</form>';

return $rows;
}


//delete massive data
function REMmassiveData($array)
{

//only admin
if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1')
{
	GLOBAL $DBCFG;

	if($array["massrem_terms"]=='1')
	{
		$sql=SQL("truncate","$DBCFG[DBprefix]term2tterm");
		$sql=SQL("truncate","$DBCFG[DBprefix]uri");
		$sql=SQL("truncate","$DBCFG[DBprefix]notas");
		$sql=SQL("truncate","$DBCFG[DBprefix]indice");
		$sql=SQL("truncate","$DBCFG[DBprefix]tabla_rel");
		$sql=SQL("truncate","$DBCFG[DBprefix]tema");
	return;
	}

	if($array["massrem_teqterms"]=='1')
	{
		$sql=SQL("truncate","$DBCFG[DBprefix]term2tterm");
	}

	if($array["massrem_url"]=='1')
	{
		$sql=SQL("truncate","$DBCFG[DBprefix]uri");
	}

	if($array["massrem_notes"]=='1')
	{
		$sql=SQL("truncate","$DBCFG[DBprefix]notas");
	}

	return;
};
}


//retrieve term_id (created or retrieved)
function resolveTerm_id($string)
{
	$term_id = fetchTermId($string);

	return  ((!$term_id)) ? abm_tema('alta',$string) : $term_id;
}


//retrieve term_id (created or retrieved) to RT
function resolveTerm_id2RT($string,$tema_id)
{
		$term = fetchTermId2RT($string,$tema_id);

		return  ((!$term[tema_id])) ? abm_tema('alta',$string) : $term[tema_id];
}


//retrieve term_id (created or retrieved) to UF or NT from free term
function resolve2FreeTerms($string,$tema_id)
{
		$term = fetchSearchExactFreeTerms($string,$tema_id);

		return  ((!$term[tema_id])) ? abm_tema('alta',$string) : $term[tema_id];
}


// Create mapped relation with term from target vocabulary by code
function do_target_temaXcode($tema_id,$code,$tvocab_id)
{

	GLOBAL $DBCFG;

	$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

// 	check valid data
	$tema_id=secure_data($tema_id,"int");
	$tvocab_id=secure_data($tvocab_id,"int");
	$code=secure_data($code,"alnum");

// 	retrieve data about target vocabulary
	$arrayVocab=ARRAYtargetVocabulary($tvocab_id);

	require_once(T3_ABSPATH . 'common/include/vocabularyservices.php')	;

	$dataTterm=getURLdata($arrayVocab[tvocab_uri_service].'?task=fetchCode&arg='.$code);

	$tterm_id=(int)$dataTterm->result->term->term_id;
	$tterm_string=(string)$dataTterm->result->term->string;

	if ((int)$dataTterm->result->term->term_id>0) {

		$arrayTterm["tterm_uri"]=$arrayVocab["tvocab_uri_service"].'?task=fetchTerm&arg='.$tterm_id;
		$arrayTterm["tterm_url"]=$arrayVocab["tvocab_url"].'?tema='.$tterm_id;
		$arrayTterm["tterm_string"]=secure_data($tterm_string,"ADOsql");


		$sql=SQLo("insert","into $DBCFG[DBprefix]term2tterm (tema_id,tvocab_id,tterm_url,tterm_uri,tterm_string,cuando,uid)
				values (?,?,?,?,$arrayTterm[tterm_string],now(),?)",
				array($tema_id,$arrayVocab[tvocab_id],$arrayTterm[tterm_url],$arrayTterm[tterm_uri],$userId));

		$target_relation_id=$sql[cant];
	}

	return array("tterm_id"=>$target_relation_id);
}



function setMetaTerm($term_id,$flag=0)
{
	GLOBAL $DBCFG;

	$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];
	// 	check valid data
	$tema_id=secure_data($tema_id,"int");
	$flag=(in_array($flag, array(1,0))) ? $flag : 0;

	$sql=SQL("update","$DBCFG[DBprefix]tema set isMetaTerm='$flag', uid_final='$userId',cuando_final=now()
						where tema_id='$term_id' and tesauro_id=1");

	return array("tema_id"=>$term_id);
}


#
# Reset and update sparql endpoint
#
function doSparqlEndpoint()
{

	GLOBAL $DBCFG;
	/* Include ARC2 classes. */
	require_once(T3_ABSPATH . 'common/arc2/ARC2.php');
	/* ARC2 static class inclusion */

	/* MySQL and endpoint configuration */
	$config = array(
	/* db */
	'db_host' => $DBCFG["Server"] , /* optional, default is localhost */
	'db_name' => $DBCFG["DBName"] ,
	'db_user' => $DBCFG["DBLogin"],
	'db_pwd' => $DBCFG["DBPass"],
	'store_name' => $DBCFG["DBprefix"],  /* store name */
	'endpoint_features' => array(
	'select', 'construct', 'ask', 'describe','load'
	),
	'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
	'endpoint_read_key' => '', /* optional */
	'endpoint_write_key' => '', /* optional, but without one, everyone can write! */
	'endpoint_max_limit' => 250, /* optional */
	);

		/* instantiation */
		$ep = ARC2::getStoreEndpoint($config);

		if (!$ep->isSetUp()) {
		  $ep->setUp(); /* create MySQL tables */
		}

		// reset the endpoint
		$ep->reset();

		// ask terms
		$sql=SQLIdTerminosValidos();


		//fetch main metadata
		$sparql_command='LOAD <'.$_SESSION["CFGURL"].'xml.php?skosMeta=1> into <'.$_SESSION["CFGURL"].'>';
		$ep->query($sparql_command);


		while ($array=$sql->FetchRow())
		{
			$i==++$i;
			#Mantener vivo el navegador
			$time_now = time();
			if ($time_start >= $time_now + 10) {
				$time_start = $time_now;
				header('X-pmaPing: Pong');
			};

			$sparql_command='LOAD <'.$_SESSION["CFGURL"].'xml.php?skosNode='.$array[id].'> into <'.$_SESSION["CFGURL"].'>';


			$ep->query($sparql_command);
		}


		//Update data about las endpoint
		$ARRAYlastUpdateEndpoint=fetchlastUpdateEndpoint();

		if($ARRAYlastUpdateEndpoint["value"])
			{
				$sql=SQL("update"," $DBCFG[DBprefix]values set value=now() where  value_type='DATESTAMP' and value_code='ENDPOINT_CHANGE'");
			}
			else
			{
				$sql=SQL("insert","into $DBCFG[DBprefix]values (`value_type`, `value`, `value_order`, `value_code`) VALUES
					('DATESTAMP', now(), NULL, 'ENDPOINT_CHANGE')");
			};

	return array("count_nodes"=>$i);
}


function ADDreferencesSuggestedTerm($term_id,$tterm_id,$ARRAYtargetVocabulary,$options=array())
{


	if($options["addNoteReference"]==1){
		abmNota('A',$term_id,"NB",$_SESSION["CFGIdioma"],$ARRAYtargetVocabulary["tvocab_title"].'. URL:'.$ARRAYtargetVocabulary["tvocab_url"]);
	};


	if($options["addLinkReference"]>0){
		abmURI('A',$term_id,array("uri_type_id"=>$options["addLinkReference"],"uri"=>"$ARRAYtargetVocabulary[tvocab_url]?tema=$tterm_id"));
	};

	if($options["addMappReference"]==1){
		abm_target_tema('A',$term_id,$ARRAYtargetVocabulary["tvocab_id"],$tterm_id);
	};

}


function REMTerms($terms_id=array(),$onlyFreeTerms=1){

	$i_term=count($terms_id);
	$i_delete=0;
	for($i=0; $i<sizeof($terms_id);++$i){

		$ctrl=1;

		if($onlyFreeTerms==1){
				$sqlCtrl=SQLcheckFreeTerm($terms_id[$i]);
				$ctrl=(SQLcount($sqlCtrl));
			}


		if($ctrl=='1'){
			borra_t($terms_id[$i]);
			$i_delete=++$i_delete;
			}
		}

	return array("terms"=>$i_term, "error"=>$i_term-$i_delete,"success"=>$i_delete);
}



function REJECTterms($terms_id=array(),$onlyFreeTerms=1){

	$i_term=count($terms_id);
	$i_task=0;
	for($i=0; $i<sizeof($terms_id);++$i){
		$ctrl=1;
		if($onlyFreeTerms==1)			{
				$sqlCtrl=SQLcheckFreeTerm($terms_id[$i]);
				$ctrl=(SQLcount($sqlCtrl));
			}

		if($ctrl=='1'){
			//14==reject status
			cambio_estado($terms_id[$i],14);
			$i_task=++$i_task;
			}
		}

	return array("terms"=>$i_term, "error"=>$i_term-$i_task,"success"=>$i_task);
}


//associate multiple free terms with one term
function freeTermsAssoc($term_id,$rel_id,$freeTerms_id=array(),$onlyFreeTerms=1){

	$i_term=count($freeTerms_id);
	$i_task=0;
	for($i=0; $i<sizeof($freeTerms_id);++$i){
		$ctrl=1;
		if($onlyFreeTerms==1)			{
				$sqlCtrl=SQLcheckFreeTerm($freeTerms_id[$i]);
				$ctrl=(SQLcount($sqlCtrl));
			}

		if($ctrl=='1'){
			switch ($rel_id) {
				case '2':
					$new_relacion=do_terminos_relacionados($freeTerms_id[$i],$term_id);
					break;

				case '3':
					$new_relacion=do_r($term_id,$freeTerms_id[$i],"3");
					break;

				case '4':
					$new_relacion=do_r($freeTerms_id[$i],$term_id,"4");
					//DATESTAMP change term for the non-prefered term.
					updateTermDate($term_id);
					break;
				default:
					break;
			}
			$i_task=++$i_task;
			}
		}

	return array("terms"=>$i_term, "error"=>$i_term-$i_task,"success"=>$i_task);
}


function makeMetaTerms($terms_id=array()){

	$i_term=count($terms_id);
	$i_task=0;
	for($i=0; $i<sizeof($terms_id);++$i){

		setMetaTerm($terms_id[$i],1);
			$i_task=++$i_task;
		}

	return array("terms"=>$i_term, "error"=>$i_term-$i_task,"success"=>$i_task);
}

//Create many terms
function createTerms($arrayStrings,$isMetaTerm=0){

	$arrayTerminos=explode("\n",$arrayStrings);

	for($i=0; $i<sizeof($arrayTerminos);++$i){
		//duplicate check policies
		if($_SESSION[$_SESSION["CFGURL"]]["CFG_ALLOW_DUPLICATED"]==0){
			$fetchTerm=checkDuplicateTerm($arrayTerminos[$i],$isMetaTerm);

			if($fetchTerm["tema_id"]){
					$arrayDuplicateTerms[$fetchTerm["tema_id"]].=$fetchTerm["tema"];
			}else{

				$new_termino=abm_tema('alta',XSSprevent($arrayTerminos[$i]));
				$tema=$new_termino;
				if($isMetaTerm==1)	setMetaTerm($tema,1);
			}
		}else{

			$new_termino=abm_tema('alta',XSSprevent($arrayTerminos[$i]));
			$tema=$new_termino;
			if($isMetaTerm==1)	setMetaTerm($tema,1);
		}
	}

return array("last_term_id"=>$tema,
			 "arrayDupliTerms"=>$arrayDuplicateTerms);
}


//mod term
function modTerm($string,$term_id){

	$arrayTerm=ARRAYverTerminoBasico($term_id);

	//duplicate check policies
	if($_SESSION[$_SESSION["CFGURL"]]["CFG_ALLOW_DUPLICATED"]==0){

			$fetchTerm=checkDuplicateTerm($string,$arrayTerm["isMetaTerm"]);
			//hay término y no es el mismo que el modificado => término duplicado
			if(($fetchTerm["tema_id"]) && ($fetchTerm["tema_id"]!==$term_id)){
				$log=false;
			}else{
				$task=abm_tema('mod',XSSprevent($string),$term_id);
				$log=true;

			}
		//duplicate are allowed
		}else{
			$task=abm_tema('mod',XSSprevent($string),$term_id);
			$log=true;

		}

return array("tema_id"=>$term_id,
			 "term_original"=>$arrayTerm["titTema"],
			 "log"=>$log);
}


function associateTerms($term_id,$arrayStrings,$t_relacion,$t_rel_rel_id=0){

	$ARRAYtema=ARRAYverTerminoBasico($term_id);
	$tema=$ARRAYtema["tema_id"];


	$arrayTerminos=explode("\n",$arrayStrings);

	for($i=0; $i<sizeof($arrayTerminos);++$i){

		//duplicate check policies => there are disable
		if($_SESSION[$_SESSION["CFGURL"]]["CFG_ALLOW_DUPLICATED"]==0){
			$fetchTerm=checkDuplicateTerm($arrayTerminos[$i]);

			if($fetchTerm["tema_id"]){
					$arrayDuplicateTerms[$fetchTerm["tema_id"]].=$fetchTerm["tema"];
			}else{
				//fetch already exist related term candidate
				$relative_term_id=resolve2FreeTerms($arrayTerminos[$i],$ARRAYtema["tema_id"]);
				//RT have different logical check
				if($t_relacion=='2'){
					$new_relacion=do_terminos_relacionados($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}elseif($t_relacion=='3'){
					$new_relacion=doHieraquicalRelation($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}else{
					$new_relacion=doAltRelation($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}
			}
		}else{//duplicate check policies => are enable
				//fetch already exist related term candidate
				$relative_term_id=resolve2FreeTerms($arrayTerminos[$i],$ARRAYtema["tema_id"]);
				//RT have different logical check
				if($t_relacion=='2'){
					$new_relacion=do_terminos_relacionados($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}elseif($t_relacion=='3'){
					$new_relacion=doHieraquicalRelation($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}else{
					$new_relacion=doAltRelation($ARRAYtema["tema_id"],$relative_term_id,$t_rel_rel_id);
				}
		}
	}

return array("last_term_id"=>$ARRAYtema["tema_id"],
			 "arrayDupliTerms"=>$arrayDuplicateTerms);
}




function doHieraquicalRelation($bt_id,$nt_id,$t_rel_rel_id){

	return do_r($bt_id,$nt_id,3,$t_rel_rel_id);
}


function doAltRelation($pref_id,$alt_id,$t_rel_rel_id){

	return do_r($alt_id,$pref_id,4,$t_rel_rel_id);
}



//bulk term editor
function SQLbulkReplaceTerm($from,$to,$where,$arrayTerms){

	GLOBAL $DBCFG;
	$from_string=secure_data($from,"ADOsql");
	$to_string=secure_data($to,"ADOsql");
	$where_string=secure_data("%$where%","ADOsql");

	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

	//redact term group
	if(count($arrayTerms)>0){
		for($i=0; $i<count($arrayTerms);++$i){
				$term_id=secure_data($arrayTerms[$i],"int");
				$where_in.=$term_id.',';
			}
		$where_in=substr("$where_in",0,-1);
	}

	return SQL("update","$DBCFG[DBprefix]tema  set tema=replace(tema, $from_string, $to_string),
						cuando_final=now(),
						uid_final=$userId
						where tema like BINARY $where_string
						and tema_id in ( $where_in )
						and tesauro_id=1");
}

//bulk note editor
function SQLbulkReplaceNote($from,$to,$where,$arrayNotes){

	GLOBAL $DBCFG;
	$from_string=secure_data($from,"ADOsql");
	$to_string=secure_data($to,"ADOsql");
	$where_string=secure_data("%$where%","ADOsql");

	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];

	//redact term group
	if(count($arrayNotes)>0){
		for($i=0; $i<count($arrayNotes);++$i){
				$note_id=secure_data($arrayNotes[$i],"int");
				$where_in.=$note_id.',';
			}
		$where_in=substr("$where_in",0,-1);
	}

	return SQL("update","$DBCFG[DBprefix]notas  set nota=replace(nota, $from_string, $to_string),
						cuando=now(),
						uid=$userId
						where nota like BINARY $where_string
						and id in ( $where_in )");
}

//bulk note editor
function SQLbulkGlossNote($from,$to,$where,$notesType,$term_id,$replaceType=1){

	GLOBAL $DBCFG;
	$from_string=secure_data($from,"ADOsql");
	$to_string=secure_data($to,"ADOsql");
	$where_string=secure_data("%$where%","ADOsql");

	$replaceType =($replaceType!==0) ? ' BINARY ' : '';

	$userId=$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"];


	return SQL("update","$DBCFG[DBprefix]notas set nota=replace(nota, $from_string, $to_string),
						cuando=now(),
						uid=$userId
						where nota like $replaceType $where_string
						and tipo_nota='$notesType'
						and id_tema!='$term_id'");
}


//replace double char in notes
function SQLfixDobleChar4Notes($notesType,$char,$charX2){
        GLOBAL $DBCFG;
	return SQL("update","$DBCFG[DBprefix]notas set nota=replace(nota, '$charX2', '$char')
						where nota like BINARY '$charX2'
						and tipo_nota='$notesType'");

}


//replace HTML entities 2 chars in notes
function SQLnoteshtml2chars(){

	GLOBAL $DBCFG;

	$sql=SQL("select","n.id,n.nota from $DBCFG[DBprefix]notas n");

	while($array=$sql->FetchRow()){

		$nota=html_entity_decode($array["nota"]);

		$SQLupdate=SQL("update","$DBCFG[DBprefix]notas set nota='$nota'
						where id=$array[id]");
	};

}



#export alphabetic version for given term_id
function TXTalphaList4term($term_id,$params=array()){


GLOBAL $CFG;
$txt=ucfirst(LABEL_Titulo).': '.$_SESSION["CFGTitulo"]."\r\n";
$txt.=ucfirst(LABEL_Autor).': '.$_SESSION["CFGAutor"]."\r\n";
$txt.=ucfirst(LABEL_Keywords).': '.$_SESSION["CFGKeywords"]."\r\n";
$txt.=ucfirst(LABEL_Cobertura).': '.$_SESSION["CFGCobertura"]."\r\n";
$txt.=LABEL_URI.': '.$_SESSION["CFGURL"]."\r\n";
$txt.=ucfirst(LABEL_Version).': '.$_SESSION["CFGVersion"]."\r\n";
$txt.="__________________________________________________________________________\r\n";
//Lista de todos los términos
$sql=SQLterm2down($term_id);


while($arrayTema=$sql->FetchRow()){
	#Mantener vivo el navegador
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};
	// Diferenciar entre términos preferidos y términos no preferidos o referencias
	// Si es no preferido o refencia: mostrar preferido y referido
	if($arrayTema["t_relacion"]){
		//Remisiones de equivalencias y no preferidos
		$sqlNoPreferidos=SQLterminosValidosUF($arrayTema["id"]);
		while($arrayNoPreferidos=$sqlNoPreferidos->FetchRow()){
		$acronimo=arrayReplace ( array("4","5","6","7"),array(USE_termino,EQP_acronimo,EQ_acronimo,NEQ_acronimo),$arrayNoPreferidos[t_relacion]);
		$referencia_mapeo = ($arrayNoPreferidos["vocabulario_id"]!=='1') ? ' ('.$arrayNoPreferidos["titulo"].')' : ''."\r\n";
		$txt.="\n".$arrayTema["tema"] . $referencia_mapeo ;
		$txt.='	'.$acronimo.$arrayNoPreferidos["rr_code"].': '.$arrayNoPreferidos["tema_pref"]."\r\n";
		};
	}	else{	// Si es preferido: mostar notas y relaciones

		$txt.="\n".$arrayTema["tema"]."\r\n";
		//show code
		$txt.=(($CFG["_SHOW_CODE"]=='1') && (strlen($arrayTema["code"])>0)) ? '	'.ucfirst(LABEL_CODE).': '.$arrayTema["code"]."\r\n" : "";

		$label_target_vocabulary='';

		$txt.=($params["includeCreatedDate"]==1) ? LABEL_fecha_creacion.': '.$arrayTema["cuando"]."\r\n" : '';
		if(($arrayTema["cuando_final"]>$arrayTema["cuando"]) && ($params["includeModDate"]==1))	{$txt.=LABEL_fecha_modificacion.': '.$arrayTema["cuando_final"]."\r\n";};

		//Notas
		$sqlNotas=SQLdatosTerminoNotas($arrayTema[id]);
			while($arrayNotas=$sqlNotas->FetchRow()){
				$arrayNotas["label_tipo_nota"]=(in_array($arrayNotas[ntype_id],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$arrayNotas["ntype_id"]) : $arrayNotas["ntype_code"];
				if(($arrayNotas["tipo_nota"]!=='NP') && (in_array($arrayNotas["tipo_nota"], $params["includeNote"])))				{
					$txt.='	'.$arrayNotas["label_tipo_nota"].': '.html2txt($arrayNotas["nota"])."\r\n";
				}
			};


    #Fetch data about associated terms (BT,RT,UF)
    //Relaciones
    $sqlRelaciones=SQLdirectTerms($arrayTema["id"]);

    $arrayRelacionesVisibles=array(2,3,4,5,6,7); // TG/TE/UP/TR

    while($arrayRelaciones=$sqlRelaciones->FetchRow()){

        if($arrayRelaciones["t_relacion"]==4){
            # is UF and not hidden UF
            if (!in_array($arrayRelaciones["rr_code"],$CFG["HIDDEN_EQ"])){
				$txt.='	'.UP_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["uf_tema"]."\r\n";
            }
        }

        if($arrayRelaciones["t_relacion"]==3){
            if($arrayRelaciones["bt_tema"]){
				$txt.='	'.TG_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["bt_tema"]."\r\n";
            }

            if($arrayRelaciones["nt_tema"]){
				$txt.='	'.TE_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["nt_tema"]."\r\n";
                }
         }
            if($arrayRelaciones["t_relacion"]==2){
            if($arrayRelaciones["rt_tema"]){
				$txt.='	'.TR_acronimo.$arrayRelaciones["rr_code"].': '.$arrayRelaciones["rt_tema"]."\r\n";
                }
            }
    }

    //internal target terms
    $SQLiTargetTerms=SQLtermsInternalMapped($arrayTema["id"]);

    while($ARRAYiTargetTerms=$SQLiTargetTerms->FetchRow()){
        $acronimoTterm=arrayReplace (array(5,6,7),array(EQP_acronimo,EQ_acronimo,NEQ_acronimo),$ARRAYiTargetTerms["t_relacion"]);
		$txt.='	'.$acronimoTterm.': '.$ARRAYiTargetTerms["tema"].' ('.$ARRAYiTargetTerms["titulo"].') '."\r\n";
    };

			$txt.=$label_target_vocabulary;
			//Terminos equivalentes web services
			$SQLtargetTerms=SQLtargetTerms($arrayTema["id"]);
			while($arrayTT=$SQLtargetTerms->FetchRow()){
					$txt.='	'.FixEncoding(ucfirst($arrayTT[tvocab_label])).': '.FixEncoding($arrayTT[tterm_string])."\r\n";
			};
	} //end Si es preferido: mostar notas y relaciones
}


$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaAbc).'.txt';
return sendFile("$txt","$filname");
};


#export tree version for given term_id
function TXTtreeList4term($term_id){

$txt=ucfirst(LABEL_Titulo).': '.$_SESSION["CFGTitulo"]."\r\n";
$txt.=ucfirst(LABEL_Autor).': '.$_SESSION["CFGAutor"]."\r\n";
$txt.=ucfirst(LABEL_Keywords).': '.$_SESSION["CFGKeywords"]."\r\n";
$txt.=ucfirst(LABEL_Cobertura).': '.$_SESSION["CFGCobertura"]."\r\n";
$txt.=LABEL_URI.': '.$_SESSION["CFGURL"]."\r\n";
$txt.=ucfirst(LABEL_Version).': '.$_SESSION["CFGVersion"]."\r\n";
$txt.="__________________________________________________________________________\r\n";


$arrayTema=ARRAYverTerminoBasico($term_id);

$txt.=$arrayTema["tema"]."\r\n";
//Terminos especificos
$txt.=TXTverTE($arrayTema["tema_id"],"0");

$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaSis).'.txt';

return sendFile("$txt","$filname");
};


//print alphabetic version on PDF
function do_pdfAlpha($params=array()){

//update stats
doLastModified();
//Load config values
loadConfigValues(1);

require_once(T3_ABSPATH . 'common/fpdf/fpdf.php');
require_once(T3_ABSPATH . 'common/include/fun.pdf.php');

$pdf = new PDF();
$pdf->SetTitle(latin1($_SESSION["CFGTitulo"]));
$pdf->SetAuthor(latin1($_SESSION["CFGAutor"]));
$pdf->SetSubject(latin1($_SESSION["CFGCobertura"]));
$pdf->SetKeywords(latin1($_SESSION["CFGKeywords"]));
$pdf->SetCreator($_SESSION["CFGVersion"]);

$pdf->PrintCover($params);

$sqlMenuAlfabetico=SQLlistaABC();

while ($datosAlfabetico = $sqlMenuAlfabetico->FetchRow())	{
	$datosAlfabetico[0]=isValidLetter($datosAlfabetico[0]);
	if(ctype_digit($datosAlfabetico[0])){
		$ARRAYletras["0-9"].=$datosAlfabetico[0];
		}else{
		$ARRAYletras[$datosAlfabetico[0]].=$datosAlfabetico[0];
		}
	}
	foreach ($ARRAYletras as $key => $value) {
		if(strlen($value)>0) $pdf->PrintChapter(ucwords($key),$value,$params);
	}

$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaAbc).'.pdf';

$pdf->Output('D',$filname);


}


//print systematic version on PDF
function do_pdfSist($params=array()) {
	global $CFG;
	require_once(T3_ABSPATH . 'common/fpdf/fpdf.php');
	require_once(T3_ABSPATH . 'common/include/fun.pdf.php');

	$pdf = new PDF();
	$pdf->SetTitle(latin1($_SESSION["CFGTitulo"]));
	$pdf->SetAuthor(latin1($_SESSION["CFGAutor"]));
	$pdf->SetSubject(latin1($_SESSION["CFGCobertura"]));
	$pdf->SetKeywords(latin1($_SESSION["CFGKeywords"]));
	$pdf->SetCreator($_SESSION["CFGVersion"]);
	$pdf->PrintCover($params);

	if ($params['hasTopTerm'] == '') {
		$sql=SQLverTopTerm();
		while ($arrayTema=$sql->FetchRow()) {
			#Mantener vivo el navegador
			$time_now = time();
			if ($time_start >= $time_now + 10) {
				$time_start = $time_now;
				header('X-pmaPing: Pong');
			}
			$txt.=$arrayTema[tema]."\r\n";
			$txt.=TXTverTE($arrayTema[id],"0");
		}
	} else {
		$txt=TXTverTE($params['hasTopTerm'],"0");
	}

	$txt = str_replace(".\t", "     ", $txt);
	$txt = utf8_decode($txt);

	$pdf->SetMargins(20,20);
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(0,10);
	$pdf->footer = 1;
	$pdf->SetFont('helvetica','',11);
	$lines = explode("\r\n", $txt);
	$i = 1;
	foreach ($lines as $line) {
		if ($i == 33) {
			$pdf->AddPage();
			$i = 1;
		}
		$pdf->Cell(0,8,$line);
		$pdf->Ln();
		$i++;
	}

	$filname=string2url($_SESSION[CFGTitulo].'-Sistematico').'.pdf';
	$pdf->Output('D',$filname);
}



function autoridadesMarcXML($params=array()){

	GLOBAL $CFG;

	//Note types enabled: Scope note, historical note, bibliographic note, cataloging note and definition note
	$includeNotes=array("NA","NH","NB","NC","DF");
    
    // lista de todos os termos
    $sql=SQLlistaTemas();

// cabecalho do arquivo marc
$text = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<collection
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.loc.gov/MARC21/slim
http://www.loc.gov/standards/marcxml/schema/MARC21slim.xsd"
xmlns="http://www.loc.gov/MARC21/slim">
\n
EOT;
    // $txt armazena o conteudo do marcxml a ser gerado
    $txt .= $text;

    // pega termo do banco de dados, coluna por coluna
    while($arrayTema=$sql->FetchRow())
    { // mantem o navegador acordado
   	 $time_now = time();
   	 if ($time_start >= $time_now + 10)
   	 {
   	 $time_start = $time_now;
   	 header('X-pmaPing: Pong');
   	 };

    // explode ( string $delimiter , string $string [, int $limit ] ) : array
    // Retorna uma matriz de strings, cada uma como substring de string
    // formada pela divisão dela a partir do delimiter.
    $date = date('Y-m-d H:i:s');
    $dataCalendario=explode(" ", $date);
    $anoMesDia = explode("-", $dataCalendario[0]);
    $horaMinSeg = explode(":", $dataCalendario[1]);
    $formatoData = $anoMesDia[0] .$anoMesDia[1] . $anoMesDia[2];
    $formatoHora = $horaMinSeg[0] .$horaMinSeg[1] . $horaMinSeg[2] . ".0";
    $txt .='<record>' . "\n";
    $txt.= "<leader>00415nz  a2200121n  4500</leader>" . "\n";
    $txt .=' <controlfield tag="003">OSt</controlfield>' . "\n";
    $txt .=' <controlfield tag="005">' . $formatoData . $formatoHora . '</controlfield>' .
    "\n";
    $txt .=' <controlfield tag="008">171020|| aca||babn | a|a d</controlfield>' .
    "\n";
    $txt .=' <datafield tag="040" ind1=" " ind2=" ">' . "\n";
    $txt .='  <subfield code="a">OSt</subfield>' . "\n";
    $txt .=' </datafield>' . "\n";
    $txt .=' <datafield tag="150" ind1=" " ind2=" ">' . "\n";
    // inclusao do termo no campo 150 $a
    $txt .='  <subfield code="a">'.$arrayTema["tema"] .'</subfield>' . "\n";
    $txt .=' </datafield>' . "\n";

    $sqlRelaciones=SQLdirectTerms($arrayTema["id"]);

    $arrayRelacionesVisibles=array(2,3,4,5,6,7); // TG/TE/UP/TR

	while($arrayRelaciones=$sqlRelaciones->FetchRow()){

    	$acronimo=arrayReplace ( $arrayRelacionesVisibles,array(TR_acronimo,TG_acronimo,UP_acronimo,EQP_acronimo,EQ_acronimo,NEQ_acronimo),$arrayRelaciones["t_relacion"]);

    	if($arrayRelaciones["t_relacion"]==4){
   		 // inclusao de termos nao-autorizados 450 $a
        	# is UF and not hidden UF
        	if (!in_array($arrayRelaciones["rr_code"],$CFG["HIDDEN_EQ"]))
        	{
       		 $txt .=' <datafield tag="450" ind1=" " ind2=" ">' . "\n";
   			 $txt .=' <subfield code="a">'.$arrayRelaciones["uf_tema"] .'</subfield>' . "\n";
   			 $txt .=' <subfield code="i">'.ucfirst(LABEL_esNoPreferido).'</subfield>' . "\n";
   			 $txt .=' </datafield>' . "\n";
        	}
    	}

    	if($arrayRelaciones["t_relacion"]==3)
    	{    // inclusao de termos genericos 550 $a
        	if($arrayRelaciones["bt_tema"])
        	{
       		 $txt .=' <datafield tag="550" ind1=" " ind2=" ">' . "\n";
   			 $txt .='  <subfield code="a">'.$arrayRelaciones["bt_tema"] .'</subfield>' . "\n";
   			 $txt .='  <subfield code="w">g</subfield>' . "\n";
   			 $txt .=' </datafield>' . "\n";
        	}

        	// inclusao de termos especificos 550 $a
        	if($arrayRelaciones["nt_tema"])
        	{
       		 $txt .=' <datafield tag="550" ind1=" " ind2=" ">' . "\n";
   			 $txt .='  <subfield code="a">'.$arrayRelaciones["nt_tema"] .'</subfield>' . "\n";
   			 $txt .='  <subfield code="w">h</subfield>' . "\n";
   			 $txt .=' </datafield>' . "\n";
        	}
     	}
    		 // inclusao de termos relacionados 550 $a
        	if($arrayRelaciones["t_relacion"]==2){
        	if($arrayRelaciones["rt_tema"]){
       		 $txt .=' <datafield tag="550" ind1=" " ind2=" ">' . "\n";
   			 $txt .='  <subfield code="a">'.$arrayRelaciones["rt_tema"] .'</subfield>' . "\n";
   			 $txt .=' </datafield>' . "\n";
            	}
        	}
	}

	//Notas
    $sqlNotas=SQLdatosTerminoNotas($arrayTema[id]);

   	 while($arrayNotas=$sqlNotas->FetchRow()){

   		 if(in_array($arrayNotas["tipo_nota"], $includeNotes)){
			/*$includeNotes=array("NA","NH","NB","NC","DF");   
			677 - Definition (R)
			670 - Source Data Found (R)
			688 - Application History Note (R) 
			680 - Public General Note (R) 
			688 - Application History Note (R) 
			*/
	 		$tag_note=arrayReplace($includeNotes,array("680","688","670","688","677"),$arrayNotas["tipo_nota"]);
   			 $txt .=' <datafield tag="'.$tag_note.'" ind1=" " ind2=" ">' . "\n";
   			 $txt .='  <subfield code="a">'.html2txt($arrayNotas["nota"]) .'</subfield>' . "\n";
   			 $txt .=' </datafield>' . "\n";
   		 }
   	 };

    $txt .='</record>' . "\n";
    }
    $txt .='</collection>' . "\n";
    $filname=string2url($_SESSION[CFGTitulo].' '.marcXML).'.xml';
    
    return sendFile("$txt","$filname");
};


?>
