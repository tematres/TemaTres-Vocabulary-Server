<?php 
include("config.tematres.php");

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
			$string_term=secure_data($_POST["edit_tema"],"sql");
			if((is_numeric($tema_id)) && (strlen($string_term)>0))
			{
				$task=abm_tema('mod',$string_term,$tema_id);
			}
			
			$arrayTerm=ARRAYverTerminoBasico($tema_id);
			echo $arrayTerm[tema];		
		}
		
}




$searchq		=	$_GET['q'];

if (!$searchq) return;

if(strlen($searchq)>= CFG_MIN_SEARCH_SIZE){

	$getRecord_sql	= ($_GET[t]=='e') ? SQLSimpleSearchTrueTerms($searchq,"15") : SQLbuscaTerminosSimple($searchq,"15");

	// ---------------------------------------------------------------- // 
	// AJAX Response													// 
	// ---------------------------------------------------------------- // 

	if($getRecord_sql[cant]>0)
	{

		while ($row = mysqli_fetch_array($getRecord_sql[datos])) 
		{		
			$tema= ($CFG["_CHAR_ENCODE"]=='utf-8') ? $row[tema] : FixEncoding($row[tema]);
			//$tema=$row[tema];
			if (strpos(strtolower($tema), $searchq) !== false) 
			{			
				echo "$tema|$row[tema_id]\n";
			}
			
		} 
	} ;

};


?>
