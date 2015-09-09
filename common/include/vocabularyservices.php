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
Hacer una consulta y devolver un objeto
* $uri = url de servicios tematres
* +    & task = consulta a realizar
* +    & arg = argumentos de la consulta
*/
function getURLdata($url,$debug=0){


  if (extension_loaded('curl'))
  {
    $rCURL = curl_init();
    curl_setopt($rCURL, CURLOPT_URL, $url);
    curl_setopt($rCURL, CURLOPT_HEADER, 0);
    curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
    $xml = curl_exec($rCURL) or die ("Could not open a feed called: " . $url);
    curl_close($rCURL);

  }
  else
  {
    $xml=file_get_contents($url) or die ("Could not open a feed called: " . $url);
  }

  $content = new SimpleXMLElement($xml);



  if($debug==1)
  {
    echo $url;
    var_dump($xml);
  }


  return $content;
}


//Create one array from many terms references by one relation (eg: uf,BT)
function getForeingStrings($tvocab_uri_service,$task,$array_terms){

  $arrayTtermData = array();

  if(!in_array($task, array('fetchAlt','fetchDown','fetchRelated','fetchTerms'))) return array();

  if(count($array_terms)<1) return array();


  foreach ($array_terms as $term){

    $dataTerm=getURLdata($tvocab_uri_service.'?task='.$task.'&arg='.$term["term_id"]);

    if($dataTerm->resume->cant_result > "0")	{
      foreach ($dataTerm->result->term as $value){

        $i=++$i;
        $term_id=(int) $value->term_id;
        $string=(string) $value->string;
        $arrayTtermData[$term_id]=array("term_id"=>$term_id,
        "string"=>$string,
        "source_string"=>$term["string"],
        "source_term_id"=>$term["term_id"]
      );
    };
  }
}
return $arrayTtermData;
}


//Create one array from object references by one relation (eg: terms,related)
function getForeingStringsObject($dataTterm){

  $arrayTtermData = array();

  if(count($array_term_id)<1) return array();

  if((int) $dataTterm->resume->cant_result < 1) return array();

  foreach ($dataTterm->result->term as $value){

    $i=++$i;
    $term_id=(int) $value->term_id;
    $string=(string) $value->string;
    $arrayTtermData[$term_id]=array("term_id"=>$term_id,
    "string"=>$string
  );
};

return $arrayTtermData;
}

?>
