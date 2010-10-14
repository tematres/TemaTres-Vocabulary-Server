<?php
/*
 *      vocabularyservices.php
 *      
 *      Copyright 2009 diego ferreyra <diego@r020.com.ar>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


/*
Funciones generales de parseo XML / General function for XML parser
*/

//Check XML
function loadXML($data) {
  $xml = @simplexml_load_string($data);
  if (!is_object($xml))
    //throw new Exception('Error reading XML',1001);
    die ("Error reading XML");    
  return $xml;
}

/*
Check tematres service provider
*/
function loadTemaTresServices($xml) {

 $status_services= $xml->xpath('//status');
 $status_services=(string)$status_services[0];
 
 if ($status_services!=='available')
     //throw new Exception('TemaTres Web Services not available',1003);
     die ("TemaTres Web Services not available");    
  
  return $xml;
}


function xml2arraySimple($str) {
	
	// is it an XML
	$xml = loadXML($str);

	// is it tematres XML
	$xml=loadTemaTresServices($xml);

	return simplexml2array($xml);
}


function simplexml2array($xml) {
/*
fix bug for php 5.04
*/
if(is_object($xml))
{
	if (get_class($xml) == 'SimpleXMLElement') {
		$attributes = $xml->attributes();
		foreach($attributes as $k=>$v) {
			if ($v) $a[$k] = (string) $v;
		}
		$x = $xml;
		$xml = get_object_vars($xml);
	}
}


	if (is_array($xml)) {
		if (count($xml) == 0) return (string) $x; // for CDATA
		foreach($xml as $key=>$value) {
			$r[$key] = simplexml2array($value);
		}
		if (isset($a)) $r['@'] = $a;// Attributes
		return $r;
	}
	return (string) $xml;
}




/*
Funciones de consulta de datos
*/


/*
Hacer una consulta y devolver un array
* $uri = url de servicios tematres
* +    & task = consulta a realizar
* +    & arg = argumentos de la consulta
*/
function xmlVocabulary2array($url){
	$url=$string = str_replace(' ','%',$url);
	$xml=file_get_contents($url) or die ("Could not open a feed called: " . $url);
	return xml2arraySimple($xml);
	}




/*
Recibe un array y lo publica como HTML
*/
function arrayVocabulary2html($array,$div_title,$tag_type){

	if($array["resume"]["cant_result"]>"0")	{

	$rows.='<h3>'.$div_title.'</h3><'.$tag_type.'>';
	
	foreach ($array["result"] as $key => $value){
				while (list( $k, $v ) = each( $value )){
					$i=++$i;
					//Controlar que no sea un resultado unico
					if(is_array($v)){
						$rows.='<li>';
						$rows.='<a href="'.$PHP_SELF.'?task=fetchTerm&amp;arg='.$v[term_id].'">'.utf8_decode($v[string]).'</a>';
						$rows.='</li>';
			
						} else {

							//controlar que sea la ultima
							if(count($value)==$i){
								$rows.='<li>';
								$rows.='<a href="'.$PHP_SELF.'?task=fetchTerm&amp;arg='.$value[term_id].'">'.utf8_decode($value[string]).'</a>';
								$rows.='</li>';
								}
						}
					}

		}		
	$rows.='</'.$tag_type.'>';
	}

return $rows;
	}





/*
Recibe notas array y lo publica como HTML
*/
function arrayVocabulary2htmlNotes($array){

	if($array["resume"]["cant_result"]>"0")	{

	$rows.='<dl>';

	foreach ($array["result"] as $key => $value){
				while (list( $k, $v ) = each( $value )){
					$i=++$i;
					//Controlar que no sea un resultado unico
					if(is_array($v)){
						$rows.='<dd>'.$v[note_type].' ('.$v[note_lang].')</dd>';
						$rows.='<dt>'.utf8_decode($v[note_text]).'</dt>';
			
						} else {

							//controlar que sea la ultima
							if(count($value)==$i){
							$rows.='<dd>'.$value[note_type].' ('.$value[note_lang].')</dd>';
							$rows.='<dt>'.utf8_decode($value[note_text]).'</dt>';
								}
						}
					}

		}		
	$rows.='</dl>';
	}

return $rows;
	}




/*
Recibe un array y lo publica como HTML
*/
function arrayVocabulary2htmlSearch($array,$div_title,$tag_type){
	
	$rows.='<h3>'.$div_title.' ('.$array["resume"]["cant_result"].')</h3><'.$tag_type.'>';
	
	if($array["resume"]["cant_result"]>"0")	{	
	foreach ($array["result"] as $key => $value){
				while (list( $k, $v ) = each( $value )){
					$i=++$i;
					//Controlar que no sea un resultado unico
					if(is_array($v)){
						$rows.='<li>';
						$rows.='<a href="'.$PHP_SELF.'?task=fetchTerm&amp;arg='.$v[term_id].'">'.utf8_decode($v[string]).'</a>';
						$rows.='</li>';
			
						} else {

							//controlar que sea la ultima
							if(count($value)==$i){
								$rows.='<li>';
								$rows.='<a href="'.$PHP_SELF.'?task=fetchTerm&amp;arg='.$value[term_id].'">'.utf8_decode($value[string]).'</a>';
								$rows.='</li>';
								}
						}
					}

		}		
	$rows.='</'.$tag_type.'>';
	}

return $rows;
	}


/*
datos HTML de un término
*/
function arrayTerm2html($array){

GLOBAL $URL_BASE;

$rows.='<h2>'.utf8_decode($array[result][term][string]).'</h2>';


/*
Notas // notes
*/
	$arrayNotes=xmlVocabulary2array($URL_BASE.'?task=fetchNotes&arg='.$array[result][term][tema_id]);
	$rows.=arrayVocabulary2htmlNotes($arrayNotes,"Notes","ul");


/*
Buscar términos genericos // fetch broader terms
*/
	$arrayTG=xmlVocabulary2array($URL_BASE.'?task=fetchUp&arg='.$array[result][term][tema_id]);
	$rows.=arrayVocabulary2html($arrayTG,"Broader terms","ol");


/*
Buscar términos específicos // fetch narrow terms
*/
	$arrayTE=xmlVocabulary2array($URL_BASE.'?task=fetchDown&arg='.$array[result][term][tema_id]);
	
	$rows.=arrayVocabulary2html($arrayTE,"Narrower terms","ul");

/*
Buscar términos relacionados // fetch related terms
*/
	$arrayTR=xmlVocabulary2array($URL_BASE.'?task=fetchRelated&arg='.$array[result][term][tema_id]);
	$rows.=arrayVocabulary2html($arrayTR,"Related terms","ul");

	return $rows;
	}


?>
