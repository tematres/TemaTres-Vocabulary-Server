<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
/*
must be ADMIN
*/
if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){
	// get the variables

	// tests
	$ok = true ;
	$error = array() ;


	if ( $ok && utf8_encode(utf8_decode($content_text)) == $content_text ) {
		$content_text = NULL ;
	}
	else {
		$ok = false ;
		$error[] = "ERROR : encodage of import file must be UTF-8" ;
		// sinon faire conversion automatique
	}





	if (($_POST['taskAdmin']=='importTag') && (file_exists($_FILES["file"]["tmp_name"])) )
	{

		$src_txt= $_FILES["file"]["tmp_name"];


		//tag separator
		$separador=":";
		$t_relacion='';
		$tabulador='====';

		//get for notes tag
		$sqlNotesTag=SQLcantNotas();
		$arrayTiposNotas=array();
		while ($arrayNotesTag=$sqlNotesTag->FetchRow()){
			array_push($arrayTiposNotas, $arrayNotesTag["value_code"]);
		}

		//admited tags
		$arrayTiposTermino =  array("BT","NT","RT","UF","Use","CODE",$tabulador);

		//lang
		$thes_lang=$_SESSION["CFGIdioma"];

		/*
		Procesamiento del file
		*/
		$fd=fopen($src_txt,"r");

		while ( ($contents= fgets($fd)) !== false ) {
			$rw=trim($contents);

			$rwTerms=explode($separador,$rw);

			//Ver si es un array
			if(is_array($rwTerms))
			{

				$rwTerms[0]=trim($rwTerms[0]);
				$rwTerms[1]=trim($rwTerms[1]);

				$term=$rwTerms[0];
				$objectTerm=$rwTerms[1];

				//Si es un término o un tag
				$t_relacion=(in_array($rwTerms[0],$arrayTiposTermino)) ? $rwTerms[0] : $t_relacion;


				//es un término
				if ((strlen($term)>0) && (!$objectTerm)) {

					$term_id=resolveTerm_id($term);
					$i=++$i;
				}

				//es una nota
				if (in_array($rwTerms[0],$arrayTiposNotas)) {
					//re-redactar nota para prevenir signo de separación en notas
					$note=implode($separador, array_slice($rwTerms, 1));

					abmNota("A",$term_id,$rwTerms[0],"$thes_lang",trim($note));


				}//es una relación terminológica
				elseif (in_array($rwTerms[0],$arrayTiposTermino)) {


					//Retomar tag
					$label=($rwTerms[0]==$tabulador) ? $past_label : trim($rwTerms[0]);

					switch ($label) {
						case 'CODE':
						edit_single_code($term_id,$objectTerm);
						break;

						case 'BT':
						$BTterm_id=resolveTerm_id($objectTerm,"1");
						ALTArelacionXId($BTterm_id,$term_id,"3");
						break;

						case 'RT':
						$RTterm_id=resolveTerm_id($objectTerm,"1");
						ALTArelacionXId($term_id,$RTterm_id,"2");
						ALTArelacionXId($RTterm_id,$term_id,"2");
						break;

						case 'NT':
						$NTterm_id=resolveTerm_id($objectTerm,"1");
						ALTArelacionXId($term_id,$NTterm_id,"3");
						break;

						case 'UF':
						$UFterm_id=resolveTerm_id($objectTerm);
						ALTArelacionXId($UFterm_id,$term_id,"4");
						break;

						case 'USE':
						$UFterm_id=resolveTerm_id($objectTerm,"1");
						ALTArelacionXId($term_id,$UFterm_id,"4");
						break;

						default :


						break;
					}

					$past_label=$label;
				}//fin del if mida algo el termino

				//}	//fin del if in_array por tipo de relacions
			}	// fin del if es un array
		}// fin del arbribr archo
		fclose($fd);
		//recreate index
		$sql=SQLreCreateTermIndex();
		echo '<p class="true">'.ucfirst(IMPORT_finish).'</p>' ;
	};
}
/*
functiones
*/




function ALTArelacionXId($id_mayor,$id_menor,$t_relacion){
	GLOBAL $DBCFG;

	if(($id_mayor>0) && ($id_menor>0))
	{
		return do_r($id_mayor,$id_menor,$t_relacion);
	}
}
?>
