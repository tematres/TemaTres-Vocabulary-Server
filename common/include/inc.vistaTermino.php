<?php
if ((stristr($_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) {
    die("no access");
}
// TemaTres : aplicación para la gestión de lenguajes documentales #       #
//
// Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
//
//
// Include para seleccionar include o función de formulario de edición

//array de acciones posibles para asociar términos
$arrayTaskExistTerms=array("addBT","addRT","addFreeUF","addFreeNT");

$evalUserLevel=evalUserLevel($_SESSION[$_SESSION["CFGURL"]]);
//verificar que hay datos de un termino y que hubiera session
if ($evalUserLevel>0) {
    switch ($_GET["taskterm"]) {
        case 'addBT':
            echo HTMLformAssociateExistTerms($_GET["taskterm"], $metadata["arraydata"], $term_id);
            break;

        case 'addRT':
            echo HTMLformAssociateExistTerms($_GET["taskterm"], $metadata["arraydata"], $term_id);
            break;

        case 'addFreeUF':
            echo HTMLformAssociateExistTerms($_GET["taskterm"], $metadata["arraydata"], $term_id);
            break;

        case 'addFreeNT':
            echo HTMLformAssociateExistTerms($_GET["taskterm"], $metadata["arraydata"], $term_id);
            break;

        case 'addEQ':
            echo HTMLformAltaEquivalenciaTermino(ARRAYverDatosTermino($tema));
            break;

        case 'editNote':
            include_once T3_ABSPATH . 'common/include/inc.abmNota.php';
            break;

        case 'addNT':
            echo HTMLformEditTerms($_GET["taskterm"], $metadata["arraydata"]);
            break;

        case 'addUF':
            echo HTMLformEditTerms($_GET["taskterm"], $metadata["arraydata"]);
            break;

        case 'addTerm':
            echo HTMLformEditTerms($_GET["taskterm"], $metadata["arraydata"]);
            break;


        case 'addRTnw':
            echo HTMLformEditTerms($_GET["taskterm"], $metadata["arraydata"]);
            break;

        case 'editTerm':
            echo HTMLformEditTerms($_GET["taskterm"], $metadata["arraydata"]);
            break;

        case 'findTargetTerm':
            echo HTMLformAssociateTargetTerms($metadata["arraydata"]);
            break;

        case 'findSuggestionTargetTerm':
            echo HTMLformSuggestTermsXRelations($metadata["arraydata"]);
            break;

        case 'addTermSuggested':
            echo HTMLformSuggestTerms($metadata["arraydata"]);
            break;
        case 'findTermNews':
            echo HTMLformTermsNews($_GET["tvocab_id"]);
            break;

        case 'addURI':
            echo HTMLformURI4term($metadata["arraydata"]);
            break;

        case 'getWikidataTerm':
            require_once T3_ABSPATH . 'common/include/fun.wikidata.php'; 

            $searchText=array2value("string2search", $_GET);

            /*entidades en wikidata*/
            echo HTMLformSuggestTerms4Wikidata($searchText);
            try {
               
                $term_data=buscarConceptosEnWikidataSoloIdioma($searchText, $language = $_SESSION["CFGIdioma"], $limit = 10);

                /*Buscar términos para incorporar en base a texto*/
                if(is_array($term_data)){
                    echo HTMLformSelectTerms4Wikidata($searchText,$term_data);
                    }
                
            } catch (Exception $e) {
                echo $e->getMessage();
            }


            break;


        case 'getWikidataRelTerm':
            require_once T3_ABSPATH . 'common/include/fun.wikidata.php'; 
            try {               
                $wikidata_terms=buscarConceptosEnWikidataSoloIdioma($metadata["arraydata"]["titTema"], $language = $_SESSION["CFGIdioma"], $limit = 10);
            
            //Buscar términos para incorporar en base a relaciones
            $qId=array2value("q_id", $_GET);
            $t_relation=array2value("t_relation", $_GET);
            echo HTMLformSuggestWikidataTermsXrelations($metadata["arraydata"],$wikidata_terms,$t_relation,$qId);


            } catch (Exception $e) {
                echo '[ <a class="topOfPage" href="'.URL_BASE.'index.php?tema='.$metadata["arraydata"]["idTema"].'" title="'.$metadata["arraydata"]["titTema"].'">'.ucfirst(LABEL_Anterior).'</a> ]' . $e->getMessage();
            }




            try {
                switch ($t_relation) {
                    case '2':
                        // RT code...
                        /*
                        P5972 (término relacionado): Para términos estrechamente relacionados
                        P1709 (término equivalente en un vocabulario controlado)
                        P460 (igual que) - Para equivalencias
                        */
                        $pId="P1659";
                        try {
                            // Obtener hipónimos e instancias de "Ser humano" (Q5) en español
                            $terms = obtenerEntidadesRelacionadasWikidata($pId, $qId, $language=$_SESSION["CFGIdioma"]);
             
                        echo HTMLformSuggestedTermsFromWikidata($metadata["arraydata"],$t_relation,$pId,$qId,$terms);

                        } catch (Exception $e) {
                            echo  $e->getMessage();
                        }                        

                        break;
                    case '3':
                        // NT code...
                        /*
                        P279 (subclase de) - Para jerarquías conceptuales
                        P31 (instancia de) - Para clasificación
                        P279 (parte de) - Para sistemas conceptuales
                        */

                        $pId="P31";
                        try {
                            // Obtener hipónimos e instancias de "Ser humano" (Q5) en español
                            $terms = obtenerEntidadesRelacionadasWikidata($pId, $qId, $language=$_SESSION["CFGIdioma"]);
             
                        echo HTMLformSuggestedTermsFromWikidata($metadata["arraydata"],$t_relation,$pId,$qId,$terms);
                        } catch (Exception $e) {
                            echo  $e->getMessage();
                        }                        


                        break;
                    case '4':
                        try {
                            // Obtener sinonimos 
                            $terms=obtenerSinonimosWikidata($qId, $language=$_SESSION["CFGIdioma"]);                        

                            echo HTMLformSuggestedTermsFromWikidata($metadata["arraydata"],$t_relation,"P460",$qId,$terms);
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }                        
                       break;
                    
                    default:
                        // code...
                        break;
                }

                

                } catch (Exception $e) {
                    echo $e->getMessage();    
                }    
            break;

        default:
            echo HTMLbodyTermino($metadata["arraydata"]);
    }
} elseif ($metadata["arraydata"]) {
    echo HTMLbodyTermino($metadata["arraydata"]);
}
