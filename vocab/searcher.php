<?php 
include("config.tematres.php");

$page_encode = (in_array($CFG["_CHAR_ENCODE"],array('utf-8','iso-8859-1'))) ? $CFG["_CHAR_ENCODE"] : 'utf-8';
	
header ('Content-type: text/html; charset='.$page_encode.'');

//user login true
if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
	//gestión de codigo de tema
	if($_POST["code_tema_id"])
		{
			$tema_id=str_replace("code_tema", "", $_POST["code_tema_id"]);	
			if(is_numeric($tema_id))
			{
				$task=edit_single_code($tema_id,$_POST[code_tema]);
				switch ($task["log"]) {
				case '0': //no pasó nada = nothing
				echo $task[code];				
				break;
				
				case '1': // OK
				echo $task[code];				
				break;

				case '-1': // ERROR
				header("HTTP/1.1 406 Not Acceptable");
				echo ' '.$_POST[code_tema].': '.MSG_ERROR_CODE.' ('.LABEL_Termino.' '.$task[tema].')';
				break;
				}
			}
		}
		
	//gestión de codigo de tema
	if($_POST["edit_tema_id"])
		{

			$tema_id=str_replace("edit_tema", "", $_POST["edit_tema_id"]);			
			//additional secure check
			$string_term=trim($_POST["edit_tema"]);
			if((is_numeric($tema_id)) && (strlen($string_term)>0))
			{
				$task=abm_tema('mod',$string_term,$tema_id);
			}
			
			$arrayTerm=ARRAYverTerminoBasico($tema_id);
			echo $arrayTerm[tema];		
		}

	//abm for relations defined by user
	if($_POST["edit_rel_id"])
		{

			$rel_id=str_replace("edit_rel_id", "", $_POST["edit_rel_id"]);			


			//eliminar relación == 
			if($_POST[rel_rel_id]=='0')
			{				
				$task=abm_rel_rel("BAJA",$rel_id,$_POST[rel_rel_id]);
			}
			elseif (is_numeric($_POST[rel_rel_id])) {

				$task=abm_rel_rel("ALTA",$rel_id,$_POST[rel_rel_id]);
				
			}
						
			$arrayRelData=ARRAYdataRelation($task[rel_id]);
			
			$labelRel=LABELrelTypeSYS($arrayRelData[t_relation]);
	
			//reverse or not view of the relation	
			echo ($_POST[relativeLabel]=='X') ? $labelRel[rx_code].$arrayRelData[rr_code] : $labelRel[r_code].$arrayRelData[rr_code];		
		}
		
}
?>
