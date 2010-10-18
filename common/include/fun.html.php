<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Funciones HTML. #
#

#
# Armado de resultados de búsqueda
#
function resultaBusca($texto,$tipo=""){

$texto=trim($texto);

//Anulación de sugerencia de términos
$sgs=$_GET[sgs];

//Ctrol lenght string
if((strlen($texto)>=CFG_MIN_SEARCH_SIZE) || ($tipo=='E'))
{
	$sql= ($tipo=='E') ? SQLbuscaExacta("$texto") : SQLbuscaSimple("$texto");
	
	$classMensaje= ($sql[cant]) ? 'information' : 'warning';
	
	$resumeResult = '<p class='.$classMensaje.'><strong>'.$sql[cant].'</strong> '.MSG_ResultBusca.' <strong> "<em>'.stripslashes($texto).'</em>"</strong></p>';
} 
else
{
	$sql[cant]='0';	
	$resumeResult = '<p class="error">'.sprintf(MSG_minCharSerarch,stripslashes($texto),strlen($texto),CFG_MIN_SEARCH_SIZE-1).'</p>';
}

 $body.='<div id="bodyText"><h1>'.LABEL_busqueda.'</h1>';
 
 $body.=$resumeResult;

if($sql[cant]>0)
 {
	 $row_result.='<div id="listaBusca"><ul>';

	 while($resulta_busca=mysqli_fetch_array($sql[datos])){
		$ibusca=++$ibusca;
		$acumula_indice.=$resulta_busca[indice];
		
		$acumula_temas.=$resulta_busca[id_definitivo].'|';

		if($ibusca=='1')
		{
			//Guardar el primer término para ver si hay coincidencia exacta
			$primerTermino=$resulta_busca[tema];
		}
		
		$leyendaTerminoLibre=($resulta_busca[esTerminoLibre]=='SI') ? ' ('.LABEL_terminoLibre.')' : '';

	//Si no es un término preferido
		if($resulta_busca[termino_preferido])
		{
				switch($resulta_busca[t_relacion])
				{
				case '4':					//UF
				$leyendaConector=USE_termino;
				break;
	
				case '5'://Tipo relacion término equivalente parcialmente
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
	
				case '6'://Tipo relacion término equivalente
				$leyendaConector='<acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym>';
				break;
	
				case '7'://Tipo relacion término no equivalente
				$leyendaConector='<acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym>';
				break;
	
				case '8'://Tipo relacion término equivalente inexacta
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
				}

			$row_result.='<li><em><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[tema_id].'&amp;/'.string2url($resulta_busca[tema]).'">'.$resulta_busca[tema].'</a></em> '.$leyendaConector.' <a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[id_definitivo].'">'.$resulta_busca[termino_preferido].'</a> </li>'."\r\n" ;
		}
		else // es un término preferido
		{
			$row_result.='<li><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[id_definitivo].'&amp;/'.string2url($resulta_busca[tema]).'">'.$resulta_busca[tema].'</a> '.$leyendaTerminoLibre.'</li>'."\r\n" ;
		}

	 };//fin del while
	$row_result.='</ul>';
	$row_result.='</div>';

	//Si no hubo coincidencia exacta
	if((strtoupper($primerTermino)!==trim(strtoupper($texto))) && ($_GET[sgs]!='off'))
	{
		$body.=HTMLsugerirTermino($texto,$acumula_temas);
	}

}
elseif(strlen($texto)>=CFG_MIN_SEARCH_SIZE)// Si no hay resultados y la expresión es mayor al mínimo
{

	$body.=HTMLsugerirTermino($texto);

};// fin de if result

$result_suplementa.=HTMLbusquedaExpandidaTG($acumula_indice,$acumula_temas);
$result_suplementa.=HTMLbusquedaExpandidaTR($acumula_temas);

if(strlen($result_suplementa)>0)
{
		$result_suplementa='<div id="lista_secundaria">'.$result_suplementa.'</div>';
}

return $body.$row_result.$result_suplementa.'</div>';
};
#######################################################################

#
#  ARMADOR DE HTML CON DATOS DEL TERMINO
#
function doContextoTermino($idTema,$i_profundidad){
	
GLOBAL $CFG;

//recibe de HTMLbodyTermino
//$idTema = id del término
//$i_profundidad= contador de profundidad

//Terminos específicos
$sqlNT=SQLverTerminosE($idTema);

//Se devolverá el tema_id para utilizar en fuentes XML y como tema_id canónico
$tema_id=$idTema;

while ($datosNT=mysqli_fetch_array($sqlNT[datos])){
	$int=++$int;
	if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
		$td_delete='[<a id="elimina_'.$datosNT[id_tema].'" title="'.LABEL_borraRelacion.'"  class="eliminar" href="'.$PHP_SELF.'?ridelete='.$datosNT[id_relacion].'&amp;tema='.$idTema.'" onclick="return askData();"><acronym title="'.LABEL_borraRelacion.'" lang="'.LANG.'">x</acronym></a>]';
		}else{
		$td_delete='';
		};

	if($datosNT[id_te]){
		$link_next=' [<a href="javascript:expand(\''.$datosNT[id_tema].'\')" title="'.LABEL_verDetalle.' '.$datosNT[tema].'"><span id="expandTE'.$datosNT[id_tema].'">+</span><span id="contraeTE'.$datosNT[id_tema].'" style="display: none">~</span></a>]';
		$link_next.=HTMLverTE($datosNT[id_tema],$i_profundidad);
		}else{
		$link_next='';
		};
	$row_NT.=' <li id="t'.$datosNT[id_tema].'">'.$td_delete.'<acronym title="'.TE_termino.'" lang="'.LANG.'">'.TE_acronimo.$i_profundidad.'</acronym>';
	
	//Editor de código
	if(($_SESSION[$_SESSION["CFGURL"]][ssuser_id]) && ($CFG["_USE_CODE"]=='1'))
	{
		$row_NT.='<div title="term code, click to edit" class="editable_textarea" id="code_tema'.$datosNT[id_tema].'">'.$datosNT[code].'</div>';
	}
	else 
	{
		$row_NT.=' '.$datosNT[code].' ';
	}
	$row_NT.='<a title="'.LABEL_verDetalle.' '.$datosNT[tema].' ('.TE_termino.')"  href="index.php?tema='.$datosNT[id_tema].'&amp;/'.string2url($datosNT[tema]).'">'.$datosNT[tema].'</a>'.$link_next.'</li>';
	
	
};

// Terminos TG, UF y TR
$sqlTotalRelacionados=SQLverTerminoRelaciones($idTema);

while($datosTotalRelacionados= mysqli_fetch_array($sqlTotalRelacionados[datos])){
	if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
		$td_delete='[<a  class="eliminar" title="'.LABEL_borraRelacion.'" href="'.$PHP_SELF.'?ridelete='.$datosTotalRelacionados[id_relacion].'&amp;tema='.$idTema.'" onclick="return askData();"><acronym title="'.LABEL_borraRelacion.'" lang="'.LANG.'">x</acronym></a>]';
		}else{
		$td_delete='';
		};

	switch($datosTotalRelacionados[t_relacion]){
	case '3':// TG
	$itg=++$itg;
	$row_TG.='          <li>'.$td_delete.'<acronym title="'.TG_termino.'" lang="'.LANG.'">'.TG_acronimo.'</acronym>';
	$row_TG.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.TG_termino.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a></li>';
	break;

	case '4':// UF
	$iuf=++$iuf;
	$row_UP.='          <li>'.$td_delete.'<acronym title="'.UP_termino.'" lang="'.LANG.'">'.UP_acronimo.'</acronym>';
	$row_UP.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.UP_termino.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a></li>';	
	break;

	case '2':// TR
	$irt=++$irt;
	$row_TR.='          <li>'.$td_delete.'<acronym title="'.TR_termino.'" lang="'.LANG.'">'.TR_acronimo.'</acronym>';
	$row_TR.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.TR_termino.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a></li>';
	break;

	case '5':// parcialmente EQ
	$ieq=++$ieq;
	$row_EQ.='          <li>'.$td_delete.' <acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym> ';
	$row_EQ.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.LABEL_termino_parcial_equivalente.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a> ('.$datosTotalRelacionados[titulo].' / '.$datosTotalRelacionados[idioma].')</li>';
	break;

	case '6':// EQ
	$ieq=++$ieq;
	$row_EQ.='          <li>'.$td_delete.' <acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym> ';
	$row_EQ.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.LABEL_termino_equivalente.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a> ('.$datosTotalRelacionados[titulo].' / '.$datosTotalRelacionados[idioma].')</li>';
	break;

	case '7':// NO EQ
	$ieq=++$ieq;
	$row_EQ.='          <li>'.$td_delete.' <acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym> ';
	$row_EQ.='          <a title="'.LABEL_verDetalle.' '.$datosTotalRelacionados[tema].' ('.LABEL_termino_no_equivalente.')"  href="index.php?tema='.$datosTotalRelacionados[id].'&amp;/'.string2url($datosTotalRelacionados[tema]).'">'.$datosTotalRelacionados[tema].'</a> ('.$datosTotalRelacionados[titulo].' / '.$datosTotalRelacionados[idioma].')</li>';
	break;
	}
};

//Si no es un término válido y es un UF.
if($sqlTotalRelacionados[cant]==0){
	
	$sqlTerminosValidosUF=SQLterminosValidosUF($idTema);

	while($arrayTerminosValidosUF= mysqli_fetch_array($sqlTerminosValidosUF[datos])){
		
		//Reasignación del tema_id para utilizar en fuentes XML y como tema_id canónico
		$tema_id=$arrayTerminosValidosUF[tema_pref_id];
		
		switch($arrayTerminosValidosUF[t_relacion]){

		case '4':// USE
			$leyendaConector=USE_termino;
			$iuse=++$iuse;
			$row_USE.='<li><em>'.$arrayTerminosValidosUF[tema].'</em> '.$leyendaConector.' <a title="'.LABEL_verDetalle.$arrayTerminosValidosUF[tema_pref].'" href="index.php?tema='.$arrayTerminosValidosUF[tema_pref_id].'">'.$arrayTerminosValidosUF[tema_pref].'</a> </li>'."\r\n" ;
		break;


		case '5':// parcialmente EQ
			$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
			$ieq=++$ieq;
			$row_EQ='<li><em>'.$arrayTerminosValidosUF[tema].'</em> ('.$arrayTerminosValidosUF[titulo].' / '.$arrayTerminosValidosUF[idioma].') '.$leyendaConector.' <a title="'.LABEL_verDetalle.$arrayTerminosValidosUF[tema_pref].'" href="index.php?tema='.$arrayTerminosValidosUF[tema_pref_id].'">'.$arrayTerminosValidosUF[tema_pref].'</a> </li>'."\r\n" ;
		break;

		case '6':// EQ
			$leyendaConector='<acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym>';
			$ieq=++$ieq;
			$row_EQ='<li><em>'.$arrayTerminosValidosUF[tema].'</em> ('.$arrayTerminosValidosUF[titulo].' / '.$arrayTerminosValidosUF[idioma].') '.$leyendaConector.' <a title="'.LABEL_verDetalle.$arrayTerminosValidosUF[tema_pref].'" href="index.php?tema='.$arrayTerminosValidosUF[tema_pref_id].'">'.$arrayTerminosValidosUF[tema_pref].'</a> </li>'."\r\n" ;
		break;

		case '7':// NO EQ
			$leyendaConector='<acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym>';
			$ieq=++$ieq;
			$row_EQ='<li><em>'.$arrayTerminosValidosUF[tema].'</em> ('.$arrayTerminosValidosUF[titulo].' / '.$arrayTerminosValidosUF[idioma].') '.$leyendaConector.' <a title="'.LABEL_verDetalle.$arrayTerminosValidosUF[tema_pref].'" href="index.php?tema='.$arrayTerminosValidosUF[tema_pref_id].'">'.$arrayTerminosValidosUF[tema_pref].'</a> </li>'."\r\n" ;
		break;
		}
	};
}

$rows=array("UP"=>doListaTag($iuf,"ul",$row_UP,"UP"),
	"USE"=>doListaTag($iuse,"ul",$row_USE,"EQ"),
	"TR"=>doListaTag($irt,"ul",$row_TR,"TR"),
	"TG"=>doListaTag($itg,"ul",$row_TG,"TG"),
	"TE"=>doListaTag($int,"ul",$row_NT,"TE"),
	"EQ"=>doListaTag($ieq,"ul",$row_EQ,"EQ")
	);

$cant_relaciones=array(
		"cantUF"=>$iuf,
		"cantRT"=>$irt,
		"cantTG"=>$itg,
		"cantNT"=>$int,
		"cantTotal"=>$iuf+$irt+$itg+$int
		);

return array("HTMLterminos"=>$rows,
			 "cantRelaciones"=>$cant_relaciones,
			 "tema_id"=>$tema_id);
};
#######################################################################


function HTMLbodyTermino($array){

GLOBAL $MSG_ERROR_RELACION;
GLOBAL $CFG;

  $sqlMiga=SQLarbolTema($array[idTema]);
  
  $HTMLterminos=doContextoTermino($array[idTema],$sqlMiga[cant]);
  
  $fecha_crea=do_fecha($array[cuando]);
  $fecha_estado=do_fecha($array[cuando_estado]);
  
		
//Si tiene padres
if($sqlMiga[cant]){
	while($arrayMiga=mysqli_fetch_array($sqlMiga[datos])){
		if($arrayMiga[tema_id]!==$array[idTema]){
			$menu_miga.='<li><a title="'.LABEL_verDetalle.$arrayMiga[tema].'" href="index.php?tema='.$arrayMiga[tema_id].'&amp;/'.string2url($arrayMiga[tema]).'" >'.$arrayMiga[tema].'</a></li>';
			}
		}
	};

$row_miga.='<ol><li><a title="'.MENU_Inicio.'" href="index.php">'.ucfirst(MENU_Inicio).'</a></li>'.$menu_miga.'<li>'.$array[titTema].'</li></ol>';




$body='<div id="bodyText">';

//MENSAJE DE ERROR
$body.=$MSG_ERROR_RELACION;

$body.=' <h1 id="T'.$array[tema_id].'">'.$array[titTema].'</h1>';


if(($_SESSION[$_SESSION["CFGURL"]][ssuser_id])||(CFG_VIEW_STATUS=='1'))
	{
	$label_estado='<span class="estado_termino'.$array[estado_id].'"> ' .ucfirst( arrayReplace(array("12","13","14"),array(LABEL_Candidato,LABEL_Aceptado,LABEL_Rechazado),$array[estado_id])). ': '.$fecha_estado[dia].'-'.$fecha_estado[descMes].'-'.$fecha_estado[ano].'</span> ';
   	};

#Div miga de pan
$body.='<div id="breadScrumb">';
$body.=$row_miga;
$body.='</div>';
# fin Div miga de pan

$body.=HTMLNotasTermino($array);

#Div relaciones del terminos
$body.='<div id="relacionesTermino">';
$body.=$HTMLterminos[HTMLterminos]["UP"];
$body.=$HTMLterminos[HTMLterminos]["TG"];

	//Editor de código
	if(($_SESSION[$_SESSION["CFGURL"]][ssuser_id]) && ($CFG["_USE_CODE"]=='1'))
	{
		$body.='<div title="term code, click to edit" class="editable_textarea" id="code_tema'.$array[tema_id].'">'.$array[code].'</div>';
		
		$body.=HTMLtermMenu($array,$HTMLterminos[cantRelaciones]);

	}
	else 
	{
		$body.= ($array[code]) ? ' <label class="code_tema" for="T'.$array[tema_id].'">'.$array[code].'</label>' : '';
	}

//el termino
if($_SESSION[$_SESSION["CFGURL"]][ssuser_id])
{
	//span editable
	$body.=doListaTag('1',"h5",'<span id="edit_tema'.$array[tema_id].'" class="edit_area_term">'.$array[titTema].'</span> ',"term");	
}
else 
{
	$body.=doListaTag('1',"h5",$array[titTema],"term");
}


$body.=$HTMLterminos[HTMLterminos]["USE"];
$body.=$HTMLterminos[HTMLterminos]["TE"];
$body.=$HTMLterminos[HTMLterminos]["TR"];
$body.=$HTMLterminos[HTMLterminos]["EQ"];


$body.=HTMLtargetTerms($array[tema_id]);



$body.='</div>';


#Fin div bodyText
$body.='</div>';

#Div pie de datos
$body.='<div id="pie_datos" class="enlacefoo"><ul id="fechas"><li> '.LABEL_Fecha.': '.$fecha_crea[dia].'-'.$fecha_crea[descMes].'-'.$fecha_crea[ano].'</li>';
if($array[cuando_final]){
	$fecha_cambio=do_fecha($array[cuando_final]);
	$body.='<li>'.LABEL_fecha_modificacion.': '.$fecha_cambio[dia].'-'.$fecha_cambio[descMes].'-'.$fecha_cambio[ano].'</li> ';
	}
$body.='</ul>'.$label_estado.'</div> ';
# fin Div pie de datos


$body.=HTML_URLsearch($CFG[SEARCH_URL_SITES],$array);

/*
 * $HTMLterminos[tema_id] es el ID del término válido siempre
 * 
*/
$body.='<ul id="enlaces_xml">';
$body.='        <li><a title="'.LABEL_verEsquema.' MADS"  href="xml.php?madsTema='.$HTMLterminos[tema_id].'">MADS</a></li>  ';
$body.='        <li><a title="'.LABEL_verEsquema.' Zthes" href="xml.php?zthesTema='.$HTMLterminos[tema_id].'">Zthes</a></li>  ';
$body.='        <li><a title="'.LABEL_verEsquema.' Skos"  href="xml.php?skosTema='.$HTMLterminos[tema_id].'">SKOS-Core</a></li>';
$body.='        <li><a title="'.LABEL_verEsquema.' BS8723-5"  href="xml.php?bs8723Tema='.$HTMLterminos[tema_id].'">BS8723-5</a></li>';
$body.='        <li><a title="'.LABEL_verEsquema.' TopicMap"  href="xml.php?xtmTema='.$HTMLterminos[tema_id].'">XTM</a></li>';
$body.='        <li><a title="'.LABEL_verEsquema.' Dublin Core"  href="xml.php?dcTema='.$HTMLterminos[tema_id].'">DC</a></li>';
$body.='</ul>';

return $body;
};

/*
menu: deprecated
*/
function do_menuABM($array_tema,$relacionesTermino){
//Sólo si hay session
if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){

$sqlcheckIsValidTerm=SQLcheckIsValidTerm($array_tema[idTema]);


if(($relacionesTermino[cantTotal])=='0'){
	$link_borra='<li><a title="'.LABEL_EliminarTE.'" href="index.php?id_dete='.$array_tema[idTema].'">'.ucfirst(LABEL_EliminarTE).'</a></li>';

	switch($array_tema[estado_id])
		{
		case '12':
		//Candidato / candidate => aceptado
		$link_borra.='<li><a title="'.LABEL_AceptarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=13">'.ucfirst(LABEL_AceptarTermino).'</a></li>';
		//Candidato / candidate => rechazado
		$link_borra.='<li><a title="'.LABEL_RechazarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=14">'.ucfirst(LABEL_RechazarTermino).'</a></li>';
		break;

		case '13':
		//Aceptado / Acepted=> Rechazado
		$link_borra.='<li><a title="'.LABEL_RechazarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=14">'.ucfirst(LABEL_RechazarTermino).'</a></li>';
		break;

		case '14':
		//Rechazado / Rejected=> Candidato
		$link_borra.='<li><a title="'.LABEL_CandidatearTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=12">'.ucfirst(LABEL_CandidatearTermino).'</a></li>';
		break;
		}
};


// PERMITIR O NO POLIJERARQUIAS//
if( ( ($relacionesTermino[cantTG]==0) || ($_SESSION[CFGPolijerarquia]=='1') ) && ($array_tema[estado_id]=='13')){
	$link_subordinar='<li><a title="'.MENU_AgregarTG.'" href="index.php?taskterm=addBT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTG).'</a></li>';
};

	$row.='<div id="menu_edicion"><menu id="menu_editor">';

	//es admin
	if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){
		$row.='<li><a href="#" onmouseover="montre(\'menu_admin\');" onmouseout="cache(\'menu_admin\');" >'.LABEL_Admin.'</a>';
		$row.='<menu id="menu_admin" onmouseover="montre(\'menu_admin\');" onmouseout="cache(\'menu_admin\');">';
		$row.='<li><a title="'.ucfirst(LABEL_lcConfig).'" href="admin.php?vocabulario_id=list">'.ucfirst(LABEL_lcConfig).'</a></li>';
		$row.='<li><a title="'.ucfirst(MENU_Usuarios).'" href="admin.php?user_id=list">'.ucfirst(MENU_Usuarios).'</a></li>';
		$row.='<li><a title="'.ucfirst(LABEL_export).'" href="admin.php?doAdmin=export">'.ucfirst(LABEL_export).'</a></li>';
		$row.='<li><a title="'.ucfirst(LABEL_OptimizarTablas).'" href="admin.php?opTbl=TRUE">'.ucfirst(LABEL_OptimizarTablas).'</a></li>';
		$row.='<li><a title="'.ucfirst(LABEL_update1_1x1_2).'" href="admin.php?doAdmin=updte1_1x1_2">'.ucfirst(LABEL_update1_1x1_2).'</a></li>';
		$row.='</menu></li>';
		}

        $row.='<li><a href="#" onmouseover="montre(\'menu_ppal\');" onmouseout="cache(\'menu_ppal\');" >'.ucfirst(LABEL_Menu).'</a><menu id="menu_ppal" onmouseover="montre(\'menu_ppal\');" onmouseout="cache(\'menu_ppal\');">';
        $row.='<li><a title="'.ucfirst(MENU_AgregarT).'" href="index.php?taskterm=addTerm&amp;tema=0">'.ucfirst(MENU_AgregarT).'</a></li>';
        $row.='<li><a title="'.ucfirst(LABEL_terminosLibres).'" href="index.php?verT=L">'.ucfirst(LABEL_terminosLibres).'</a></li>';
        $row.='<li><a title="'.ucfirst(LABEL_terminosRepetidos).'" href="index.php?verT=R">'.ucfirst(LABEL_terminosRepetidos).'</a></li>';
		$row.='<li><a title="'.ucfirst(LABEL_Rechazados).'" href="index.php?estado_id=14">'.ucfirst(LABEL_Rechazados).'</a></li>';
		$row.='<li><a title="'.ucfirst(LABEL_Candidato).'" href="index.php?estado_id=12">'.ucfirst(LABEL_Candidatos).'</a></li>';


	$row.='    </menu></li>';
	//Hay un termino
	if($array_tema){
		$row.='      <li><a href="#" onmouseover="montre(\'menu_opciones\');" onmouseout="cache(\'menu_opciones\');" >'.ucfirst(LABEL_Opciones).'</a><menu id="menu_opciones" onmouseover="montre(\'menu_opciones\');" onmouseout="cache(\'menu_opciones\');">';
		$row.='      <li><a title="'.MENU_EditT.'" href="index.php?taskterm=editTerm&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_EditT).'</a></li>';
		
		//es un término que admite notas y relaciones
		if($sqlcheckIsValidTerm[cant]=='0')
		{
			$row.='     <li><a title="'.LABEL_EditorNota.'" href="index.php?taskterm=editNote&amp;note_id=?&amp;editNota=?&amp;tema='.$array_tema[idTema].'">'.ucfirst(LABEL_EditorNota).'</a></li>';
			$row.='    '.$link_subordinar.'';
			$row.='     '.$link_borra.'';
		}	
		$row.='    </menu></li>';

		//solo acepta relaciones si el término esta aceptado
		if(($array_tema[estado_id]=='13') && ($sqlcheckIsValidTerm[cant]=='0')){
			$row.='<li><a href="#" onmouseover="montre(\'menu_agregar\');" onmouseout="cache(\'menu_agregar\');" >'.ucfirst(LABEL_Agregar).'</a><menu id="menu_agregar" onmouseover="montre(\'menu_agregar\');" onmouseout="cache(\'menu_agregar\');">';
			//link agregar un TE
			$row.='     <li><a title="'.MENU_AgregarTE.'" href="index.php?taskterm=addNT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTE).'</a></li>';
			$row.='     <li><a title="'.MENU_AgregarTEexist.'" href="index.php?taskterm=addFreeNT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTEexist).'</a></li>'; //SafetyLit			
			//link agregar un UP
			$row.='     <li><a href="index.php?taskterm=addUF&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarUP).'</a></li>';
			$row.='     <li><a href="index.php?taskterm=addFreeUF&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarUPexist).'</a></li>'; //SafetyLit			
			//link agregar un TR
			$row.='     <li><a title="'.MENU_AgregarTR.'" href="index.php?taskterm=addRT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTR).'</a></li>';
			//link agregar un EQ
			$row.='     <li><a title="'.LABEL_relacion_vocabulario.'" href="index.php?taskterm=addEQ&amp;tema='.$array_tema[idTema].'">'.ucfirst(LABEL_relacion_vocabulario).'</a></li>';
			$row.='    </menu></li>';
			}
		};

	$row.='   </li></menu>';
    $row.='</div>';

}//Fin del hay session
return $row;
};


function HTMLmainMenu(){
	
	$row.='<li><a tabindex="0" href="#menu-manager" id="hierarchybreadcrumb">'.LABEL_Menu.'</a>
	<div id="menu-manager" class="hidden" style="display: none">';

	$row.='<ul class="menumanager">';

/*
Agregar térm
*/
        $row.='<li><a title="'.ucfirst(MENU_AgregarT).'" href="index.php?taskterm=addTerm&amp;tema=0">'.ucfirst(MENU_AgregarT).'</a></li>';

/*
 * Admin menu
*/
if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){
	$row.='<li><a href="#">'.LABEL_Admin.'</a>';
	$row.='<ul>';
	$row.='<li><a title="'.ucfirst(LABEL_lcConfig).'" href="admin.php?vocabulario_id=list">'.ucfirst(LABEL_lcConfig).'</a></li>';
	$row.='<li><a title="'.ucfirst(MENU_Usuarios).'" href="admin.php?user_id=list">'.ucfirst(MENU_Usuarios).'</a></li>';
	$row.='<li><a title="'.ucfirst(LABEL_export).'" href="admin.php?doAdmin=export">'.ucfirst(LABEL_export).'</a></li>';

	$row.='<li><a href="#">'.ucfirst(LABEL_dbMantenimiento).'</a><ul>';
	$row.='<li><a  href="admin.php?doAdmin=reindex">'.ucfirst(LABEL_reIndice).'</a></li>';	
	$row.='<li><a href="admin.php?doAdmin=import" title='.ucfirst(LABEL_import).'>'.ucfirst(LABEL_import).'</a></li>';
	$row.='<li><a title="'.ucfirst(MENU_DatosTesauro).'" href="admin.php?opTbl=TRUE">'.ucfirst(LABEL_OptimizarTablas).'</a></li>';
	$row.='<li><a title="'.ucfirst(LABEL_update1_1x1_2).'" href="admin.php?doAdmin=updte1_1x1_2">'.ucfirst(LABEL_update1_1x1_2).'a</a></li>';

	$row.='</ul></li>';

	$row.='</ul></li>';
	}
/*
Menu ver
*/
$row.='<li><a href="#">'.ucfirst(LABEL_Ver).'</a><ul>';
$row.='<li><a title="'.ucfirst(LABEL_terminosLibres).'" href="index.php?verT=L">'.ucfirst(LABEL_terminosLibres).'</a></li>';
$row.='<li><a title="'.ucfirst(LABEL_terminosRepetidos).'" href="index.php?verT=R">'.ucfirst(LABEL_terminosRepetidos).'</a></li>';
$row.='<li><a title="'.ucfirst(LABEL_Rechazados).'" href="index.php?estado_id=14">'.ucfirst(LABEL_Rechazados).'</a></li>';
$row.='<li><a title="'.ucfirst(LABEL_Candidato).'" href="index.php?estado_id=12">'.ucfirst(LABEL_Candidatos).'</a></li>';
$row.='</ul></li>';


//User menu		
$row.='<li><a title="'.MENU_MisDatos.'" href="login.php">'.MENU_MisDatos.'</a></li>';
$row.='<li><a title="'.MENU_Salir.'" href="index.php?cmdlog='.substr(md5(date("Ymd")),"5","10").'">'.MENU_Salir.'</a></li>';

$row.='   </ul>';		
$row.='</div></li>';
return $row;
};




#
# term menu options
#
function HTMLtermMenu($array_tema,$relacionesTermino){

$row.='[<a tabindex="0" href="#menu-manager" id="hierarchybreadcrumbTermMenu">'.LABEL_Opciones.'</a>]';
$row.='<div id="term-menu" class="hidden" style="display: none">';

$row.='<ul class="menumanager">';

$sqlcheckIsValidTerm=SQLcheckIsValidTerm($array_tema[tema_id]);


//no have relations
if(($relacionesTermino[cantTotal])=='0')
{
	$link_estado='<li><a title="'.LABEL_EliminarTE.'" href="index.php?id_dete='.$array_tema[idTema].'">'.ucfirst(LABEL_EliminarTE).'</a></li>';
	/*
	Change status term
	*/
	$link_estado.='<li><a href="#">'.ucfirst(LABEL_CambiarEstado).'</a><ul id="menu_estado">';
	switch($array_tema[estado_id])
		{
		case '12':
			//Candidato / candidate => aceptado
			$link_estado.='<li><a title="'.LABEL_AceptarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=13">'.ucfirst(LABEL_AceptarTermino).'</a></li>';
			//Candidato / candidate => rechazado
			$link_estado.='<li><a title="'.LABEL_RechazarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=14">'.ucfirst(LABEL_RechazarTermino).'</a></li>';
			break;

			case '13':
			//Aceptado / Acepted=> Rechazado
			$link_estado.='<li><a title="'.LABEL_RechazarTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=14">'.ucfirst(LABEL_RechazarTermino).'</a></li>';
			break;

			case '14':
			//Rechazado / Rejected=> Candidato
			$link_estado.='<li><a title="'.LABEL_CandidatearTermino.'" href="index.php?tema='.$array_tema[idTema].'&amp;estado_id=12">'.ucfirst(LABEL_CandidatearTermino).'</a></li>';
			break;
			}
	$link_estado.='</ul></li>';
};



// PERMITIR O NO POLIJERARQUIAS//
if( ( ($relacionesTermino[cantTG]==0) || ($_SESSION[CFGPolijerarquia]=='1') ) && ($array_tema[estado_id]=='13')){
	   $link_subordinar='<li><a title="'.MENU_AgregarTG.'" href="index.php?taskterm=addBT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTG).'</a></li>';
	};
	
	
		$row.='      <li><a title="'.MENU_EditT.'" href="index.php?taskterm=editTerm&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_EditT).'</a></li>';	
		//es un término que admite notas y relaciones
		if($sqlcheckIsValidTerm[cant]=='0')
		{
			$row.='     <li><a title="'.LABEL_EditorNota.'" href="index.php?taskterm=editNote&amp;note_id=?&amp;editNota=?&amp;tema='.$array_tema[idTema].'">'.ucfirst(LABEL_EditorNota).'</a></li>';
		}	
		
		$row.=$link_estado;
		
		
		//solo acepta relaciones si el término esta aceptado
		if(($array_tema[estado_id]=='13') && ($sqlcheckIsValidTerm[cant]=='0')){
			$row.='<li><a href="#">'.ucfirst(LABEL_Agregar).'</a><ul id="menu_agregar">';
			
			//link agregar un TE
			$row.='     <li><a title="'.MENU_AgregarTE.'" href="#">'.ucfirst(MENU_AgregarTE).'</a><ul>';
			
			//elegir vía de agregacion
			$row.='     <li><a title="'.MENU_AgregarTE.'" href="index.php?taskterm=addNT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarT).'</a></li>';
			$row.='     <li><a title="'.MENU_AgregarTEexist.'" href="index.php?taskterm=addFreeNT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTEexist).'</a></li>'; //SafetyLit					
			$row.='</ul></li>';
	
			//link agregar un UP
			$row.='     <li><a title="'.MENU_AgregarUP.'" href="#">'.ucfirst(MENU_AgregarUP).'</a><ul>';
			//elegir vía de agregacion
			$row.='     <li><a href="index.php?taskterm=addUF&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarT).'</a></li>';
			$row.='     <li><a href="index.php?taskterm=addFreeUF&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarUPexist).'</a></li>'; //SafetyLit	
			$row.='</ul></li>';

			//link agregar un TR
			$row.='     <li><a title="'.MENU_AgregarTR.'" href="index.php?taskterm=addRT&amp;tema='.$array_tema[idTema].'">'.ucfirst(MENU_AgregarTR).'</a></li>';
			$row.='    '.$link_subordinar;
			$row.='    </ul></li>';
			
			
			$row.='<li><a href="#">'.ucfirst(LABEL_relbetweenVocabularies).'</a><ul id="menu_agregar_relaciones">';
		//link agregar un EQ
			$row.='     <li><a title="'.LABEL_vocabulario_referencia.'" href="index.php?taskterm=addEQ&amp;tema='.$array_tema[idTema].'">'.ucfirst(LABEL_vocabulario_referencia).'</a></li>';
			//link agregar un término externo vía web services
			$row.='     <li><a title="'.LABEL_relacion_vocabularioWebService.'" href="index.php?taskterm=findTargetTerm&amp;tema='.$array_tema[idTema].'">'.ucfirst(LABEL_vocabulario_referenciaWS).'</a></li>';
			$row.='    </ul>
			</li>';
			}
/*
		$row.='    </ul></li>';
*/

$row.='   </ul>';		
$row.='</div>';

return $row;
};




#
# Ficha del término
#
function HTMLNotasTermino($array){
  if(count($array[notas])){
        for($iNota=0; $iNota<(count($array[notas])); ++$iNota){
                if($array[notas][$iNota][id]){
                        $body.='<div class="NA" id="'.$array[notas][$iNota][tipoNota].$array[notas][$iNota][id].'">';
                        $body.='<dl id="notas">';
                                switch($array[notas][$iNota][tipoNota]){
                                        case 'NA';
                                        $tipoNota=LABEL_NA;
                                        break;

                                        case 'NH';
                                        $tipoNota=LABEL_NH;
                                        break;

                                        case 'NC';
                                        $tipoNota=LABEL_NC;
                                        break;

                                        case 'NB';
                                        $tipoNota=LABEL_NB;
                                        break;

                                        case 'NP';
                                        $tipoNota=LABEL_NP;
                                        break;

                                }
		//idioma de la nota
		//Rellenar si esta vacion
		$array[notas][$iNota][lang_nota]=(!$array[notas][$iNota][lang_nota]) ? $_SESSION["CFGIdioma"] : $array[notas][$iNota][lang_nota];

		//no mostrar si es igual al idioma del vocabulario
		$label_lang_nota=($array[notas][$iNota][lang_nota]==$_SESSION["CFGIdioma"]) ? '' : ' ('.$array[notas][$iNota][lang_nota].')';

                        if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
                        $body.='<dt> <a title="'.LABEL_EditarNota.'" href="'.$PHP_SELF.'?editNota='.$array[notas][$iNota][id].'&amp;taskterm=editNote&amp;tema='.$array[idTema].'"><img alt="'.LABEL_EditarNota.'"  src="../common/images/icons/page_edit.png"/></a> <a title="'.LABEL_EditarNota.'" href="'.$PHP_SELF.'?editNota='.$array[notas][$iNota][id].'&amp;taskterm=editNote&amp;tema='.$array[idTema].'">'.$tipoNota.'</a>'.$label_lang_nota.'</dt><dd> '.wiki2html($array[notas][$iNota][nota]).'</dd>';
                        }else{
                        $body.='<dt>'.$tipoNota.$label_lang_nota.'</dt><dd> '.wiki2html($array[notas][$iNota][nota]).'</dd>';
                        }

                        $body.='</dl>';;
                        $body.='</div>';;
                  };//fin de if id nota
        };// fin del for

  };
  return $body;
};

#
# //// BUCLE HACIA ARRIBA
#
function sql_rel($idTema,$i){
if($i<10){// Para evitar bucle infinito en caso de error por relaciones recursivas. max= 10
      $sql=SQLbucleArriba($idTema);
                    if($sql[cant]==0){
                        $datos=ARRAYverTerminoBasico($idTema);
                                if($i==0){
                                $enlace.='#'.$datos[titTema].' ';
                                }else{
                                $enlace.='#<a title="'.LABEL_verDetalle.$datos[titTema].'" href="'.$PHP_SELF.'?tema='.$datos[idTema].'">'.$datos[titTema].'</a>';
                                };

                    return $enlace;
                    }else{
                    return ver_txt($sql[datos],$i);
                    };
        };
};



#
# //// PROCESAMIENTO HTML DEL BUCLE HACIA ARRIBA
#

function ver_txt($datos,$i){
                    while($lista=mysqli_fetch_row($datos)){
                          if($i==0){
                             $rows.='#'.$lista[2].'';
                             }else{
                             $rows.='#<a title="'.LABEL_verDetalle.$lista[2].'" href="index.php?tema='.$lista[1].'">'.$lista[2].'</a>';
                             }

                          if($lista[0]>0){
                             $rows.=sql_rel($lista[0],$i+1);
                             }
                          };

 return $rows;
};



#
# //// armado de un tema_id acumula los tema_ids hacia arriba
#
function bucle_arriba($indice_temas,$idTema){
      $sql=SQLbucleArriba($idTema);
      $indice_temas.=otro_bucle_arriba($sql[datos]);
   return $indice_temas;
};

function otro_bucle_arriba($sql){
         while($lista=mysqli_fetch_row($sql)){
		if($lista[0]>0){
                $indice_temas.=bucle_arriba($lista[0].'|',$lista[0]);
		}
	}

	return $indice_temas;
};
#
# //// BUCLE HACIA ABAJO
#
function evalRelacionSuperior($idTema,$i,$idTemaEvaluado){

      $sql=SQLbucleArriba($idTema);

                    if($sql[cant]==0){
                    return "TRUE";
                    }else{
                    return evalSubordina($sql[datos],$i,$idTemaEvaluado);
                    };
};


#
# //// PROCESAMIENTO ARRAY DEL BUCLE HACIA abajo
#
function evalSubordina($datos,$i,$idTemaEvaluado){

         while($lista=mysqli_fetch_row($datos)){
                    if(($idTemaEvaluado==$lista[1])||($idTemaEvaluado==$lista[0])){
                    return FALSE;
                    }elseif($lista[0]>1){
                    return evalRelacionSuperior($lista[0],$i+1,$idTemaEvaluado);
                    }else{
                    return TRUE;
                    }
         };
};



#
# Armado del menú de cambio de idioma
#
function doMenuLang(){

   GLOBAL $idiomas_disponibles;

    $selectLang.='<form id="select-lang" method="get" action="index.php">';
	$selectLang.='<select name="setLang" id="setLang" onchange="this.form.submit();">';
   foreach ($idiomas_disponibles AS $key => $value) {
        if($value[2]==$_SESSION[$_SESSION["CFGURL"]][lang][2]){
	$selectLang.='<option value="'.$value[2].'" selected="selected">'.$value[0].'</option>';
        }else{
	$selectLang.='<option value="'.$value[2].'">'.$value[0].'</option>';
        };
    };

    $parametrosGET=str_replace("&amp;","", doValFromGET());
    $parametrosGET=explode("=",$parametrosGET);
    $selectLang.='</select>';
    $selectLang.='<input type="hidden" name="'.$parametrosGET[0].'" value="'.$parametrosGET[1].'" />';
    $selectLang.='</form>';
    $menuLang=substr("$menuLang",1);
    return $selectLang;
};




#
# Armado de tabla de términos según meses
#
function doBrowseTermsFromDate($month,$year,$ord=""){

        GLOBAL $MONTHS;
        $sql=SQLlistTermsfromDate($month,$year,$ord);
        $rows.='<table cellpadding="0" cellspacing="0" summary="'.LABEL_auditoria.'" >';


        $rows.='<tbody>';
        while($array=mysqli_fetch_array($sql[datos])){
                $fecha_termino=do_fecha($array[cuando]);

                $rows.='<tr>';
                $rows.='<td class="izq"><a href="index.php?tema='.$array[id_tema].'" title="'.LABEL_verDetalle.LABEL_Termino.'">'.$array[tema].'</a></td>';
                $rows.='<td>'.$fecha_termino[dia].' / '.$fecha_termino[descMes].' / '.$fecha_termino[ano].'</td>';
                if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){
                $rows.='<td><a href="admin.php?user_id='.$array[id_usuario].'" title="'.LABEL_DatosUser.'">'.$array[apellido].', '.$array[nombres].'</a></td>';
                }else{
                $rows.='<td>'.$array[apellido].', '.$array[nombres].'</td>';
                }
                $rows.='</tr>';
                };
                $rows.='</tbody>';

        $rows.='<thead>';
        $rows.='<tr>';
        $rows.='<th class="izq" colspan="3"><a href="sobre.php" title="'.ucfirst(LABEL_auditoria).'">'.ucfirst(LABEL_auditoria).'.</a> &middot; '.$fecha_termino[descMes].' / '.$fecha_termino[ano].': '.$sql[cant].' '.LABEL_Terminos.'</th>';
        $rows.='</tr>';

        $rows.='<tr>';
        $rows.='<th><a href="sobre.php?m='.$month.'&y='.$year.'&ord=T" title="'.LABEL_ordenar.' '.LABEL_Termino.'">'.ucfirst(LABEL_Termino).'</a></th>';
        $rows.='<th><a href="sobre.php?m='.$month.'&y='.$year.'&ord=F" title="'.LABEL_ordenar.' '.LABEL_Fecha.'">'.ucfirst(LABEL_Fecha).'</a></th>';
        $rows.='<th><a href="sobre.php?m='.$month.'&y='.$year.'&ord=U" title="'.LABEL_ordenar.' '.MENU_Usuarios.'">'.ucfirst(MENU_Usuarios).'</a></th>';
        $rows.='</tr>';
        $rows.='</thead>';


        $rows.='<tfoot>';
        $rows.='<tr>';
        $rows.='<td class="izq">'.ucfirst(LABEL_TotalTerminos).'</td>';
        $rows.='<td colspan="2">'.$sql[cant].'</td>';
        $rows.='</tr>';
        $rows.='</tfoot>';

        $rows.='</table>        ';
        return $rows;
};


#
# Armado de browse de términos
#
function doBrowseTermsByDate(){
        GLOBAL $MONTHS;
        $sql=SQLtermsByDate();
        $rows.='<table class="contenido" cellpadding="0" cellspacing="0" summary="'.ucfirst(LABEL_auditoria).'">';

        $rows.='<thead>';

        $rows.='<tr>';
        $rows.='<th colspan="3" class="titulo_tabla">'.ucfirst(LABEL_auditoria).'</th>';
        $rows.='</tr>';

        $rows.='<tr>';
        $rows.='<th>'.ucfirst(LABEL_ano).'</th>';
        $rows.='<th>'.ucfirst(LABEL_mes).'</th>';
        $rows.='<th>'.ucfirst(LABEL_Terminos).'</th>';
        $rows.='</tr>';
        $rows.='</thead>';


        $rows.='<tbody>';
        while($array=mysqli_fetch_array($sql[datos])){

                $fecha_termino=do_fecha($array[cuando]);
                $rows.='<tr>';
                $rows.='<td class="centrado">'.$array[years].'</td>';
                $rows.='<td class="centrado"><a href="sobre.php?m='.$array[months].'&y='.$array[years].'" title="'.LABEL_verDetalle.$fecha_termino[descMes].'">'.$fecha_termino[descMes].'</a></td>';
                $rows.='<td class="centrado">'.$array[cant].'</td>';
                $rows.='</tr>';
                $TotalTerminos+=$array[cant];
                };
                $rows.='</tbody>';
        $rows.='<tfoot>';
        $rows.='<tr>';
        $rows.='<td colspan="2">'.ucfirst(LABEL_TotalTerminos).'</td>';
        $rows.='<td>'.$TotalTerminos.'</td>';
        $rows.='</tr>';
        $rows.='</tfoot>';

        $rows.='</table>        ';
        return $rows;
};



function HTML_URLsearch($display=Array(),$arrayTema=Array()) {

	GLOBAL $CFG; 
	$ARRAY_busquedas=$CFG[SEARCH_URL_SITES_SINTAX];

	$string_busqueda = $arrayTema[titTema];
 	$html = '<ul id="enlaces_web">' . "\n";
	foreach($display as $sitename) {
		if (in_array($sitename, $ARRAY_busquedas))
			continue;
		$site = $ARRAY_busquedas[$sitename];
		$html .= "\t<li>";
		$url = $site['url'];
		if($site['encode']=='utf8'){
			$url = str_replace('STRING_BUSQUEDA', urlencode(utf8_encode($string_busqueda)), $url);
			}else{
			$url = str_replace('STRING_BUSQUEDA', $string_busqueda, $url);
			}

		$html .= '<a href="'.$url.'" title="'.LABEL_Buscar.' '.$arrayTema[titTema].'  ('.$site[leyenda].')">';
		$html .= '<img src="../common/images/'.$site[favicon].'" alt="'.LABEL_Buscar.' '.$arrayTema[titTema].'  ('.$site[leyenda].')"/>';
		$html .= '</a>';
		$html .= "</li>\n";
		}
	$html .= "</ul>\n";

return $html;
};



function HTMLlistaAlfabetica($letra=""){

$letra=urldecode($letra[0]);

$sqlMenuAlfabetico=SQLlistaABC();

$openBodyDiv='<div id="bodyText"><h1>'.MENU_ListaAbc.'</h1>';

while ($datosAlfabetico = mysqli_fetch_row($sqlMenuAlfabetico[datos])) 
{
	$i_alfabeto=++$i_alfabeto;
	if ($datosAlfabetico[1]==0) 
	{
		$menuAlfabetico.='<a title="'.LABEL_verTerminosLetra.' '.$datosAlfabetico[0].'" href="'.$PHP_SELF.'?letra='.$datosAlfabetico[0].'">'.$datosAlfabetico[0].'</a>';        
	}
	else 
	{
		$menuAlfabetico.='<strong>'.$datosAlfabetico[0].'</strong>';
	}
	

	if ($i_alfabeto<$sqlMenuAlfabetico[cant]) 
	{
		$menuAlfabetico.='   &middot;   ';
	}         
};//fin del while


if ($letra!=='?') 
{
	$sqlDatosLetra=SQLmenuABC($letra);

	$terminosLetra.='<p class="success">'.MSG_ResultLetra.' <em>'.$letra.'</em>: <strong>'.$sqlDatosLetra[cant].' </strong>'.LABEL_Terminos.'.</p>';

	if($sqlDatosLetra[cant])
	{
	$enlaceFoo='[<a href="javascript: history.go(-1);"><</a>]  | [<a href="#arriba">^</a>] | [<a href="'.$PHP_SELF.'">inicio</a>]';
	$terminosLetra.='<div id="listaBusca"><ul>';
	while ($datosLetra= mysqli_fetch_array($sqlDatosLetra[datos])){

	//Si no es un término preferido
		if($datosLetra[termino_preferido]){
			switch($datosLetra[t_relacion]){
//UF
				case '4':
				$leyendaConector=USE_termino;
				break;
//Tipo relacion término equivalente parcialmente
				case '5':
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
//Tipo relacion término equivalente
				case '6':
				$leyendaConector='<acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym>';
				break;
//Tipo relacion término no equivalente
				case '7':
				$leyendaConector='<acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym>';
				break;
//Tipo relacion término equivalente inexacta
				case '8':
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
				}

			$terminosLetra.='<li><em><a title="'.LABEL_verDetalle.xmlentities($datosLetra[tema]).'" href="index.php?tema='.$datosLetra[tema_id].'&amp;/'.string2url($datosLetra[tema]).'">'.$datosLetra[tema].'</a></em> '.$leyendaConector.' <a title="'.LABEL_verDetalle.$datosLetra[tema].'" href="index.php?tema='.$datosLetra[id_definitivo].'&amp;/'.($datosLetra[termino_preferido]).'">'.$datosLetra[termino_preferido].'</a></li>'."\r\n" ;
		}
		else
		{
			$styleClassLink= ($datosLetra[estado_id]!=='13') ? 'class="estado_termino'.$datosLetra[estado_id].'"' : '';
			
			$terminosLetra.='<li><a '.$styleClassLink.' title="'.LABEL_verDetalle.xmlentities($datosLetra[tema]).'" href="index.php?tema='.$datosLetra[id_definitivo].'&amp;/'.string2url($datosLetra[tema]).'">'.xmlentities($datosLetra[tema]).'</a></li>'."\r\n" ;
		}
			};
			$terminosLetra.='   </ul>';
			$terminosLetra.='</div>';
	};
 };

$endBodyDiv='</div>';

return $openBodyDiv.$menuAlfabetico.$terminosLetra.$endBodyDiv;
};

#
# Expande una busqueda hacia arriba == busca los términos más generales de los términos especificos devueltos en una busqueda
#
function HTMLbusquedaExpandidaTG($acumula_indice,$acumula_temas){
global $DBCFG;

$array_indice = explode("|", $acumula_indice);
$array_temas = explode("|", $acumula_temas);

$cantValores=array_count_values($array_indice);
$array_indice=array_unique($array_indice);

while (list($key, $val) = each($array_indice)) 
{
	if(!in_array($val,$array_temas))
	{
		$temas_ids.=$val.',';
	}
};


//Si no hay términos más genericos que los resultados
if(@$temas_ids)
{
	$sql=SQLlistaTema_id(substr($temas_ids,0,-1));

	//Si hay resultados
	if($sql[cant])
	{
		//Si hay menos de 10, se muestran sin colapsar
		($sql[cant]<10) ? ($row_result.='<h5>'.ucfirst(LABEL_resultados_suplementarios).' ('.$sql[cant].')</h5> <ul id="TG_expandidos" class="lista_secundaria">') : ($row_result.='<h5><a href="javascript:expandLink(\'TG_expandidos\')" title="'.LABEL_resultados_suplementarios.'">'.ucfirst(LABEL_resultados_suplementarios).'</a> ('.$sql[cant].')</h5><ul id="TG_expandidos" style="display: none" class="lista_secundaria">');

		while($resulta_busca=mysqli_fetch_array($sql[datos]))
		{
			$ibusca=++$ibusca;
			$row_result.='<li><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[tema_id].'&amp;/'.string2url($resulta_busca[tema]).'">'.$resulta_busca[tema].'</a></li>'."\r\n" ;
		}
		$row_result.='</ul>';
	};
}

return $row_result;

};



#
# Expande una busqueda hacia terminos relacionados == busca los términos relacionados de los términos especificos devueltos en una busqueda
#
function HTMLbusquedaExpandidaTR($acumula_temas){

$temas_ids=str_replace("|",",", $acumula_temas);
//Si no hay términos más genericos que los resultados
if(@$temas_ids){
$sql=SQLexpansionTR(substr($temas_ids,0,-1));

//Si hay resultados
if($sql[cant]){
	//Si hay menos de 10, se muestran sin colapsar
	($sql[cant]<10) ? ($row_result.='<h5>'.ucfirst(LABEL_resultados_relacionados).' ('.$sql[cant].')</h5> <ul id="TR_expandidos" class="lista_secundaria">') : ($row_result.='<h5><a href="javascript:expandLink(\'TR_expandidos\')" title="'.LABEL_resultados_relacionados.'">'.ucfirst(LABEL_resultados_relacionados).'</a> ('.$sql[cant].')</h5><ul id="TR_expandidos" style="display: none" class="lista_secundaria">');

	while($resulta_busca=mysqli_fetch_array($sql[datos])){
		$ibusca=++$ibusca;
		$row_result.='<li><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[tema_id].'&amp;/'.string2url($resulta_busca[tema]).'">'.$resulta_busca[tema].'</a></li>'."\r\n" ;
		}
	$row_result.='</ul>';
	}
}
return $row_result;

};



function HTMLverTE($tema_id,$i_profundidad,$i=""){

GLOBAL $CFG;

$sql=SQLverTerminosE($tema_id);
$rows='<ul id="masTE'.$tema_id.'" style="display: none">';

//Contador de profundidad de TE desde la raíz
$i_profundidad=++$i_profundidad;

//Contador de profundidad de TE desde el TE base
$i=++$i;
while($array=mysqli_fetch_array($sql[datos])){
   if($array[id_te]){
	if($i<CFG_MAX_TREE_DEEP){
		$link_next=' [<a href="javascript:expand(\''.$array[id_tema].'\')" title="'.LABEL_verDetalle.' '.$array[tema].' ('.TE_termino.')" ><span id ="expandTE'.$array[id_tema].'">+</span><span id ="contraeTE'.$array[id_tema].'" style="display: none">~</span></a>]';
		$link_next.=HTMLverTE($array[id_tema],$i_profundidad,$i);
		}else{
		$link_next='&nbsp;[<a title="'.LABEL_verDetalle.TE_termino.' '.$array[tema].'" href="index.php?tema='.$array[id_tema].'">+</a>]';
		}
     }else{
     $link_next='';
     };
	
	$rows.='<li><acronym title="'.TE_termino.'" lang="'.LANG.'">'.TE_acronimo.$i_profundidad.'</acronym>  ' ;
	$rows.=' <a title="'.LABEL_verDetalle.' '.$array[tema].' ('.TE_termino.')"  href="index.php?tema='.$array[id_tema].'&amp;/'.string2url($array[tema]).'">'.$array[tema].'</a>'.$link_next.'</li>';
	};
$rows.='</ul>';
return $rows;
}


function HTMLlistaTerminosEstado($estado_id,$limite="")
{

//Estados posibles y aceptados
$arrayEstados_id=array(12,14);

//Descripcion de estados
$arrayEstados=array("12"=>LABEL_Candidatos,"13"=>LABEL_Aceptados,"14"=>LABEL_Rechazados);

if(in_array($estado_id,$arrayEstados_id)){

	$sql=SQLterminosEstado($estado_id,$limite);

	$rows.='<div><h1>'.ucfirst($arrayEstados[$estado_id]).' ('.$sql[cant].') </h1>';
	$rows.='<ul>';
	while($array = mysqli_fetch_array($sql[datos])){
			$rows.='<li> <a class="estado_termino'.$array[estado_id].'" title="'.$array[tema].'" href="index.php?tema='.$array[tema_id].'&tipo=E">'.$array[tema].'</a><li/>';
			}
	$rows.='</ul>';
	$rows.='</div>';
	}

return $rows;
};



function HTMLsugerirTermino($texto,$acumula_temas="0"){

$sqlSimilar=SQLsimiliar($texto,$acumula_temas);

if($sqlSimilar[cant])
{
	while($arraySimilar=mysqli_fetch_array($sqlSimilar[datos])){
		$listaCandidatos.= $arraySimilar[tema].'|';
		}

		$listaCandidatos=explode("|",$listaCandidatos);
		$similar = new Qi_Util_Similar($listaCandidatos, $texto);
		$sugerencia= $similar->sugestao();

		if ($sugerencia) 
		{
		$rows.='<h4>'.ucfirst(LABEL_TERMINO_SUGERIDO).' <em><strong><a href="index.php?'.FORM_LABEL_buscar.'='.$sugerencia.'&sgs=off" title="'.LABEL_verDetalle.$sugerencia.'">'.$sugerencia.'</a></strong></em> </h4>';			
		}
}
return $rows;
}


/*
Display top terms
*/
function HTMLtopTerms(){

GLOBAL $CFG;

$sql=SQLverTopTerm();

$rows.='<div id="bodyText">';

$rows.=HTMLlistaAlfabeticaUnica($_GET[letra]);

$rows.='<div class="clearer-top"></div>';

//Top terms
while ($array = mysqli_fetch_array($sql[datos])){

	$rows.='<h2 class="TT">';
	//Editor de código
	if(($_SESSION[$_SESSION["CFGURL"]][ssuser_id]) && ($CFG["_USE_CODE"]=='1'))
	{
		$rows.='<div title="term code, click to edit" class="editable_textarea" id="code_tema'.$array[tema_id].'">'.$array[code].'</div>';
	}
	else 
	{
		$rows.=' '.$array[code].' ';
	}
	$rows.='<a title="'.LABEL_verDetalle.$array[tema].'" href="index.php?tema='.$array[tema_id].'">'.$array[tema].'</a>';
	$rows.='</h2>' ;
	
	};

$rows.='</div>';

return $rows;
}


function HTMLlistaAlfabeticaUnica($letra=""){

$letra=urldecode($letra[0]);


$sqlMenuAlfabetico=SQLlistaABC($letra);

while ($datosAlfabetico = mysqli_fetch_row($sqlMenuAlfabetico[datos])) 
{
/*
	if(ctype_alpha($datosAlfabetico[0]))
*/
	if(!ctype_digit($datosAlfabetico[0]))
	{
	$classMenu = ($datosAlfabetico[1]==0)  ? '' : ' class="selected" ';
	$menuAlfabetico.='<a '.$classMenu.' title="'.LABEL_verTerminosLetra.' '.$datosAlfabetico[0].'" href="'.$PHP_SELF.'?letra='.$datosAlfabetico[0].'">'.$datosAlfabetico[0].'</a>';        
	}
	else 
	{
	$menuNoAlfabetico='<a class="buttonLarge" title="'.LABEL_verTerminosLetra.' '.$datosAlfabetico[0].'" href="'.$PHP_SELF.'?letra='.$datosAlfabetico[0].'">0-9</a>';        
	}
	
};//fin del while

$menuAlfabetico='<div class="glossary">'.$menuNoAlfabetico.$menuAlfabetico.'</div>';

return $menuAlfabetico;
};



/*
All terms form one char
*/
function HTMLterminosLetra($letra) 
{

$sqlDatosLetra=SQLmenuABC($letra);

/*
$letra_label= (ctype_alpha($letra)) ?  $letra : '0-9';
*/
$letra_label= (!ctype_digit($letra)) ?  $letra : '0-9';
$terminosLetra.='<div id="breadScrumb" class="letters"><ol><li><a title="'.MENU_Inicio.'" href="index.php">'.ucfirst(MENU_Inicio).'</a></li><li><em>'.$letra_label.'</em>: <strong>'.$sqlDatosLetra[cant].' </strong>'.LABEL_Terminos.'</li></ol></div>';

if($sqlDatosLetra[cant])
{
$terminosLetra.='<div id="listaBusca"><ul>';
while ($datosLetra= mysqli_fetch_array($sqlDatosLetra[datos])){

//Si no es un término preferido
	if($datosLetra[termino_preferido]){
		switch($datosLetra[t_relacion]){
			//UF
			case '4':
			$leyendaConector=USE_termino;
			break;
			//Tipo relacion término equivalente parcialmente
			case '5':
			$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
			break;
			//Tipo relacion término equivalente
			case '6':
			$leyendaConector='<acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym>';
			break;
			//Tipo relacion término no equivalente
			case '7':
			$leyendaConector='<acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym>';
			break;
			//Tipo relacion término equivalente inexacta
			case '8':
			$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
			break;
			}

		$terminosLetra.='<li><em><a title="'.LABEL_verDetalle.xmlentities($datosLetra[tema]).'" href="index.php?tema='.$datosLetra[tema_id].'&amp;/'.string2url($datosLetra[tema]).'">'.$datosLetra[tema].'</a></em> '.$leyendaConector.' <a title="'.LABEL_verDetalle.$datosLetra[tema].'" href="index.php?tema='.$datosLetra[id_definitivo].'&amp;/'.($datosLetra[termino_preferido]).'">'.$datosLetra[termino_preferido].'</a></li>'."\r\n" ;
	}
	else
	{
		$styleClassLink= ($datosLetra[estado_id]!=='13') ? 'class="estado_termino'.$datosLetra[estado_id].'"' : '';
		
		$terminosLetra.='<li><a '.$styleClassLink.' title="'.LABEL_verDetalle.xmlentities($datosLetra[tema]).'" href="index.php?tema='.$datosLetra[id_definitivo].'&amp;/'.string2url($datosLetra[tema]).'">'.xmlentities($datosLetra[tema]).'</a></li>'."\r\n" ;
	}
};
		$terminosLetra.='   </ul>';
		$terminosLetra.='</div>';
};

	return $terminosLetra;
}



#
# Armado de resultados de búsqueda avanzada
#
function HTMLadvancedSearchResult($array){

//Ctrol lenght string
$array[xstring]=secure_data(trim($array[xstring]),"sql");

if(strlen(trim($array[xstring]))>=CFG_MIN_SEARCH_SIZE)
{
	$sql= SQLadvancedSearch($array);
echo $sql[error];
	$classMensaje= ($sql[cant]) ? 'information' : 'warning';
	
	$resumeResult = '<p id="adsearch" class='.$classMensaje.'><strong>'.$sql[cant].'</strong> '.MSG_ResultBusca.' <strong> "<em>'.stripslashes($array[xstring]).'</em>"</strong></p>';
} 
else
{
	$sql[cant]='0';	
	$resumeResult = '<p id="adsearch" class="error">'.sprintf(MSG_minCharSerarch,stripslashes($array[xstring]),strlen($array[xstring]),CFG_MIN_SEARCH_SIZE-1).'</p>';
}

 $body.=$resumeResult;

if($sql[cant]>0)
 {
	 $row_result.='<div id="listaBusca"><ul>';

	 while($resulta_busca=mysqli_fetch_array($sql[datos])){
		$ibusca=++$ibusca;

		//Si no es un término preferido
		if($resulta_busca[uf_tema_id])
		{
				switch($resulta_busca[t_relacion])
				{
				case '4':					//UF
				$leyendaConector=USE_termino;
				break;
	
				case '5'://Tipo relacion término equivalente parcialmente
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
	
				case '6'://Tipo relacion término equivalente
				$leyendaConector='<acronym title="'.LABEL_termino_equivalente.'" lang="'.LANG.'">'.EQ_acronimo.'</acronym>';
				break;
	
				case '7'://Tipo relacion término no equivalente
				$leyendaConector='<acronym title="'.LABEL_termino_no_equivalente.'" lang="'.LANG.'">'.NEQ_acronimo.'</acronym>';
				break;
	
				case '8'://Tipo relacion término equivalente inexacta
				$leyendaConector='<acronym title="'.LABEL_termino_parcial_equivalente.'" lang="'.LANG.'">'.EQP_acronimo.'</acronym>';
				break;
				}

			$row_result.='<li><em><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[uf_tema_id].'&amp;/'.string2url($resulta_busca[uf_tema]).'">'.$resulta_busca[uf_tema].'</a></em> '.$leyendaConector.' <a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[tema_id].'">'.$resulta_busca[tema].'</a> </li>'."\r\n" ;
		}
		else // es un término preferido
		{
			$row_result.='<li><a title="'.LABEL_verDetalle.$resulta_busca[tema].'" href="index.php?tema='.$resulta_busca[tema_id].'&amp;/'.string2url($resulta_busca[tema]).'">'.$resulta_busca[tema].'</a></li>'."\r\n" ;
		}

	};//fin del while
	$row_result.='</ul>';
	$row_result.='</div>';


};// fin de if result


return $body.$row_result;
};


/*
Show terms from target vocabularies
*/
function HTMLtargetTerms($tema_id)
{
	$sql=SQLtargetTerms($tema_id);
	
	if ($sql[cant]) 
	{
		$rows='<ul>';
		
	 while ($array=mysqli_fetch_array($sql[datos]))
		{
			if ($_SESSION[$_SESSION["CFGURL"]][ssuser_id]) 
			{
				$delLink= '[<a id="elimina_'.$array[tterm_id].'" title="'.LABEL_borraRelacion.'"  class="eliminar" href="'.$PHP_SELF.'?tterm_id='.$array[tterm_id].'&amp;tema='.$tema_id.'&amp;tvocab_id='.$array[tvocab_id].'&amp;taskrelations=delTgetTerm" onclick="return askData();"><acronym title="'.LABEL_borraRelacion.'" lang="'.LANG.'">x</acronym></a>]'; 
				$checkLink= '[<a id="actua_'.$array[tterm_id].'" title="'.LABEL_ShowTargetTermforUpdate.'"  href="'.$PHP_SELF.'?tterm_id='.$array[tterm_id].'&amp;tema='.$tema_id.'&amp;tvocab_id='.$array[tvocab_id].'&amp;tterm_id='.$array[tterm_id].'&amp;taskEdit=checkDateTermsTargetVocabulary">'.LABEL_ShowTargetTermforUpdate.'</a>]'; 
				
				$ttermManageLink=' '.$delLink.' '.$checkLink.'  ';
			
			}
			
			

			$rows.='<li>'.$ttermManageLink.' '.FixEncoding(ucfirst($array[tvocab_label])).' <a href="'.$array[tterm_url].'" title="'.FixEncoding($array[tterm_string]).'">'.FixEncoding($array[tterm_string]).'</a>';
			$rows.=(($_GET[taskEdit]=='checkDateTermsTargetVocabulary') && ($_GET[tterm_id]==$array[tterm_id]) && ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel])) ? HTMLcheckTargetTerm($array) : '';
			$rows.='</li>';

		}
		$rows.='</ul>';
	}

return $rows;	
}


/*
check changes in one foreing term
*/
function HTMLcheckTargetTerm($array) 
{

$ARRAYSimpleChkUpdateTterm=ARRAYSimpleChkUpdateTterm("tematres",$array[tterm_uri]);	

$last_term_update=($array[cuando_last]) ? $array[cuando_last] : $array[cuando];
	
/*
	El término no existe más en el vocabulario de destino
*/
	if(!$ARRAYSimpleChkUpdateTterm[result][term][tema_id])
	{
		$rows.= '<ul class="errorNoImage">';
		$rows.= '<li><strong>'.ucfirst(LABEL_notFound).'</strong></li>';
		$rows.= '<li>[<a href="index.php?tvocab_id='.$array[tvocab_id].'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
		$rows.= '</ul>';
	}
/*
	hay actualizacion del término
*/
	elseif ($ARRAYSimpleChkUpdateTterm[result][term][date_mod]>$last_term_update) 
	{
		$ARRAYupdateTterm["$array[tterm_uri]"]["string"]=FixEncoding($ARRAYSimpleChkUpdateTterm[result][term]["string"]);	
		$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"]=$ARRAYSimpleChkUpdateTterm[result][term]["date_mod"];
					
		$rows.= '<ul class="warningNoImage">';
		$rows.= '<li><strong>'.$ARRAYupdateTterm["$array[tterm_uri]"]["string"].'</strong></li>';
		$rows.= '<li>'.$ARRAYupdateTterm["$array[tterm_uri]"]["date_mod"].'</li>';
		$rows.= '<li>[<a href="index.php?tvocab_id='.$array[tvocab_id].'&amp;tterm_id='.$array[tterm_id].'&amp;tgetTerm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=updTgetTerm" title="'.ucfirst(LABEL_actualizar).'">'.ucfirst(LABEL_actualizar).'</a>]</li>';
		$rows.= '<li>[<a href="index.php?tvocab_id='.$array[tvocab_id].'&amp;tterm_id='.$array[tterm_id].'&amp;tema='.$array[tema_id].'&amp;taskrelations=delTgetTerm" title="'.ucfirst(LABEL_borraRelacion).'">'.ucfirst(LABEL_borraRelacion).'</a>]</li>';
		$rows.= '</ul>';
	}
	else
	{
		$array[tema_id]["status_tterm"]= true;
		$rows='<span class="successNoImage">'.LABEL_termUpdated.'</span>';
	}	

return $rows;
}

#######################################################################
?>
