<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Include para seleccionar include o función de visualizaicon de listas de términos #

//Mostrar alfabeto
if($_GET[letra])
{
	// sanitice $letra
	$letra=isValidLetter($_GET[letra]);
}

if((strlen($letra)>0) && (strlen($letra)<5))
{
	echo '<div class="container" id="bodyText">';
	echo '<div class="row">';

	echo HTMLlistaAlfabeticaUnica($letra);

	echo HTMLterminosLetra($letra);
	echo '</div>';
	echo '</div>';
}
elseif (strlen($search_string)>0) {

	//check again
	$search_string=XSSprevent($search_string);
	echo resultaBusca($search_string,$_GET["tipo"]);
}
//Mostrar ficha de termino o crear término
elseif(
	(is_numeric($metadata["arraydata"]["tema_id"])) ||
	($_GET["taskterm"]=='addTerm') ||
	($_GET["taskterm"]=='addTermSuggested')
	)
{
	require_once(T3_ABSPATH . 'common/include/inc.vistaTermino.php');
}
//Vista de términos según estados
elseif(is_numeric($_GET[estado_id]))
{
	echo '<div class="container" id="bodyText">';
	echo HTMLlistaTerminosEstado($_GET[estado_id],CFG_NUM_SHOW_TERMSxSTATUS);
	echo '</div>';
}
//Vista de términos según estados
elseif($_GET["s"]=='n')
{
	echo '<div class="container" id="bodyText">';
	echo HTMLlistaTerminosFecha();
	echo '</div>';
}
//Vista de busqueda avanzada
elseif(($_GET[xsearch]=='1'))
{
	echo '<div class="container" id="bodyText">';
	echo HTMLformAdvancedSearch($_GET);
	echo '</div>';
}
//Vista de reporteador
elseif(($_GET[mod]=='csv') && ($_SESSION[$_SESSION["CFGURL"]][ssuser_id]))
{
	echo '<div id="bodyText">';
	echo HTMLformSimpleTermReport($_GET);

	echo HTMLformAdvancedTermReport($_GET);

	echo HTMLformNullNotesTermReport($_GET);

	echo HTMLformMappedTermReport($_GET);

	echo '</div>';
}
//Esta login y mostrar terminios libres o repetidos
elseif(($_SESSION[$_SESSION["CFGURL"]][ssuser_id])&&($_GET[verT]))
{
	echo '<div class="container" id="bodyText">';
	switch($_GET[verT]){
		case 'L':
		echo HTMLformVerTerminosLibres($_POST["taskterm"],$_POST["deleteFreeTerms_id"]);
		break;

		case 'R':
		echo HTMLformVerTerminosRepetidos();
		break;

		case 'NBT':
		echo HTMLformVerTerminosSinBT($_POST["taskterm"],$_POST["deleteTerms_id"]);
		break;
		};
	echo '</div>';
}
//Mostrar terminos topes
elseif($_SESSION[$_SESSION["CFGURL"]]["_SHOW_TREE"]=='1')
{

	echo HTMLtopTerms($letra);

}
elseif($_SESSION[$_SESSION["CFGURL"]]["_SHOW_TREE"]=='0')
{

	echo '<div class="container" id="bodyText">';

	echo HTMLlistaAlfabeticaUnica($letra);

	echo '</div>';
}
?>
