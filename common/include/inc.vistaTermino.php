<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
#   Include para seleccionar include o función de formulario de edición

//array de acciones posibles para asociar términos
$arrayTaskExistTerms=array("addBT","addRT","addFreeUF","addFreeNT");

//verificar que hay datos de un termino y que hubiera session
if($_SESSION[$_SESSION["CFGURL"]][ssuser_id])
{
	switch($_GET[taskterm])
	{
		case 'addBT':
		echo HTMLformAssociateExistTerms($_GET[taskterm],$metadata["arraydata"],$term_id);
		break;

		case 'addRT':
		echo HTMLformAssociateExistTerms($_GET[taskterm],$metadata["arraydata"],$term_id);
		break;

		case 'addFreeUF':
		echo HTMLformAssociateExistTerms($_GET[taskterm],$metadata["arraydata"],$term_id);
		break;

		case 'addFreeNT':
		echo HTMLformAssociateExistTerms($_GET[taskterm],$metadata["arraydata"],$term_id);
		break;

		case 'addEQ':
		echo HTMLformAltaEquivalenciaTermino(ARRAYverDatosTermino($tema));
		break;

		case 'editNote':
		require_once(T3_ABSPATH . 'common/include/inc.abmNota.php');
		break;

		case 'addNT':
		echo HTMLformEditTerms($_GET[taskterm],$metadata["arraydata"]);
		break;

		case 'addUF':
		echo HTMLformEditTerms($_GET[taskterm],$metadata["arraydata"]);
		break;

		case 'addTerm':
		echo HTMLformEditTerms($_GET[taskterm],$metadata["arraydata"]);
		break;


		case 'addRTnw':
		echo HTMLformEditTerms($_GET[taskterm],$metadata["arraydata"]);
		break;

		case 'editTerm':
		echo HTMLformEditTerms($_GET[taskterm],$metadata["arraydata"]);
		break;

		case 'findTargetTerm':
		echo HTMLformAssociateTargetTerms($metadata["arraydata"]);
		break;

		case 'findSuggestionTargetTerm':
		echo HTMLformSuggestTermsXRelations($metadata["arraydata"]);
		break;

		case 'addTermSuggested':
		echo HTMLformSuggestTerms($metadata["arraydata"]);
		break;

		case 'addURI':
		echo HTMLformURI4term($metadata["arraydata"]);
		break;

		default:
		echo HTMLbodyTermino($metadata["arraydata"]);
	}

}
elseif($metadata["arraydata"])
{
	echo HTMLbodyTermino($metadata["arraydata"]);
}
?>
