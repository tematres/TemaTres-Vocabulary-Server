<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# llamada de funciones de gestion de terminos
#

if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0){

	# Alta de término subordinado
	#1. Alta de término
	#2. Alta de relación
	if($_POST[id_termino_sub])
	{
		$arrayTerminos=explode("\n",doValue($_POST,FORM_LABEL_termino));

		for($i=0; $i<sizeof($arrayTerminos);++$i){
				$new_termino=abm_tema('alta',$arrayTerminos[$i]);
				$new_relacion=do_r($_POST[id_termino_sub],$new_termino,"3");
				$tema=$new_termino;
				$_GET[id_sup]='';
				};
	}

	# Alta de término no preferido
	#1. Alta de término
	#2. Alta de relación
	if($_POST[id_termino_uf])
	{
		$arrayTerminos=explode("\n",doValue($_POST,FORM_LABEL_termino));

		for($i=0; $i<sizeof($arrayTerminos);++$i){
			$new_termino=abm_tema('alta',$arrayTerminos[$i]);
			$new_relacion=do_r($new_termino,$_POST[id_termino_uf],"4");
			$tema=$_POST[id_termino_uf];
			$_GET[id_uf]='';
			}
	}


	# Alta de equivalencia de término
	#1. Alta de término
	#2. Alta de relación
	if($_POST[id_termino_eq])
	{
		$new_termino=abm_tema('alta',doValue($_POST,FORM_LABEL_termino));
		$new_relacion=do_r($new_termino,$_POST[id_termino_eq],$_POST[tipo_equivalencia]);
		$tema=$_POST[id_termino_eq];
		$_GET[id_eq]='';
	}

switch ($_GET[taskrelations])
{
	case 'addTgetTerm'://agregar un término de WS 
	$new_relacion=abm_target_tema("A",$_GET[tema],$_GET[tvocab_id],$_GET[tgetTerm_id]);
	break;

	case 'delTgetTerm'://eliminar un término de WS 
	$del_relacion=abm_target_tema("B",$_GET[tema],$_GET[tvocab_id],$_GET[tgetTerm_id],$_GET[tterm_id]);
	break;

	case 'updTgetTerm'://actualiza término de WS
	$up_relacion=abm_target_tema("U",$_GET[tema],$_GET[tvocab_id],$_GET[tgetTerm_id],$_GET[tterm_id]);
	break;

	case 'addRT': 
	$new_relacion=do_terminos_relacionados($_GET[rema_id],$_GET[tema],"2");
	$MSG_ERROR_RELACION=$new_relacion[msg_error];
	break;

	case 'addBT': 
	$new_relacion=do_r($_GET[rema_id],$_GET[tema],"3");
	$tema=$_GET[rema_id];
	$_GET[sel_idsuptr]='';
	$MSG_ERROR_RELACION=$new_relacion[msg_error];
	break;

	case 'addFreeUF': 
	$new_relacion=do_r($_GET[rema_id],$_GET[tema],"4");
	$tema=$_GET[tema];
	$MSG_ERROR_RELACION=$new_relacion[msg_error];
	break;
	
	case 'addFreeNT': 
	$new_relacion=do_r($_GET[tema],$_GET[rema_id],"3");
	$tema=$_GET[tema];
	$MSG_ERROR_RELACION=$new_relacion[msg_error];
	break;
	
	default: 
}

	# Alta de relación entre término
	if($_GET[sel_idtr])
	{
		$new_relacion=do_terminos_relacionados($_GET[sel_idtr],$_GET[tema],"2");
		$_GET[sel_idtr]='';
		$MSG_ERROR_RELACION=$new_relacion[msg_error];
	}

	# Subordinación de un término a otro
	if($_GET[sel_idsuptr])
	{
		$new_relacion=do_r($_GET[sel_idsuptr],$tema,"3");
		$tema=$_GET[sel_idsuptr];
		$_GET[sel_idsuptr]='';
		$MSG_ERROR_RELACION=$new_relacion[msg_error];
	};


	# Borrado de  relación
	if($_GET[ridelete])
	{
		borra_r($_GET[ridelete]);
	};


	# Borrado de  término
	if($_GET[id_dete])
	{
		borra_t($_GET[id_dete]);
	};

	# Alta de término
	if($_POST[alta_t]=='new')
	{
		$arrayTerminos=explode("\n",doValue($_POST,FORM_LABEL_termino));

		for($i=0; $i<sizeof($arrayTerminos);++$i){
			$new_termino=abm_tema('alta',$arrayTerminos[$i]);
			$tema=$new_termino;
			}	
	};

	# Modificación de término
	if($_POST[edit_id_tema])
	{
		$new_termino=abm_tema('mod',doValue($_POST,FORM_LABEL_termino),"$_POST[edit_id_tema]");
		$tema=$new_termino;
	};

	# Alta de nota
	if($_POST[altaNota])
	{
		$tema=abmNota('A',"$_POST[idTema]",doValue($_POST,FORM_LABEL_tipoNota),doValue($_POST,FORM_LABEL_Idioma),doValue($_POST,FORM_LABEL_nota));
	};

	#Operaciones Mod y Borrado de notas
	if($_POST[modNota]){
		# Modificación de nota
		if($_POST[guardarCambioNota]==LABEL_Cambiar)
		{
			$tema=abmNota('M',"$_POST[idTema]",doValue($_POST,FORM_LABEL_tipoNota),doValue($_POST,FORM_LABEL_Idioma),doValue($_POST,FORM_LABEL_nota),"$_POST[idNota]");
		};

		# Borrado de nota
		if($_POST[eliminarNota]==LABEL_EliminarNota)
		{
			$tema=abmNota('B',"$_POST[idTema]","","","","$_POST[idNota]");
		};
	};


	# Cambio de estado de un término
	if(($_GET[estado_id])&&($_GET[tema]))
	{
		$cambio_estado=cambio_estado($_GET[tema],$_GET[estado_id]);
		$tema=$cambio_estado[tema_id];
		$MSG_ERROR_ESTADO=$cambio_estado[msg_error];
	};


/*
function to select wich report download
*/
function wichReport($task) 
{
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
	$sql=SQLtermsXstatus($_SESSION[id_tesa],"12");
	break;

	//rejected terms
	case 'csv6':
	$sql=SQLtermsXstatus($_SESSION[id_tesa],"14");
	break;
	
	default :

	break;
}

return sql2csv($sql,string2url($_SESSION[CFGTitulo]).'.csv');
}




};// fin de llamdas de funciones de gestion



###################################################################################
##################      FUNCIONES DE ABM TERMINOS   ###############################
###################################################################################

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
function do_terminos_relacionados($id_mayor,$id_menor,$t_relacion){
$evalRecursividad_ida=evalRelacionSuperior($id_mayor,'0',$id_menor);

$evalRecursividad_vuelta=evalRelacionSuperior($id_menor,'0',$id_mayor);

if(($evalRecursividad_ida==TRUE)&&($evalRecursividad_vuelta==TRUE)){
	#1. Alta de relación de ida
	#2. Alta de relación de vuelta
	$new_relacionIda=do_r($id_mayor,$id_menor,"2");
	$new_relacionVuelta=do_r($id_menor,$id_mayor,"2");
	$msg='';
	}else{
	$msg='<p class="error">'.MSGL_relacionIlegal.'</p>';;
	}

return array("id_tema"=>$id_menor,"msg_error"=>$msg);
};

#
# ALTA DE TERMINOS RELACIONADOS (todo tipo de relacion)
#
function do_r($id_mayor,$id_menor,$t_relacion){
GLOBAL $DBCFG;

$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

// Evaluar recursividad
$evalRecursividad=evalRelacionSuperior($id_mayor,'0',$id_menor);

// Evaluar si son valores numericos
if(	(is_numeric($id_menor) && 
	is_numeric($id_mayor) && 
	is_numeric($t_relacion) )
	) {
	$okValues = TRUE;
	};

# NO es una relacion recursiva
if(($evalRecursividad == TRUE) && ($okValues == TRUE)){
	$sql=SQL("insert","into $DBCFG[DBprefix]tabla_rel (id_mayor,id_menor,t_relacion,uid,cuando)
		values
		('$id_mayor','$id_menor','$t_relacion','$userId',now())");
	//es TG y hay que actualizar el arbol
	if($t_relacion=='3'){
		actualizaListaArbolAbajo($id_menor);
		}
	$msg='';
	}else{
	$msg='<p class="error">'.MSGL_relacionIlegal.'</p>';;
	};

return array("id_tema"=>$_POST[id_tema],"msg_error"=>$msg);
};



function actualizaListaArbolAbajo($tema_id){

$tema_id=secure_data($tema_id,"sql");

actualizaArbolxTema($tema_id);
$sqlTerminosAfectados=SQLtieneTema($tema_id);
//Hay algo que actualizar
if($sqlTerminosAfectados[cant]){
	while($array=mysqli_fetch_row($sqlTerminosAfectados[datos])){
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

$id_t=secure_data($id_t,"sql");

$sqlCtrl=SQLverTerminosLibres($id_t);
if($sqlCtrl[cant]=='1')
	{
	$delete=SQL("delete","from $DBCFG[DBprefix]term2tterm where tema_id='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where '$id_t' in (id_menor,id_mayor)");
	$delete=SQL("delete","from $DBCFG[DBprefix]indice where tema_id='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]notas where id_tema='$id_t'");
	$delete=SQL("delete","from $DBCFG[DBprefix]tema where tema_id='$id_t'");
	}
	else return $MSG_ERROR_ELIMINAR;
};


#
# BAJA DE RELACIONES ENTRE TERMINOS
#
function borra_r($id_r){

GLOBAL $DBCFG;

$sql_dator=SQL("select","$DBCFG[DBprefix]tabla_rel.id,id_mayor,id_menor,t_relacion from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
$dator=mysqli_fetch_array($sql_dator[datos]);

switch($dator[t_relacion]){
	case '2':
	$sql_id_delete=SQL("select","$DBCFG[DBprefix]tabla_rel.id
		from $DBCFG[DBprefix]tabla_rel
		where
		id_menor in ('$dator[id_menor]','$dator[id_mayor]')
		and id_mayor in ('$dator[id_menor]','$dator[id_mayor]')
		and t_relacion='$dator[t_relacion]'");

	while($id_delete=mysqli_fetch_row($sql_id_delete[datos]))
		{
		$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_delete[0]'");
		}
	break;

	case '3':
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	actualizaListaArbolAbajo($dator[id_menor]);
	break;


	case '4': //UF
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar también el término
	//borra_t($dator[id_mayor]);
	break;

	case '5': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar también el término
	borra_t($dator[id_mayor]);
	break;

	case '6': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar también el término
	borra_t($dator[id_mayor]);
	break;

	case '7': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar también el término
	borra_t($dator[id_mayor]);
	break;


	case '8': //EQ
	$delete=SQL("delete","from $DBCFG[DBprefix]tabla_rel where id='$id_r'");
	//Eliminar también el término
	borra_t($dator[id_mayor]);
	break;
	};

};

#
# devuelve una lista separada por | del arbol/indice de un tema
#
function generaIndices($tema_id){
	$tema_id=secure_data($tema_id,"sql");
	
	$indice_temas=bucle_arriba($tema_id.'|',$tema_id);
return $indice_temas;
};



#
# actualiza la situacion de tema en el arbol/indice 
#
function actualizaArbolxTema($tema_id){
	GLOBAL $DBCFG;
	$tema_id=secure_data($tema_id,"sql");
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
	if($sql[error]){
		$sql=SQL("update","$DBCFG[DBprefix]indice set indice='$esteindice' where tema_id='$tema_id'");
		}
return $tema_id;
};


#
# ALTA Y MODIFICACION DE TERMINOS
#
function abm_tema($do,$titu_tema,$tema_id=""){
GLOBAL $DBCFG;

$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

//Es un término del vocabulario o una referencia a un término mapeado de otro vocabulario.
($_POST[ref_vocabulario_id]) ? $tesauro_id=$_POST[ref_vocabulario_id] :	$tesauro_id=$_SESSION[id_tesa];

$titu_tema=secure_data($titu_tema,"sql");

$tema_id=secure_data($tema_id,"sql");

if(strlen($titu_tema)>0)
	{
	switch($do)
		{
		case 'alta':
		$estado_id = (@$_POST[estado_id]) ? $_POST[estado_id] : '13';
		$sql=SQL("insert","into $DBCFG[DBprefix]tema (tema,tesauro_id,uid,cuando,estado_id,cuando_estado) values ('$titu_tema','$tesauro_id','$userId',now(),'$estado_id',now())");
		$tema_id=$sql[cant];
		break;

		case 'mod':
		$sql=SQL("update","$DBCFG[DBprefix]tema set tema='$titu_tema' ,uid_final='$userId',cuando_final=now() where tema_id='$tema_id'");
		break;
		};
	};

return $tema_id;
};



#
# ALTA Y baja DE target TERMINOS externos
#
function abm_target_tema($do,$tema_id,$tvocab_id,$tgetTerm_id,$tterm_id="0")
{
GLOBAL $DBCFG;

$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

$tema_id=secure_data($tema_id,"sql");
$tvocab_id=secure_data($tvocab_id,"sql");

$arrayVocab=ARRAYtargetVocabulary($tvocab_id);

if(is_array($arrayVocab))
	{
		
	
	switch($do)
		{
		case 'A':				

		require('vocabularyservices.php')	;
		
		$arrayTterm=xmlVocabulary2array($arrayVocab[tvocab_uri_service].'?task=fetchTerm&arg='.$tgetTerm_id);

		$arrayTterm[tterm_uri]=$arrayVocab[tvocab_uri_service].'?task=fetchTerm&arg='.$tgetTerm_id;	
		
		$arrayTterm[tterm_url]=$arrayVocab[tvocab_url].'?tema='.$tgetTerm_id;
		
		$arrayTterm[tterm_string]=FixEncoding($arrayTterm[result][term]["string"]);
		
		$sql=SQL("insert","into $DBCFG[DBprefix]term2tterm (tema_id,tvocab_id,tterm_url,tterm_uri,tterm_string,cuando,uid) 
			values ('$tema_id','$arrayVocab[tvocab_id]','$arrayTterm[tterm_url]','$arrayTterm[tterm_uri]','$arrayTterm[tterm_string]',now(),'$userId')");
		$target_relation_id=$sql[cant];
		
		break;

		case 'B'://delete				
		$sql=SQL("delete","from $DBCFG[DBprefix]term2tterm where tterm_id='$tterm_id' and tema_id='$tema_id' and tvocab_id='$tvocab_id' limit 1"); 
		$target_relation_id=$sql[cant];		
		break;

		case 'U'://update data
		
		require('vocabularyservices.php')	;
		//obtener datos locales del término
		$arrayTterm=ARRAYtargetTerm($tema_id,$tgetTerm_id);
		
		//obtener datos externos del término
		$arrayTterm=xmlVocabulary2array($arrayTterm[tterm_uri]);
		
		$arrayTterm[tterm_string]=FixEncoding($arrayTterm[result][term]["string"]);
		
		$sql=SQL("update","$DBCFG[DBprefix]term2tterm set 
		tterm_string='$arrayTterm[tterm_string]',
		cuando_last=now(),
		uid='$userId'
		where tterm_id='$tterm_id' and tema_id='$tema_id' and tvocab_id='$tvocab_id' limit 1"); 

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
$tema_id=secure_data($tema_id,"sql");

$estado_id=secure_data($estado_id,"sql");

switch($estado_id)
	{
	case '13'://Aceptado / Aceptado
	//todos pueden ser aceptados
	$sql=SQL("update","$DBCFG[DBprefix]tema set estado_id='13' ,uid_final='$userId',cuando_estado=now() where tema_id='$tema_id' ");
	break;

	default :// '12' Candidato / Candidate o '14'://Rechazado / rejected 
	// sólo términos libres / only free terms
	$sqlCtrl=SQLverTerminosLibres($tema_id);
	if($sqlCtrl[cant]=='1')
		{
		$sql=SQL("update","$DBCFG[DBprefix]tema set estado_id='$estado_id' ,uid_final='$userId',cuando_estado=now() where tema_id='$tema_id'");
		}
		else
		{
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
$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

$nota=secure_data($nota,"sqlhtml");

switch($do){
	case 'A':
	$sql=SQL("insert","into $DBCFG[DBprefix]notas (id_tema,tipo_nota,lang_nota,nota,cuando,uid) values ('$idTema','$tipoNota','$langNota','$nota',now(),'$userId')");
	break;

	case 'M':
	$sql=SQL("update","$DBCFG[DBprefix]notas set tipo_nota='$tipoNota',lang_nota='$langNota',nota='$nota',uid='$userId',cuando=now() where id='$idNota'");
	break;

	case 'B':
	$sql=SQL("delete","from $DBCFG[DBprefix]notas where id='$idNota'");
	break;
	};

return $idTema;
};


#
# alta y modificación de código de términos
#
function edit_single_code($tema_id,$code)
{
	GLOBAL $DBCFG;
	
	$code=trim($code);
	$code=secure_data($code,"sql");
	$code=secure_data($code,"alnum");

	$ARRAYCode=ARRAYCode($code);
	
	//No cambió nada
	if($ARRAYCode[tema_id]==$tema_id)
	{
		//sin cambios
		$ARRAYCode["log"]='0';
		return $ARRAYCode;
		
	}
	elseif($ARRAYCode[tema_id])
	{
		//error
		$ARRAYCode["log"]='-1';
		return $ARRAYCode;
	}
	else 
	{
		//cambios
				
		$code=(strlen($code)<1) ? NULL : $code;
		
		$sql=SQL("update","$DBCFG[DBprefix]tema set code='$code' where tema_id='$tema_id'");
		
		$ARRAYCode=ARRAYCode($code);		
		
		$ARRAYCode["log"]='1';
		return $ARRAYCode;
	}

}



function admin_users($do,$user_id=""){

	GLOBAL $DBCFG;

	$userId=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

	if (is_numeric($user_id)) 
	{
		$arrayUserData=ARRAYdatosUser($user_id);
		
		if($arrayUserData[nivel]=='1'){
			//Cehcquear que sea ADMIN
			$sqlCheckAdmin=SQL("select","count(*) from $DBCFG[DBprefix]usuario where nivel='1' and estado='ACTIVO'");
			$arrayCheckAdmin=mysqli_fetch_row($sqlCheckAdmin[datos]);
			}
	}
	

	
	switch($do){
		case 'actua':
		$POSTarrayUser=doArrayDatosUser($_POST);
		
		//Normalice admin		
		$nivel=($POSTarrayUser[isAdmin]=='1') ? '1' : '2';
		
		//Check have one admin user
		if (($nivel=='2') && 
			($arrayUserData[nivel]=='1') &&
			($arrayCheckAdmin[0]=='1')
			)
		{
			$nivel='1';
		}
		$sql=SQL("update","$DBCFG[DBprefix]usuario
			SET apellido='$POSTarrayUser[apellido]',
			nombres= '$POSTarrayUser[nombres]',
			mail='$POSTarrayUser[mail]',
			uid='$userId',
			pass= '$POSTarrayUser[pass]',
			orga= '$POSTarrayUser[orga]',
			nivel ='$nivel'
			WHERE id='$arrayUserData[user_id]'");
		break;

		case 'estado':
		$new_estado = ($_GET[estado]=='ACTIVO') ? 'BAJA' : 'ACTIVO';

		//Check have one admin user
		if (($new_estado=='BAJA') && 
			($arrayUser[nivel]=='1') &&
			($arrayCheckAdmin[0]=='1')
			)
		{
			$new_estado='ACTIVO';
		}


		$sql=SQL("update","$DBCFG[DBprefix]usuario
			SET estado='$new_estado',
			uid='$userId',
			hasta=now()
			WHERE id='$arrayUserData[user_id]'
			");
		break;

		case 'alta':
		$POSTarrayUser=doArrayDatosUser($_POST);
		
		$nivel=($POSTarrayUser[isAdmin]=='1') ? '1' : '2';

		$sql=SQL("insert","into $DBCFG[DBprefix]usuario (apellido, nombres, uid, cuando, mail, pass, orga, nivel, estado, hasta)
			VALUES
			('$POSTarrayUser[apellido]', '$POSTarrayUser[nombres]', '$userId', now(), '$POSTarrayUser[mail]', '$POSTarrayUser[pass]', '$POSTarrayUser[orga]', '$nivel', 'ACTIVO', now())
			");
		$user_id=$sql[cant];
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
$arrayTesa=doArrayDatosTesauro($_POST);
switch($do){
	case 'A':
	//Alta de vocabulario de referencia
	$sql=SQL("insert","into $DBCFG[DBprefix]config (titulo,autor,idioma,cobertura,keywords,tipo,polijerarquia,url_base,cuando) values ('$arrayTesa[titulo]','$arrayTesa[autor]','$arrayTesa[idioma]','$arrayTesa[cobertura]','$arrayTesa[keywords]','$arrayTesa[tipo]', '$arrayTesa[polijerarquia]', '$arrayTesa[url_base]','$arrayTesa[cuando]')");
	break;

	case 'M':
	//Modificacion de vocabulario de referencia y principal
	$sql=SQL("update","$DBCFG[DBprefix]config SET titulo='$arrayTesa[titulo]',
				autor='$arrayTesa[autor]',
				idioma='$arrayTesa[idioma]',
				cobertura='$arrayTesa[cobertura]',
				keywords= '$arrayTesa[keywords]',
				tipo= '$arrayTesa[tipo]',
				polijerarquia= '$arrayTesa[polijerarquia]',
				url_base= '$arrayTesa[url_base]',
				cuando='$arrayTesa[cuando]'
				where id='$vocabulario_id'");
	break;

	case 'B':
	//Eliminacion de un vocabulario de REFERENCIA
	break;
	}
return array("vocabulario_id"=>$vocabulario_id);
};


# cambios de configuracion y registro de vocabularios de referencia vía web services
function abm_targetVocabulary($do,$tvocab_id="0"){

GLOBAL $DBCFG;

$user_id=$_SESSION[$_SESSION["CFGURL"]][ssuser_id];

switch($do){
	case 'A':
	//Alta de vocabulario de referencia
	
	require('vocabularyservices.php')	;
	$arrayVocab[tvocab_uri_service]=$_POST[tvocab_uri_service];
	$arrayVocab=xmlVocabulary2array($arrayVocab[tvocab_uri_service].'?task=fetchVocabularyData');

/*
	Check web services
*/
	if($arrayVocab[result][vocabulary_id]=='1')
	{
		$array[tvocab_label]=$_POST[tvocab_label];
		$array[tvocab_tag]=$_POST[tvocab_tag];
		$array[tvocab_lang]=$_POST[tvocab_lang];
		$array[tvocab_title]=$arrayVocab[result][title];
		$array[tvocab_uri]=$arrayVocab[result][uri];
		$array[tvocab_uri_service]=$_POST[tvocab_uri_service];
		$array[tvocab_status]=$_POST[tvocab_status];
		
		$sql=SQL("insert","into $DBCFG[DBprefix]tvocab (tvocab_label, tvocab_tag,tvocab_lang, tvocab_title, tvocab_url, tvocab_uri_service, tvocab_status, cuando, uid) 
		VALUES 
		('$array[tvocab_label]', '$array[tvocab_tag]', '$array[tvocab_lang]', '$array[tvocab_title]', '$array[tvocab_uri]', '$array[tvocab_uri_service]', '$array[tvocab_status]', now(), '$user_id')");

		$tvocab_id=$sql[cant];
	}	
	else 
	{
		return false;
	}

	
	break;

	case 'M':
	require('vocabularyservices.php');
	
	$arrayVocab=ARRAYtargetVocabulary($tvocab_id);

	$arrayVocab=xmlVocabulary2array($arrayVocab[tvocab_uri_service].'?task=fetchVocabularyData');

/*
	Check web services
*/
	if($arrayVocab[result][vocabulary_id]=='1')
	{
		$array[tvocab_label]=$_POST[tvocab_label];
		$array[tvocab_tag]=$_POST[tvocab_tag];
		$array[tvocab_lang]=$_POST[tvocab_lang];
		$array[tvocab_status]=$_POST[tvocab_status];

		$array[tvocab_title]=$arrayVocab[result][title];
		$array[tvocab_uri]=$arrayVocab[result][uri];
		$array[tvocab_uri_service]=$arrayVocab[tvocab_uri_service];

	
		$sql=SQL("update","$DBCFG[DBprefix]tvocab set 
		tvocab_label='$array[tvocab_label]', 
		tvocab_tag='$array[tvocab_tag]', 
		tvocab_lang='$array[tvocab_lang]', 
		tvocab_title='$array[tvocab_title]',
		tvocab_url= '$array[tvocab_uri]', 
		#tvocab_uri_service='$array[tvocab_uri_service]', 
		tvocab_status='$array[tvocab_status]', 
		cuando=now(), 
		uid='$user_id'
		where tvocab_id='$tvocab_id'");
	 }
	 else 
	 {
		 //actualiza solo datos consignados
		 
		$array[tvocab_label]=$_POST[tvocab_label];
		$array[tvocab_tag]=$_POST[tvocab_tag];
		$array[tvocab_status]=$_POST[tvocab_status];
		 
		$sql=SQL("update","$DBCFG[DBprefix]tvocab set 
		tvocab_label='$array[tvocab_label]', 
		tvocab_tag='$array[tvocab_tag]', 
		tvocab_status='$array[tvocab_status]', 
		cuando=now(), 
		uid='$user_id'
		where tvocab_id='$tvocab_id'");	 
	 }	 	
	break;

	case 'B':
	//Eliminacion de un vocabulario de REFERENCIA
	
	//delete referenced terms from the service
	$sql=SQL("delete","from $DBCFG[DBprefix]term2tterm where tvocab_id='$tvocab_id'");
	
	//delete referenced service
	$sql=SQL("delete","from $DBCFG[DBprefix]tvocab where tvocab_id='$tvocab_id'");
		
	break;
	}
	
return array("tvocab_id"=>$tvocab_id);
};




function optimizarTablas(){

	GLOBAL $DBCFG;
	$sql=SQLoptimizarTablas("`$DBCFG[DBprefix]notas` , `$DBCFG[DBprefix]tabla_rel` , `$DBCFG[DBprefix]tema`,`$DBCFG[DBprefix]indice`,`$DBCFG[DBprefix]term2tterm`,`$DBCFG[DBprefix]tvocab`");

	$rows.='<div id="NA">';
	$rows.='<dl>';
	while($array=mysqli_fetch_array($sql)){
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
	case '1_1x1_2':
		$task=SQLupdateTemaTresVersion('1_1x1_2');
		
		$rows=($task["$ver2ver"]=='3') ? '<br/><span class="success">'.$install_message[306].'</span>' : '<br/><span class="error">'.ERROR.'</span>';
	break;

	default :

	break;
}

return $rows;

}

}; // fin funciones de administracion

#
# Vista de términos libres
#

function verTerminosLibres(){

	$sql=SQLverTerminosLibres();

	$rows.='<div><h1>'.ucfirst(LABEL_terminosLibres).' ('.$sql[cant].') </h1>';
	$rows.='<ul>';
	if($sql[cant]==0){
		$rows.='<li>'.ucfirst(MSG_noTerminosLibres).'<li/>';
	}else{
		while ($array = mysqli_fetch_array($sql[datos])){
		$rows.='<li><a title="'.$array[tema].'" href="index.php?tema='.$array[tema_id].'">'.$array[tema].'</a><li/>';
		};
	}
	$rows.='</ul>';
	$rows.='</div>';
return $rows;
};

#
# Vista de términos libres
#

function verTerminosRepetidos(){

$sql=SQLverTerminosRepetidos();

$rows.='<div><h1>'.ucfirst(LABEL_terminosRepetidos).' ('.$sql[cant].') </h1>';
$rows.='<ul>';

if($sql[cant]==0){
	$rows.='<li>'.ucfirst(MSG_noTerminosRepetidos).'<li/>';
	}else{
	while($array = mysqli_fetch_array($sql[datos])){
		$rows.='<li> <a title="'.$array[tema].'" href="index.php?'.FORM_LABEL_buscar.'='.$array[tema].'&tipo=E">'.$array[tema].'</a> ('.$array[cant].')<li/>';
		}
};
$rows.='</ul>';
$rows.='</div>';


return $rows;
};

###########################################################################
##########  HTML DE GESTION #############################################
###########################################################################
#
# Armado de tabla de términos según usuarios
#
function doBrowseTermsFromUser($user_id,$ord=""){

GLOBAL $MONTHS;

$sql=SQLlistTermsfromUser($user_id,$ord);

$rows.='<table cellpadding="0" cellspacing="0" summary="'.ucfirst(LABEL_auditoria).'">';
$rows.='<tbody>';
while($array=mysqli_fetch_array($sql[datos])){
	$user_id=$array[id_usuario];
	$apellido=$array[apellido];
	$nombres=$array[nombres];
	$fecha_termino=do_fecha($array[cuando]);
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="index.php?tema='.$array[id_tema].'" title="'.LABEL_verDetalle.LABEL_Termino.'">'.$array[tema].'</a></td>';
	$rows.='<td>'.$fecha_termino[dia].' / '.$fecha_termino[descMes].' / '.$fecha_termino[ano].'</td>';
	$rows.='</tr>';
	};
$rows.='</tbody>';

$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="3"><a href="sobre.php">'.ucfirst(LABEL_auditoria).'</a> &middot; <a href="admin.php?user_id='.$user_id.'"  title="'.LABEL_verDetalle.$apellido.', '.$nombres.'">'.$apellido.', '.$nombres.'</a>: '.$sql[cant].' '.LABEL_Terminos.'.</th>';
$rows.='</tr>';

$rows.='<tr>';
$rows.='<th><a href="sobre.php?user_id='.$user_id.'&ord=T" title="'.LABEL_ordenar.' '.LABEL_Termino.'">'.ucfirst(LABEL_Termino).'</a></th>';
$rows.='<th><a href="sobre.php?user_id='.$user_id.'&ord=F" title="'.LABEL_ordenar.' '.LABEL_Fecha.'">'.ucfirst(LABEL_Fecha).'</a></th>';
$rows.='</tr>';
$rows.='</thead>';


$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td class="izq">'.ucfirst(LABEL_TotalTerminos).'</td>';
$rows.='<td>'.$sql[cant].'</td>';
$rows.='</tr>';
$rows.='</tfoot>';

$rows.='</table>        ';
return $rows;
};


#
# Lista de usuarios
#
function HTMLListaUsers(){

$sqlListaUsers=SQLdatosUsuarios();

$rows.='<table cellpadding="0" cellspacing="0" summary="'.MENU_Usuarios.'" >';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="4">'.MENU_Usuarios.' &middot; [<a href="admin.php?user_id=new" title="'.MENU_NuevoUsuario.'">'.MENU_NuevoUsuario.'</a>]</th>';
$rows.='</tr>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_apellido).', '.ucfirst(LABEL_nombre).'</th>';
$rows.='<th>'.ucfirst(LABEL_orga).'</th>';
$rows.='<th>'.ucfirst(LABEL_Fecha).'</th>';
$rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
$rows.='</tr>';
$rows.='</thead>';

$rows.='<tbody>';

while($listaUsers=mysqli_fetch_array($sqlListaUsers[datos])){
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
$rows.='<td colspan="3">'.$sqlListaUsers[cant].'</td>';
$rows.='</tr>';
$rows.='</tfoot>';

$rows.='</table>        ';

return $rows;
};


#
# lista de vocabularios
#
function HTMLlistaVocabularios(){

$sql=SQLdatosVocabulario();

$rows.='<table cellpadding="0" cellspacing="0" summary="'.LABEL_lcConfig.'" >';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="3">'.LABEL_lcConfig.' &middot; [<a href="admin.php?vocabulario_id=0" title="'.MENU_NuevoVocabularioReferencia.'">'.LABEL_Agregar.' '.LABEL_vocabulario_referencia.'</a>]</th>';
$rows.='</tr>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_Titulo).'</th>';
$rows.='<th>'.ucfirst(LABEL_Autor).'</th>';
$rows.='<th>'.ucfirst(LABEL_tipo_vocabulario).'</th>';
$rows.='</tr>';
$rows.='</thead>';
$rows.='<tbody>';

while($array=mysqli_fetch_array($sql[datos])){
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

$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td colspan="3">'.$sql[cant].'</td>';
$rows.='</tr>';
$rows.='</tfoot>';
$rows.='</table>        ';

return $rows;
};


#
# lista de vocabularios referidos vía web services
#
function HTMLlistaTargetVocabularios(){

$sql=SQLtargetVocabulary("0");


$rows.='<table cellpadding="0" cellspacing="0" summary="'.LABEL_lcConfig.'" >';
$rows.='<thead>';
$rows.='<tr>';
$rows.='<th class="izq" colspan="3">'.LABEL_lcConfig.' &middot; [<a href="admin.php?tvocabulario_id=0&doAdmin=seeformTargetVocabulary" title="'.MENU_NuevoVocabularioReferencia.'">'.LABEL_Agregar.' '.LABEL_vocabulario_referenciaWS.'</a>]</th>';
$rows.='</tr>';
$rows.='<tr>';
$rows.='<th>'.ucfirst(LABEL_tvocab_label).'</th>';
$rows.='<th>'.ucfirst(LABEL_Titulo).'</th>';
$rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
$rows.='</tr>';
$rows.='</thead>';
$rows.='<tbody>';

while($array=mysqli_fetch_array($sql[datos])){
	$fecha_alta=do_fecha($listaUsers[cuando]);
	
	$label_tvocab_status=($array[tvocab_status]=='1') ? ucfirst(LABEL_enable) : ucfirst(LABEL_disable);
	
	$rows.='<tr>';
	$rows.='<td class="izq"><a href="admin.php?tvocab_id='.$array[tvocab_id].'&amp;doAdmin=seeformTargetVocabulary" title="'.MENU_DatosTesauro.' '.$array[tvocab_title].'">'.FixEncoding($array[tvocab_label]).'</a> ('.FixEncoding($array[tvocab_tag]).')</td>';
	$rows.='<td class="izq"><a href="'.$array[tvocab_url].'" title="'.LABEL_vocabulario_referenciaWS.' '.FixEncoding($array[tvocab_title]).'">'.FixEncoding($array[tvocab_title]).'</a></td>';
	
	//hay términos y esta habilitado
	if ($array[cant]>0)
	{
		$rows.='<td><a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;tvocab_id='.$array[tvocab_id].'">'.$label_tvocab_status.': '.$array[cant].'</a></td>';		
	}
	$rows.='</tr>';
	};

$rows.='</tbody>';

$rows.='<tfoot>';
$rows.='<tr>';
$rows.='<td colspan="3">'.$sql[cant].'</td>';
$rows.='</tr>';
$rows.='</tfoot>';
$rows.='</table>        ';

return $rows;
};

#
# lista de términos de un vocabulario referido vía web services
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



while($array=mysqli_fetch_array($sql[datos])){

	$last_term_update=($array[cuando_last]) ? $array[cuando_last] : $array[cuando];
	
	if($_GET["doAdmin2"]=='checkDateTermsTargetVocabulary')
	{
		$iUpd=0;
		
		$ARRAYSimpleChkUpdateTterm=ARRAYSimpleChkUpdateTterm("tematres",$array[tterm_uri]);
/*
		El término no existe más en el vocabulario de destino
*/
		if(!$ARRAYSimpleChkUpdateTterm[result][term][tema_id])
		{
			$linkUpdateTterm["$array[tterm_uri]"].= '<ul class="errorNoImage">';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li><strong>'.ucfirst(LABEL_notFound).'</strong></li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '</ul>';
			$array[tema_id]["status_tterm"]= false;
		}
/*
		hay actualizacion del término
*/
		elseif ($ARRAYSimpleChkUpdateTterm[result][term][date_mod]>$last_term_update) 
		{
			$iUpd=++$iUpd;
			$ARRAYupdateTterm["$array[tterm_uri]"]["string"]=FixEncoding($ARRAYSimpleChkUpdateTterm[result][term]["string"]);	
			$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"]=$ARRAYSimpleChkUpdateTterm[result][term]["date_mod"];
						
			$linkUpdateTterm["$array[tterm_uri]"].= '<ul class="warningNoImage">';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li><strong>'.$ARRAYupdateTterm["$array[tterm_uri]"]["string"].'</strong></li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>'.$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"].'</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tgetTerm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=updTgetTerm" title="'.ucfirst(LABEL_actualizar).'">'.ucfirst(LABEL_actualizar).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '<li>[<a href="admin.php?doAdmin=seeTermsTargetVocabulary&amp;doAdmin2=checkDateTermsTargetVocabulary&amp;tvocab_id='.$ARRAYtargetVocabulary[tvocab_id].'&amp;f='.$from.'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
			$linkUpdateTterm["$array[tterm_uri]"].= '</ul>';
			
			$array[tema_id]["status_tterm"]= true;
		}
		else
		{
			$array[tema_id]["status_tterm"]= true;
		}
	}
	
	$rows.='<tr>';
	
	$rows.='<td class="izq"><a href="index.php?tema='.$array[tema_id].'" title="'.LABEL_verDetalle.' '.$array[tema].'">'.$array[tema].'</a></td>';
	$rows.='<td class="izq">';
	
	$rows.=($array[tema_id]["status_tterm"]==1) ? ' <a href="'.$array[tterm_url].'" title="'.LABEL_verDetalle.' '.FixEncoding($array[tterm_string]).'" >'.FixEncoding($array[tterm_string]).'</a>' : FixEncoding($array[tterm_string]);
	
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
$rows.='</table>        ';


$thead.='<table cellpadding="0" cellspacing="0" summary="'.LABEL_lcConfig.'" >';
$thead.='<thead>';
$thead.='<tr>';
$thead.='<th class="izq" colspan="3"><a href="admin.php" title="'.ucfirst(LABEL_lcConfig).'">'.ucfirst(LABEL_lcConfig).'</a> &middot; '.$ARRAYtargetVocabulary[tvocab_title].' &middot '.(($array[tvocab_status]=='1') ? LABEL_enable : LABEL_disable).'</th>';
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


function HTMLformExport(){
$LABEL_jtxt=MENU_ListaSis.' (txt)';
$LABEL_abctxt=MENU_ListaAbc.' (txt)';

$rows.='<h1>'.ucfirst(LABEL_Admin).'</h1><fieldset>';
$rows.='    <legend>'.ucfirst(LABEL_export).'</legend>';
$rows.='<form class="formdiv" name="export" action="xml.php" method="get">';
$rows.='<label for="dis">'.ucfirst(FORM_LABEL_format_export).'</label><br />';
$rows.='<select id="dis" name="dis">';
$rows.='<optgroup label="'.FORM_LABEL_format_export.'">';
$rows.=doSelectForm(array("jtxt#$LABEL_jtxt","txt#$LABEL_abctxt","zline#Zthes","rfile#Skos-Core","rxtm#TopicMap","BSfile#BS8723","siteMap#SiteMap","rsql#SQL (Backup)"),"$_GET[dis]");
$rows.='</optgroup>';
$rows.='</select>';
$rows.='<div class="submit_form" align="center">';
$rows.='<br /><input type="submit"  name="boton" value="'.LABEL_Guardar.'"/>';
$rows.=' | <input type="button"  name="cancelar" type="button" onClick="location.href=\'admin.php\'" value="'.ucfirst(LABEL_Cancelar).'"/>';
$rows.='</div>';
$rows.='</form>';
$rows.='  </fieldset>';

return $rows;
};


// 
// Exportaciones totales del vocabularios
// 

function doTotalZthes($tipoEnvio){

$time_start = time();

@set_time_limit(900);

switch($tipoEnvio){
	case 'line':
	$sql=SQLIdTerminosValidos();

		header ('content-type: text/xml');
		outputCosas('<?xml version="1.0" encoding="ISO-8859-1"?>');
		outputCosas('<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/xml/zthes-05.dtd">');
		outputCosas('<?xml-stylesheet href="http://'.$_SERVER['HTTP_HOST']. rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/css/zthes.xsl" type="text/xsl"?>');
		outputCosas('        <Zthes>');
		while($array=mysqli_fetch_row($sql[datos])){
		outputCosas(do_nodo_zthes($array[0],"TRUE"));
		};
		outputCosas('</Zthes>');

	break;

	#enviar como archivo  !!!no implementado!!!
	case 'file':

	$sql=SQLIdTerminosValidos();
	while($array=mysqli_fetch_row($sql[datos])){

		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};

		$zthes.=do_nodo_zthes($array[0],"TRUE");
	};

		$meta_tag.='<?xml version="1.0" encoding="ISO-8859-1"?>';
		$meta_tag.='<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/xml/zthes-05.dtd">';
		$meta_tag.='<Zthes>';
		$meta_tag.=$zthes;
		$meta_tag.='</Zthes>';

	$filname=string2url($_SESSION[CFGTitulo]).'.xml';
	return sendFile("$meta_tag","$filname");

	break;
	};

};


/*
 * Exportación total según esquema BS8723
*/
function doTotalBS8723($tipoEnvio){

$time_start = time();

@set_time_limit(900);

switch($tipoEnvio){
	#enviar como archivo
	case 'file':
	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="ISO-8859-1"?>';
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
	
	while($array=mysqli_fetch_row($sql[datos]))
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



function doTotalSkos($tipoEnvio){

$time_start = time();

@set_time_limit(900);

switch($tipoEnvio){
	case 'line':

	# Top term del esquema
	$sqlTT=SQLverTopTerm();
	while ($arrayTT=mysqli_fetch_array($sqlTT[datos])){
		$skos_TT.='<skos:hasTopConcept rdf:nodeID="tema'.$arrayTT[id].'"/>';
		};

		header ('content-type: text/xml');
		outputCosas('<?xml version="1.0" encoding="ISO-8859-1"?>');
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
while($array=mysqli_fetch_row($sql[datos]))
	{
	outputCosas(do_nodo_skos($array[0]));
	};
outputCosas('</rdf:RDF>');
break;

#enviar como archivo  !!!no implementado!!!
case 'file':
	$sql=SQLIdTerminosValidos();

	while($array=mysqli_fetch_row($sql[datos])){

	#Mantener vivo el navegador
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	$skosNodos.=do_nodo_skos($array[0]);
	};

	$meta_tag=do_skos($skosNodos);

	$filname=string2url($_SESSION[CFGTitulo]).'.rdf';
	return sendFile("$meta_tag","$filname");
	break;
	};

};



function doTotalTopicMap($tipoEnvio){

$time_start = time();

@set_time_limit(900);

switch($tipoEnvio){
	case 'line':
	$sql=SQLIdTerminosValidos();

	header ('content-type: text/xml');
	outputCosas('<?xml version="1.0" encoding="ISO-8859-1"?>');
	outputCosas(XTMheader);
	outputCosas(doTerminosXTM());
	outputCosas(doRelacionesXTM());
	outputCosas('</topicMap>');
	break;

	#enviar como archivo
	case 'file':
	header ('content-type: text/xml');
	$row.='<?xml version="1.0" encoding="ISO-8859-1"?>';
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

while ($array=mysqli_fetch_array($sql[datos])){
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	($array[cuando_final]>0) ? $fecha = do_fecha($array[cuando_final]) : $fecha = do_fecha($array[cuando]);


	//valores posibles para prioridad
    $priority_values=array("0.0", "0.1", "0.2", "0.3", "0.4", "0.5", "0.6", "0.7", "0.8", "0.9", "1.0");
    
    $term_distance=substr_count($array[indice],'|');

	//Cálculo de prioridad
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




function txtAlfabetico(){

$txt=ucfirst(LABEL_Titulo).': '.$_SESSION["CFGTitulo"]."\r\n";
$txt.=ucfirst(LABEL_Autor).': '.$_SESSION["CFGAutor"]."\r\n";
$txt.=ucfirst(LABEL_Keywords).': '.$_SESSION["CFGKeywords"]."\r\n";
$txt.=ucfirst(LABEL_Cobertura).': '.$_SESSION["CFGCobertura"]."\r\n";
$txt.=LABEL_URI.': '.$_SESSION["CFGURL"]."\r\n";
$txt.=ucfirst(LABEL_Version).': '.$_SESSION["CFGVersion"]."\r\n";
$txt.="__________________________________________________________________________\r\n";

//Lista de todos los términos
$sql=SQLlistaTemas();
while($arrayTema=mysqli_fetch_array($sql[datos])){

	#Mantener vivo el navegador
	$time_now = time();
	if ($time_start >= $time_now + 10) {
		$time_start = $time_now;
		header('X-pmaPing: Pong');
	};

	// Diferenciar entre términos preferidos y términos no preferidos o referencias
	if($arrayTema[t_relacion])// Si es no preferido o refencia: mostrar preferido y referido
	{
	//Remisiones de equivalencias y no preferidos
	$sqlNoPreferidos=SQLterminosValidosUF($arrayTema[id]);
	while($arrayNoPreferidos=mysqli_fetch_array($sqlNoPreferidos[datos])){

		$acronimo=arrayReplace ( array("4","5","7","8"),array(USE_termino,EQ_acronimo,EQP_acronimo,NEQ_acronimo),$arrayNoPreferidos[t_relacion]);
	
		$referencia_mapeo = ($arrayNoPreferidos[vocabulario_id]!=='1') ? (' ('.$arrayNoPreferidos[titulo].' / '.$arrayNoPreferidos[idioma].')') : ('')."\r\n";

		$txt.="\n".$arrayTema[tema] . $referencia_mapeo ;
		$txt.='	'.$acronimo.': '.$arrayNoPreferidos[tema_pref]."\r\n";
		};


	} else {// Si es preferido: mostar notas y relaciones
	$txt.="\n".$arrayTema[tema]."\r\n";

	$txt.=LABEL_fecha_creacion.': '.$arrayTema[cuando]."\r\n";
	if($arrayTema[cuando_final]>$arrayTema[cuando])	{$txt.=LABEL_fecha_modificacion.': '.$arrayTema[cuando_final]."\r\n";};

	//Notas
	$sqlNotas=SQLdatosTerminoNotas($arrayTema[id],array("NB","NH","NA","NC"));
	while($arrayNotas=mysqli_fetch_array($sqlNotas[datos])){
		$acronimo=arrayReplace ( array("NB","NH","NA","NC"),array(NB_acronimo,NH_acronimo,NA_acronimo,NC_acronimo),$arrayNotas[tipo_nota]);
		$txt.='	'.$acronimo.': '.html2txt($arrayNotas[nota])."\r\n";
		};

	//Relaciones
	$sqlRelaciones=SQLverTerminoRelaciones($arrayTema[id]);

	$arrayRelacionesVisibles=array("2","3","4"); // TG/TE/UP /TR
	while($arrayRelaciones=mysqli_fetch_array($sqlRelaciones[datos])){
		
		if(in_array($arrayRelaciones[t_relacion],$arrayRelacionesVisibles)){

			$acronimo=arrayReplace ( $arrayRelacionesVisibles,array(TR_acronimo,TG_acronimo,UP_acronimo),$arrayRelaciones[t_relacion]);
			$txt.='	'.$acronimo.': '.$arrayRelaciones[tema]."\r\n";
			
			}

		};

	//Terminos especificos
	$SQLTerminosE=SQLverTerminosE($arrayTema[id]);
	while($arrayTE=mysqli_fetch_array($SQLTerminosE[datos])){
		$txt.='	'.TE_acronimo.': '.$arrayTE[tema]."\r\n";
		};
	}
}

$filname=string2url($_SESSION[CFGTitulo].' '.MENU_ListaAbc).'.txt';

return sendFile("$txt","$filname");
};


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
while($arrayTema=mysqli_fetch_array($sql[datos])){

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

//Contador de profundidad de TE desde la raíz
	while($array=mysqli_fetch_array($sql[datos])){
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
 * http://davidwalsh.name/backup-mysql-database-php
 * */
function do_mysql_dump($encode="utf8")
{
	GLOBAL $DBCFG;
	
	$tables= $DBCFG[DBprefix].'config,'.$DBCFG[DBprefix].'tema,'.$DBCFG[DBprefix].'tabla_rel,'.$DBCFG[DBprefix].'indice,'.$DBCFG[DBprefix].'usuario,'.$DBCFG[DBprefix].'notas,'.$DBCFG[DBprefix].'values,'.$DBCFG[DBprefix].'tvocab,'.$DBCFG[DBprefix].'term2tterm';
	
	$link = mysql_connect($DBCFG["Server"],$DBCFG["DBLogin"],$DBCFG["DBPass"]);
	mysql_select_db($DBCFG["DBName"],$link);


	/*
	 * To UTF-8 databases
	*/
	if($encode=='utf8')
	{
		mysql_query('SET NAMES utf8');
		mysql_query('SET CHARACTER SET utf8');	
	}
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
				
		$return.= 'DROP TABLE IF EXISTS '.$table.'; ';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
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
?>
