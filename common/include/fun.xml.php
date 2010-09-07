<?php
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
$meta_tag.='<!DOCTYPE Zthes SYSTEM "http://zthes.z3950.org/xml/zthes-05.dtd">';
$meta_tag.='  <Zthes>';
$meta_tag.=''.$nodos_zthes;
$meta_tag.='  </Zthes>';

return  $meta_tag;
};

function do_nodo_zthes($idTema){
$datosTermino=ARRAYverDatosTermino($idTema);
$SQLTerminosE=SQLverTerminosE($idTema);
$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($idTema);

while ($datosTerminosE=mysqli_fetch_array($SQLTerminosE[datos])){
	$zthes_narrower.='<relation>';
	$zthes_narrower.='<relationType>NT</relationType>';
	$zthes_narrower.='<termId>'.$datosTerminosE[id_tema].'</termId>';
	$zthes_narrower.='<termName>'.xmlentities($datosTerminosE[tema]).'</termName>';
	$zthes_narrower.='<termType>PT</termType>';
	$zthes_narrower.='</relation>';
	};


while ($datosTerminosRelacionados= mysqli_fetch_array($SQLTerminosRelacionados[datos])){

if($datosTerminosRelacionados[t_relacion]=='3'){// TG
	$zthes_broader.='<relation>';
	$zthes_broader.='<relationType>BT</relationType>';
	$zthes_broader.='<termId>'.$datosTerminosRelacionados[id_tema].'</termId>';
	$zthes_broader.='<termName>'.xmlentities($datosTerminosRelacionados[tema]).'</termName>';
	$zthes_broader.='<termType>'.$datosTerminosRelacionados[tipo_termino].'</termType>';
	$zthes_broader.='</relation>';
};

if($datosTerminosRelacionados[t_relacion]=='4'){// UF
	$zthes_UF.='<relation>';
	$zthes_UF.='<relationType>UF</relationType>';
	$zthes_UF.='<termId>'.$datosTerminosRelacionados[id_tema].'</termId>';
	$zthes_UF.='<termName>'.xmlentities($datosTerminosRelacionados[tema]).'</termName>';
	$zthes_UF.='<termType>ND</termType>';
	$zthes_UF.='</relation>';
};

if($datosTerminosRelacionados[t_relacion]=='2'){// TR
	$zthes_related.='<relation>';
	$zthes_related.='<relationType>RT</relationType>';
	$zthes_related.='<termId>'.$datosTerminosRelacionados[id_tema].'</termId>';
	$zthes_related.='<termName>'.xmlentities($datosTerminosRelacionados[tema]).'</termName>';
	$zthes_related.='<termType>'.$datosTerminosRelacionados[tipo_termino].'</termType>';
	$zthes_related.='</relation>';
};

};

	$meta_tag.='<term>';
	$meta_tag.='<termId>'.$datosTermino[idTema].'</termId>';
	$meta_tag.='<termName>'.xmlentities($datosTermino[titTema]).'</termName>';
	$meta_tag.='<termType>'.$datosTermino[tipoTema].'</termType>';
		for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
			if($datosTermino[notas][$iNota][id]){
				switch($datosTermino[notas][$iNota][tipoNota]){
				case 'NA':
					$meta_tag.='<termNote>'.xmlentities($datosTermino[notas][$iNota][nota],true).'</termNote>';
				break;
				}
			};
		};
	$meta_tag.='<termCreatedDate>'.$datosTermino[cuando].'</termCreatedDate>';
	if($datosTermino[cuando_final]){
		$meta_tag.='<termModifiedDate>'.$datosTermino[cuando_final].'</termModifiedDate>';
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
# FUNCION PARA ARMAR RDF SKOS
#
function do_skos($nodos_skos){

GLOBAL $CFG;

$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

/*
Tomar URL por default
*  Para que utilice URLs navegables:
*  $_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';
* Para que utilice URLs Skos core
*/
$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : 'xml.php?skosTema=';


# Top term del esquema
$sqlTT=SQLverTopTerm();

while ($arrayTT=mysqli_fetch_array($sqlTT[datos])){
	$skos_TT.='<skos:hasTopConcept rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$arrayTT[id].'"/>';
	};
	header ('content-type: text/xml');
	$meta_tag.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
	$meta_tag.='<rdf:RDF';
	$meta_tag.='  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
	$meta_tag.='  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"';
	$meta_tag.='  xmlns:skos="http://www.w3.org/2004/02/skos/core#"';
	$meta_tag.='  xmlns:dct="http://purl.org/dc/terms/"';
	$meta_tag.='  xmlns:dc="http://purl.org/dc/elements/1.1/">';

	$meta_tag.='<skos:ConceptScheme rdf:about="'.$_URI_BASE_ID.'">';
	
	$meta_tag.='  <dc:title>'.xmlentities($_SESSION[CFGTitulo]).'</dc:title>';
	$meta_tag.='  <dc:creator>'.xmlentities($_SESSION[CFGAutor]).'</dc:creator>';
	$meta_tag.='  <dc:subject>'.xmlentities($_SESSION[CFGKeywords]).'</dc:subject>';
	$meta_tag.='  <dc:description>'.xmlentities($_SESSION[CFGCobertura],true).'</dc:description>';
	$meta_tag.='  <dc:publisher>'.xmlentities($_SESSION[CFGAutor]).'</dc:publisher>';
	$meta_tag.='  <dc:date>'.xmlentities($_SESSION[CFGCreacion]).'</dc:date>';
	$meta_tag.='  <dc:language>'.LANG.'</dc:language>';

	//lista de Top terms
	$meta_tag.='  '.$skos_TT;
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
$SQLterminosRelacionados=SQLverTerminoRelaciones($idTema);


while ($datosTerminosE=mysqli_fetch_array($SQLTerminosE[datos])){
	$skos_narrower.='<skos:narrower rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosE[id_tema].'"/>';
	};


while ($datosTerminosRelacionados= mysqli_fetch_array($SQLterminosRelacionados[datos])){
if($datosTerminosRelacionados[t_relacion]=='2'){// TR
	$skos_related.='<skos:related rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[id].'"/>';
	};

if($datosTerminosRelacionados[t_relacion]=='3'){// TG
	$skos_broader.='<skos:broader rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[id].'"/>';
	};

if($datosTerminosRelacionados[t_relacion]=='4'){// UF
	$skos_altLabel.='<skos:altLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTerminosRelacionados[tema]).'</skos:altLabel>';
	$skos_hiddenLabel.='<skos:hiddenLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTerminosRelacionados[tema]).'</skos:hiddenLabel>';
	};
};

for($iNota=0; $iNota<(count($datosTermino[notas])); ++$iNota){
   if($datosTermino[notas][$iNota][id]){
	switch($datosTermino[notas][$iNota][tipoNota]){
	case 'NH':
	$skos_notes.=' <skos:historyNote xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</skos:historyNote>';
	break;

	case 'NA':
	$skos_notes.=' <skos:scopeNote xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</skos:scopeNote>';
	break;

	case 'ND':
	$skos_notes.=' <skos:definition xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</skos:definition>';
	break;

	case 'NB':
	$skos_notes.=' <skos:note xml:lang="'.$datosTermino[notas][$iNota][lang_nota].'">'.xmlentities($datosTermino[notas][$iNota][nota],true).'</skos:note>';
	break;
	}
    };
};

$meta_tag.='  <skos:Concept rdf:about="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'">';

$meta_tag.='<skos:prefLabel xml:lang="'.$_SESSION["CFGIdioma"].'">'.xmlentities($datosTermino[titTema]).'</skos:prefLabel>';
$meta_tag.=$skos_altLabel;
$meta_tag.=$skos_hiddenLabel;
$meta_tag.=$skos_notes;

$meta_tag.='<skos:inScheme rdf:resource="'.$_URI_BASE_ID.'"/>';

$meta_tag.=$skos_related;
$meta_tag.=$skos_broader;
$meta_tag.=$skos_narrower;

$meta_tag.='  <dct:created>'.$datosTermino[cuando].'</dct:created>';
if($datosTermino[cuando_final]){
	$meta_tag.='<dct:modified>'.$datosTermino[cuando_final].'</dct:modified>';
	}
$meta_tag.='<skos:subjectIndicator rdf:resource="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'"/>';
$meta_tag.='  </skos:Concept>';

return $meta_tag;
};





#
# Armado de salida MADS
#
function do_mads($idTema){

$datosTermino=ARRAYverDatosTermino($idTema);
$SQLTerminosE=SQLverTerminosE($idTema);
$SQLTerminosRelacionados=SQLverTerminoRelacionesTipo($idTema);

GLOBAL $CFG;

$_URI_BASE_ID = ($CFG["_URI_BASE_ID"]) ? $CFG["_URI_BASE_ID"] : $_SESSION["CFGURL"];

$_URI_SEPARATOR_ID = ($CFG["_URI_SEPARATOR_ID"]) ? $CFG["_URI_SEPARATOR_ID"] : '?tema=';



header ('content-type: text/xml');
$xml.='<?xml version="1.0" encoding="'.$CFG["_CHAR_ENCODE"].'"?>';
$xml.='<mads xmlns="http://www.loc.gov/mads/" xmlns:mods="http://www.loc.gov/mods/v3" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.loc.gov/mads/
mads.xsd">';
$xml.='<authority>';
$xml.='<topic authority="'.$_URI_BASE_ID.'">'.xmlentities($datosTermino[titTema]).'</topic>';
$xml.='</authority>';

while ($datosTerminosE=mysqli_fetch_array($SQLTerminosE[datos])){
	$xml.='<related type="narrower">';
	$xml.='<topic>'.xmlentities($datosTerminosE[tema]).'</topic>';
	$xml.='</related>';
	};

while ($datosTerminosRelacionados= mysqli_fetch_array($SQLTerminosRelacionados[datos])){

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

$xml.='</mads>';
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
if(isset($datosTermino[cuando_final]))
	{$xml.='<dcterms:modified>'.$datosTermino[cuando_final].'</dcterms:modified>';}

$xml.='<dcterms:isPartOf xsi:type="dcterms:URI">'.$_SESSION[CFGURL].'</dcterms:isPartOf>';
$xml.='<dcterms:isPartOf xml:lang="'.$_SESSION[CFGIdioma].'">'.xmlentities($_SESSION[CFGTitulo]).'</dcterms:isPartOf>';
$xml.='<dc:format>text/html</dc:format>';

while ($datosTerminosRelacionados= mysqli_fetch_array($SQLTerminosRelacionados[datos])){
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
while ($datosTerminosE=mysqli_fetch_array($SQLTerminosE[datos]))
{
	$xmlnodosNT.='<HasHierRelConcept Role="NT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosE[id_tema].'</HasHierRelConcept>';
};

//Nodos RT, BT y UF
while ($datosTerminosRelacionados= mysqli_fetch_array($SQLterminosRelacionados[datos]))
{
	switch ($datosTerminosRelacionados[t_relacion]) {
		
		case '2'://RT
		$xmlnodosRT.='<HasRelatedConcept Role="RT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[id].'</HasRelatedConcept>';
		break;

		case '3'://BT
		$xmlnodosBT.='<HasHierRelConcept Role="BT">'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[id].'</HasHierRelConcept>';
		break;

		case '4'://UF
		$xmlnodosUF.='<NonPreferredTerm dc:identifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTerminosRelacionados[id].'" xml:lang="'.$_SESSION["CFGIdioma"].'">';
		$xmlnodosUF.='	<LexicalValue>'.xmlentities($datosTerminosRelacionados[tema]).'</LexicalValue>';
		$xmlnodosUF.='		<dcterms:created>'.$datoTerminosRelacionados[t1_cuando].'</dcterms:created>';
		$xmlnodosUF.='		<USE>'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datoTerminosRelacionados[tema_id].'</USE>';
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
if ($datosTermino[cuando_final]) 
{
	$xmlnodoTermino.='	<dcterms:modified>'.$datosTermino[cuando_final].'</dcterms:modified>';
}
$xmlnodoTermino.='</PreferredTerm>';

//Armado del nodo del concepto
$xmlnodo='<ThesaurusConcept dc:identifier="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$datosTermino[idTema].'">';
$xmlnodo.='	<dcterms:created>'.$datosTermino[cuando].'</dcterms:created>';
if ($datosTermino[cuando_final]) 
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
while ($array=mysqli_fetch_array($sql[datos])){
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

if(secure_data($tema,"digit")){

	//Si hay tema_id desde GET o PORS
	$tema_id = ($_POST[tema]) ? $_POST[tema] : $_GET[tema];


	//Si hay tema_id desde algún proceso
	$tema_id = ($tema) ? $tema : $tema_id;
	}

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

elseif(secure_data($_GET[letra],"alnum"))
		{
		$sub_title='; '.MSG_ResultLetra.' '.xmlentities($_REQUEST[letra]);
		$ver_sub_title=' :: '.MENU_ListaAbc.': '.xmlentities($_REQUEST[letra]);
		}


	$meta_tag='<title>'.xmlentities($ver_sub_title.' '.$_SESSION[CFGTitulo]).'</title>';
/*
 * Error en verificación
	$meta_tag.='<meta http-equiv="content-language" content="'.LANG.'" />';
*/
	$meta_tag.='<meta http-equiv="content-type" content="application/xhtml+xml; charset='.$CFG["_CHAR_ENCODE"].'" />';
	$meta_tag.='<meta name="generator" content="'.xmlentities($_SESSION[CFGVersion]).'" />';
	$meta_tag.='<meta name="description" content="'.html2txt($ver_sub_title.$_SESSION[CFGCobertura]).'" />';
	$meta_tag.='<meta name="keywords" content="'.xmlentities($_SESSION[CFGKeywords].$sub_title).'" />';
	$meta_tag.='<meta name="author" content="'.xmlentities($_SESSION[CFGAutor]).'" />';
	$meta_tag.='<meta name="Creation_Date" content="'.$_SESSION[CFGCreacion].'" />';
	$meta_tag.='<meta name="robots" content="index, follow" />';
	$meta_tag.='<meta name="revisit-after" content="15 days" />';

	//$meta_tag.='<!-- Dublin Core -->';
	$meta_tag.='<meta name="DC.Title"        content="'.xmlentities($ver_sub_title.' '.$_SESSION[CFGTitulo]).'" />';
	$meta_tag.='<meta name="DC.Creator"      content="'.xmlentities($_SESSION[CFGAutor]).'" />';
	$meta_tag.='<meta name="DC.Subject"      content="'.xmlentities($_SESSION[CFGKeywords].$sub_title).'" />';
	$meta_tag.='<meta name="DC.Description"  content="'.html2txt($ver_sub_title.$_SESSION[CFGCobertura],true).'" />';
	$meta_tag.='<meta name="DC.Publisher"    content="'.xmlentities($_SESSION[CFGAutor]).'" />';
	$meta_tag.='<meta name="DC.Date"         content="'.$_SESSION[CFGCreacion].'" />';
	$meta_tag.='<meta name="DC.Language"     content="'.LANG.'" />';

	$meta_tag.='<link rel="'.MENU_Inicio.'" href="'.$_SESSION[CFGURL].'index.php" title="'.MENU_Inicio.'" />';
	$meta_tag.='<link rel="'.MENU_ListaSis.'" href="'.$_SESSION[CFGURL].'index.php" title="'.MENU_ListaSis.'" />';
	$meta_tag.='<link rel="'.MENU_ListaAbc.'" href="'.$_SESSION[CFGURL].'index.php?letra=?" title="'.MENU_ListaAbc.'" />';
	$meta_tag.='<link rel="'.MENU_Sobre.'" href="'.$_SESSION[CFGURL].'sobre.php" title="'.MENU_Sobre.'" />';
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


$sql=SQLTerminosValidos($tema_id);

while ($array=mysqli_fetch_array($sql[datos])){
	$row.='<topic id="'.$_URI_BASE_ID.$_URI_SEPARATOR_ID.$array[id].'">';
	$row.='<instanceOf>';
	$row.='<topicRef xlink:href="#term"/>';
	$row.='</instanceOf>';
	$row.='<baseName>';
	$row.='<baseNameString>'.xmlentities($array[tema]).'</baseNameString>';
	$row.='</baseName>';

	$sqlNotas=SQLdatosTerminoNotas($array[id],array("NA"));
	while ($arrayNotas=mysqli_fetch_array($sqlNotas[datos])){
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
	while ($array=mysqli_fetch_array($sql[datos])){
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
	while ($array=mysqli_fetch_array($sql[datos])){
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

?>
