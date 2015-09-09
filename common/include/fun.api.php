<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Abstraccion de funciones de consulta
#
// Be careful, access to this file is not protected
if (stristr( $_SERVER['REQUEST_URI'], "fun.api.php") ) die("no access");

class XMLvocabularyServices {

	// Devuelve array de temas relacionados
	// array (tema_id, tema,t_relacion_id)
	function fetchRelatedTerms($tema_id){

		$sql=SQLverTerminoRelaciones($tema_id);

		while($array=$sql->FetchRow()){
			if($array["t_relacion"]=='2'){
				$result["result"][$array[tema_id]]= array(
					"term_id"=>$array["tema_id"],
					"code"=>$array["code"],
					"lang"=>$array["idioma"],
					"string"=>$array["tema"],
					"isMetaTerm"=>$array["isMetaTerm"],
					"relation_type_id"=>$array["t_relacion"],
					"relation_type"=>"RT",
					"relation_code"=>$array["rr_code"],
					"relation_label"=>$array["rr_value"]
				);
			};
		}
		return $result;
	}


	// Devuelve array de términos no preferidos
	// array with "use for" or "alternative" or  "non prefered" terms for tema_id
	// array (tema_id, tema,t_relacion_id)
	function fetchAltTerms($tema_id){

		$sql=SQLverTerminoRelaciones($tema_id);

		while($array=$sql->FetchRow()){
			if($array[t_relacion]=='4'){
				$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"code"=>$array[code],
					"lang"=>$array[idioma],
					"string"=>$array[tema],
					"relation_type_id"=>$array[t_relacion],
					"relation_type"=>"UF",
					"relation_code"=>$array[rr_code],
					"relation_label"=>$array[rr_value]
				);
			};
		}
		return $result;
	}

	// Devuelve array de términos de búsqueda exacta
	// array(tema_id,string,no_term_string,relation_type_id,order)
	function fetchExactTerm($string){

		$sql=SQLbuscaExacta($string);

		while($array=$sql->FetchRow()){
			$i=++$i;

			$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"isMetaTerm"=>$array["isMetaTerm"],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
				"order" => $i
			);
		};
		return $result;
	}

	// Devuelve array de términos UF,TR y TG directos
	// array with non prefered (UF),related and direct TG terms for tema_id
	// array (tema_id, string,t_relacion_id)
	function fetchDirectTerms($tema_id){

		/*
		$sql=SQLterminosDirectos($tema_id);
		*/
		$sql=SQLverTerminoRelaciones($tema_id);

		while($array=$sql->FetchRow()){

			$relation_type=arrayReplace(array("2","3","4"),array("RT","BT","UF"),$array[t_relacion]);

			$result["result"][$array[tema_id]]= array(
				"term_id"=>$array[tema_id],
				"code"=>$array[code],
				"lang"=>$array[idioma],
				"string"=>$array[tema],
				"isMetaTerm"=>$array[isMetaTerm],
				"relation_type_id"=>$array[t_relacion],
				"relation_type"=>$relation_type,
				"relation_code"=>$array[rr_code],
				"relation_label"=>$array[rr_value]
			);
		}
		return $result;
	}

	// Devuelve lista de temas especificos
	// array (tema_id, tema,t_relacion_id, hasMoreDown)
	function fetchTermDown($tema_id){

		$sql=SQLverTerminosE($tema_id);

		while($array=$sql->FetchRow())
		{
			$result["result"][$array[id_tema]]= array(
				"term_id"=>$array[id_tema],
				"string"=>$array[tema],
				"isMetaTerm"=>$array[isMetaTerm],
				"lang"=>$array[idioma],
				"relation_type_id"=>$array[t_relacion],
				"relation_type"=>"NT",
				"relation_code"=>$array[rr_code],
				"relation_label"=>$array[rr_value],
				"hasMoreDown" => ($array[id_te]) ? 1 : 0
			);
		};
		return $result;
	}



	/*
	// Devuelve lista de URL externas vincualdas al términos
	* retrieve URLs linked to the term
	*/
	function fetchURI($tema_id){

		$sql=SQLURIxterm($tema_id);

		while($array=$sql->FetchRow())
		{
			$result["result"][$array["tema_id"]]= array(
				"link_type"=>$array["uri_value"],
				"link"=>$array["uri"]
			);
		};
		return $result;
	}


	// Devuelve arbol de temas genericos
	// array(tema_id,string,relation_type_id,order)
	function fetchTermUp($tema_id){

		$sql=SQLarbolTema($tema_id);

		/*
		Si hay resultados
		*/
		if(SQLcount($sql)>0){
			while($array=$sql->FetchRow())
			{
				$i=++$i;
				$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema],
					"isMetaTerm"=>$array[isMetaTerm],
					"relation_type_id"=>$array[t_relacion],
					"order" => $i
				);
			};
		}
		return $result;
	}


	// Devuelve detalles competos de un tema (tema + notas)
	// array(tema_id,string,hasMoreUp,term_type,date_create,date_mod,numNotes)
	function fetchTermDetailsFull($tema_id){

		$array=ARRAYverDatosTermino($tema_id);

		$result["tema_id"]=$array[idTema];
		$result["code"]=$array[code];
		$result["lang"]=$array[idioma];
		$result["string"]=$array[titTema];
		$result["isMetaTerm"]=$array[isMetaTerm];
		$result["hasMoreUp"]=$array[supraTema];
		$result["term_type"]=$array[tipoTema];
		$result["date_create"]=$array[cuando];
		$result["date_mod"]=$array[cuando_final];
		$result["numNotes"]=count($array["notas"]);
		return $result;
	}


	// Devuelve detalles de un tema
	// array(tema_id,string)
	function fetchTermDetailsBrief($tema_id){

		$array=ARRAYverTerminoBasico($tema_id);

		if(is_array($array)){
			$result["result"]["term"]["term_id"]=$array["idTema"];
			$result["result"]["term"]["tema_id"]=$array["idTema"];
			$result["result"]["term"]["code"]=$array["code"];
			$result["result"]["term"]["lang"]=$array["idioma"];
			$result["result"]["term"]["string"]=$array["titTema"];
			$result["result"]["term"]["isMetaTerm"]=$array["isMetaTerm"];
			$result["result"]["term"][date_create]=$array[cuando];
			$result["result"]["term"][date_mod] = ($array[cuando_final]) ?  $array[cuando_final] : $array[cuando];
		}
		return $result;
	}


	// Devuelve detalles de un tema para un código
	// Retrieve simple term data for given code

	// return array(tema_id,string)
	function fetchCode($code){

		$array=ARRAYCodeDetailed($code);

		if(is_array($array)){
			$result["result"]["term"]["term_id"]=$array["idTema"];
			$result["result"]["term"]["tema_id"]=$array["idTema"];
			$result["result"]["term"]["code"]=$array["code"];
			$result["result"]["term"]["lang"]=$array["idioma"];
			$result["result"]["term"]["string"]=$array["titTema"];
			$result["result"]["term"]["isMetaTerm"]=$array["isMetaTerm"];
			$result["result"]["term"][date_create]=$array[cuando];
			$result["result"]["term"][date_mod] = ($array[cuando_final]) ?  $array[cuando_final] : $array[cuando];
		}
		return $result;
	}



	// Devuelve notas de un tema
	// array(tema_id,string,note_id,note_type,note_lang,note_text)
	function fetchTermNotes($tema_id){

		$sql=SQLdatosTerminoNotas($tema_id);

		while($array=$sql->FetchRow())
		{
			$i=++$i;
			$result["result"][$array[nota_id]]= array(
				"term_id"=>$array[tema_id],
				"string"=>$array[tema],
				"note_id"=>$array[nota_id],
				"note_type"=>($array[ntype_code]) ? $array[ntype_code] : $array[tipo_nota],
				"note_lang"=>$array[lang_nota],
				"note_text"=>$array[nota]
			);
		};
		return $result;
	}


	// Array de términos tope
	// array(tema_id,string)
	function fetchTopTerms($arrayCfg){

		$sql=SQLverTopTerm();

		while($array=$sql->FetchRow())
		{
			$result["result"][$array[id]]= array(
				"term_id"=>$array["id"],
				"code"=>$array["code"],
				"lang"=>$array["idioma"],
				"string"=>FixEncoding($array["tema"]),
				"isMetaTerm"=>$array["isMetaTerm"]
			);
		};
		return $result;
	}

	// Array de términos tope
	// array(tema_id,string)
	function fetchLast(){

		$sql=SQLlastTerms(50);

		while($array=$sql->FetchRow())
		{
			$array["cuando_final"]=($array["cuando_final"]>0) ? $array["cuando_final"] : '';

			$result["result"]["$array[tema_id]"]= array(
				"term_id"=>$array["tema_id"],
				"code"=>$array["code"],
				"lang"=>$array["idioma"],
				"string"=>FixEncoding($array["tema"]),
				"isMetaTerm"=>$array["isMetaTerm"],
				"date_create"=>$array["cuando"],
				"date_mod"=>$array["cuando_final"]
			);
		};
		return $result;
	}



	// Devuelve lista de términos para una lista separada por comas de tema_id
	// array(tema_id,string)
	function fetchTermsByIds($tema_id_list){

		$sql=SQLlistaTema_id($tema_id_list);

		while($array=$sql->FetchRow())
		{
			$result["result"][$array[tema_id]]= array(
				"term_id"=>$array["tema_id"],
				"string"=>$array["tema"],
				"isMetaTerm"=>$array["isMetaTerm"]
			);
		};
		return $result;
	}



	// Devuelve lista de términos relacionados para una lista separada por comas de tema_id
	// array(tema_id,string)
	function fetchRelatedTermsByIds($tema_id_list){

		$sql=SQLexpansionTR($tema_id_list);

		while($array=$sql->FetchRow())
		{
			$result["result"][$array[tema_id]]= array(
				"term_id"=>$array[tema_id],
				"string"=>$array[tema],
				"isMetaTerm"=>$array["isMetaTerm"]
			);
		};
		return $result;
	}

	// Devuelve lista de términos mapeados para un tema_id
	// array(tema_id,string)
	function fetchTargetTermsById($tema_id){

		$sql=SQLtargetTerms($tema_id);

		while($array=$sql->FetchRow())
		{
			$result["result"][$array[tterm_id]]= array(

				"string"=>$array[tterm_string],
				"url"=>$array[tterm_url],
				"uri"=>$array[tterm_uri],
				"term_id"=>$array[tema_id],
				"target_vocabulary_label"=>$array[tvocab_label],
				"target_vocabulary_tag"=>$array[tvocab_tag],
				"target_vocabulary_title"=>$array[tvocab_title]
			);
		};
		return $result;
	}

	// Devuelve lista de términos propios mapeados para una URI de un término externo
	//
	function fetchSourceTermsByURI($URI_term){

		$sql=SQLsourceTermsByURI($URI_term);
		while($array=$sql->FetchRow())
		{
			$result["result"][$array[tema_id]]= array(
				"term_id"=>$array["tema_id"],
				"tema_id"=>$array["tema_id"],
				"code"=>$array["code"],
				"lang"=>$array["idioma"],
				"string"=>$array["tema"],
				"isMetaTerm"=>$array["isMetaTerm"],
				"date_create"=>$array["cuando"],
				"date_mod"=> ($array["cuando_final"]) ?  $array["cuando_final"] : $array["cuando"]
			);
		};
		return $result;
	}

	// Devuelve lista de términos propios mapeados para un término
	//
	function fetchSourceTerms($term){

		$sql=SQLsourceTermsByTerm($term);
		while($array=$sql->FetchRow())
		{
			$result["result"][$array[tema_id]]= array(
				"term_id"=>$array["tema_id"],
				"tema_id"=>$array["tema_id"],
				"code"=>$array["code"],
				"lang"=>$array["idioma"],
				"string"=>$array["tema"],
				"isMetaTerm"=>$array["isMetaTerm"],
				"date_create"=>$array["cuando"],
				"date_mod"=> ($array["cuando_final"]) ?  $array["cuando_final"] : $array["cuando"]
			);
		};
		return $result;
	}

	// Array de términos que comienzan con una letra
	// array(tema_id,string,no_term_string,relation_type_id)
	function fetchTermsByLetter($letter){

		$cantLetra=numTerms2Letter($letter);

		$sql=SQLmenuABCpages($letter,array("min"=>0,"limit"=>$cantLetra));

		while($array=$sql->FetchRow())
		{
			$i=++$i;
			$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"isMetaTerm"=>$array["isMetaTerm"],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
				"relation_type_id"=>$array[t_relacion]
			);
		};
		return $result;
	}


	// Devuelve lista de términos para una busqueda
	// array(tema_id,string,no_term_string,relation_type_id,array(index),order)
	function fetchTermsBySearch($string){


		$sql=SQLbuscaSimple($string);

		while($array=$sql->FetchRow()){
			$i=++$i;
			$arrayIndex=explode('|',$array[indice]);
			$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"isMetaTerm"=>$array["isMetaTerm"],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
				"index"=>$array[indice],
				"order" => $i
			);
		};
		return $result;
	}


	// Devuelve lista de términos para una busqueda en notas
	// array(tema_id,string,no_term_string,relation_type_id,array(index),order)
	function fetchTermsBySearchNotes($string){


		$sql=SQLsearchInNotes($string);

		while($array=$sql->FetchRow()){
			$i=++$i;
			$arrayIndex=explode('|',$array[indice]);
			$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"isMetaTerm"=>$array["isMetaTerm"],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
				"index"=>$array[indice],
				"order" => $i
			);
		};
		return $result;
	}


	// Devuelve lista de términos para una cadena inicial de busqueda = return terms beginning with string
	// array(tema_id,string,no_term_string,relation_type_id,array(index),order)
	function fetchSuggestedDetails($string){


		$sql=SQLstartWith($string);

		while($array=$sql->FetchRow()){
			$i=++$i;
			$arrayIndex=explode('|',$array[indice]);
			$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"isMetaTerm"=>$array["isMetaTerm"],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
				"index"=>$array[indice],
				"order" => $i
			);
		};
		return $result;
	}



	// Devuelve lista de términos para una cadena inicial de busqueda = return terms beginning with string
	// array(tema_id,string,no_term_string,relation_type_id,array(index),order)
	function fetchSuggested($string){


		$sql=SQLstartWith($string);

		$result["result"]=array();

		while($array=$sql->FetchRow()){
			$i=++$i;
			array_push($result["result"], ($array[termino_preferido]) ? $array[termino_preferido] : $array[tema]);
		};

		return $result;
	}


	// Devuelve detalles del vocabularios
	//array(vocabulario_id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base,polijerarquia)
	function fetchVocabularyData($vocabulary_id){

		$sql=SQLdatosVocabulario($vocabulary_id);
		$array=$sql->FetchRow();
		$arrayResponse["result"][vocabulary_id]	=$array[vocabulario_id];
		$arrayResponse["result"][title]		=$array[titulo];
		$arrayResponse["result"][author]		=$array[autor];
		$arrayResponse["result"][lang]		=$array[idioma];
		$arrayResponse["result"][scope]		=$array[cobertura];
		$arrayResponse["result"][keywords]	=$array[keywords];
		$arrayResponse["result"][uri]		=$array[url_base];
		$arrayResponse["result"][createDate]=$array[cuando];
		$arrayResponse["result"][lastMod]	=fetchlastMod();


		$ARRAYfetchValues=ARRAYfetchValues('METADATA');
		$ARRAYfetchContactMail=ARRAYfetchValue('CONTACT_MAIL');

		$arrayResponse["result"]["contributor"]= $ARRAYfetchValues["dc:contributor"]["value"];
		$arrayResponse["result"]["adminEmail"]= $ARRAYfetchContactMail["value"];
		$arrayResponse["result"]["publisher"]= $ARRAYfetchValues["dc:publisher"]["value"];
		$arrayResponse["result"]["rights"]= $ARRAYfetchValues["dc:rights"]["value"];


		$cant_term=ARRAYcantTerms4Thes("1");

		$arrayResponse["result"]["cant_terms"]	=$cant_term["cant"];


		return $arrayResponse;
	}

	//Devuelve un término con cadena similar para una una cadena de búsqueda
	//array($tema_id,$tema)
	function fetchSimilar($string)
	{

		$sqlSimilar=SQLsimiliar($string);

		if(is_object($sqlSimilar))
		{
			while($arraySimilar=$sqlSimilar->FetchRow())
			{
				$listaCandidatos.= $arraySimilar[tema].'|';
			}

			$listaCandidatos=explode("|",$listaCandidatos);
			$similar = new Qi_Util_Similar($listaCandidatos, $string);
			$sugerencia= $similar->sugestao();
		}

		$evalSimilar=evalSimiliarResults($string, $sugerencia);

		if ($sugerencia && $evalSimilar)
		{
			$result["result"]= array("string"=>$sugerencia);
		}
		else
		{
			$result["result"]= array();
		}

		return $result;
	}


	// Desvuelve un array describiendo los servicios
	function describeService($msg=array()){

		GLOBAL $CFG;

		$array['status'] = (CFG_SIMPLE_WEB_SERVICE=='1') ? 'available' : 'disable';

		$array['status_skos_core'] = ($_SESSION[$_SESSION["CFGURL"]]["_PUBLISH_SKOS"]=='1') ? 'available' : 'disable';


		$array['param'] = array("task","arg","output");

		$array['param']['task'] = "Action to do";
		$array['param']['arg'] = "arguments for task action (eg: string for search task, numerical id for specific term data)";
		$array['param']['output'] = "Output format, can be JSON or XML. Optional parameter, XML by default ";

		$array['web_service_version'] = $CFG["VersionWebService"];

		$array['version'] = $CFG["Version"];

		if(@$msg["error"])
		{
			$array['error']['message'] = $msg["error"];
		}


		$array['fetchVocabularyData']['action'] = 'Retrieve data about vocabulary';
		$array['fetchVocabularyData']['task'] = 'fetchVocabularyData ';
		$array['fetchVocabularyData']['arg'] = '1';
		$array['fetchVocabularyData']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchVocabularyData';

		$array['fetchTopTerms']['action'] = ' Retrieve vocabulary top terms';
		$array['fetchTopTerms']['task'] = 'fetchTopTerms';
		$array['fetchTopTerms']['arg'] = ' none';
		$array['fetchTopTerms']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchTopTerms';

		$array['search']['action'] = 'Search and retrieve terms';
		$array['search']['task'] = 'search';
		$array['search']['arg'] = 'search expresion (string)';
		$array['search']['example'] = $_SESSION["CFGURL"].'services.php?task=search&arg=peace';

		$array['fetch']['action'] = 'Search and retrieve terms using exact matching';
		$array['fetch']['task'] = 'fetch';
		$array['fetch']['arg'] = 'search expresion (string)';
		$array['fetch']['example'] = $_SESSION["CFGURL"].'services.php?task=fetch&arg=peace';

		$array['searchNotes']['action'] = 'Retrieve terms searching in notes';
		$array['searchNotes']['task'] = 'searchNotes';
		$array['searchNotes']['arg'] = 'search expresion (string)';
		$array['searchNotes']['example'] = $_SESSION["CFGURL"].'services.php?task=searchNotes&arg=peace';

		$array['suggest']['action'] = 'Simple search and retrieve terms who start with string (only string)';
		$array['suggest']['task'] = 'suggest';
		$array['suggest']['arg'] = 'search expresion (string)';
		$array['suggest']['example'] = $_SESSION["CFGURL"].'services.php?task=suggest&arg=pea';

		$array['suggestDetails']['action'] = 'Search and retrieve terms who start with string (term_id, term, and more data)';
		$array['suggestDetails']['task'] = 'suggestDetails';
		$array['suggestDetails']['arg'] = 'search expresion (string)';
		$array['suggestDetails']['example'] = $_SESSION["CFGURL"].'services.php?task=suggestDetails&arg=pea';

		$array['fetchCode']['action'] = 'Retrieve simple term data by code';
		$array['fetchCode']['task'] = 'fetchCode';
		$array['fetchCode']['arg'] = 'code (string)';
		$array['fetchCode']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchCode&arg=01.03.04';

		$array['letter']['action'] = 'Search and retrieve terms was beginning with letter $arg';
		$array['letter']['task'] = 'letter';
		$array['letter']['arg'] = 'one letter (for example: arg=a)';
		$array['letter']['example'] = $_SESSION["CFGURL"].'services.php?task=letter&arg=a';

		$array['fetchTerm']['action'] = ' Retrieve simple term data ';
		$array['fetchTerm']['task'] = 'fetchTerm';
		$array['fetchTerm']['arg'] = 'one ID (int)';
		$array['fetchTerm']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchTerm&arg=1';

		$array['fetchAlt']['action'] = ' Retrieve alternative/non prefered terms for one ID ';
		$array['fetchAlt']['task'] = 'fetchAlt';
		$array['fetchAlt']['arg'] = 'one ID (int)';
		$array['fetchAlt']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchAlt&arg=1';

		$array['fetchDown']['action'] = ' Retrieve more specific terms for one ID ';
		$array['fetchDown']['task'] = 'fetchDown';
		$array['fetchDown']['arg'] = 'one ID (int)';
		$array['fetchDown']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchDown&arg=1';

		$array['fetchUp']['action'] = ' Retrieve hierarquical structure for one ID ';
		$array['fetchUp']['task'] = 'fetchUp';
		$array['fetchUp']['arg'] = 'one ID (int)';
		$array['fetchUp']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchUp&arg=1';

		$array['fetchRelated']['action'] = ' Retrieve related terms for one ID ';
		$array['fetchRelated']['task'] = 'fetchRelated';
		$array['fetchRelated']['arg'] = 'one ID (int)';
		$array['fetchRelated']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchRelated&arg=1';

		$array['fetchNotes']['action'] = ' Retrieve notes for one term ';
		$array['fetchNotes']['task'] = 'fetchNotes';
		$array['fetchNotes']['arg'] = 'one ID (int)';
		$array['fetchNotes']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchNotes&arg=1';

		$array['fetchDirectTerms']['action'] = ' Retrieve alternative, related and direct hieraquical terms for one term_id ';
		$array['fetchDirectTerms']['task'] = 'fetchDirectTerms';
		$array['fetchDirectTerms']['arg'] = 'one ID (int)';
		$array['fetchDirectTerms']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchDirectTerms&arg=1';

		$array['fetchURI']['action'] = 'Search and retrieve data about URI or internet entities linked to one term_id';
		$array['fetchURI']['task'] = 'fetchURI';
		$array['fetchURI']['arg'] = 'one ID term_id (int)';
		$array['fetchURI']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchURI&arg=1';

		//~ $array['fetchSourceTermsURI']['action'] = 'Search and retrieve terms mapped in target vocabulary for term in source vocabulary. Use URI of web services for the term to retrieve data';
		//~ $array['fetchSourceTermsURI']['task'] = 'fetchSourceTermsURI';
		//~ $array['fetchSourceTermsURI']['arg'] = 'the URI provided by source vocabulary for the term. The URI must be a string according to RFC 3986.';
		//~ $array['fetchSourceTermsURI']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchSourceTermsURI&arg='.$_SESSION["CFGURL"].'services.php?task=fetchTerm&arg=1';

		$array['fetchTargetTerms']['action'] = 'Search and retrieve data about target terms mapped via web services for one term_id';
		$array['fetchTargetTerms']['task'] = 'fetchTargetTerms';
		$array['fetchTargetTerms']['arg'] = 'one ID term_id (int)';
		$array['fetchTargetTerms']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchTargetTerms&arg=1';

		$array['fetchSourceTerms']['action'] = 'Search and retrieve terms mapped in target vocabulary for a given term';
		$array['fetchSourceTerms']['task'] = 'fetchSourceTerms';
		$array['fetchSourceTerms']['arg'] = 'term (string)';
		$array['fetchSourceTerms']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchSourceTerm&arg=term';

		$array['fetchTerms']['action'] = ' Retrieve simple term data for some coma separated IDs (example: 3,6,98) ';
		$array['fetchTerms']['task'] = 'fetchTerms';
		$array['fetchTerms']['arg'] = 'some coma separated IDs (for example: arg=3,6,98)';
		$array['fetchTerms']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchTerms&arg=1,2,4';

		$array['fetchRelatedTerms']['action'] = ' Retrieve simple related term data for some coma separated terms IDs (example: 3,6,98) ';
		$array['fetchRelatedTerms']['task'] = 'fetchRelatedTerms';
		$array['fetchRelatedTerms']['arg'] = 'some coma separated IDs (for example: arg=3,6,98)';
		$array['fetchRelatedTerms']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchRelatedTerms&arg=1,4';

		$array['fetchSimilar']['action'] = 'Search and retrieve similar term for string search expresion ($arg)';
		$array['fetchSimilar']['task'] = 'fetchSimilar';
		$array['fetchSimilar']['arg'] = 'string (for example: arg=trrends)';
		$array['fetchSimilar']['example'] = $_SESSION["CFGURL"].'services.php?task=letter&arg=a';

		$array['fetchLast']['action'] = 'Retrieves last terms created';
		$array['fetchLast']['task'] = 'fetchLast';
		$array['fetchLast']['arg'] = 'none';
		$array['fetchLast']['example'] = $_SESSION["CFGURL"].'services.php?task=fetchLast';


		return $array;
	}


	// fin de la clase
}


#######################################################################



function fetchVocabularyService($task,$arg,$output="xml")
{

	$evalParam=evalServiceParam($task,$arg);

	//Verificar servicio habilitado
	if((CFG_SIMPLE_WEB_SERVICE !== "1") || (!$task)){
		$service=new XMLvocabularyServices();
		return array2xml($service-> describeService());

		// Controlar parametros

	} elseif(@$evalParam["error"]) {

		$service=new XMLvocabularyServices();
		return array2xml($service-> describeService($evalParam));

		// Los param esta bien
	}else{

		$task=$evalParam["task"];
		$arg=$evalParam["arg"];

		$service=new XMLvocabularyServices();
		switch($task){
			//array
			case 'fetch':
			$response = $service-> fetchExactTerm($arg);
			break;

			//array
			case 'search':
			$response = $service-> fetchTermsBySearch($arg);
			break;

			//array
			case 'searchNotes':
			$response = $service-> fetchTermsBySearchNotes($arg);
			break;

			//array
			case 'suggest':
			$response = $service-> fetchSuggested($arg);
			break;

			//array
			case 'suggestDetails':
			$response = $service-> fetchSuggestedDetails($arg);
			break;

			//array (tema_id,tema)
			case 'fetchSimilar':
			$response = $service-> fetchSimilar($arg);
			break;

			case 'fetchRelated':
			// array (tema_id, tema,t_relacion_id)
			$response = $service-> 	fetchRelatedTerms($arg);
			break;

			case 'fetchAlt':
			// array (tema_id, tema,t_relacion_id)
			$response = $service-> 	fetchAltTerms($arg);
			break;


			case 'fetchDown':
			// Devuelve lista de temas especificos
			// array (tema_id, tema,t_relacion_id, hasMoreDown)
			$response = $service-> fetchTermDown($arg);
			break;


			case 'fetchUp':
			// Devuelve arbol de temas genericos
			// array(tema_id,string,relation_type_id,order)
			$response = $service-> fetchTermUp($arg);
			break;

			case 'fetchTermFull':
			// Devuelve detalles competos de un tema (tema + notas)
			// array(tema_id,string,hasMoreUp,term_type,date_create,date_mod,numNotes)
			break;

			case 'fetchTerm':
			// Devuelve detalles de un tema
			// array(tema_id,string)
			$response = $service-> fetchTermDetailsBrief($arg);
			break;

			case 'fetchCode':
			// Devuelve detalles de un tema
			// array(tema_id,string)
			$response = $service-> fetchCode($arg);
			break;

			case 'fetchNotes':
			// Devuelve notas de un tema
			// array(tema_id,string,note_id,note_type,note_lang,note_text)
			$response = $service-> fetchTermNotes($arg);
			break;

			case 'fetchTopTerms':
			// Array de términos tope
			// array(tema_id,string)
			$response = $service-> fetchTopTerms($arg);
			break;

			case 'fetchLast':
			// Array de últimos términos creados
			// array(tema_id,string)
			$response = $service-> fetchLast();
			break;

			case 'fetchDirectTerms':
			// Array de términos vinculados directamente con el termino (TG,TR,UF)
			// array(tema_id,string,relation_type_id)
			$response = $service-> fetchDirectTerms($arg);
			break;

			case 'fetchTerms':
			// Devuelve lista de términos para una lista separada por comas de tema_id
			// array(tema_id,string)
			$response = $service-> fetchTermsByIds($arg);
			break;

			case 'fetchRelatedTerms':
			// Devuelve lista de términos relacionados para una lista separada por comas de tema_id
			// array(tema_id,string)
			$response = $service-> fetchRelatedTermsByIds($arg);
			break;

			case 'fetchTargetTerms':
			// Devuelve lista de términos mapeados para un tema_id
			// array(tema_id,string)
			$response = $service-> fetchTargetTermsById($arg);
			break;

			case 'fetchURI':
			// Devuelve lista de enlaces linkeados para un tema_id
			// list of foreign links to term
			// array(type link,link)
			$response = $service-> fetchURI($arg);
			break;

			//~ case 'fetchSourceTermsURI':
			//~ // Devuelve lista de términos propios que están mapeados para una URI provista por un término externo
			//~ // list of source terms who are mapped by URI provided by target vocabulary.
			//~ // array(tema_id,string,code,lang,date_create,date_mod)
			//~ $response = $service-> fetchSourceTermsByURI(rawurldecode($arg));
			//~ break;

			case 'fetchSourceTerms':
			// Devuelve lista de términos propios que están mapeados para un determinado término
			// list of source terms who are mapped for a given term  provided by ANY target vocabulary.
			// array(tema_id,string,code,lang,date_create,date_mod)
			$response = $service-> fetchSourceTerms($arg);
			break;

			case 'letter':
			// Array de términos que comienzan con una letra
			// array(tema_id,string,no_term_string,relation_type_id)

			// sanitice $letter
			$arg=trim(urldecode($arg));
			// comment this line for russian chars
			//$arg=secure_data($arg,"alnum");

			$response = $service-> fetchTermsByLetter($arg);
			break;


			case 'fetchVocabularyData':
			// Devuelve detalles del vocabularios
			//array(vocabulario_id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base)
			$response = $service-> fetchVocabularyData("1");
			break;

			default:
			$response = $service-> describeService();
			break;
		}



		GLOBAL $CFG;

		$arrayResume['status'] = (CFG_SIMPLE_WEB_SERVICE=='1') ? 'available' : 'disable';

		$arrayResume['param'] = array("task"=>$task,"arg"=>$arg);

		$arrayResume['web_service_version'] = $CFG["VersionWebService"];

		$arrayResume['version'] = $CFG["Version"];

		$arrayResume["cant_result"] = count($response["result"]);

		$response["resume"] = $arrayResume;

		$xml_resume=array2xml($arrayResume, $name='resume', $standalone=FALSE, $beginning=FALSE);

		$xml_response=array2xml($response, $name='terms', $standalone=TRUE, $beginning=FALSE,$nodeChildName='term');



		switch ($output){
			case 'json':
			header('Content-type: application/json');
			return array2json($response,'vocabularyservices');
			break;

			case 'skos':
			header('Content-Type: text/xml');
			return ($_SESSION[$_SESSION["CFGURL"]]["_PUBLISH_SKOS"]=='1') ? array2skos($response,'vocabularyservices') : array2xml($response,'vocabularyservices');
			break;

			default:
			header('Content-Type: text/xml');
			return array2xml($response,'vocabularyservices');
		};

	}
}

function evalServiceParam($task,$arg)
{

	$array_tasks=array("fetch"=>"string",
	"search"=>"string",
	"searchNotes"=>"string",
	"suggest"=>"string",
	"suggestDetails"=>"string",
	"fetchSimilar"=>"string",
	"fetchCode"=>"string",
	"fetchRelated"=>"int",
	"fetchAlt"=>"int",
	"fetchDown"=>"int",
	"fetchUp"=>"int",
	"fetchTermFull"=>"int",
	"fetchTerm"=>"int",
	"fetchDirectTerms"=>"int",
	"fetchNotes"=>"int",
	"fetchURI"=>"int",
	"fetchTopTerms"=>"NULL",
	"fetchLast"=>"NULL",
	"fetchVocabularyData"=>"NULL",
	"fetchTerms"=>"array_int",
	"fetchTargetTerms"=>"int",
	"fetchSourceTerms"=>"string",
	"fetchRelatedTerms"=>"array_int",
	"letter"=>"string"
);

//eval task
if(!array_key_exists($task,$array_tasks)){

	return array("error"=>"invalid task param");
}

//eval arg
$arg=evalArg($array_tasks[$task],$arg);

switch($task){
	case 'fetch':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'search':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'suggest':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'suggestDetails':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'similarTerm':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchCode':
	$response = (is_string($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchRelated':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchAlt':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchDown':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;


	case 'fetchUp':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchTermFull':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchTerm':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchDirectTerms':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchNotes':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchURI':
	$response = (is_numeric($arg)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchTopTerms':
	$response = array("task"=>$task,"arg"=>$arg);
	break;

	case 'fetchLast':
	$response = array("task"=>$task,"arg"=>$arg);
	break;

	case 'fetchTerms':
	$response = (is_array(explode(',',$arg))) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'fetchRelatedTerms':
	$response = (is_array(explode(',',$arg))) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	case 'letter':
	$response = ((is_string($arg))&&(strlen($arg)==1)) ? array("task"=>$task,"arg"=>$arg) : array("error"=>"invalid input");
	break;

	default:
	$response =  array("task"=>$task,"arg"=>$arg) ;
	break;
}

return $response;
}





//////////////////*//////////////////////////*//////////////////////////*//////////////////////////*////////



//////////////////*//////////////////////////*//////////////////////////*//////////////////////////*////////

function array2xml($array, $name='vocabularyservices', $standalone=TRUE, $beginning=TRUE,$nodeChildName='term') {

	//GLOBAL $nested;
	//$nodeChildName='term';

	GLOBAL $CFG;

	$encode =($CFG["_CHAR_ENCODE"]=='latin1') ? "iso-8859-1" : "utf-8";

	if ($beginning) {
		if ($standalone) header("content-type:text/xml;$encode");
		$output .= '<'.'?'.'xml version="1.0" encoding="'.$encode.'"'.'?'.'>';

		$output .= '<' . $name . '>';
		$nested = 0;
	}
	foreach ($array as $root=>$child) {
		if (is_array($child)) {
			$output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $nodeChildName) . '>';
			$nested++;
			$output .= array2xml($child,NULL,NULL,FALSE);
			$nested--;
			$output .= str_repeat(" ", (2 * $nested)) . '  </' . (is_string($root) ? $root : $nodeChildName) . '>' ;
		}
		else {
			$output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $nodeChildName) . '><![CDATA[' . $child . ']]></' . (is_string($root) ? $root : $nodeChildName) . '>';
		}
	}

	if ($beginning) $output .= '</' . $name . '>';

	return $output;
}



//read from array 2 skos
function array2skos($array, $name='vocabularyservices') {

	//GLOBAL $nested;
	//$nodeChildName='term';

	foreach ($array as $node) {
		if (is_array($node)) {
			foreach ($node as $root=>$child) {
				if($child[term_id]>0)$nodos_skos .= do_nodo_skos($child[term_id]);
			}
		}
	}
	return do_skos($nodos_skos);
}


/*
* Basic evaluation of params
*/
function evalArg($type,$arg)
{

	switch ($type) {
		case 'string':
		$arg=(is_string($arg)) ? $arg : '';
		break;

		case 'int':
		$arg=secure_data($arg,"int");
		break;

		case 'array_int':
		$arg=string2array4ID($arg);
		break;

		default :
		$arg="";
		break;
	}

	return $arg;
}
?>
