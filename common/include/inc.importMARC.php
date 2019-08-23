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


    if (($_POST['taskAdmin']=='importXML') && (file_exists($_FILES["file"]["tmp_name"]))){
        
        $src_txt= $_FILES["file"]["tmp_name"];


        //tag separator
        $separador=(isset($CFG["IMP_TAG_SEPARATOR"])) ? $CFG["IMP_TAG_SEPARATOR"]: ":";
        //tabulator
        $tabulador=(isset($CFG["IMP_TAG_TABULATOR"])) ? $CFG["IMP_TAG_TABULATOR"]: "===";
        
        $t_relacion='';
        //get for notes tag
        $sqlNotesTag=SQLcantNotas();
        $arrayTiposNotas=array();
        while ($arrayNotesTag=$sqlNotesTag->FetchRow()){
            array_push($arrayTiposNotas, $arrayNotesTag["value_code"]);
        }

        //lang
        $thes_lang=$_SESSION["CFGIdioma"];

        /*
        Procesamiento del file
        */
        $doc = new DOMDocument();
        $doc->load( $src_txt );

        $collection = $doc->getElementsByTagName( "collection" );
        $records = $collection->item(0)->childNodes;

        foreach( $records as $record )
        {
            if($record->nodeName == "#text")
                continue;

            $termo = getTerm($record);
            $termosUF = getUFterms($record);
            $termosRT = getRTterms($record);
            $termosNT = getNTterms($record);
            $termosBT = getBTterms($record);

            //es un término
            if ((strlen($termo)>0)) {

                $term_id=resolveTerm_id($termo);
                $i=++$i;
            }
            
            //adiciona termos UF
            if(count($termosUF) > 0)
            {
                foreach($termosUF as $termoUF)
                {    
                    $UFterm_id=resolveTerm_id($termoUF);
                    ALTArelacionXId($UFterm_id,$term_id,"4");
                }
            }
            
            //adiciona termos RT
            if(count($termosRT) > 0)
            {
                foreach($termosRT as $termoRT)
                {
                    $RTterm_id=resolveTerm_id($termoRT,"1");
                    ALTArelacionXId($term_id,$RTterm_id,"2");
                    ALTArelacionXId($RTterm_id,$term_id,"2");
                }
            }
            
            //adiciona termos NT
            if(count($termosNT) > 0)
            {
                foreach($termosNT as $termoNT)
                {
                    $NTterm_id=resolveTerm_id($termoNT,"1");
                    ALTArelacionXId($term_id,$NTterm_id,"3");
                }
            }
            
            //adiciona termos BT
            if(count($termosBT) > 0)
            {
                foreach($termosBT as $termoBT)
                {
                    $BTterm_id=resolveTerm_id($termoBT,"1");
                    ALTArelacionXId($BTterm_id,$term_id,"3");
                }
            }
        }
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

function getFieldList($record, $nameField)
{
    $fields = $record->childNodes;

    $cont = 0;
    $resultFields = array();
    foreach($fields as $field)
    {
        if($field->nodeName == "#text")
            continue;

        $atributos = $field->attributes;

        foreach($atributos as $atributo)
        {
            if($atributo->textContent == $nameField)
            {    
                $resultFields[$cont++] = $field;
            }
        }
    }
    return $resultFields;
}

function getTerm($record)
{    
    $nameField = "150";
    $termos150 = getFieldList($record, $nameField);

    foreach ($termos150 as $termo150)
    {
        if(hasSubfield($termo150, "a"))
        {
            $sf = getSubfield($termo150, "a");
            if($sf->textContent != "")
            {
                return trim($sf->textContent);
            }
        }
    }
}

function getUFterms($record)
{    
    $nameField = "450";
    $termos450 = getFieldList($record, $nameField);

    $cont = 0;
    $resultFields = array();
    foreach ($termos450 as $termo450)
    {
        if(hasSubfield($termo450, "i"))
        {
            $sf = getSubfield($termo450, "a");
            if($sf->textContent != "")
            {
                $resultFields[$cont++] = trim($sf->textContent);
            }
        }
    }
    return $resultFields;
}

function getRTterms($record)
{
    $nameField = "550";
    $termos550 = getFieldList($record, $nameField);

    $cont = 0;
    $resultFields = array();
    foreach ($termos550 as $termo550)
    {
        if(!hasSubfield($termo550, "w"))
        {
            $sf = getSubfield($termo550, "a");
            if($sf->textContent != "")
            {
                $resultFields[$cont++] = trim($sf->textContent);
            }
        }
    }
    return $resultFields;
}

function getNTterms($record)
{
    $nameField = "550";
    $termos550 = getFieldList($record, $nameField);

    $cont = 0;
    $resultFields = array();
    foreach ($termos550 as $termo550)
    {
        if(hasSubfield($termo550, "w"))
        {
            $subfieldW = getSubfield($termo550, "w");
            if($subfieldW->textContent == "h")
            {
                $sf = getSubfield($termo550, "a");
                if($sf->textContent != "")
                {
                    $resultFields[$cont++] = trim($sf->textContent);
                }
            }
        }
    }
    return $resultFields;
}

function getBTterms($record)
{
    $nameField = "550";
    $termos550 = getFieldList($record, $nameField);

    $cont = 0;
    $resultFields = array();
    foreach ($termos550 as $termo550)
    {
        if(hasSubfield($termo550, "w"))
        {
            $subfieldW = getSubfield($termo550, "w");
            if($subfieldW->textContent == "g")
            {
                $sf = getSubfield($termo550, "a");
                if($sf->textContent != "")
                {
                    $resultFields[$cont++] = trim($sf->textContent);
                }
            }
        }
    }
    return $resultFields;
}

function hasField($record, $field)
{

}

function hasSubfield($field, $subfield)
{
    $subfields = $field->childNodes;

    foreach ($subfields as $sf)
    {
        if($sf->nodeName == "#text")
            continue;

        $atributos = $sf->attributes;
        foreach ($atributos as $at) {
            if($at->textContent == $subfield)
                return true;
        }
    }
    return false;
}

function getSubfield($field, $subfield)
{
    $subfields = $field->childNodes;

    foreach ($subfields as $sf)
    {
        if($sf->nodeName == "#text")
            continue;

        $atributos = $sf->attributes;
        foreach ($atributos as $at) {
            if($at->textContent == $subfield)
                return $sf;
        }
    }
}

?>