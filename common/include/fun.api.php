<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Abstraccion de funciones de consulta
#


class XMLvocabularyServices {

// Devuelve array de temas relacionados
// array (tema_id, tema,t_relacion_id)
function fetchRelatedTerms($tema_id){

	$sql=SQLverTerminoRelaciones($tema_id);

	while($array=mysqli_fetch_array($sql[datos])){
	if($array[t_relacion]=='2'){
		$result["result"][$array[id]]= array(
					"term_id"=>$array[id],
					"string"=>$array[tema],
					"relation_type_id"=>$array[t_relacion]
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

	while($array=mysqli_fetch_array($sql[datos])){
	if($array[t_relacion]=='4'){
		$result["result"][$array[id]]= array(
					"term_id"=>$array[id],
					"string"=>$array[tema],
					"relation_type_id"=>$array[t_relacion]
					);
		};
	}
	return $result;
	}

// Devuelve array de términos UF,TR y TG directos
// array with non prefered (UF),related and direct TG terms for tema_id
// array (tema_id, string,t_relacion_id)
function fetchDirectTerms($tema_id){

	$sql=SQLterminosDirectos($tema_id);

	while($array=mysqli_fetch_array($sql[datos])){
		$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema],
					"relation_type_id"=>$array[t_relacion]
					);
		}
	return $result;
	}

// Devuelve lista de temas especificos
// array (tema_id, tema,t_relacion_id, hasMoreDown)
function fetchTermDown($tema_id){

	$sql=SQLverTerminosE($tema_id);

	while($array=mysqli_fetch_array($sql[datos])){
		$result["result"][$array[id_tema]]= array(
					"term_id"=>$array[id_tema],
					"string"=>$array[tema],
					"relation_type_id"=>$array[t_relacion],
					"hasMoreDown" => ($array[id_te]) ? 1 : 0
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
if($sql[cant]>'0'){
	while($array=mysqli_fetch_array($sql[datos])){
		$i=++$i;
		$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema],
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

	$result[tema_id]=$array[idTema];
	$result[string]=$array[titTema];
	$result[hasMoreUp]=$array[supraTema];
	$result[term_type]=$array[tipoTema];
	$result[date_create]=$array[cuando];
	$result[date_mod]=$array[cuando_final];
	$result[numNotes]=count($array["notas"]);
	return $result;
	}


// Devuelve detalles de un tema
// array(tema_id,string)
function fetchTermDetailsBrief($tema_id){

	$array=ARRAYverTerminoBasico($tema_id);

	if(is_array($array)){
		$result["result"]["term"][tema_id]=$array[idTema];
		$result["result"]["term"][string]=$array[titTema];
		$result["result"]["term"][date_create]=$array[cuando];
		$result["result"]["term"][date_mod] = ($array[cuando_final]) ?  $array[cuando_final] : $array[cuando];
		}
	return $result;
	}



// Devuelve notas de un tema
// array(tema_id,string,note_id,note_type,note_lang,note_text)
function fetchTermNotes($tema_id){
	$sql=SQLdatosTerminoNotas($tema_id);

	while($array=mysqli_fetch_array($sql[datos])){
		$i=++$i;
		$result["result"][$array[nota_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema],
					"note_id"=>$array[nota_id],
					"note_type"=>$array[tipo_nota],
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

	while($array=mysqli_fetch_array($sql[datos])){
		$result["result"][$array[id]]= array(
					"term_id"=>$array[id],
					"string"=>FixEncoding2($array[tema])
					);
		};
	return $result;
	}



// Devuelve lista de términos para una lista separada por comas de tema_id 
// array(tema_id,string)
function fetchTermsByIds($tema_id_list){

	$sql=SQLlistaTema_id($tema_id_list);

	while($array=mysqli_fetch_array($sql[datos])){
		$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema]
					);
		};
	return $result;
	}



// Devuelve lista de términos relacionados para una lista separada por comas de tema_id
// array(tema_id,string)
function fetchRelatedTermsByIds($tema_id_list){

	$sql=SQLexpansionTR($tema_id_list);

	while($array=mysqli_fetch_array($sql[datos])){
		$result["result"][$array[tema_id]]= array(
					"term_id"=>$array[tema_id],
					"string"=>$array[tema]
					);
		};
	return $result;
	}

// Array de términos que comienzan con una letra
// array(tema_id,string,no_term_string,relation_type_id)
function fetchTermsByLetter($letter){

	$sql=SQLmenuABC($letter);

	while($array=mysqli_fetch_array($sql[datos])){
		$i=++$i;
		$result["result"][$array[id_definitivo]]= array(
					"term_id"=>$array[id_definitivo],
					"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
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

while($array=mysqli_fetch_array($sql[datos])){
	$i=++$i;
	$arrayIndex=explode('|',$array[indice]);
	$result["result"][$array[id_definitivo]]= array(
				"term_id"=>$array[id_definitivo],
				"string"=>($array[termino_preferido]) ? $array[termino_preferido] : $array[tema],
				"no_term_string"=>($array[termino_preferido]) ? $array[tema] : FALSE ,
/*
				"relation_type_id"=>$array[t_relacion],
*/
// 				"index"=> (count($arrayIndex)>'1') ? $arrayIndex: array() ,
				"index"=>$array[indice],
				"order" => $i
				);
	};
return $result;
}


// Devuelve detalles del vocabularios
//array(vocabulario_id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base,polijerarquia)
function fetchVocabularyData($vocabulary_id){

	$sql=SQLdatosVocabulario($vocabulary_id);
	$array=mysqli_fetch_array($sql[datos]);
		$arrayResponse["result"][vocabulary_id]	=$array[vocabulario_id];
		$arrayResponse["result"][title]		=$array[titulo];
		$arrayResponse["result"][author]		=$array[autor];
		$arrayResponse["result"][lang]		=$array[idioma];
		$arrayResponse["result"][scope]		=$array[cobertura];
		$arrayResponse["result"][keywords]	=$array[keywords];
		$arrayResponse["result"][uri]		=$array[url_base];

	return $arrayResponse;
	}

//Devuelve un término con cadena similar para una una cadena de búsqueda
//array($tema_id,$tema)
function fetchSimilar($string) 
{
	$sqlSimilar=SQLsimiliar($string);

	if($sqlSimilar[cant])
	{
		while($arraySimilar=mysqli_fetch_array($sqlSimilar[datos]))
			{
			$listaCandidatos.= $arraySimilar[tema].'|';
			}

		$listaCandidatos=explode("|",$listaCandidatos);
		$similar = new Qi_Util_Similar($listaCandidatos, $string);
		$sugerencia= $similar->sugestao();
	}
	
	if ($sugerencia) 
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
function describeService(){

	GLOBAL $CFG;

	$array['status'] = (CFG_SIMPLE_WEB_SERVICE=='1') ? 'available' : 'disable';

	$array['param'] = array("task","arg","output");
	
	$array['param']['task'] = "Action to do";
	$array['param']['arg'] = "arguments for task action (eg: string for search task, numerical id for specific term data)";
	$array['param']['output'] = "Output format, can be JSON or XML. Optional parameter, XML by default ";
	

	$array['web_service_version'] = $CFG["VersionWebService"];

	$array['version'] = $CFG["Version"];

	$array['fetchRelated']['action'] = ' Retrieve related terms for one ID ';
	$array['fetchRelated']['task'] = 'fetchRelated';
	$array['fetchRelated']['arg'] = 'one ID (int)';
	$array['fetchRelated']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchRelated&arg=1';

	$array['fetchRelated']['action'] = ' Retrieve alternative/non prefered terms for one ID ';
	$array['fetchRelated']['task'] = 'fetchAlt';
	$array['fetchRelated']['arg'] = 'one ID (int)';
	$array['fetchRelated']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchAlt&arg=1';


	$array['fetchDown']['action'] = ' Retrieve more specific terms for one ID ';
	$array['fetchDown']['task'] = 'fetchDown';
	$array['fetchDown']['arg'] = 'one ID (int)';
	$array['fetchDown']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchDown&arg=1';

	$array['fetchUp']['action'] = ' Retrieve hierarquical structure for one ID ';
	$array['fetchUp']['task'] = 'fetchUp';
	$array['fetchUp']['arg'] = 'one ID (int)';
	$array['fetchUp']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchUp&arg=1';

	$array['fetchTerm']['action'] = ' Retrieve simple term data ';
	$array['fetchTerm']['task'] = 'fetchTerm';
	$array['fetchTerm']['arg'] = 'one ID (int)';
	$array['fetchTerm']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchTerm&arg=1';

	$array['fetchNotes']['action'] = ' Retrieve notes for one term ';
	$array['fetchNotes']['task'] = 'fetchNotes';
	$array['fetchNotes']['arg'] = 'one ID (int)';
	$array['fetchNotes']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchNotes&arg=1';

	$array['fetchDirectTerms']['action'] = ' Retrieve alternative, related and direct hieraquical terms for one term_id ';
	$array['fetchDirectTerms']['task'] = 'fetchDirectTerms';
	$array['fetchDirectTerms']['arg'] = 'one ID (int)';
	$array['fetchDirectTerms']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchDirectTerms&arg=1';


	$array['fetchTopTerms']['action'] = ' Retrieve vocabulary top terms';
	$array['fetchTopTerms']['task'] = 'fetchTopTerms';
	$array['fetchTopTerms']['arg'] = ' none';
	$array['fetchTopTerms']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchTopTerms';

	$array['fetchTerms']['action'] = ' Retrieve simple term data for some coma separated IDs (example: 3,6,98) ';
	$array['fetchTerms']['task'] = 'fetchTerms';
	$array['fetchTerms']['arg'] = 'some coma separated IDs (for example: arg=3,6,98)';
	$array['fetchTerms']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchTerms&arg=1,2,4';

	$array['fetchRelatedTerms']['action'] = ' Retrieve simple related term data for some coma separated terms IDs (example: 3,6,98) ';
	$array['fetchRelatedTerms']['task'] = 'fetchRelatedTerms';
	$array['fetchRelatedTerms']['arg'] = 'some coma separated IDs (for example: arg=3,6,98)';
	$array['fetchRelatedTerms']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchRelatedTerms&arg=1,4';

	$array['letter']['action'] = 'Search and retrieve terms was beginning with letter $arg';
	$array['letter']['task'] = 'letter';
	$array['letter']['arg'] = 'one letter (for example: arg=a)';
	$array['letter']['example'] = $_SESSION["CFGURL"].'/services.php?task=letter&arg=a';

	$array['search']['action'] = 'Search and retrieve terms';
	$array['search']['task'] = 'search';
	$array['search']['arg'] = 'search expresion (string)';
	$array['search']['example'] = $_SESSION["CFGURL"].'/services.php?task=search&arg=peace';

	$array['fetchSimilar']['action'] = 'Search and retrieve similar term for string search expresion ($arg)';
	$array['fetchSimilar']['task'] = 'fetchSimilar';
	$array['fetchSimilar']['arg'] = 'string (for example: arg=trrends)';
	$array['fetchSimilar']['example'] = $_SESSION["CFGURL"].'/services.php?task=letter&arg=a';

	$array['fetchVocabularyData']['action'] = 'Retrieve data about vocabulary';
	$array['fetchVocabularyData']['task'] = 'fetchVocabularyData ';
	$array['fetchVocabularyData']['arg'] = '1';
	$array['fetchVocabularyData']['example'] = $_SESSION["CFGURL"].'/services.php?task=fetchVocabularyData';

	return $array;
	}


// fin de la clase
}


#######################################################################



function fetchVocabularyService($task,$arg,$output="xml")
{

$evalParam=evalServiceParam($task,$arg);

/*
Prevents SQL injection
*/
$arg=secure_data($arg,"sql");

//Verificar servicio habilitado
if(CFG_SIMPLE_WEB_SERVICE !== "1"){
	$service=new XMLvocabularyServices();
	return array2xml($service-> describeService());

// Controlar parametros

	} elseif(is_array(evalServiceParam($task,$arg))) {
	
	return array2xml($evalParam);

// Los param esta bien
	}else{

	$service=new XMLvocabularyServices();
	switch($_GET[task]){
		//array
		case 'search':
		$response = $service-> fetchTermsBySearch($arg);
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

		case 'letter':
		// Array de términos que comienzan con una letra
		// array(tema_id,string,no_term_string,relation_type_id)
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


	if ($output == 'json') 
	{
		return array2json($response,'vocabularyservices');
	}
	else 
	{
		return array2xml($response,'vocabularyservices');
	}
	
	
	
	}
}

function evalServiceParam($task,$arg)
{
	
switch($task){
	case 'search':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? TRUE : array("error"=>"invalid input");
	break;
	
	case 'similarTerm':
	$response = ((is_string($arg))&&(strlen($arg)>=CFG_MIN_SEARCH_SIZE)) ? TRUE : array("error"=>"invalid input");
	break;
	

	case 'fetchRelated':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchAlt':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchDown':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;


	case 'fetchUp':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchTermFull':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchTerm':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchDirectTerms':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchNotes':
	$response = (is_numeric($arg)) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchTopTerms':
	$response = TRUE;
	break;

	case 'fetchTerms':
	$response = (is_array(explode(',',$arg))) ? TRUE : array("error"=>"invalid input");
	break;

	case 'fetchRelatedTerms':
	$response = (is_array(explode(',',$arg))) ? TRUE : array("error"=>"invalid input");
	break;

	case 'letter':
	$response = ((is_string($arg))&&(strlen($arg)==1)) ? TRUE : array("error"=>"invalid input");
 	break;

	default:
	$response =  TRUE ;
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




/*
* Function from http://www.bin-co.com/php/scripts/array2json/
* 
*/

function array2json(array $arr)
{
if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
$parts = array();
$is_list = false;

if (count($arr)>0){
//Find out if the given array is a numerical array
$keys = array_keys($arr);
$max_length = count($arr)-1;
if(($keys[0] === 0) and ($keys[$max_length] === $max_length)) {//See if the first key is 0 and last key is length - 1
$is_list = true;
for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
if($i !== $keys[$i]) { //A key fails at position check.
$is_list = false; //It is an associative array.
break;
}
}
}

foreach($arr as $key=>$value) {
$str = ( !$is_list ? '"' . $key . '":' : '' );
if(is_array($value)) { //Custom handling for arrays
$parts[] = $str . array2json($value);
} else {
//Custom handling for multiple data types
if (is_numeric($value) && !is_string($value)){
$str .= $value; //Numbers
} elseif(is_bool($value)) {
$str .= ( $value ? 'true' : 'false' );
} elseif( $value === null ) {
$str .= 'null';
} else {
$str .= '"' . addslashes($value) . '"'; //All other things
}
$parts[] = $str;
}
}
}
$json = implode(',',$parts);

if($is_list) return '[' . $json . ']';//Return numerical JSON
return '{' . $json . '}';//Return associative JSON
}

?>
