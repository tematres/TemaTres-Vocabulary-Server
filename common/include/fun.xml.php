<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# funciones XML #


#######################################################################


define(XTMheader,'<topicMap xmlns="http://www.topicmaps.org/xtm/1.0/" xmlns:xlink="http://www.w3.org/1999/xlink">
<topic id="term">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#term"/>
</subjectIdentity>
<baseName>
<baseNameString>Term</baseNameString>
</baseName>
</topic>
<topic id="broader-narrower">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#broader-narrower"/>
</subjectIdentity>
<baseName>
<baseNameString>Broader Term-Narrower Term</baseNameString>
</baseName>
<baseName>
<scope>
<topicRef xlink:href="#broader"/>
</scope>
<baseNameString>Specialisations</baseNameString>
</baseName>
<baseName>
<scope>
<topicRef xlink:href="#narrower"/>
</scope>
<baseNameString>Generalisation</baseNameString>
</baseName>
</topic>
<topic id="broader">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#broader"/>
</subjectIdentity>
<baseName>
<baseNameString>Broader</baseNameString>
</baseName>
</topic>
<topic id="narrower">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#narrower"/>
</subjectIdentity>
<baseName>
<baseNameString>Narrower</baseNameString>
</baseName>
</topic>
<topic id="related-terms">
<baseName>
<baseNameString>Related Terms</baseNameString>
</baseName>
</topic>
<topic id="related-term">
<baseName>
<baseNameString>Related Term</baseNameString>
</baseName>
</topic>
<topic id="synonym">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#synonym"/>
</subjectIdentity>
<baseName>
<baseNameString>Synonym</baseNameString>
</baseName>
</topic>
<topic id="preferred-term">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#preferred-term"/>
</subjectIdentity>
<baseName>
<baseNameString>Preferred Term</baseNameString>
</baseName>
</topic>
<topic id="non-preferred-term">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#non-preferred-term"/>
</subjectIdentity>
<baseName>
<baseNameString>Non-Preferred Term</baseNameString>
</baseName>
</topic>
<topic id="scope-note">
<subjectIdentity>
<subjectIndicatorRef
xlink:href="http://www.techquila.com/psi/thesaurus/#scope-note"/>
</subjectIdentity>
<baseName>
<baseNameString>Scope Note</baseNameString>
</baseName>
</topic>');

#
# Armado de salida ZTHES
#
function do_zthes($nodos_zthes){


	GLOBAL $CFG;

	header ('content-type: text/xml');

	$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$meta_tag.='<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/schema/zthes-1.0.dtd">';
	$meta_tag.='  <Zthes>';
	$meta_tag.=''.$nodos_zthes;
	$meta_tag.='  </Zthes>';

	return  $meta_tag;
};

function do_nodo_zthes($idTema){
	$datosTermino=ARRAYverDatosTermino($idTema);
	$SQLTerminosE=SQLverTerminosE($idTema);
	$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($idTema);

	while ($datosTerminosE=$SQLTerminosE->FetchRow()){
		$zthes_narrower.='<relation>';
		$zthes_narrower.='<relationType>NT</relationType>';
		$zthes_narrower.='<termId>'.$datosTerminosE["id_tema"].'</termId>';
		$zthes_narrower.='<termName>'.xmlentities($datosTerminosE["tema"]).'</termName>';
		$zthes_narrower.='<termType>PT</termType>';
		$zthes_narrower.='</relation>';
	};


	while ($datosTerminosRelacionados= $SQLTerminosRelacionados->FetchRow()){

		if($datosTerminosRelacionados[t_relacion]=='3'){// TG
			$zthes_broader.='<relation>';
			$zthes_broader.='<relationType>BT</relationType>';
			$zthes_broader.='<termId>'.$datosTerminosRelacionados[id_tema].'</termId>';
			$zthes_broader.='<termName>'.xmlentities($datosTerminosRelacionados[tema]).'</termName>';
			$zthes_broader.='<termType>'.$datosTerminosRelacionados[tipo_termino].'</termType>';
			$zthes_broader.='</relation>';
		};

		if($datosTerminosRelacionados["t_relacion"]=='4'){// UF
			$zthes_UF.='<relation>';
			$zthes_UF.='<relationType>UF</relationType>';
			$zthes_UF.='<termId>'.$datosTerminosRelacionados["id_tema"].'</termId>';
			$zthes_UF.='<termName>'.xmlentities($datosTerminosRelacionados["tema"]).'</termName>';
			$zthes_UF.='<termType>ND</termType>';
			$zthes_UF.='</relation>';
		};

		if($datosTerminosRelacionados["t_relacion"]=='2'){// TR
			$zthes_related.='<relation>';
			$zthes_related.='<relationType>RT</relationType>';
			$zthes_related.='<termId>'.$datosTerminosRelacionados["id_tema"].'</termId>';
			$zthes_related.='<termName>'.xmlentities($datosTerminosRelacionados["tema"]).'</termName>';
			$zthes_related.='<termType>'.$datosTerminosRelacionados["tipo_termino"].'</termType>';
			$zthes_related.='</relation>';
		};

	};

	$meta_tag.='<term>';
	$meta_tag.='<termId>'.$datosTermino["idTema"].'</termId>';
	$meta_tag.='<termName>'.xmlentities($datosTermino["titTema"]).'</termName>';
	$meta_tag.='<termType>'.$datosTermino["tipoTema"].'</termType>';

	$meta_tag.='<termLanguage>'.$datosTermino["idioma"].'</termLanguage>';
	$meta_tag.='<termVocabulary>'.xmlentities($_SESSION["CFGTitulo"]).'</termVocabulary>';
	$meta_tag.='	<termStatus>active</termStatus>';
	$meta_tag.='	<termApproval>'.arrayReplace(array('12','13','14'),array('candidate','approved','rejected'),$datosTermino["estado_id"]).'</termApproval>';


	if($datosTermino["isMetaTerm"]!=='1') $meta_tag.='	<termSortkey>'.xmlentities($datosTermino["titTema"]).'</termSortkey>';

	for($iNota=0; $iNota<(count($datosTermino["notas"])); ++$iNota){
		if($datosTermino[notas][$iNota][id]){
			switch($datosTermino["notas"][$iNota]["tipoNota"]){
				case 'NP':
				//nothing
				break;

				case 'NA':
				$meta_tag.='<termNote label="Scope">'.xmlentities($datosTermino["notas"][$iNota]["nota"],true).'</termNote>';
				break;

				case 'NH':
				$meta_tag.='<termNote label="History">'.xmlentities($datosTermino["notas"][$iNota]["nota"],true).'</termNote>';
				break;

				case 'NB':
				$meta_tag.='<termNote label="Source">'.xmlentities($datosTermino["notas"][$iNota]["nota"],true).'</termNote>';
				break;

				case 'DF':
				$meta_tag.='<termNote label="Definition">'.xmlentities($datosTermino["notas"][$iNota]["nota"],true).'</termNote>';
				break;

				default:
				$meta_tag.='<termNote label="'.xmlentities($datosTermino["notas"][$iNota]["tipoNotaLabel"]).'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</termNote>';
				break;
			}
		};
	};

	$meta_tag.='<termCreatedDate>'.xmlentities($datosTermino["titTema"]).'</termCreatedDate>';

	if(@$datosTermino["cuando_final"]>$datosTermino["cuando"]){
		$meta_tag.='<termModifiedDate>'.$datosTermino["cuando_final"].'</termModifiedDate>';
		}


	$meta_tag.=$zthes_UF;
	$meta_tag.=$zthes_broader;
	$meta_tag.=$zthes_narrower;
	$meta_tag.=$zthes_related;
	$meta_tag.='</term>';

	return  $meta_tag;
};

###############################################################################################################################

#
# Armado de salida XML glossary Moodle
#
function do_moodle($moodle_nodes){


	GLOBAL $CFG;

	header ('content-type: text/xml');
	$output='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$output.='<GLOSSARY>';
	$output.='  <INFO>';
	$output.='    <NAME>'.xmlentities($_SESSION["CFGTitulo"]).'</NAME>';
	$output.='    <INTRO>'.xmlentities($_SESSION["CFGCobertura"],true).'</INTRO>';
	$output.='    <ALLOWDUPLICATEDENTRIES>0</ALLOWDUPLICATEDENTRIES>';
	$output.='    <DISPLAYFORMAT>dictionary</DISPLAYFORMAT>';
	$output.='    <SHOWSPECIAL>1</SHOWSPECIAL>';
	$output.='    <SHOWALPHABET>1</SHOWALPHABET>';
	$output.='    <SHOWALL>1</SHOWALL>';
	$output.='    <ALLOWCOMMENTS>0</ALLOWCOMMENTS>';
	$output.='    <USEDYNALINK>0</USEDYNALINK>';
	$output.='    <DEFAULTAPPROVAL>1</DEFAULTAPPROVAL>';
	$output.='    <GLOBALGLOSSARY>0</GLOBALGLOSSARY>';
	$output.='    <ENTBYPAGE>10</ENTBYPAGE>';
	$output.='    <ENTRIES>';

	$output.=$moodle_nodes;

	$output.='    </ENTRIES>';
	$output.='  </INFO>';
	$output.='</GLOSSARY>';

	return  $output;
};

function do_nodo_moodle($tema_id){

	$datosTermino=ARRAYverDatosTermino($tema_id);
	$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($tema_id);

	$output.='    	<ENTRY>';
	$output.='    		<CONCEPT>'.xmlentities($datosTermino["titTema"]).'</CONCEPT>';
	$output.='    		<FORMAT>1</FORMAT><USEDYNALINK>0</USEDYNALINK><CASESENSITIVE>0</CASESENSITIVE><FULLMATCH>0</FULLMATCH><TEACHERENTRY>1</TEACHERENTRY>';

	for($iNota=0; $iNota<(count($datosTermino["notas"])); ++$iNota){
		if($datosTermino["notas"][$iNota]["id"]){
			switch($datosTermino["notas"][$iNota]["tipoNota"]){
				case 'NA':
				$output.='<DEFINITION>'.xmlentities($datosTermino["notas"][$iNota]["nota"],true).'</DEFINITION>';
				break;
			}
		};
	};


	while ($datosTerminosRelacionados= $SQLTerminosRelacionados->FetchRow()){

		if($datosTerminosRelacionados["t_relacion"]=='4'){// UF
			$i_UF=++$i_UF;
			$tag_UF.='<ALIAS><NAME>'.xmlentities($datosTerminosRelacionados["tema"]).'</NAME></ALIAS>';
		};
	};

	if($i_UF>0){
		$output.='    		<ALIASES>';
		$output.=$tag_UF;
		$output.='    		</ALIASES>';
	}


	$output.='    	</ENTRY>';

	return  $output;
};



#
# FUNCION PARA ARMAR RDF SKOS
#
function do_skos($nodos_skos,$top_terms="false"){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$ARRAYfetchValues=ARRAYfetchValues('METADATA');

	/*
	Tomar URL por default
	*  Para que utilice URLs navegables:
	*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
	* Para que utilice URLs Skos core
	*/
	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';

	if ($top_terms=='true')
	{
		# Top term del esquema
		$sqlTT=SQLverTopTerm();

		while ($arrayTT=$sqlTT->FetchRow()){
			$skos_TT.='<skos:hasTopConcept rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$arrayTT[id].'"/>';
		};

	};//fin top terms
	header ('content-type: text/xml');
	$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$meta_tag.='<rdf:RDF';
	$meta_tag.='  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
	$meta_tag.='  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"';
	$meta_tag.='  xmlns:skos="http://www.w3.org/2004/02/skos/core#"';
	$meta_tag.='  xmlns:map="http://www.w3c.rl.ac.uk/2003/11/21-skos-mapping#"';
	$meta_tag.='  xmlns:dct="http://purl.org/dc/terms/"';
	$meta_tag.='  xmlns:dc="http://purl.org/dc/elements/1.1/">';

	$meta_tag.='<skos:ConceptScheme rdf:about="'.$_URI_BASE_ID.'">';

	$meta_tag.='  <dc:title>'.xmlentities($_SESSION[CFGTitulo]).'</dc:title>';
	$meta_tag.='  <dc:creator>'.xmlentities($_SESSION[CFGAutor]).'</dc:creator>';
	$meta_tag.='  <dc:contributor>'.xmlentities($ARRAYfetchValues["dc:contributor"]["value"]).'</dc:contributor>';
	$meta_tag.='  <dc:publisher>'.xmlentities($ARRAYfetchValues["dc:publisher"]["value"]).'</dc:publisher>';
	$meta_tag.='  <dc:rights>'.xmlentities($ARRAYfetchValues["dc:rights"]["value"]).'</dc:rights>';
	$meta_tag.='  <dc:subject>'.xmlentities($_SESSION[CFGKeywords]).'</dc:subject>';
	$meta_tag.='  <dc:description>'.xmlentities($_SESSION[CFGCobertura],true).'</dc:description>';
	$meta_tag.='  <dc:date>'.xmlentities($_SESSION[CFGCreacion]).'</dc:date>';
	$meta_tag.='  <dct:modified>'.fetchlastMod().'</dct:modified>';
	$meta_tag.='  <dc:language>'.$_SESSION["CFGIdioma"].'</dc:language>';

	//lista de Top terms
	$meta_tag.='  '.$skos_TT;
	$meta_tag.='</skos:ConceptScheme>';

	$meta_tag.=$nodos_skos;

	$meta_tag.='</rdf:RDF>';

	return $meta_tag;
};

#
# FUNCION PARA ARMAR RDF NODO SKOS
# Make SKOS-Core nodes only with node data and conceptScheme reference
#
function do_skosNode($nodos_skos,$top_terms="false"){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$ARRAYfetchValues=ARRAYfetchValues('METADATA');

	/*
	Tomar URL por default
	*  Para que utilice URLs navegables:
	*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
	* Para que utilice URLs Skos core
	*/
	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';


	header ('content-type: text/xml');
	$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$meta_tag.='<rdf:RDF';
	$meta_tag.='  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
	$meta_tag.='  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"';
	$meta_tag.='  xmlns:skos="http://www.w3.org/2004/02/skos/core#"';
	$meta_tag.='  xmlns:map="http://www.w3c.rl.ac.uk/2003/11/21-skos-mapping#"';
	$meta_tag.='  xmlns:dct="http://purl.org/dc/terms/"';
	$meta_tag.='  xmlns:dc="http://purl.org/dc/elements/1.1/">';

	$meta_tag.='<skos:ConceptScheme rdf:about="'.$_URI_BASE_ID.'">';
	$meta_tag.='</skos:ConceptScheme>';

	$meta_tag.=$nodos_skos;

	$meta_tag.='</rdf:RDF>';

	return $meta_tag;
};

#
# Arma nodos Skos
#
function do_nodo_skos($idTema){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	/*
	Tomar URL por default
	*  Para que utilice URLs navegables:
	*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
	* Para que utilice URLs Skos core
	*/
	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';


	$datosTermino=ARRAYverDatosTermino($idTema);

	$SQLTerminosE=SQLverTerminosE($idTema);
	while ($datosTerminosE=$SQLTerminosE->FetchRow()){
		$skos_narrower.='<skos:narrower rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosE[id_tema].'"/>';
	};

	$SQLterminosRelacionados=SQLverTerminoRelaciones($idTema);

	while ($datosTerminosRelacionados= $SQLterminosRelacionados->FetchRow()){
		if($datosTerminosRelacionados["t_relacion"]=='2'){// TR
			$skos_related.='<skos:related rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id].'"/>';
		};

		if($datosTerminosRelacionados["t_relacion"]=='3'){// TG
			$skos_broader.='<skos:broader rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id].'"/>';
		};

		if($datosTerminosRelacionados["t_relacion"]=='4'){// UF

			//HiddenLabel
			if(in_array($datosTerminosRelacionados["rr_code"],$CFG["HIDDEN_EQ"]))
			{
				$skos_altLabel.='<skos:hiddenLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTerminosRelacionados[tema]).'</skos:hiddenLabel>';
			}
			else
			{
				$skos_altLabel.='<skos:altLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTerminosRelacionados[tema]).'</skos:altLabel>';

			}

		};

		//terms with internal mapping
		if(in_array($datosTerminosRelacionados["t_relacion"], array(5,6)))
		{

			$map_label=arrayReplace(array(5,6), array("partial","exact"),$datosTerminosRelacionados["t_relacion"]);

			$skos_map.='<skos:'.$map_label.'Match>';
			$skos_map.=' <skos:Concept rdf:about="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados["tema_id"].'">';
			$skos_map.=' <skos:prefLabel xml:lang="'.$datosTerminosRelacionados["idioma"].'">'.$datosTerminosRelacionados["tema"].'</skos:prefLabel>';
			$skos_map.=' </skos:Concept>';
			$skos_map.='</skos:'.$map_label.'Match>';

		}
	};


	$SQLtargetTerms=SQLtargetTerms($idTema);
	while ($datosTargetTerms=$SQLtargetTerms->FetchRow()){

		$map_label=(in_array(strtolower($datosTargetTerms[tvocab_tag]), array('exact','close','related','partial','broad','narrow'))) ? strtolower($datosTargetTerms[tvocab_tag]) : 'exact';

		$skos_map.='<skos:'.$map_label.'Match>';
		$skos_map.=' <skos:Concept rdf:about="'.$datosTargetTerms[tterm_url].'">';
		$skos_map.=' <skos:prefLabel xml:lang="'.$datosTargetTerms[tvocab_lang].'">'.$datosTargetTerms[tterm_string].'</skos:prefLabel>';
		$skos_map.=' </skos:Concept>';
		$skos_map.='</skos:'.$map_label.'Match>';
	};

	$SQLURI2term=SQLURIxterm($idTema);

	while ($datosURI2term=$SQLURI2term->FetchRow()){

		if(in_array(strtolower($datosURI2term[uri_code]), array('exactmatch','closematch','relatedmatch','partialmatch','broadmatch','narrowmatch')))
		{

			$skos_map.='<skos:'.$datosURI2term[uri_code].'>';
			$skos_map.=' <skos:Concept rdf:about="'.htmlentities($datosURI2term[uri]).'"/>';
			$skos_map.='</skos:'.$datosURI2term[uri_code].'>';

			/*
			$skos_map.='<skos:'.$datosURI2term[uri_code].' resource="'.htmlentities($datosURI2term[uri]).'" />';
			*/
		}

	};


	for($iNota=0; $iNota<(count($datosTermino["notas"])); ++$iNota){
		if($datosTermino["notas"][$iNota]["id"]){
			switch($datosTermino["notas"][$iNota]["tipoNota"]){
				case 'NH':
				$skos_notes.=' <skos:historyNote xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:historyNote>';
				break;

				case 'NA':
				$skos_notes.=' <skos:scopeNote xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:scopeNote>';
				break;

				case 'DF':
				$skos_notes.=' <skos:definition xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:definition>';
				break;

				case 'ED':
				$skos_notes.=' <skos:editorialNote xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:editorialNote>';
				break;

				case 'EX':
				$skos_notes.=' <skos:example xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:example>';
				break;

				case 'CH':
				$skos_notes.=' <skos:changeNote xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:changeNote>';
				break;

				case 'NB':
				$skos_notes.=' <skos:note xml:lang="'.$datosTermino["notas"][$iNota]["lang_nota"].'">'.html2txt($datosTermino[notas][$iNota][nota]).'</skos:note>';
				break;
			}
		};
	};

	$meta_tag.='  <skos:Concept rdf:about="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'">';

	$meta_tag.='<skos:prefLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTermino[titTema]).'</skos:prefLabel>';

	//Use or not term code / notation tag in Skos
	if(($CFG["_USE_CODE"]=='1') && (strlen($datosTermino[code])>0))
	{
		$meta_tag.='<skos:notation>'.xmlentities($datosTermino[code]).'</skos:notation>';
	}

	$meta_tag.=$skos_altLabel;
	$meta_tag.=$skos_notes;

	$meta_tag.='<skos:inScheme rdf:resource="'.$_URI_BASE_ID.'"/>';

	$meta_tag.=$skos_related;
	$meta_tag.=$skos_broader;
	$meta_tag.=$skos_narrower;
	$meta_tag.=$skos_map;

	$meta_tag.='  <dct:created>'.$datosTermino[cuando].'</dct:created>';
	if($datosTermino[cuando_final]>$datosTermino[cuando]){
		$meta_tag.='<dct:modified>'.$datosTermino[cuando_final].'</dct:modified>';
	}

	/* Deprecated in Skos-core
	//$meta_tag.='<skos:subjectIndicator rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'"/>';
	*/
	$meta_tag.='  </skos:Concept>';

	return $meta_tag;
};





#
# Armado de salida MADS
#
function do_mads($idTema){

	GLOBAL $CFG;

	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$xml.='<mads xmlns="http://www.loc.gov/mads/" xmlns:mods="http://www.loc.gov/mods/v3" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.loc.gov/mads/
	mads.xsd">';

	$xml.=do_nodo_mads($idTema);

	$xml.='</mads>';
	return  $xml;
};


#
# Armado de salida MADS
#
function do_nodo_mads($idTema){

	GLOBAL $CFG;

	$datosTermino=ARRAYverDatosTermino($idTema);
	$SQLTerminosE=SQLverTerminosE($idTema);
	$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($idTema);

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';


	$xml.='<authority>';
	$xml.='<topic authority="'.$_URI_BASE_ID.'">'.xmlentities($datosTermino[titTema]).'</topic>';
	$xml.='</authority>';

	while ($datosTerminosE=$SQLTerminosE->FetchRow()){
		$xml.='<related type="narrower">';
		$xml.='<topic>'.xmlentities($datosTerminosE[tema]).'</topic>';
		$xml.='</related>';
	};

	while ($datosTerminosRelacionados= $SQLTerminosRelacionados->FetchRow()){

		if($datosTerminosRelacionados[t_relacion]=='3'){// TG
			$xml.='<related type="broader">';
			$xml.='<topic>'.xmlentities($datosTerminosRelacionados[tema]).'</topic>';
			$xml.='</related>';
		};

		if($datosTerminosRelacionados[t_relacion]=='2'){// TR
			$xml.='<related type="other">';
			$xml.='<topic>'.xmlentities($datosTerminosRelacionados[tema]).'</topic>';
			$xml.='</related>';
		};

		if($datosTerminosRelacionados[t_relacion]=='4'){// UF
			$xml.='<variant type="other">';
			$xml.='<topic>'.xmlentities($datosTerminosRelacionados[tema]).'</topic>';
			$xml.='</variant>';
		};
	};

	for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
		if($datosTermino[notas][$iNota][id]){
			switch($datosTermino[notas][$iNota][tipoNota]){
				case 'NH':
				$xml.=' <note type="history" xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</note>';
				break;

				case 'NA':
				$xml.=' <note xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</note>';
				break;

				case 'NB':
				$xml.=' <note type="source" xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</note>';
				break;
			}
		};
	};

	return  $xml;
};



#
# Armado de salida Dublin Core x término
#
function do_dublin_core($idTema){

	GLOBAL $CFG;

	$datosTermino=ARRAYverDatosTermino($idTema);
	$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($idTema);

	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$xml.='<metadata xmlns:dc="http://purl.org/dc/elements/1.1/"  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:dcterms="http://purl.org/dc/terms/">';

	$xml.='<dc:title xml:lang="'.$_SESSION[CFGIdioma].'">'.xmlentities($datosTermino[titTema]).'</dc:title>';
	$xml.='<dc:identifier>'.$_SESSION[CFGURL].'?tema='.$idTema.'</dc:identifier>';
	$xml.='<dc:language>'.$_SESSION[CFGIdioma].'</dc:language>';
	$xml.='<dc:publisher xml:lang="'.$_SESSION[CFGIdioma].'">'.xmlentities($_SESSION[CFGAutor]).'</dc:publisher>';
	$xml.='<dcterms:created>'.$datosTermino[cuando].'</dcterms:created>';
	if($datosTermino[cuando_final]>$datosTermino[cuando])
	{$xml.='<dcterms:modified>'.$datosTermino[cuando_final].'</dcterms:modified>';}

	$xml.='<dcterms:isPartOf xsi:type="dcterms:URI">'.$_SESSION[CFGURL].'</dcterms:isPartOf>';
	$xml.='<dcterms:isPartOf xml:lang="'.$_SESSION[CFGIdioma].'">'.xmlentities($_SESSION[CFGTitulo]).'</dcterms:isPartOf>';
	$xml.='<dc:format>text/html</dc:format>';

	while ($datosTerminosRelacionados= $SQLTerminosRelacionados->FetchRow()){
		if($datosTerminosRelacionados[t_relacion]=='4'){// UF
			$xml.=' <dcterms:alternative xml:lang="'.$_SESSION[CFGIdioma].'">'.xmlentities($datosTerminosRelacionados[tema]).'</dcterms:alternative>';
		};
	};


	for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
		if($datosTermino[notas][$iNota][id]){
			//idioma de la nota
			$label_lang_nota = (!$datosTermino[notas][$iNota][lang_nota]) ? $_SESSION["CFGIdioma"] : $datosTermino[notas][$iNota][lang_nota];
			switch($datosTermino[notas][$iNota][tipoNota]){
				case 'NA':
				$xml.=' <dc:description xml:lang="'.$label_lang_nota.'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</dc:description>';
				break;

				case 'NB':
				$xml.=' <dc:source xml:lang="'.$label_lang_nota.'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</dc:source>';
				break;
			}
		};
	};
	$xml.='</metadata>';
	echo  $xml;
};





/*
* Arma nodos BS8723-simple // Create BS8723 simple node
* BS 8723: Structured Vocabularies for Information Retrieval
* http://schemas.bs8723.org/Home.aspx
*
*/
function do_nodo_BS8723($tema_id){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	/*
	Tomar URL por default
	*  Para que utilice URLs navegables:
	*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
	* Para que utilice URLs Skos core
	*/
	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';


	//Buscar datos del termino
	$datosTermino=ARRAYverDatosTermino($tema_id);

	//Términos específicos (NT) del término
	$SQLTerminosE=SQLverTerminosE($tema_id);

	//Otras relaciones del término (UF,RT, BT) del término
	$SQLterminosRelacionados=SQLverTerminoRelaciones($tema_id);

	//Nodos de NT
	while ($datosTerminosE=$SQLTerminosE->FetchRow())
	{
		$xmlnodosNT.='<HasHierRelConcept Role="NT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosE[id_tema].'</HasHierRelConcept>';
	};

	//Nodos RT, BT y UF
	while ($datosTerminosRelacionados= $SQLterminosRelacionados->FetchRow())
	{
		switch ($datosTerminosRelacionados[t_relacion]) {

			case '2'://RT
			$xmlnodosRT.='<HasRelatedConcept Role="RT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id].'</HasRelatedConcept>';
			break;

			case '3'://BT
			$xmlnodosBT.='<HasHierRelConcept Role="BT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id].'</HasHierRelConcept>';
			break;

			case '4'://UF
			$xmlnodosUF.='<NonPreferredTerm dc:identifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id].'" xml:lang="'.$_SESSION["CFGIdioma"].'">';
			$xmlnodosUF.='	<LexicalValue>'.xmlentities($datosTerminosRelacionados[tema]).'</LexicalValue>';
			$xmlnodosUF.='		<dcterms:created>'.$datoTerminosRelacionados[t1_cuando].'</dcterms:created>';
			$xmlnodosUF.='		<USE>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$tema_id.'</USE>';
			$xmlnodosUF.='</NonPreferredTerm>';
			break;
		}
	};


	//Notas
	for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
		if($datosTermino[notas][$iNota][id]){
			switch($datosTermino[notas][$iNota][tipoNota]){
				case 'NH'://HistoryNote
				$xmlnodosNotas.='<HistoryNote xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">';
				$xmlnodosNotas.='  <LexicalValue>'.xmlentities($datosTermino[notas][$iNota][nota],true).'</LexicalValue>';
				$xmlnodosNotas.='</HistoryNote>';
				break;

				case 'NA'://ScopeNote
				$xmlnodosNotas.='<ScopeNote xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">';
				$xmlnodosNotas.='  <LexicalValue>'.xmlentities($datosTermino[notas][$iNota][nota],true).'</LexicalValue>';
				$xmlnodosNotas.='</ScopeNote>';
				break;
			}
		};
	};

	//Nodo del término
	$xmlnodoTermino.='<PreferredTerm dc:identifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'" xml:lang="'.$_SESSION["CFGIdioma"].'">';
	$xmlnodoTermino.='	<LexicalValue>'.xmlentities($datosTermino[titTema]).'</LexicalValue>';
	$xmlnodoTermino.='	<dcterms:created>'.$datosTermino[cuando].'</dcterms:created>';
	if ($datosTermino[cuando_final]>$datosTermino[cuando])
	{
		$xmlnodoTermino.='	<dcterms:modified>'.$datosTermino[cuando_final].'</dcterms:modified>';
	}
	$xmlnodoTermino.='</PreferredTerm>';

	//Armado del nodo del concepto
	$xmlnodo='<ThesaurusConcept dc:identifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'">';
	$xmlnodo.='	<dcterms:created>'.$datosTermino[cuando].'</dcterms:created>';
	if ($datosTermino[cuando_final]>$datosTermino[cuando])
	{
		$xmlnodo.='	<dcterms:modified>'.$datosTermino[cuando_final].'</dcterms:modified>';
	}
	$xmlnodo.=$xmlnodoTermino;
	$xmlnodo.=$xmlnodosNotas;
	$xmlnodo.=$xmlnodosUF;
	$xmlnodo.=$xmlnodosBT;
	$xmlnodo.=$xmlnodosNT;
	$xmlnodo.=$xmlnodosRT;

	$xmlnodo.='</ThesaurusConcept>';

	return $xmlnodo;
};





#
# FUNCION PARA ARMAR XML BS8723s
#
function do_BS8723s($xmlnodos){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$xml.='<Thesaurus
	xmlns="http://schemas.bs8723.org/XmlSchema/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:dcterms="http://purl.org/dc/terms/"
	xmlns:eGMS="http://www.govtalk.gov.uk/CM/gms"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://schemas.bs8723.org/XmlSchema/DD8723-5.xsd">';
	$xml.='	 <dc:identifier>'.$_URI_BASE_ID.'</dc:identifier>';
	$xml.='  <dc:title>'.xmlentities($_SESSION[CFGTitulo]).'</dc:title>';
	$xml.='  <dc:creator>'.xmlentities($_SESSION[CFGAutor]).'</dc:creator>';
	$xml.='  <dc:subject>'.xmlentities($_SESSION[CFGKeywords]).'</dc:subject>';
	$xml.='  <dc:description>'.xmlentities($_SESSION[CFGCobertura],true).'</dc:description>';
	$xml.='  <dc:publisher>'.xmlentities($_SESSION[CFGAutor]).'</dc:publisher>';
	$xml.='  <dc:date>'.xmlentities($_SESSION[CFGCreacion]).'</dc:date>';
	$xml.='  <dc:language>'.LANG.'</dc:language>';
	$xml.=$xmlnodos;
	$xml.='</Thesaurus>';

	return $xml;
};



#
# Armado de salida RSS
#
function do_rss($limit="30"){

	GLOBAL $CFG;

	$sql=SQLlastTerms($limit);

	while ($array=$sql->FetchRow()){
		$xml_seq.='<li xmlns:dc="http://purl.org/dc/elements/1.1/" rdf:resource="index.php?tema='.$array[tema_id].'"/>';
		$xml_item.='<item xmlns:dc="http://purl.org/dc/elements/1.1/" rdf:about="'.$_SESSION["CFGURL"].'?tema='.$arrayTT[tema_id].'">';
		$xml_item.='<title>'.$array[tema].'</title>';
		$xml_item.='<link>'.$_SESSION["CFGURL"].'?tema='.$array[tema_id].'</link>';
		$xml_item.='</item>';
	};

	header ('content-type: text/xml');
	$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'" standalone="yes"?>';
	$xml.='<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.1/">';
	$xml.='<channel rdf:about="'.$_SESSION["CFGURL"].'">';
	$xml.='<title xmlns:dc="http://purl.org/dc/elements/1.1/">'.xmlentities($_SESSION["CFGTitulo"]).'</title>';
	$xml.='<description xmlns:dc="http://purl.org/dc/elements/1.1/">'.xmlentities($_SESSION["CFGCobertura"],true).'</description>';
	$xml.='<link xmlns:dc="http://purl.org/dc/elements/1.1/">'.$_SESSION["CFGURL"].'</link>';
	$xml.='<items>';
	$xml.='<rdf:Seq>';
	$xml.=$xml_seq;
	$xml.='</rdf:Seq>';
	$xml.='</items>';
	$xml.='</channel>';
	$xml.=$xml_item;
	$xml.='</rdf:RDF>';
	echo $xml;
};

#######################################################################
#
# GENERADOR DE META TAGS Y DC
#
function do_meta_tag($arrayTermino=""){

	GLOBAL $CFG;

	//Si hay algún tema de proveniente de algún proceso
	GLOBAL $tema;

	//Si hay cambio de idioma... para que no dé duplicado
	$labelChangeLang= ($_GET[setLang]) ? '. '.ucfirst($_SESSION[$_SESSION["CFGURL"]][lang][0]) : '';


	$ARRAYfetchValues=ARRAYfetchValues('METADATA');

	$_SESSION["CFGContributor"]=$ARRAYfetchValues["dc:contributor"]["value"];
	$_SESSION["CFGRights"]=$ARRAYfetchValues["dc:rights"]["value"];
	$_SESSION["CFGPublisher"]=$ARRAYfetchValues["dc:publisher"]["value"];
	$_SESSION["CFGlastMod"]=fetchlastMod();

	if(secure_data($tema,"digit")){

		//Si hay tema_id desde GET o POST
		$tema_id = ($_POST[tema]) ? secure_data($_POST[tema],"digit") : secure_data($_GET[tema],"digit");


		//Si hay tema_id desde algún proceso
		$tema_id = ($tema) ? $tema : $tema_id;
	}

	$letra=isValidLetter($_GET[letra]);

	if(secure_data($tema_id,"digit"))
	{
		$ARRAYdatosTermino=ARRAYverDatosTermino(secure_data($tema_id,"digit"));

		$sub_title='; '.xmlentities($ARRAYdatosTermino[titTema]);
		$ver_sub_title=xmlentities($ARRAYdatosTermino[titTema]).' - ';
		$relMeta='<link rel="Dublin Core metadata" type="application/xml" href="xml.php?dcTema='.$ARRAYdatosTermino[idTema].'" title="Dublin Core '.xmlentities($datosTermino[titTema]).'" />';
		$relMeta.='<link rel="MADS metadata" type="application/xml" href="xml.php?madsTema='.$ARRAYdatosTermino[idTema].'" title="MADS '.xmlentities($datosTermino[titTema]).'" />';
		$relMeta.='<link rel="Zthes metadata" type="application/xml" href="xml.php?zthesTema='.$ARRAYdatosTermino[idTema].'" title="Zthes '.xmlentities($datosTermino[titTema]).'" />';
		$relMeta.='<link rel="Skos metadata" type="application/rdf+xml" href="xml.php?skosTema='.$ARRAYdatosTermino[idTema].'" title="Skos Core '.xmlentities($datosTermino[titTema]).'" />';
		$relMeta.='<link rel="TopicMap metadata" type="application/xml" href="xml.php?xtmTema='.$ARRAYdatosTermino[idTema].'" title="TopicMap '.xmlentities($datosTermino[titTema]).'" />';
	}

	elseif(strlen($letra)>0)
	{
		$sub_title='; '.MSG_ResultLetra.' '.xmlentities($letra);
		$ver_sub_title=' :: '.MENU_ListaAbc.': '.xmlentities($letra);
	}


	$meta_tag='<title>'.xmlentities($ver_sub_title.' '.$_SESSION[CFGTitulo].$labelChangeLang).'</title>';
	/*
	* Error en verificación
	$meta_tag.='<meta http-equiv="content-language" content="'.LANG.'" />';
	*/
	$page_encode = (in_array($CFG["_CHAR_ENCODE"],array('utf-8','iso-8859-1'))) ? $CFG["_CHAR_ENCODE"] : 'utf-8';

	header ('Content-type: text/html; charset='.$page_encode.'');
	$meta_tag.='<meta http-equiv="content-type" content="application/xhtml+xml; charset='.$page_encode.'" />';
	$meta_tag.='<meta name="generator" content="'.xmlentities($_SESSION[CFGVersion]).'" />';
	$meta_tag.='<meta name="description" content="'.html2txt($ver_sub_title.$_SESSION[CFGCobertura].$labelChangeLang).'" />';
	$meta_tag.='<meta name="keywords" content="'.xmlentities($_SESSION[CFGKeywords].$sub_title.$labelChangeLang).'" />';
	$meta_tag.='<meta name="author" content="'.xmlentities($_SESSION[CFGAutor]).'" />';
	$meta_tag.='<meta name="Creation_Date" content="'.$_SESSION[CFGCreacion].'" />';
	$meta_tag.='<meta http-equiv="last-modified" content="'.$_SESSION["CFGlastMod"].'" />';
	$meta_tag.='<meta name="robots" content="index, follow" />';
	$meta_tag.='<meta name="revisit-after" content="15 days" />';

	//$meta_tag.='<!-- Dublin Core -->';
	$meta_tag.='<meta name="DC.Title"        content="'.xmlentities($ver_sub_title.' '.$_SESSION[CFGTitulo]).'" />';
	$meta_tag.='<meta name="DC.Creator"      content="'.xmlentities($_SESSION[CFGAutor]).'" />';
	$meta_tag.='<meta name="DC.Subject"      content="'.xmlentities($_SESSION[CFGKeywords].$sub_title).'" />';
	$meta_tag.='<meta name="DC.Description"  content="'.html2txt($ver_sub_title.$_SESSION[CFGCobertura],true).'" />';
	$meta_tag.='<meta name="DC.Publisher"    content="'.xmlentities($_SESSION[CFGPublisher]).'" />';
	$meta_tag.='<meta name="DC.Contributor"    content="'.xmlentities($_SESSION[CFGContributor]).'" />';
	$meta_tag.='<meta name="DC.Rights"    content="'.xmlentities($_SESSION[CFGRights]).'" />';
	$meta_tag.='<meta name="DC.Date"         content="'.$_SESSION[CFGCreacion].'" />';
	$meta_tag.='<meta name="DC.Language"     content="'.LANG.'" />';

	$meta_tag.='<link rel="'.MENU_Inicio.'" href="'.$_SESSION[CFGURL].'index.php" title="'.MENU_Inicio.'" />';
	$meta_tag.='<link rel="'.MENU_ListaSis.'" href="'.$_SESSION[CFGURL].'index.php" title="'.MENU_ListaSis.'" />';
	$meta_tag.='<link rel="'.MENU_ListaAbc.'" href="'.$_SESSION[CFGURL].'index.php?letra=?" title="'.MENU_ListaAbc.'" />';
	$meta_tag.='<link rel="'.MENU_Sobre.'" href="'.$_SESSION[CFGURL].'sobre.php" title="'.MENU_Sobre.'" />';
	$meta_tag.='<link rel="help" href="'.$_SESSION[CFGURL].'sobre.php" title="'.MENU_Sobre.'" />';
	$meta_tag.='<link rel="login" href="'.$_SESSION[CFGURL].'login.php" title="'.LABEL_login.'" />';
	$meta_tag.='<link rel="service" href="'.$_SESSION[CFGURL].'services.php" title="terminogical web services" />';
	$meta_tag.='<link rel="bookmark" href="'.$_SESSION[CFGURL].'"/>';
	$meta_tag.='<link rel="rss" type="application/rss+xml" href="xml.php?rss=true" title="RSS '.xmlentities($_SESSION[CFGTitulo]).'" />';
	$meta_tag.='<link rel="alternate" type="application/rss+xml" href="xml.php?rss=true" title="RSS '.xmlentities($_SESSION[CFGTitulo]).'" />';
	$meta_tag.=$relMeta;

	return array("metadata"=>$meta_tag,"arraydata"=>$ARRAYdatosTermino);
};
#######################################################################

function do_topicMap($tema_id){

	GLOBAL $CFG;

	$time_start = time();
	@set_time_limit(900);
	header ('content-type: text/xml');
	$row.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$row.=XTMheader;

	$rowTerminos=doTerminosXTM($tema_id);
	$rowRelaciones=doRelacionesXTM($tema_id);
	$rowFinal='</topicMap>';

	$rows=$row.$rowTerminos.$rowRelaciones.$rowFinal;
	echo $rows;
};



function doTerminosXTM($tema_id=""){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';


	/*
	$sql=SQLTerminosValidos($tema_id);
	*/
	$sql=SQLTerminosPreferidos($tema_id);

	while ($array=$sql->FetchRow()){
		$row.='<topic id="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id].'">';
		$row.='<instanceOf>';
		$row.='<topicRef xlink:href="#term"/>';
		$row.='</instanceOf>';
		$row.='<baseName>';
		$row.='<baseNameString>'.xmlentities($array[tema]).'</baseNameString>';
		$row.='</baseName>';

		$sqlNotas=SQLdatosTerminoNotas($array[id],array("NA"));

		while ($arrayNotas=$sqlNotas->FetchRow()){
			$row.='  <occurrence>';
			$row.='    <instanceOf>';
			$row.='      <topicRef xlink:href="#scope-note"/>';
			$row.='    </instanceOf>';
			$row.='<baseName>';
			$row.='<baseNameString>'.xmlentities($arrayNotas[nota],true).'</baseNameString>';
			$row.='</baseName>';
			$row.='  </occurrence>';
		};
		$row.='</topic>';
	};

	//Esta pidiendo el vocabulario completo -> incluir topic de términos no preferidos.
	if(!isset($tema_id)){
		//Sql de términos no prereridos (UF)
		$sql=SQLterminosValidosUF();
		while ($array=$sql->FetchRow()){
			$row.='<topic id="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[tema_id].'">';
			$row.='<instanceOf>';
			$row.='<topicRef xlink:href="#term"/>';
			$row.='</instanceOf>';
			$row.='<baseName>';
			$row.='<baseNameString>'.xmlentities($array[tema]).'</baseNameString>';
			$row.='</baseName>';
			$row.='</topic>';
		};
	}
	return $row;
};



/*
Creación de relacion XTM
*/
function doRelacionesXTM($tema_id=""){
	GLOBAL $DBCFG;

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';


	$sql=SQLTerminoRelacionesIDs($tema_id);
	while ($array=$sql->FetchRow()){
		#Mantener vivo el navegador
		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};


		switch($array[t_relacion]){
			case '2': //TR
			$row.='  <association>';
			$row.='    <instanceOf>';
			$row.='      <topicRef xlink:href="#related-terms"/>';
			$row.='    </instanceOf>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#related-term"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'"/>';
			$row.='    </member>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#related-term"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'"/>';
			$row.='    </member>';
			$row.='  </association>';
			break;

			case '3': //TG-TE
			$row.='  <association>';
			$row.='    <instanceOf>';
			$row.='      <topicRef xlink:href="#broader-narrower"/>';
			$row.='    </instanceOf>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#narrower"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'"/>';
			$row.='    </member>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#broader"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'"/>';
			$row.='    </member>';
			$row.='  </association>';
			break;

			case '4': //UP-USE
			$row.='  <association>';
			$row.='    <instanceOf>';
			$row.='      <topicRef xlink:href="#synonym"/>';
			$row.='    </instanceOf>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#non-preferred-term"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'"/>';
			$row.='    </member>';
			$row.='    <member>';
			$row.='      <roleSpec>';
			$row.='  <topicRef xlink:href="#preferred-term"/>';
			$row.='      </roleSpec>';
			$row.='      <topicRef xlink:href="#'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'"/>';
			$row.='    </member>';
			$row.='  </association>';
			break;
		}
	};
	return $row;
};



function do_VDEX($tema_id){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$time_start = time();
	@set_time_limit(900);

	header ('content-type: text/xml');
	$row.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>
	<vdex xmlns="http://www.imsglobal.org/xsd/imsvdex_v1p0"  orderSignificant="false" language="'.$_SESSION["CFGIdioma"].'">
	<vocabIdentifier>'.$_URI_BASE_ID.'</vocabIdentifier>';

	$rowTerminos=doTerminosVDEX($tema_id);

	$rowRelaciones=doRelacionesVDEX($tema_id);

	$rowFinal='</vdex>';

	$rows=$row.$rowTerminos.$rowRelaciones.$rowFinal;

	echo $rows;
};



function doTerminosVDEX($tema_id=""){

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';


	$sql=SQLTerminosPreferidos($tema_id);

	while ($array=$sql->FetchRow()){
		$row.='<term>';
		$row.='<termIdentifier>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id].'</termIdentifier>';
		$row.='<caption>'.xmlentities($array[tema]).'</caption>';
		$row.='</term>';
	};

	//Esta pidiendo el vocabulario completo -> incluir topic de términos no preferidos.
	if(!isset($tema_id)){
		//Sql de términos no prereridos (UF)
		$sql=SQLterminosValidosUF();
		while ($array=$sql->FetchRow()){
			$row.='<term>';
			$row.='<termIdentifier>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[tema_id].'</termIdentifier>';
			$row.='<caption>'.xmlentities($array[tema]).'</caption>';
			$row.='</term>';
		};
	}
	return $row;
};


/*
Creación de relacion VDEX
*/
function doRelacionesVDEX($tema_id=""){
	GLOBAL $DBCFG;

	GLOBAL $CFG;

	$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

	$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';



	$sql=SQLTerminoRelacionesIDs($tema_id);
	while ($array=$sql->FetchRow()){
		#Mantener vivo el navegador
		$time_now = time();
		if ($time_start >= $time_now + 10) {
			$time_start = $time_now;
			header('X-pmaPing: Pong');
		};


		switch($array[t_relacion]){
			case '2': //TR
			if($array[id1]==$tema_id)
			{
				$row.='  <relationship>';
				$row.='      <sourceTerm>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'</sourceTerm>';
				$row.='      <targetTerm vocabIdentifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'">'.$array[t2].'</targetTerm>';
				$row.='      <relationshipType source="http://www.imsglobal.org/vocabularies/iso2788_relations.xml">RT</relationshipType>';
				$row.='  </relationship>';
			}
			break;

			case '3': //TG-TE
			if($array[id2]==$tema_id)
			{
				$row.='  <relationship>';
				$row.='      <sourceTerm>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'</sourceTerm>';
				$row.='      <targetTerm vocabIdentifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'">'.$array[tema1].'</targetTerm>';
				$row.='      <relationshipType source="http://www.imsglobal.org/vocabularies/iso2788_relations.xml">BT</relationshipType>';
				$row.='  </relationship>';
			}
			else{
				$row.='  <relationship>';
				$row.='      <sourceTerm>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'</sourceTerm>';
				$row.='      <targetTerm vocabIdentifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'">'.$array[t2].'</targetTerm>';
				$row.='      <relationshipType source="http://www.imsglobal.org/vocabularies/iso2788_relations.xml">NT</relationshipType>';
				$row.='  </relationship>';
			}

			break;

			case '4': //UP-USE
			if($array[id2]==$tema_id)
			{
				$row.='  <relationship>';
				$row.='      <sourceTerm>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'</sourceTerm>';
				$row.='      <targetTerm vocabIdentifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'">'.$array[tema1].'</targetTerm>';
				$row.='      <relationshipType source="http://www.imsglobal.org/vocabularies/iso2788_relations.xml">UF</relationshipType>';
				$row.='  </relationship>';
			}
			else{
				$row.='  <relationship>';
				$row.='      <sourceTerm>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id1].'</sourceTerm>';
				$row.='      <targetTerm vocabIdentifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id2].'">'.$array[t2].'</targetTerm>';
				$row.='      <relationshipType source="http://www.imsglobal.org/vocabularies/iso2788_relations.xml">USE</relationshipType>';
				$row.='  </relationship>';
			}
			break;
		}
	};
	return $row;
};


/*
check update data for term from target vocabulary
*/
function dataSimpleChkUpdateTterm($method,$tterm_uri)
{
	require_once('vocabularyservices.php')	;
	switch ($method) {
		case 'tematres':
		return getURLdata($tterm_uri);
		break;

		default :
		return getURLdata($tterm_uri);
		break;
	}
}

#
# Arma nodos JSON-LD
#
function do_jsonld($tema_id){

	GLOBAL $CFG;

	$ARRAYjson_relations=array( "skos:narrower"=>array(),
	"skos:broader"=>array(),
	"skos:altLabel"=>array(),
	"skos:hiddenLabel"=>array(),
	"skos:related"=>array()
);


$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

/*
Tomar URL por default
*  Para que utilice URLs navegables:
*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
* Para que utilice URLs Skos core
*/
$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';


$datosTermino=ARRAYverDatosTermino($tema_id);

if(!is_numeric($datosTermino["tema_id"])) return null;

$SQLTerminosE=SQLverTerminosE($tema_id);
while ($datosTerminosE=$SQLTerminosE->FetchRow()){
	array_push($ARRAYjson_relations["skos:narrower"],$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosE[id_tema]);
}


$SQLterminosRelacionados=SQLverTerminoRelaciones($tema_id);

while ($datosTerminosRelacionados= $SQLterminosRelacionados->FetchRow()){
	if($datosTerminosRelacionados[t_relacion]=='2'){// TR
		array_push($ARRAYjson_relations["skos:related"],$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id]);
	};

	if($datosTerminosRelacionados[t_relacion]=='3'){// TG
		array_push($ARRAYjson_relations["skos:broader"],$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[tema_id]);
	};

	if($datosTerminosRelacionados[t_relacion]=='4'){// UF

		//HiddenLabel
		if(in_array($datosTerminosRelacionados[rr_code],$CFG["HIDDEN_EQ"]))
		{
			array_push($ARRAYjson_relations["skos:hiddenLabel"],array("language"=>$_SESSION["CFGIdioma"],"value"=>$datosTerminosRelacionados[tema]));
		}
		else
		{
			array_push($ARRAYjson_relations["skos:altLabel"],array("language"=>$_SESSION["CFGIdioma"],"value"=>$datosTerminosRelacionados[tema]));
		}
	};
};


$SQLtargetTerms=SQLtargetTerms($tema_id);

$ARRAYjson_map=array();

while ($datosTargetTerms=$SQLtargetTerms->FetchRow()){

	$map_label=(in_array(strtolower($datosTargetTerms[tvocab_tag]), array('exact','close','related','partial','broad','narrow'))) ? strtolower($datosTargetTerms[tvocab_tag]) : 'exact';

	$skos_tag='skos:'.$map_label.'Match';
	$ARRAYjson_map["$skos_tag"][]=array("@id"=>$datosTargetTerms[tterm_url],
	"@type"=>"skos:Concept",
	"skos:prefLabel"=>array("@language"=>$datosTargetTerms[tvocab_lang],
	"@value="=>$datosTargetTerms[tterm_string])
);
};

$SQLURI2term=SQLURIxterm($tema_id);

$ARRAYjson_URI=array();

while ($datosURI2term=$SQLURI2term->FetchRow()){
	if(in_array(strtolower($datosURI2term[uri_code]), array('exactmatch','closematch','relatedmatch','partialmatch','broadmatch','narrowmatch')))
	{
		$ARRAYjson_URI["$datosURI2term[uri_code]"][]=array("@id"=>$datosURI2term[uri],
		"@type"=>"skos:Concept"
	);
}

};
$ARRAYjson_notes=array();

for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
	if($datosTermino[notas][$iNota][id]){
		switch($datosTermino[notas][$iNota][tipoNota]){
			case 'NH':
			$ARRAYjson_notes["skos:historyNote"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'NA':
			$ARRAYjson_notes["skos:scopeNote"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'DF':
			$ARRAYjson_notes["skos:definition"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'ED':
			$ARRAYjson_notes["skos:editorialNote"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'EX':
			$ARRAYjson_notes["skos:example"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'CH':
			$ARRAYjson_notes["skos:changeNote"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;

			case 'NB':
			$ARRAYjson_notes["skos:note"][]=array("@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino[notas][$iNota][nota]));
			break;
		}
	};
};



$ARRAY_json=array("@context"=>array( "dc"=>"http://purl.org/dc/elements/1.1/",
"skos"=>"http://www.w3.org/2004/02/skos/core#",
"skos:broader"=>array("@type"=>"@id"),
"skos:inScheme"=>array("@type"=>"@id"),
"skos:related"=>array("@type"=>"@id"),
"skos:narrower"=>array("@type"=>"@id"),
"skos:hasTopConcept"=>array("@type"=>"@id"),
"skos:topConceptOf"=>array("@type"=>"@id")
),
"@id"=>$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema],
"@type"=>"skos:Concept",
"skos:prefLabel"=>array("@language"=>$_SESSION["CFGIdioma"],
"@value="=>xmlentities($datosTermino[titTema])),
"skos:inScheme"=>$_URI_BASE_ID,
"dct:created"=>$datosTermino[cuando]
);

if($datosTermino[cuando_final])
{
	$ARRAY_json=array_merge($ARRAY_json,array("dct:modified"=>$datosTermino[cuando_final]));
};


//Use or not term code / notation tag in Skos
if(($CFG["_USE_CODE"]=='1') && (strlen($datosTermino[code])>0))
{
	$ARRAY_json=array_merge($ARRAY_json,array("skos:notation"=>$datosTermino[code]));
}

//Unset empty array
if(count($ARRAYjson_relations["skos:related"])==0)
{
	unset($ARRAYjson_relations["skos:related"]);
};


if(count($ARRAYjson_relations["skos:broader"])==0)
{
	unset($ARRAYjson_relations["skos:broader"]);
};


if(count($ARRAYjson_relations["skos:narrower"])==0)
{
	unset($ARRAYjson_relations["skos:narrower"]);
};


if(count($ARRAYjson_relations["skos:altLabel"])==0)
{
	unset($ARRAYjson_relations["skos:altLabel"]);
};

if(count($ARRAYjson_relations["skos:hiddenLabel"])==0)
{
	unset($ARRAYjson_relations["skos:hiddenLabel"]);
};



return json_encode(array_merge($ARRAY_json,
$ARRAYjson_notes,
$ARRAYjson_relations,
$ARRAYjson_map,
$ARRAYjson_URI
));
};

#
# Arma nodos JSON
#
function do_json($tema_id){

	GLOBAL $CFG;

	$datosTermino=ARRAYverDatosTermino($tema_id);

	if(!is_numeric($datosTermino["tema_id"])) return null;


	$ARRAYterm["tema_id"]=$datosTermino["tema_id"];
	$ARRAYterm["string"]=$datosTermino["titTema"];
	$ARRAYterm["created"]=$datosTermino["cuando"];
	$ARRAYterm["code"]=$datosTermino["code"];
	if($datosTermino["cuando_final"]) $ARRAYterm["modified"]=$datosTermino["cuando_final"];

	for($iNota=0; $iNota<(count($datosTermino["notas"])); ++$iNota){

		//there are note and is not private note
		if(($datosTermino["notas"][$iNota]["id"]) && ($datosTermino["notas"][$iNota]["tipoNota"]!=='NP')){

			$tipoNota=(in_array($datosTermino["notas"][$iNota]["tipoNota_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$datosTermino["notas"][$iNota]["tipoNota_id"]) : $datosTermino["notas"][$iNota]["tipoNotaLabel"];

			$ARRAYterm["notes"][]=array("@type"=>$tipoNota,"@lang"=>$datosTermino[notas][$iNota][lang_nota],"@value"=>html2txt($datosTermino["notas"][$iNota]["nota"]));
		};
	};

	return json_encode($ARRAYterm);
};
?>
