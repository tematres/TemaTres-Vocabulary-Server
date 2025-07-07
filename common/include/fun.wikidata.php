<?php
// don't load directly
if ((stristr($_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) {
    die("no access");
}
/**
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2025 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
*/



/**
 * Obtiene los hipónimos (subclases) e instancias de una entidad en Wikidata
 * 
 * Esta función consulta la API de Wikidata para recuperar tanto las subclases (P279)
 * como las instancias (P31) de una entidad específica, devolviendo los resultados
 * en formato estructurado con etiquetas en el idioma solicitado.
 * 
 * @param string $qId El ID de la entidad en Wikidata (ej. "Q5" para humano)
 * @param string $language Código de idioma ISO 639-1 para los resultados (por defecto 'es')
 * @return array Array asociativo con dos claves: 'hiponimos' y 'instancias', cada una conteniendo:
 *               - id: Identificador de la entidad (ej. "Q123")
 *               - label: Etiqueta principal de la entidad en el idioma solicitado
 *               - url: Enlace a la página de Wikidata de la entidad
 * @throws Exception Si ocurre un error en la conexión o procesamiento de datos
 */
function obtenerEntidadesRelacionadasWikidata($pId,$qId, $language = 'es',$limit=20) {
    // Validación del QID de Wikidata
    if (!preg_match('/^Q\d+$/i', $qId)) {
        throw new Exception(LABEL__wikiEntityError);
    }

    // Validación del PID de Wikidata
    if (!preg_match('/^P\d+$/i', $pId)) {
        throw new Exception(LABEL__wikiPropertyError);
    }

 $sparql = '
        SELECT ?item ?itemLabel ?description WHERE {
          ?item wdt:P279 wd:' . $qId . '.
          ?item rdfs:label ?itemLabel.
          FILTER(LANG(?itemLabel) = "' . $language . '")
          
          OPTIONAL {
            ?item schema:description ?description.
            FILTER(LANG(?description) = "' . $language . '")
          }
          
          SERVICE wikibase:label {
            bd:serviceParam wikibase:language "' . $language . '".
          }
        }
        LIMIT ' . (int)$limit;

    $url = 'https://query.wikidata.org/sparql?format=json&query=' . urlencode($sparql);

    $response=getWikidata($url,$language);

    if ($response === false) {
        throw new Exception(ucfirst(LABEL__wikiServiceError));
    }

    $i=0;

    // Procesar datos
    if (isset($response['results']['bindings'])) {
        foreach ($response['results']['bindings'] as $item) {
            $i=++$i;
            $resultado[] = [
                'id' => $i,
                'qid' => basename($item['item']['value']),
                'label' => $item['itemLabel']['value'] ?? '(sin etiqueta)',
                'description' => $item['description']['value'] ?? '(sin descripción)',                
                'url' => $item['item']['value']  // La URL completa ya está en los resultados
            ];
        }
    }

    if($i==0){
        throw new Exception('<h3 class="alert alert-danger" role="alert">'.ucfirst(LABEL__wikiEntity). ' <a href="https://www.wikidata.org/wiki/'.$qId.'" title="'.ucfirst(LABEL_verDetalle).' '.ucfirst(LABEL__wikiEntity). ' '.$qId.'" target="_blank">'. $qId.'</a> ('.strtoupper($language).') + '.ucfirst(LABEL__wikiProperty). ' <a href="https://www.wikidata.org/wiki/Property:'.$pId.'" title="'.ucfirst(LABEL_verDetalle).' '.ucfirst(LABEL__wikiProperty). ' '.$qId.'" target="_blank">'. $pId.'</a>  : <strong>'.$i.'</strong></h3>');

    }

    return $resultado;
};


function obtenerConPropiedad($qId, $propiedad, $language = 'es') {
    $url = 'https://www.wikidata.org/w/api.php?' . http_build_query([
        'action' => 'wbgetentities',
        'ids' => $qId,
        'props' => 'claims',
        'format' => 'json',
        'languages' => $language
    ]);

    $response = file_get_contents($url);
    $data = json_decode($response, true);
}

/**
 * Busca sinonimos en Wikidata en un idioma especificado
 * 
 * @param string $searchText Texto a buscar (ej. "amor")
 * @param string $language Código de idioma ISO 639-1 (ej. "es", "en", "fr")
 * @return array Array con conceptos que tienen TODOS los campos en el idioma solicitado
 * @throws Exception Si hay error en la consulta o idioma no válido
 */
function obtenerSinonimosWikidata($qId, $language = 'es') {

    // Validación del QID de Wikidata
    if (!preg_match('/^Q\d+$/i', $qId)) {
        throw new Exception(LABEL__wikiEntityError);
    }

    $url = 'https://www.wikidata.org/w/api.php?' . http_build_query([
        'action' => 'wbgetentities',
        'ids' => $qId,
        'props' => 'aliases',
        'languages' => $language,
        'format' => 'json'
    ]);

    $datos=getWikidata($url,$language);

    if ($datos === false) {
        throw new Exception(ucfirst(LABEL__wikiServiceError));
    }

    // Procesar los aliases
    $aliases = [];
    if (isset($datos['entities'][$qId]['aliases'][$language])) {
        foreach ($datos['entities'][$qId]['aliases'][$language] as $alias) {
            $i=++$i;
            $aliases[] = [
                'id' => $i,
                'qid' => $qId,
                'label' => $alias['value'],
                'language' => $alias['language'],
                'description' => $alias['additions']['P31'][0] ?? null // Tipo de alias si existe
            ];
        }

    }else{
        throw new Exception('<h3 class="alert alert-danger" role="alert">'.ucfirst(LABEL__wikiEntity).' <i><a href="https://www.wikidata.org/wiki/'.$qId.'" title="'.ucfirst(LABEL_verDetalle).' '.$qId.'" target="_blank">'.$qId.'</a></i>  ('.strtoupper($language).') + '.ucfirst(UP_termino).' : <strong>0</strong></h3>');
    }


    return $aliases;
}


/** 
 * Busca conceptos en Wikidata devolviendo SOLO resultados en el idioma especificado
 * 
 * @param string $searchText Texto a buscar (ej. "amor")
 * @param string $language Código de idioma ISO 639-1 (ej. "es", "en", "fr")
 * @param int $limit Límite máximo de resultados (por defecto 10)
 * @return array Array con conceptos que tienen TODOS los campos en el idioma solicitado
 * @throws Exception Si hay error en la consulta o idioma no válido
 */
function buscarConceptosEnWikidataSoloIdioma($searchText, $language = 'es', $limit = 20) {

    $searchText=XSSprevent(trim($searchText));
    // Validaciones iniciales
    if (empty($searchText)) {
        return false;
        throw new Exception(ucfirst(sprintf(MSG_minCharSerarch, stripslashes($searchText), strlen($searchText), CFG_MIN_SEARCH_SIZE-1)));
    }

    $language = strtolower($language);
    
    // Configuración de la solicitud a la API
    $url = 'https://www.wikidata.org/w/api.php?' . http_build_query([
        'action' => 'wbsearchentities',
        'search' => $searchText,
        'language' => $language,
        'uselang' => $language,
        'strictlanguage' => true, // Fuerza el uso estricto del idioma
        'limit' => min($limit, 50), // Wikidata tiene un máximo de 50 por consulta
        'format' => 'json',
    ]);

    
    $datos=getWikidata($url,$language);


    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception(ucfirst(LABEL__ParserError));
    }

    // Filtrar resultados que no cumplan con el idioma requerido
    $resultadosFiltrados = [];
    
    if (isset($datos['search'])) {

        if(count($datos['search'])===0){
            throw new Exception('<h3 class="alert alert-danger" role="alert">'.ucfirst(LABEL__wikiEntity).' "<i>' . $searchText.'</i>"  ('.strtoupper($language).'): '.ucfirst(LABEL__noResult). '. </h3>');
        }

        foreach ($datos['search'] as $item) {
                $resultadosFiltrados[] = [
                    'id' => $item['id'],
                    'titulo' => $item['label'],
                    'descripcion' => $item['description'],
                    'aliases' => array_filter($item['aliases'] ?? [], function($alias) use ($language) {
                        return !isset($alias['language']) || $alias['language'] === $language;
                    }),
                    'url' => "https://www.wikidata.org/wiki/{$item['id']}",
                    'idioma_confirmado' => $language,
                    'coincidencia_exacta' => $item['match']['type'] ?? null
                ];
            
            
            // Detener si alcanzamos el límite
            if (count($resultadosFiltrados) >= $limit) {
                break;
            }

        }     
    }

    return $resultadosFiltrados;
}



/**
 * Presenta los resultados de buscar conceptos en Wikidata con control preciso del idioma del label
 * 
 * @param array Array con conceptos encontrados, asegurando labels en el idioma solicitado
 * @return string $html contenido HTML de resultados
 * @throws Exception Si hay error en la consulta o idioma no válido
 */
function HTMLwikidataTerm($resultados){
    // Procesar los resultados con verificación de idioma
    //$resultados = [];
    if (empty($resultados)) {
        echo "No se encontraron resultados en $idiomaRequerido para '$termino'";
    } else {
        foreach ($resultados as $item) {
            echo "• {$item['titulo']} ({$item['id']})\n<br>";
            echo "  Descripción: {$item['descripcion']}\n<br>";
            echo "  Aliases: " . implode(', ', array_column($item['aliases'], 'value')) . "\n<br>";
            echo "  URL: {$item['url']}\n<br>";
            echo "  Idioma confirmado: {$item['idioma_confirmado']}\n\n<hr>";
        }
    }
}




/*
* Form for edit or add terms
1 caso:
- Alta de un término nuevo.
*
*/
function HTMLformSuggestTerms4Wikidata($string2search='')
{
    global $CFG;
    $string2search = XSSprevent(trim($string2search));

    //SEND_KEY to prevent duplicated
    session_start();
    $_SESSION['SEND_KEY']=md5(uniqid(rand(), true));


    $rows='<div class="container" id="bodyText">';
    $rows.='<a class="topOfPage" href="'.URL_BASE.'index.php?taskterm=addTerm" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';

    $rows.='<form class="" role="form" name="alta_tt" id="alta_tt" action="index.php#suggestResult" method="get">';
    $rows.='    <div class="row">
    <!-- panel  -->
    <div class="col-lg-10">
        <h3>'.ucfirst(LABEL__getForWikidataTerms).'</h3>
        <div class="panel panel-default">
            <div class="panel-body form-horizontal">
                <div class="form-group">
                    <label for="string2search" class="col-sm-3 control-label">'.ucfirst(LABEL_Buscar).'</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" required autofocus type="search" id="string2search" name="string2search" value="">
                    </div>
                </div>';
            
    $rows.='    <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?taskterm=addTerm&tema=0\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                        <button type="submit" class="btn btn-primary" value="'.LABEL_Buscar.'"/>'.ucfirst(LABEL_Buscar).'</button>

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / panel  -->';
    $rows.='<input type="hidden" name="taskterm" value="getWikidataTerm"/>';
    $rows.='</form>';

    $rows.='   </div>';//container

    return $rows;
}




function HTMLformSelectTerms4Wikidata($string_search,$resultados)
{
    global $CFG;
    //SEND_KEY to prevent duplicated
    session_start();
    $_SESSION['SEND_KEY']=md5(uniqid(rand(), true));


    $flag_allow_duplicated=($_SESSION[$_SESSION["CFGURL"]]["CFG_ALLOW_DUPLICATED"]==1) ?  1 : 0;


    $rows.='<form role="form" name="select_multi_term" action="index.php" method="post">';
    $rows.='    <div class="row">
        <div class="col-lg-10">
            <legend class="alert alert-info">'.ucfirst(MSG_ResultBusca).' <i>'.$string_search.'</i></legend>
        </div>
        <!-- panel  -->
        <div class="col-lg-10">
            <div class="panel panel-default">
                <div class="panel-body form-horizontal">';
    $rows.='<div><input id="filter" type="text" class="form-control" placeholder="'.ucfirst(LABEL_type2filter).'"></div>';
    $rows.='<div class="table-responsive"> ';
    $rows.='<table class="table table-striped table-bordered table-condensed table-hover">
    <thead>
    <tr>
        <th  class="text-center"><input name="checktodos" type="checkbox" title="'.LABEL_selectAll.'"/></th>
        <th>'.ucfirst(LABEL_Termino).'</th>
        <th>'.ucfirst(LABEL_nota).'</th>
    </tr>
    </thead>
    <tbody class="searchable">';

    foreach ($resultados as $item) {
      

            //check for duplicated term
            $SQLcheck_term=SQLbuscaExacta($item['titulo']);
            $is_duplicated=(SQLcount($SQLcheck_term)>0) ? true : false;
            $rows.= '<tr>';

            //duplicated term & allowed duplicated
            if (($is_duplicated) && ($flag_allow_duplicated==1)) {
                $rows.=  '      <td align="center"><input type="checkbox" name="selectedTerms[]" id="tterm_'.$item['id'].'" title="'.$item['titulo'].'" value="'.$item['titulo'].'|'.$item["id"].'" /> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['titulo'].'" for="tterm_'.$item['id'].'">'.$item['titulo'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['id'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['id'].'</a>]</span>  <span style="color:red">'.LABEL_terminoExistente.'</span></label></td>';
                $rows.=  '      <td>'.$item['descripcion'].'</td>';
            //duplicated term & nos allowed d
            } elseif (($is_duplicated) && ($flag_allow_duplicated==0)) {
                $rows.=  '      <td align="center"> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['titulo'].'" for="tterm_'.$item['id'].'">'.$item['titulo'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['id'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['id'].'</a>]</span>  <span style="color:red">'.LABEL_terminoExistente.'</span></label></td>';
                $rows.=  '      <td>'.$item['descripcion'].'</td>';
            } else {
                $rows.=  '      <td align="center"><input type="checkbox" name="selectedTerms[]" id="tterm_'.$item['id'].'" title="'.$item['titulo'].'" value="'.$item['titulo'].'|'.$item['id'].'" /> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['titulo'].'" for="tterm_'.$item['id'].'">'.$item['titulo'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['id'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['id'].'</a>]</span>  </label></td>';
                $rows.=  '      <td>'.$item['descripcion'].'</td>';
            }
            $rows.=  '</tr>';
        };
        $rows.='        </tbody>        </table>';
        $rows.='        </div>';

        $rows.='    <div class="form-group">
                <div class="col-sm-12 text-center">
                 <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                <button type="submit" class="btn btn-primary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
                </div>
        </div>
    </div>
    </div>
    </div> <!-- / panel  -->';
        $rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
        $rows.='<input type="hidden" id="taskterm" name="taskterm" value="addSuggestedWikiTerms"/>';
        $rows.='</form>';


    return $rows;
}






function HTMLformSuggestedTermsFromWikidata($ARRAYtermino,$t_relation,$p_relation,$q_entity,$resultados)
{
    global $CFG;
    //SEND_KEY to prevent duplicated
    session_start();
    $_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

    if(!is_array($resultados)){
        return '<div class="col-lg-10">
            <legend class="alert alert-danger">'.ucfirst(LABEL__noResult).': <i>"' . arrayReplace(array(2,3,4), array(TR_termino,TE_termino,UP_termino), $t_relation).'"</i> (<a href="https://www.wikidata.org/wiki/Property:'.$p_relation.'" title="'.ucfirst(LABEL_verDetalle).' '.$p_relation.'" target="_blank">'.$p_relation.'</a>) '.LABEL__wikiEntity.' <i>"'.$ARRAYtermino["titTema"].'"</i> (<a href="https://www.wikidata.org/wiki/'.$q_entity.'" title="'.ucfirst(LABEL_verDetalle).' '.$q_entity.'" target="_blank">'.$q_entity.'</a>)</legend>
        </div>';
    } ;

    
    $flag_allow_duplicated=($_SESSION[$_SESSION["CFGURL"]]["CFG_ALLOW_DUPLICATED"]==1) ?  1 : 0;

    $rows='<form role="form" name="select_multi_term" action="index.php" method="post">';
    $rows.='    <div class="row">
        <div class="col-lg-10">
            <legend class="alert alert-info">'.ucfirst(LABEL_results).':  <i>"' . arrayReplace(array(2,3,4), array(TR_termino,TE_termino,UP_termino), $t_relation).'"</i> (<a href="https://www.wikidata.org/wiki/Property:'.$p_relation.'" title="'.ucfirst(LABEL_verDetalle).' '.$p_relation.'" target="_blank">'.$p_relation.'</a>) '.LABEL__wikiEntity.' <i>"'.$ARRAYtermino["titTema"].'"</i> (<a href="https://www.wikidata.org/wiki/'.$q_entity.'" title="'.ucfirst(LABEL_verDetalle).' '.$q_entity.'" target="_blank">'.$q_entity.'</a>)</legend>
        </div>



        <!-- panel  -->
        <div class="col-lg-10">
            <div class="panel panel-default">
                <div class="panel-body form-horizontal">';
    $rows.='<div class="table-responsive"> ';
    $rows.='<table class="table table-striped table-bordered table-condensed table-hover">
    <thead>
    <tr>
        <th class="text-center"></th>
        <th>'.ucfirst(LABEL_Termino).'</th>
        <th>'.ucfirst(LABEL_nota).'</th>
    </tr>
    </thead>
    <tbody class="searchable">';
    foreach ($resultados as $item) {
            //check for duplicated term
            $SQLcheck_term=SQLbuscaExacta($item['label']);
            $is_duplicated=(SQLcount($SQLcheck_term)>0) ? true : false;
            $rows.= '<tr>';

            //duplicated term & allowed duplicated
            if (($is_duplicated) && ($flag_allow_duplicated==1)) {
                $rows.=  '      <td align="center"><input type="checkbox" name="selectedTerms[]" id="tterm_'.$item['id'].'" title="'.$item['label'].'" value="'.$item['label'].'|'.$item["qid"].'" /> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['label'].'" for="tterm_'.$item['id'].'">'.$item['label'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['qid'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['qid'].'</a>]</span>  <span style="color:red">'.LABEL_terminoExistente.'</span></label></td>';
                $rows.=  '      <td>'.$item['description'].'</td>';
            //duplicated term & nos allowed d
            } elseif (($is_duplicated) && ($flag_allow_duplicated==0)) {
                $rows.=  '      <td align="center"> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['label'].'" for="tterm_'.$item['id'].'">'.$item['label'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['qid'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['qid'].'</a>]</span>  <span style="color:red">'.LABEL_terminoExistente.'</span></label></td>';
                $rows.=  '      <td>'.$item['description'].'</td>';
            } else {
                $rows.=  '      <td align="center"><input type="checkbox" name="selectedTerms[]" id="tterm_'.$item['id'].'" title="'.$item['label'].'" value="'.$item['label'].'|'.$item['qid'].'" /> </td>';

                $rows.=  '      <td><label class="check_label" title="'.$item['label'].'" for="tterm_'.$item['id'].'">'.$item['label'].' <span style="font-weight:normal;">[<a href="https://www.wikidata.org/wiki/'.$item['qid'].'" title="'.ucfirst(LABEL_verDetalle).' '.$item['id'].'" target="_blank">'.$item['qid'].'</a>]</span>  </label></td>';
                $rows.=  '      <td>'.$item['description'].'</td>';
            }
            $rows.=  '</tr>';
        };
        $rows.='        </tbody>        </table>';
        $rows.='        </div>';

        $rows.='    <div class="form-group">
                <div class="col-sm-12 text-center">
                 <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                <button type="submit" class="btn btn-primary" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>
                </div>
        </div>
    </div>
    </div>
    </div> <!-- / panel  -->';
        $rows.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';
        $rows.='<input type="hidden" id="taskterm" name="taskterm" value="addSuggestedWikiRelatedTerms"/>';
        $rows.='<input type="hidden" name="tema" value="'.$ARRAYtermino["idTema"].'"/>';
        $rows.='<input type="hidden" id="t_relation" name="t_relation" value="'.$t_relation.'"/>';
        //$rows.='<input type="hidden" id="taskterm" name="taskterm" value="addSuggestedTerms"/>';
        $rows.='</form>';


    return $rows;
}


function getWikidata($url,$language="es"){
     $opcionesHTTP = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: WikidataStrictLanguageSearch/1.0 (+https://example.com)\r\n" .
                        "Accept-Language: $language\r\n"
        ]
    ];
   
    $contexto = stream_context_create($opcionesHTTP);
    $respuesta = file_get_contents($url, false, $contexto);


    if ($respuesta === false) {
        throw new Exception(LABEL__wikiConnectionError);
    }

    $datos = json_decode($respuesta, true);


    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception(LABEL__ParserError);
    }    

    return $datos;

}



function HTMLformSuggestWikidataTermsXrelations($ARRAYtermino=array(),$wikidata_terms=array(),$t_relation="",$selected_q="")
{
    //SEND_KEY to prevent duplicated
session_start();

$_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

$t_relation=secure_data($t_relation,"int");

#Redacción del dropdown
foreach ($wikidata_terms as $item) {
    $array_qIds[].=$item["id"].'#'.$item["titulo"].' ('.$item["id"].'): '.$item["descripcion"];
}

$selected_q=XSSprevent($selected_q);

//Configurar opcion búsqueda por código
$arrayOptions= array('3#'.ucfirst(TE_termino),'4#'.ucfirst(UP_termino),'2#'.ucfirst(TR_termino));
    
$rows='<div class="container" id="bodyText">';
$rows.='<a class="topOfPage" href="'.URL_BASE.'index.php?tema='.$ARRAYtermino["idTema"].'" title="'.LABEL_Anterior.'">'.LABEL_Anterior.'</a>';
$rows.='<h3>'.HTMLlinkTerm(array("tema_id"=>$ARRAYtermino["idTema"],"tema"=>$ARRAYtermino["titTema"])).'</h3>';



    $rows.='<form class="" role="form" name="alta_tt" id="alta_tt" action="index.php#suggestResult" method="get">';
    $rows.='    <div class="row">
    <div class="col-sm-12">
        <legend>'.ucfirst(LABEL__getForRecomendationWiki).'</legend>
    </div>
    <!-- panel  -->
    <div class="col-lg-7">
        <h4>'.ucfirst(LABEL__wikiSearch).'</h4>
        <div class="panel panel-default">
            <div class="panel-body form-horizontal">
                            <div class="form-group">
                            <label for="tvocab_id" class="col-sm-3 control-label">'.ucfirst(LABEL__wikiEntity).'</label>
                                    <div class="col-sm-9">
                                            <select class="form-control" id="q_id" name="q_id">
                                            '.doSelectForm($array_qIds, $selected_q).'
                                            </select>
                                    </div>
                            </div>
                            <div class="form-group">
                            <label for="t_relation" class="col-sm-3 control-label">'.ucfirst(LABEL_relationSubType).'</label>
                                    <div class="col-sm-9">
                                            <select class="form-control" id="t_relation" name="t_relation">
                                            '.doSelectForm($arrayOptions, $t_relation).'
                                            </select>
                                    </div>
                            </div>
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                                              <button type="button" class="btn btn" name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYtermino["idTema"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>
                                             <button type="submit" class="btn btn-primary" value="'.LABEL_Buscar.'"/>'.ucfirst(LABEL_Buscar).'</button>

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / panel  -->';
    $rows.='<input type="hidden" name="tema" value="'.$ARRAYtermino["idTema"].'"/>';

    $rows.='<input type="hidden" name="searchType" id="searchType" value="1" />';
    $rows.='<input type="hidden" name="taskterm" value="getWikidataRelTerm"/>';
    $rows.='</form>';

    $rows.='</div>';

$rows.='   </div>';

return $rows;
}