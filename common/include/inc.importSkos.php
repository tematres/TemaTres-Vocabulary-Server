<?php
/**
 * Nicolas Poulain, http://tounoki.Org
 * and Diego Ferreyra
 * GNU/GPL - part of tematres
 * Based in scripts from http://ica-atom.org/
*/
// Be careful, access to this file is not protected
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");

/*
must be ADMIN
*/
if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1'){


//parser node 2 term
function addTerm($skos,$node)
{
	
/*
	fectch hidden label ID
*/
	$ARRAYhiddenLabelCode=ARRAYfetchValue("4","H");
	
	
   // Preferred label
    $prefLabels = $skos->xpath->query('./skos:prefLabel', $node);

    foreach ($prefLabels as $prefLabel)
    {
 
      $value = setI18nValue($skos,$prefLabel);

      if (isset($value))
      {
		  

	   // find URI
		$uri = $node->getAttributeNodeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'about');
		if ($uri instanceof DOMAttr)
		{
		  $source_uri = $uri->nodeValue;			  
		};  
			
	 
			
        $node_stringPreferedTerm = $value["value"];

        $node_stringPreferedTermLang = $value["lang"];

        //add term
        if($node_stringPreferedTermLang==$_SESSION["CFGIdioma"])
        {
			$ARRAYterm = ARRAYCode($source_uri);
			if ($ARRAYterm[tema_id])
			{
				$term_id = $ARRAYterm[tema_id];
			}
			else
			{
				$term_id=ALTAtema($node_stringPreferedTerm,"1","13");   	
			}
		}
		elseif(!$node_stringPreferedTermLang)
		{
/*
 * What to do if the term is not in the same language of the controlled vocabulary ???
*/
			$ARRAYterm = ARRAYCode($source_uri);
			if ($ARRAYterm[tema_id])
			{
				$term_id = $ARRAYterm[tema_id];
			}
			else
			{
				$term_id=ALTAtema($node_stringPreferedTerm,"1","13");   	
			}

		}
		
      }
    }

//This is a new term
if(!$ARRAYterm[tema_id])
{
	edit_single_code($term_id,$source_uri); 	

    // Alternate labels
    foreach ($skos->xpath->query('./skos:altLabel', $node) as $altLabel)
    {
      $value = setI18nValue($skos, $altLabel);
	
		//the same language
      if ((isset($value) && ($_SESSION["CFGIdioma"]==$value["lang"])))
      {
        $node_alt_term[] = $value;
        $alt_term_id=ALTAtema($value["value"],"1","13");
        ALTArelacionXId($alt_term_id,$term_id,"4");
      }
    }

    // Alternate hidden labels
    foreach ($skos->xpath->query('./skos:hiddenLabel', $node) as $altLabel)
    {
      $value = setI18nValue($skos, $altLabel);

		//the same language
      if ((isset($value) && ($_SESSION["CFGIdioma"]==$value["lang"])))
      {
        $node_alt_term[] = $value;
        $alt_term_id=ALTAtema($value["value"],"1","13");
        
       
        ALTArelacionXId($alt_term_id,$term_id,"4",$ARRAYhiddenLabelCode[value_id]);
      }
    }

    // Scope notes
    foreach ($skos->xpath->query('./skos:scopeNote', $node) as $scopeNote)
    {
      $value = setI18nValue($skos, $scopeNote);

      if ((isset($value["value"])) && (is_string($value["value"])))
      {
        $node_notes[] = $value;

        $lang_nota=($value["lang"]) ? $value["lang"]: $node_stringPreferedTermLang;

        ALTAnota($term_id,"NA",$lang_nota,$value["value"]); 
      }
    }

    // Definition notes
    foreach ($skos->xpath->query('./skos:definition', $node) as $defNote)
    {
      $value = setI18nValue($skos, $defNote);

      if (isset($value["value"]))
      {
        $node_defnotes[] = $value;

        $lang_nota=($value["lang"]) ? $value["lang"]: $node_stringPreferedTermLang;

        ALTAnota($term_id,"NA",$lang_nota,$value["value"]); 
      }
    }

    // changeNote 
    foreach ($skos->xpath->query('./skos:changeNote', $node) as $defNote)
    {
      $value = setI18nValue($skos, $defNote);

      if (isset($value["value"]))
      {
        $node_defnotes[] = $value;

        $lang_nota=($value["lang"]) ? $value["lang"]: $node_stringPreferedTermLang;

        ALTAnota($term_id,"NH",$lang_nota,$value["value"]); 
      }
    }



    //~ // exactMatch
    $sqlMatchTypes=SQLfetchValue('URI_TYPE');
    while($arrayMatchTypes=$sqlMatchTypes->FetchRow())
    {
			
		foreach ($skos->xpath->query("./skos:$arrayMatchTypes[value]", $node) as $matchNode)
		{
		// find URI
			$uri_match = $matchNode->getAttributeNodeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'resource');
			if ($uri_match instanceof DOMAttr)
			{
			  abmURI("A",$term_id,array("uri"=>$uri_match->nodeValue,"uri_type_id"=>$arrayMatchTypes[value_id]));  
			};  
				  
		}
	}
	
    // Find and add narrow terms
    // TODO: Merge broader/narrower relations for this term, as defining
    // inverse of relationship is not required by SKOS
    // http://www.w3.org/TR/2009/NOTE-skos-primer-20090818/#sechierarchy
    if ($uri instanceof DOMAttr)
    {

      foreach ($skos->xpath->query('./skos:Concept[skos:broader[@rdf:resource="'.$uri->nodeValue.'"]]') as $narrower)
      {
        if (!($narrower instanceof DOMElement))
        {
          continue;
        }

        $NT_term_id=addTerm($skos,$narrower);
        if($NT_term_id)
        {
			ALTArelacionXId($term_id,$NT_term_id,"3");
		}
      }    
    }

//end if new term
}

	return $term_id;
}


function addTermAssociations($skos)
{

foreach ($skos->xpath->query('skos:Concept[skos:related]') as $concept)
{
  $subjectUri = $concept->getAttributeNodeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'about');
/*
  $term_id = fetchTermIdxNote($subjectUri->nodeValue);
*/
  $ARRAYterm = ARRAYCode($subjectUri->nodeValue);
  $term_id = $ARRAYterm[tema_id];

  foreach ($skos->xpath->query('./skos:related', $concept) as $related)
  {
	$objectUri = $related->getAttributeNodeNS('http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'resource');
/*
	$RT_term_id = fetchTermIdxNote($objectUri->nodeValue);
*/
	$ARRAYterm = ARRAYCode($objectUri->nodeValue);
	$RT_term_id = $ARRAYterm[tema_id];
	
	if(($term_id) && ($RT_term_id))
			{
				//echo $subjectUri->nodeValue.':'.$uri->nodeValue.'<br>';
				ALTArelacionXId($term_id,$RT_term_id,'2');
			}
  }
}

return $this;
}




//extract string and land from node
function setI18nValue($obj, $domNode)
  {
    if (!($domNode instanceof DOMElement))
    {
      return;
    }

    switch (get_class($obj))
    {
      case 'QubitNote':
        $colName = 'content';
        break;

      default:
        $colName = 'name';
    }

    // Check for xml:lang attribute
    if (null !== $langNode = $domNode->attributes->getNamedItem('lang'))
    {
      $message = $domNode->nodeValue;
      $culture = $langNode->nodeValue;
    }

    else
    {
      $message = $domNode->nodeValue;
    }

return array("value"=>$message,
			 "lang"=>$culture);
  }




//create term
 function ALTAtema($string,$tesauro_id,$estado_id="13"){
	return abm_tema('alta',$string); 		
 	}



//create any relation between terms
function ALTArelacionXId($id_mayor,$id_menor,$t_relacion,$t_rel_rel_id="0")
{
	$t_rel_rel_id=($t_rel_rel_id>0) ? $t_rel_rel_id : 'NULL';
	return do_r($id_mayor,$id_menor,$t_relacion,$t_rel_rel_id);
}
 	





//create notes
function ALTAnota($tema_id,$tipo_nota,$lang_nota,$nota) 
{
 	return abmNota('A',$tema_id,$tipo_nota,$lang_nota,$nota);
}

/*
	FILE Process 
*/
	$error=array();

	if (($_POST['taskAdmin']=='importSkos') && (file_exists($_FILES["file"]["tmp_name"])) ) {

		$src_txt= $_FILES["file"]["tmp_name"];

		libxml_use_internal_errors(true); 

		$ok = '1';

		$dom = new DOMDocument;
		
		$dom->loadXML(file_get_contents($src_txt));

		$errors = libxml_get_errors();

		if (empty($errors))
		{
			$dom->load($src_txt);

		}
		else
		{
			$ok = '0' ;
			$error[] = "ERROR : No file to import :(" ;
		}
				
	}
	
	// start the procedure
	if ( $ok=='1' ) {

		$skos->xpath = new DOMXPath($dom);

		$iTerm=0;
		
		// Create Xpath object, register namespaces
		$skos->xpath->registerNamespace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
		$skos->xpath->registerNamespace('skos', 'http://www.w3.org/2004/02/skos/core#');
		$skos->xpath->registerNamespace('dc', 'http://purl.org/dc/elements/1.1/');

		foreach ($skos->xpath->query('skos:Concept[not(skos:broader)]') as $concept)
		{
				 if (!($concept instanceof domElement))
			  {
				continue;
			  }
			  

				$time_now = time();
				if ($time_start >= $time_now + 10) {
					$time_start = $time_now;
					header('X-pmaPing: Pong');
				};			  
			  
				addTerm($skos,$concept);
				$iTerm=++$iTerm;
		}

			//add Related terms
			addTermAssociations($skos);


			//recreate index
			$sql=SQLreCreateTermIndex();
			echo '<p class="true">'.ucfirst(IMPORT_finish).'</p>' ;			

	}

	else {
		foreach ($error as $e) {
			echo "<p>$e</p>" ;
		}
	}



	################# UPLOAD FORM ##########################

//end must be admin
};
?>
