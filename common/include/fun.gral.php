<?php
if ((stristr($_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) {
    die("no access");
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* TemaTres : aplicación para la gestión de lenguajes documentales #       #

// Copyright (C) 2004-2023 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
*/

/** FUNCIONES GENERALES */

/** addslashes to vars
Funcion tomada de PHPBB: http://www.phpbb.com/
*/
$_GET=XSSpreventArray($_GET);

function PHP_magic_quotes()
{

    if (is_array($_GET)) {
        while (list($k, $v) = each($_GET)) {
            if (is_array($_GET[$k])) {
                while (list($k2, $v2) = each($_GET[$k])) {
                    $_GET[$k][$k2] = addslashes($v2);
                }
                    @reset($_GET[$k]);
            } else {
                    $_GET[$k] = addslashes($v);
            }
        }
            @reset($_GET);
    }

    if (is_array($_POST)) {
        while (list($k, $v) = each($_POST)) {
            if (is_array($_POST[$k])) {
                while (list($k2, $v2) = each($_POST[$k])) {
                    $_POST[$k][$k2] = addslashes($v2);
                }
                    @reset($_POST[$k]);
            } else {
                    $_POST[$k] = addslashes($v);
            }
        }
            @reset($_POST);
    }

    if (is_array($HTTP_COOKIE_VARS)) {
        while (list($k, $v) = each($HTTP_COOKIE_VARS)) {
            if (is_array($HTTP_COOKIE_VARS[$k])) {
                while (list($k2, $v2) = each($HTTP_COOKIE_VARS[$k])) {
                    $HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
                }
                    @reset($HTTP_COOKIE_VARS[$k]);
            } else {
                    $HTTP_COOKIE_VARS[$k] = addslashes($v);
            }
        }
            @reset($HTTP_COOKIE_VARS);
    }
}

TrimArray($_GET);
TrimArray($_POST);




//
// Concatena nombrs y variables de GET
//
function doValFromGET()
{
    $keys_get = array_keys($_GET);

    foreach ($keys_get as $key_get) {
        if ($key_get!=='setLang') {
            $i=++$i;
            $$key_get = $_GET[$key_get];
        }
    }
    if ($i) {
        return '&amp;'.$key_get.'='.$$key_get;
    };
}

function TrimArray(&$array)
{
    foreach ($array as $k => $v) {
        global $$k;
        if (is_array($$k)) {
            foreach ($$k as $k2 => $v2) {
                  $$k[$k2] = $v2;
            }
        } else {
            $$k = $v;
        }

        /* Re-assign back to array. */
        $array[$k] = $$k;
    }
};



// Seleccionar un valor del array
function doValue($array, $nombreValor)
{
    if (!is_array($array)) {
        return false;
    }
  
    if (count($array)>'0') {
        return @$array[$nombreValor];
    }
        
    return false;
};


//
// FUNCIONES DE PARSEO         ###############################
//

//
// Revisa un check de un form
//
function do_check($campo, $value, $tipo)
{
    if ($campo==$value) {
        return $tipo;
    }
};


//
// Arma un array con una fecha
//
function do_fecha($fecha)
{
    global $MONTHS;
    $array=array(
                    "min"=>date("i", strtotime($fecha)),
                    "hora"=>date("G", strtotime($fecha)),
                "dia"=>date("d", strtotime($fecha)),
                "mes"=>date("m", strtotime($fecha)),
                        "descMes"=>$MONTHS[date("m", strtotime($fecha))],
                "ano"=>date("Y", strtotime($fecha))
          );
    return $array;
}



//
// Arma un intervalo de n�meros o meses
//
function do_intervalDate($inicio, $fin, $tipo)
{
    $listInterval='';
    for ($interval="$inicio"; $interval<="$fin"; ++$interval) {
        if ($tipo=='MES') {
            $meses=array("1"=>Ene,
                "2"=>Feb,
                "3"=>Mar,
                "4"=>Abr,
                "5"=>May,
                "6"=>Jun,
                "7"=>Jul,
                "8"=>Ago,
                "9"=>Sep,
                "10"=>Oct,
                "11"=>Nov,
                "12"=>Dic,
                );
            $listInterval.=$interval.'#'.$meses[$interval].'&';
        } else {
            $listInterval.=$interval.'#'.$interval.'&';
        };
    };
    $listToform=substr("$listInterval", 0, -1);
    $listToform=explode("&", $listInterval);
    return $listToform;
};


//
// Arma un select form a partir de un Array
//
function doSelectForm($valores, $valor_selec)
{
    if (!is_array($valores)) {
        return ;
    }
    $selec_values='';
    for ($i=0; $i<sizeof($valores); ++$i) {
        $valor=explode("#", $valores[$i]);
        if ($valor[0]) {
            if ($valor[0]==$valor_selec) {
                $selec_values.='<option value="'.$valor[0].'" selected>'.$valor[1].'</option>'."\n\r";
            } else {
                $selec_values.='<option value="'.$valor[0].'">'.$valor[1].'</option>'."\n\r";
            };
        };
    };
    return $selec_values;
};


//
// Arma un select form a partir de un SQL
//

function SqlSelectForm($sql)
{
    $sqlDos=SQL("select", "$sql");
    $array='';
    while ($cons=$sqlDos->FetchRow()) {
        $array.=$cons[0].'#'.$cons[1].'&';
    };
          $array=substr("$array", 0, -1);
          $array=explode("&", $array);

    return $array;
}


//
// Abre y cierra un c�digo html
//
function doListaTag($i, $tag, $contenidoTag, $id = "", $class = "")
{
    $rows='';
    $class=(strlen((string) $class)>0) ? ' class="'.$class.'" ' : '';
    if ($i>0) {
        if (@$id) {
            $idTag=' id="'.$id.'"';
        };
        $rows='<'.$tag.$idTag.$class.'>'.$contenidoTag.'</'.$tag.'>';
    }

    return $rows;
};

//
// Empaqueta salida y envia por Header como attach
// Basada en clase PHP ExcelGen Class de (c) Erh-Wen,Kuo (erhwenkuo@yahoo.com).
function sendFile($input, $filename)
{
                header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                header("Pragma: no-cache");
                header("Content-type: application/octet-stream; name=$filename");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Description: Zthes tesauro");
                print $input;
}



//sql 2 CSV and send as attach
//based on http://www.phpclasses.org/browse/file/16237.html
function sql2csv($sql, $filename, $encode = "utf8")
{
    $res = $sql;
    $colnames = array();

    // get column captions and enclose them in doublequotes (")
    for ($i = 0; $i < $res->FieldCount(); $i++) {
        $fld = $res->FetchField($i);
        $colnames[] = '"'.$fld->name.'"';
    }

    // insert column captions at the beginning of .csv file
    //replace some colnames
    $CSV .= str_replace(array("tema_id","cuando","tema","date_estado"), array("internal_term_id","date","term","date_status"), implode(";", $colnames));

    // iterate through each row
    // replace single double-quotes with double double-quotes
    // and add values to .csv file contents
    if (SQLcount($res)>0) {
        $CSV.="\n";
        while ($array = $res->FetchRow()) {
            //for ($i = 0; $i < sizeof($row); $i++) {
            for ($i = 0; $i < $res->FieldCount(); $i++) {
                  $array[$i] = '"'.str_replace('"', '""', $array[$i]).'"';
                  $CSV.= $array[$i].";";
            }

            $CSV.="\n";
        }
    }

    // send output to browser as attachment (force to download file
    header('Expires: Mon, 1 Jan 1990 00:00:00 GMT');
    header('Last-Modified: '.gmdate("D,d M Y H:i:s").' GMT');
    header('Pragma: no-cache');
    header('Content-Disposition: attachment; filename='.$filename);

    // print the final contents of .csv file
    print ($encode=='latin1') ? latin1($CSV) : utf8($CSV);
}


//From TematresView by Nicolas Poulain
function secure_data($data, $type = "alnum")
{

    switch ($type) {
        case "alnum":
            // suppression des caracteres pas catholiques
            $data = preg_replace('/^\W+|\W+$/', '', $data);
            $data = preg_replace('/\s/', '', $data);
            break ;

        case "alpha":
            // suppression des caracteres pas catholiques
             $data = preg_replace('/^\W+|\W+$/', '', $data);
            $data = arrayReplace(array("0","1","2","3","4","5","6","7","8","9"), array(""), $data);
            $data = preg_replace('/\s/', '', $data);
            break ;


        case "ADOsql":
            global $DB;
            $data = trim((string) $data);
            $data=$DB->qstr($data);
            break ;


        case "sql":
            $data = trim((string) $data);
            // vire les balises
            $data = strip_tags($data);

            if (is_numeric($data)  || $data === null) {
                return $data;
            }
            $data = str_replace("''", "'", $data);

            $data = stripslashes($data);

            $data= addslashes($data);
            break ;

        case "sqlhtml":
            //SQL secure with HTML tags
                $data = str_replace("''", "'", (string) $data);
                $data = stripslashes($data);
            $data = trim((string) $data);
            break ;

        case "int": // int
            $data =(int) preg_replace('|[^0-9.]|i', '',(int) $data);

            if ($data == "") {
                $data = 0 ;
            }
            break ;

        default: // int
            $data =(int) preg_replace('|[^0-9.]|i', '',(int) $data);

            if ($data == "") {
                $data = 0 ;
            }
            break ;
    }
    return $data ;
}




function is_alpha($inStr)
{
    return (preg_match("/^[a-zA-Z]+$/", $inStr) != 0);
}


function is_alpha_numeric($inStr)
{
    return (preg_match("/^[a-zA-Z0-9]+$/", $inStr) != 0);
}


// XML Entity Mandatory Escape Characters or CDATA
function xmlentities($string, $pcdata = false)
{
    if ($pcdata == true) {
        return  '<![CDATA[ '.str_replace(array ('[[',']]' ), array ('',''), $string).' ]]>';
    } else {
        return str_replace(array ( '&', '"', "'", '<', '>','[[',']]' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;','',''), $string);
    }
}

//Reemplaza un valor de una matriz por otro
function arrayReplace($arrayInicio, $arrayFinal, $string)
{
    return str_replace($arrayInicio, $arrayFinal, $string);
}



//
function prepare2sqlregexp($string)
{
    $arrayPossibleSpecialChar=array('a','e','i','o','u','c','y','n');
    $arraySpecialChar=array('[a������]','[c�]','[o������]','[e����]','[i����]','[u����]','[y��]','[n�]');

    return str_replace($arrayPossibleSpecialChar, $arraySpecialChar, $string);
}


// string 2 URL legible
function string2url($string)
{
    include_once 'URLify.php';
    return URLify::filter($string);
}

//This function is a part of DAlbum.  Copyright (c) 2003 Alexei Shamov, DeltaX Inc.
// replace <BR> with /n for text mode
function br2nl($text)
{
    return preg_replace("/<br[\s\/]*>/i", "\n", $text, -1);
}

//This function is a part of DAlbum.  Copyright (c) 2003 Alexei Shamov, DeltaX Inc.
// convert html to text
function html2txt($html)
{
    //$ret = strtr($html, array_flip(get_html_translation_table(HTML_ENTITIES)));
    $ret = strtr($html, array_flip(get_html_translation_table()));
    $ret = strip_tags(br2nl($ret));
    $ret = str_replace(array ('[[',']]' ), array ('',''), $ret);

    include_once 'htmlpurifier/HTMLPurifier.auto.php';

    $config = HTMLPurifier_Config::createDefault();
    //$config->set('Core.DefinitionCache', null);
    $config->set('Cache.DefinitionImpl', null);
    $config->set('HTML.Allowed', '');
    $purifier = new HTMLPurifier($config);
    $txt = $purifier->purify($ret);

    return $txt;
}



/* Convert wiki text to html for output */
//This function is a part of http://svn.studentrobotics.org/ ide2/
function wiki2html($wikitext)
{
    if (!isset($wikitext) || $wikitext == "") {
        return false;
    }
    $i=0;
    $inter_text = $wikitext;
    while (strpos($inter_text, "[[") && strpos($inter_text, "]]")) {
        $i=++$i;
        if($i==10) break; //prevent loop when there are a error in wiki sintax
        $link = str_replace(array("[[", "]]"), "", substr($inter_text, strpos($inter_text, "[["), (strpos($inter_text, "]]")-strpos($inter_text, "[["))));
        if (strpos($link, "|")) {
            list($href, $title) = explode("|", $link);
        } else {
            $href = 'index.php?'.FORM_LABEL_buscar.'='.$link.'&amp;sgs=off';
        }
        $inter_text = str_replace('[['.$link.']]', '<a href="'.$href.'" title="'.LABEL_verDetalle.$link.'">'.$link.'</a>', $inter_text);
    }
    return $inter_text;
}


/* Convert wiki text to XML for output */
function wiki2xml($wikitext)
{
    if (!isset($wikitext) || $wikitext == "") {
        return false;
    }

    return str_replace(array ('[[',']]' ), array ('',''), $wikitext);
}

/* Convert wiki text to html for output */
//This function is a part of http://svn.studentrobotics.org/ ide2/
function wiki2link($wikitext)
{
    if (!isset($wikitext) || $wikitext == "") {
        return false;
    }

    $inter_text    = $wikitext;

    $i=0;
    while (strpos($inter_text, "[[") && strpos($inter_text, "]]")) {
        $i=++$i;
        if($i==10) break; //prevent loop when there are a error in wiki sintax
        $link    = str_replace(array("[[", "]]"), "", substr($inter_text, strpos($inter_text, "[["), (strpos($inter_text, "]]")-strpos($inter_text, "[["))));

    if (count(explode("|", $link))==2) {

            list($toSee,$string) = explode("|", $link);
            $inter_text = str_replace('[['.$toSee."|".$string.']]', string2gloss($string, $toSee, array($_SESSION[$_SESSION["CFGURL"]]["_GLOSS_NOTES"])), $inter_text);
        } else {
            $inter_text = str_replace('[['.$link.']]', string2gloss($link, $link, array($_SESSION[$_SESSION["CFGURL"]]["_GLOSS_NOTES"])), $inter_text);
        }
    }


    return $inter_text;
}




//Create link and tooltip for given string
function string2gloss($string, $toSee, $noteTypes = array("NA"))
{

    $sqlTerm=SQLbuscaExacta(html2txt($string));
    $arrayTerm=$sqlTerm->FetchRow();

    $sqlNotes=SQLdatosTerminoNotas($arrayTerm["tema_id"], $noteTypes);
    if (SQLcount($sqlNotes)>0) {
        while ($arrayNote=$sqlNotes->FetchRow()) {
            $description.=$arrayNote["nota"].' ';
        }

        $text=html2txt($description);
    } else {
        $text=ucfirst(LABEL_Detalle).' '.$arrayTerm["tema"];
    }

    if ($arrayTerm["tema_id"]) {
        return '<a href="'.URL_BASE.'index.php?tema='.$arrayTerm["tema_id"].'" class="autoGloss" data-toggle="tooltip" data-placement="right" title="'.$text.'">'.$toSee.'</a>';
    } else {
        return '<a href="'.URL_BASE.'index.php?'.FORM_LABEL_buscar.'='.$string.'&amp;sgs=off" title="'.ucfirst(LABEL_Detalle).' '.$string.'">'.$toSee.'</a>';
    }
}

/*
* Apartir de uma lista de palavras e uma palavra,
* sugere uma palavra da lista que mais se parece com a palavra informada.
// Fuente: Qiphp:Framework PHP Brasileiro voltado para sistemas legados. http://qiphp.googlecode.com/svn/
*/
class Qi_Util_Similar
{
    private $lista = array();
    private $palavra = "";



    const SIMILAR = "similar";
    const LEVENSHTEIN = "levenshtein";

    public function __construct(array $lista, $palavra, $metodo = self::LEVENSHTEIN)
    {
        $this->lista = array_map("strtolower", $lista);

        $this->palavra = strtolower($palavra);
        usort($this->lista, array($this, $metodo));
    }

    /**
     * M�todo helper st�tico
     */
    public static function sugerir($lista, $palavra, $metodo = self::SIMILAR)
    {
        $sugestor = new Qi_Util_Similar($lista, $palavra, $metodo);
        return $sugestor->sugestao();
    }

    public function sugestao()
    {
        return reset($this->lista);
    }

    public function sugestoes($limit = null)
    {
        if ($limit === null) {
            return $this->lista;
        }
        return array_slice($this->lista, 0, $limit);
    }

    private function similar($a, $b)
    {
        $pa = $pb = 0;
        similar_text($a, $this->palavra, $pa);
        similar_text($b, $this->palavra, $pb);
        if ($pa == $pb) {
            return 0;
        }
        return $pa < $pb ? 1 : -1;
    }

    private function levenshtein($a, $b)
    {

        $pa = $pb = 0;
        $pa = levenshtein($a, $this->palavra);
        $pb = levenshtein($b, $this->palavra);//123
        if ($pa == $pb) {
            return 0;
        }
        return $pa < $pb ? -1 : 1;
    }
}



function evalSimiliarResults($string_a, $string_b)
{

    global $CFG;

    $_MIN_DISTANCE=($CFG["_MIN_DISTANCE"]>0) ? $CFG["_MIN_DISTANCE"] : 6;

    // Config values to evaluate distance between to strings (Levenstein distance)
    $CFG["_COST_INST"] ='1';
    $CFG["_COST_REP"] ='2';
    $CFG["_COST_DEL"] ='3';


    $evalSimilar=levenshtein($string_a, $string_b, $CFG["_COST_INST"], $CFG["_COST_REP"], $CFG["_COST_DEL"]);


    return ($evalSimilar<$_MIN_DISTANCE);
}

function outputCosas($line)
{
       global $time_start;

         $time_now = time();

    if ($time_start >= $time_now + 10) {
        $time_start = $time_now;
        header('X-pmaPing: Pong');
    };
    echo $line;
};


function fixEncoding($input, $output_encoding = "UTF-8")
{
    return $input;
    // For some reason this is missing in the php4 in NMT
    $encoding = mb_detect_encoding($input);
    switch ($encoding) {
        case 'ASCII':
        case $output_encoding:
            return $input;
        case '':
            return mb_convert_encoding($input, $output_encoding);
        default:
            return mb_convert_encoding($input, $output_encoding, $encoding);
    }
}


/**
 * Checks to see if a string is utf8 encoded.
 *
 * NOTE: This function checks for 5-Byte sequences, UTF8
 *       has Bytes Sequences with a maximum length of 4.
 *
 * @author bmorel at ssi dot fr (modified)
 * @since  1.2.1
 *
 * @param  string $str The string to be checked
 * @return bool True if $str fits a UTF-8 model, false otherwise.
 * From WordPress
 */
function seems_utf8($str)
{
    $length = strlen((string) $str);
    for ($i=0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80) {
            $n = 0; // 0bbbbbbb
        } elseif (($c & 0xE0) == 0xC0) {
            $n=1; // 110bbbbb
        } elseif (($c & 0xF0) == 0xE0) {
            $n=2; // 1110bbbb
        } elseif (($c & 0xF8) == 0xF0) {
            $n=3; // 11110bbb
        } elseif (($c & 0xFC) == 0xF8) {
            $n=4; // 111110bb
        } elseif (($c & 0xFE) == 0xFC) {
            $n=5; // 1111110b
        } else {
            return false; // Does not match any model
        }
        for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                return false;
            }
        }
    }
    return true;
}


/*
convierte una cadena a latin1
* http://gmt-4.blogspot.com/2008/04/conversion-de-unicode-y-latin1-en-php-5.html
*/
function latin1($txt)
{
    $encoding = mb_detect_encoding($txt, 'ASCII,UTF-8,ISO-8859-1');
    if ($encoding == "UTF-8") {
        $txt = utf8_decode($txt);
    }
    return $txt;
}

/*
convierte una cadena a utf8
* http://gmt-4.blogspot.com/2008/04/conversion-de-unicode-y-latin1-en-php-5.html
*/
function utf8($txt)
{
    $encoding = mb_detect_encoding($txt, 'ASCII,UTF-8,ISO-8859-1');
    if ($encoding == "ISO-8859-1") {
        $txt = utf8_encode($txt);
    }
    return $txt;
}


function XSSprevent($string)
{
    //
    $string = str_replace(array ('<',">","&",'"' ), array ('','','',''), $string);

    //$string=htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    include_once 'htmlpurifier/HTMLPurifier.auto.php';
    $config = HTMLPurifier_Config::createDefault();
    //$config->set('Core.DefinitionCache', null);
    $config->set('Cache.DefinitionImpl', null);
    $purifier = new HTMLPurifier($config);
    $clean_string = $purifier->purify($string);

    return $clean_string;
}


function clean($val)
{
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen((string) $search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

        // &#x0040 @ search for the hex values
        $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
        // &#00064 @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen((string) $ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                    $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                    $pattern .= ')?';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}


/** 
 * Connect to database 
 *
 * @return conection object
 */
function DBconnect()
{
    include_once 'adodb5/adodb.inc.php';
    /*
    * Only for debug propouse
    */
    //    include_once('adodb5/adodb-exceptions.inc.php');

    global $DBCFG;

    //default driver
    $DBCFG["DBdriver"] = (@$DBCFG["DBdriver"]) ? $DBCFG["DBdriver"] : 'mysqli';

    //valid driver
    $DBCFG["DBdriver"] = configValue($DBCFG["DBdriver"], 'mysqli', array('mysqli','mysql'));

  
    //default value for type pesistence
    $DBCFG["DBpersist"] = (@$DBCFG["DBpersist"]==0) ? '' : '?persist';

    $connectionMode=(@$DBCFG["DBmodeConnect"]) ? (($DBCFG["DBmodeConnect"]=='DSN') ? 'DSN' : false) : false;


    if ($connectionMode=='DSN') {
        if (@$DBCFG["DBpersist"]) {
            $dsn = $DBCFG["DBdriver"].'://'.$DBCFG["DBLogin"].':'.$DBCFG["DBPass"].'@'.$DBCFG["Server"].'/'.$DBCFG["DBName"].$DBCFG["DBpersist"];
        }
  
        $DB = adoNewConnection($dsn);  // no need for Connect()
    } else {
        $DB = NewADOConnection($DBCFG["DBdriver"]);

        $DB->Connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"], $DBCFG["DBName"]);
    }



    //$DB->Execute("SET SESSION sql_mode = 'TRADITIONAL'");
    $DB->Execute("SET SESSION sql_mode = ' '");

    // Si se establecio un charset para la conexion
    if (@$DBCFG["DBcharset"]) {
        $DB->Execute("set names $DBCFG[DBcharset]");
    }

    //Si debug
    if ($DBCFG["debugMode"]=='1') {
        echo $DB->ErrorMsg();
    };

    return $DB;
}


function SQL($todo, $sql)
{

    global $DB, $DBCFG;


    $sql=$todo.' '.$sql;

    $rs = $DB->Execute($sql);

    //Si debug
    if ($DBCFG["debugMode"]=='1') {
        echo $DB->ErrorMsg();
    }

    if (!$rs) {
        return array("error"=>$DB->ErrorMsg());
    }

    switch ($todo) {
        case 'insert':
            return array("cant"=>$DB->Insert_ID());
        break;

        case 'update':
            return array("cant"=>$DB->Affected_Rows());
        break;

        default:
            return $rs;
    }
};


function SQLo($todo, $sql, $array)
{

    global $DB;

    $sql=$todo.' '.$sql;

    $rs = $DB->Prepare($sql);

    $rs = $DB->Execute($rs, $array);

    if (!$rs) {
        return array("error"=>$DB->ErrorMsg());
    }

    switch ($todo) {
        case 'insert':
            return array("cant"=>$DB->Insert_ID());
        break;

        case 'update':
            return array("cant"=>$DB->Affected_Rows());
        break;

        default:
            return $rs;
    }
};




/** Datos del Tesauro */
function SQLdatosTesaruo($tesauro_id)
{
    global $DBCFG;

    $tesauro_id=secure_data($tesauro_id, "int");

    return SQLo(
        "select",
        "id,
		titulo,
		autor,
		idioma,
		cobertura,
		keywords,
		tipo,
		cuando,
		url_base
		from $DBCFG[DBprefix]config as config
		where id=?",
        array($tesauro_id)
    );
};


function SQLAuthUser($mail, $pass)
{
    global $DBCFG;

    return SQLo(
        "select",
        "usuario.id,
			usuario.mail,
			usuario.nivel,
			concat(usuario.apellido,', ',usuario.nombres) as nombre
		from $DBCFG[DBprefix]usuario as usuario
			 where usuario.mail=?
			 and usuario.pass=?
			 and estado=1",
        array($mail,$pass)
    );
};


function ARRAYcheckLogin($mail)
{
    global $DBCFG;

    $sql=SQLo(
        "select",
        "u.id,
			u.id as user_id,
			u.mail,
			u.nivel,
			concat(u.apellido,', ',u.nombres) as nombre,
			u.pass
		from $DBCFG[DBprefix]usuario as u
			 where u.mail=?
			 and u.estado=1",
        array($mail)
    );

    return (is_object($sql)) ? $sql->FetchRow() : array("result"=>false);
}



//fix ADOdb5 problem to response 0 result
function SQLcount($object)
{
    return (is_object($object)) ? $object->RecordCount() : '0';
}


function loadConfigValues($renew = "0")
{

    global $arrayCFGs;

    //Web URL BASE
    define('URL_BASE', getURLbase());

    //renovar valores
    if ($renew=='1') {
        global $DBCFG;

        $sql=SQL(
            "select",
            "v.value_id,v.value_type,v.value,v.value_code,v.value_order
						from $DBCFG[DBprefix]values v where v.value_type='config'"
        );

        $NEWarrayCFGs=array();

        while ($array=$sql->FetchRow()) {
            switch ($array["value"]) {
                case 'CFG_MAX_TREE_DEEP':
                    $array["value_code"] = (in_array($array["value_code"], array(1,2,3,4,5,6))) ? $array["value_code"] : $arrayCFGs[$array["value"]];
                    break;

                case 'CFG_MIN_SEARCH_SIZE':
                    $array["value_code"] = (in_array($array["value_code"], array(1,2,3,4,5,6))) ? $array["value_code"] : $arrayCFGs[$array["value"]];
                    break;

                case 'CFG_NUM_SHOW_TERMSxSTATUS':
                    $array["value_code"] = (in_array($array["value_code"], array(50,100,150,200,250))) ? $array["value_code"] : $arrayCFGs[$array["value"]];
                    break;
                case '_GLOSS_NOTES':
                    $array["value_code"] = (!$array["value_code"]) ? $arrayCFGs[$array["value"]] : $array["value_code"] ;
                    break;

                case '_SHOW_RANDOM_TERM':
                    $array["value_code"] = (!$array["value_code"]) ? $arrayCFGs[$array["value"]] : $array["value_code"] ;
                    break;

                default:
                    $array["value_code"] = (in_array($array["value_code"], array(1,0))) ? $array["value_code"] : $arrayCFGs[$array["value"]];
            }

            $NEWarrayCFGs[$array["value"]]= $array["value_code"];
        }
    }// end renew

    //define default values
    foreach ($arrayCFGs as $key => $value) {
        $value = (isset($NEWarrayCFGs["$key"])) ? $NEWarrayCFGs["$key"] : $value ;
         $_SESSION[$_SESSION["CFGURL"]]["$key"]=$value;
    }
}


function LABELrelTypeSYS($r_id)
{
    //system defaults relations
    //its wrong storage data in functions.... but this data are fixed data
    //if(in_array($value_id,array(2,3,4,5,6,7)))

    $arrayLabel[2]=array("r_code"=>TR_acronimo,"r_value"=>TR_termino,"rx_code"=>TR_acronimo,"rx_value"=>TR_termino);
    $arrayLabel[3]=array("r_code"=>TG_acronimo,"r_value"=>TG_termino,"rx_code"=>TE_acronimo,"rx_value"=>TE_termino);
    $arrayLabel[4]=array("r_code"=>UP_acronimo,"r_value"=>UP_termino,"rx_code"=>USE_termino,"rx_value"=>USE_termino);
    $arrayLabel[5]=array("r_code"=>EQ_acronimo,"r_value"=>LABEL_termino_equivalente);
    $arrayLabel[6]=array("r_code"=>EQP_acronimo,"r_value"=>LABEL_termino_parcial_equivalente);
    $arrayLabel[7]=array("r_code"=>NEQ_acronimo,"r_value"=>LABEL_termino_no_equivalente);

    return $arrayLabel[$r_id];
}


function doLastModified($thes_change = false)
{
    global $DBCFG;
    $lastTerm=ARRAYlastTermMod();
    //select max value
    $lastTermMod=max($lastTerm["last_create"], $lastTerm["last_mod"], $lastTerm["last_status"]);
    $lastTtermMod=ARRAYlastTtermMod();
    $lastNoteMod=ARRAYlastNoteMod();

    $sqlTerm=SQL("update", " $DBCFG[DBprefix]values set value='$lastTermMod' where value_type='DATESTAMP' and value_code='TERM_CHANGE'");
    $sqlTterm=SQL("update", " $DBCFG[DBprefix]values set value='$lastTtermMod' where value_type='DATESTAMP' and value_code='TTERM_CHANGE'");
    $sqlNotes=SQL("update", " $DBCFG[DBprefix]values set value='$lastNoteMod' where value_type='DATESTAMP' and value_code='NOTE_CHANGE'");


    if ($thes_change==true) {
        $sql=SQL("update", " $DBCFG[DBprefix]values set value='now()' where  value_type='DATESTAMP' and value_code='THES_CHANGE'");
    }
}

//last term modified
function ARRAYlastTermMod()
{
    global $DBCFG;
    $sql=SQL("select", "max(t.cuando) as last_create,max(t.cuando_final) as  last_mod,max(t.cuando_estado) as last_status from $DBCFG[DBprefix]tema t");
    $array=$sql->FetchRow();
    return $array;
}

//last foreign term modified
function ARRAYlastTtermMod()
{
    global $DBCFG;
    $sql=SQL("select", "max(tt.cuando) last from $DBCFG[DBprefix]term2tterm tt");
    $array=$sql->FetchRow();
    return $array["last"];
}

//last note modified
function ARRAYlastNoteMod()
{
    global $DBCFG;
    $sql=SQL("select", "max(n.cuando) last from $DBCFG[DBprefix]notas n");
    $array=$sql->FetchRow();
    return $array["last"];
}



// SOME GENERAL FUNCTIOS FROM WordPress #################################
// http://codex.wordpress.org/Function_Reference/  #########################


/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used throughout WordPress to allow for both string or array
 * to be merged into another array.
 *
 * @since 2.2.0
 *
 * @param  string|array $args     Value to merge with $defaults
 * @param  array        $defaults Array that serves as the defaults.
 * @return array Merged user defined values with defaults.
 */
function t3_parse_args($args, $defaults = '')
{
    if (is_object($args)) {
        $r = get_object_vars($args);
    } elseif (is_array($args)) {
        $r =& $args;
    } else {
        t3_parse_str($args, $r);
    }

    if (is_array($defaults)) {
        return array_merge($defaults, $r);
    }
    return $r;
}


/**
 * Parses a string into variables to be stored in an array.
 *
 * @since 2.3.0
 * @uses  apply_filters() for the 'wp_parse_str' filter.
 *
 * @param string $string The string to be parsed.
 * @param array  $array  Variables will be stored in this array.
 */
function t3_parse_str($string, &$array)
{
    parse_str($string, $array);
    return $array;
}

/**
 * Navigates through an array and removes slashes from the values.
 *
 * If an array is passed, the array_map() function causes a callback to pass the
 * value back to the function. The slashes from this value will removed.
 *
 * @since 2.0.0
 *
 * @param  array|string $value The array or string to be stripped.
 * @return array|string Stripped array (or string in the callback).
 */
function stripslashes_deep($value)
{
    if (is_array($value)) {
        $value = array_map('stripslashes_deep', $value);
    } elseif (is_object($value)) {
        $vars = get_object_vars($value);
        foreach ($vars as $key => $data) {
            $value->{$key} = stripslashes_deep($data);
        }
    } else {
        $value = stripslashes($value);
    }

    return $value;
}



function currentPageURL()
{
    $pageURL = $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
    $pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    return $pageURL;
}




function currentBasePage($url)
{
    return substr($url, 0, strripos($url, "/")+1);
}

function sendMail($to_address, $subject, $message, $extra = array())
{
    global $DBCFG;
    require 'mailer/PHPMailer.php';
    require 'mailer/SMTP.php';
    require 'mailer/Exception.php';
    $mail = new PHPMailer();

    /* Exmple with SMTP from gmail **/
    //Set the hostname of the mail server
    /*
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "username";
    $mail->Password = "Password";
    */

    //OR  Set PHPMailer to use the sendmail transport
    //$mail->isSendmail();

    //OR SMTP
    //$mail->IsSMTP();
    //$mail->Host = "localhost";

    $mail->SetFrom("noreplay@noreplay.com", $_SESSION["CFGTitulo"]);
    $mail->CharSet = "UTF-8";
    $mail->AddAddress($to_address);
    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(false);                                  // set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    

    $mailcheck=$mail->Send();



    if ($DBCFG["debugMode"] == "1") {
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        echo "DEBUG DATA:". $mail->ErrorInfo;
    }

    return ($mailcheck) ? true  : false;
}


function t3_messages($msg_type)
{
    switch ($msg_type) {
        case 'no_user':
            $msg='<p class="alert alert-danger" role="alert">'.MSG_noUser.'</p>';
            break;

        case 'recovery_mail_send':
            $msg='<p  class="alert alert-info" role="alert">'.MSG_check_mail.'</p>';
            break;

        case 'mailOK':
            $msg='<p  class="alert alert-info" role="alert">'.MSG_check_mail.'</p>';
            break;

        case 'mailFail':
            $msg='<p  class="alert alert-danger" role="alert">'.MSG_no_mail.'</p>';
            break;

        default:
            break;
    }

    return $msg;
}

/**
 * * * From WordPress !!!
 * Create a hash (encrypt) of a plain text password.
 *
 * For integration with other applications, this function can be overwritten to
 * instead use the other package password checking algorithm.
 *
 * @since  2.5
 * @global object $wp_hasher PHPass object
 * @uses   PasswordHash::HashPassword
 *
 * @param  string $password Plain text user password to hash
 * @return string The hash string of the password
 */
function t3_hash_password($password)
{

    include_once 'class-phpass.php';
    // By default, use the portable hash from phpass
    $hasher = new PasswordHash(8, true);

    return $hasher->HashPassword($password);
}


/**
 ** * From WordPress !!!
 * Create a hash (encrypt) of a plain text password.
 * *
 *
 * @param  string $password Plaintext user's password
 * @param  string $hash Hash of the user's password to check against.
 * @return bool False, if the $password does not match the hashed password
 */
require_once 'class-phpass.php';

function check_password($password, $hash)
{

    if (CFG_HASH_PASS==1) {
        $hasher = new PasswordHash(8, true);
        return $hasher->CheckPassword($password, $hash);
    } else {
        return ($password==$hash);
    };
}

/*
 *
 * Update password for user
 */
function setPassword($user_id, $user_pass, $to_hash = 0)
{
    global $DBCFG;
    $user_pass=($to_hash==1) ? t3_hash_password($user_pass) : $user_pass;
    $sql_update_pass=SQLo("update", "$DBCFG[DBprefix]usuario set pass= ? where id= ?", array($user_pass,$user_id));
    return;
}


/*
 *
 * Sanitice arrays
 */
function XSSpreventArray($array)
{
    if (is_array($array)) {
        foreach ($array as $k => $v) {
            $array[$k] = is_array($v) ? XSSpreventArray($v) : XSSprevent($v);
        }
        @reset($array);
    } else {
        $array = array();
    }

    return $array;
}


/*
* Function from http://www.bin-co.com/php/scripts/array2json/
*
*/
function array2json(array $arr)
{
    if (function_exists('json_encode')) {
        return json_encode($arr); //Lastest versions of PHP already has this functionality.
    }
    $parts = array();
    $is_list = false;

    if (count($arr)>0) {
        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr)-1;
        if (($keys[0] === 0) and ($keys[$max_length] === $max_length)) {//See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
                if ($i !== $keys[$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }

        foreach ($arr as $key => $value) {
            $str = ( !$is_list ? '"' . $key . '":' : '' );
            if (is_array($value)) { //Custom handling for arrays
                $parts[] = $str . array2json($value);
            } else {
                //Custom handling for multiple data types
                if (is_numeric($value) && !is_string($value)) {
                    $str .= $value; //Numbers
                } elseif (is_bool($value)) {
                    $str .= ( $value ? 'true' : 'false' );
                } elseif ($value === null) {
                    $str .= 'null';
                } else {
                    $str .= '"' . addslashes($value) . '"'; //All other things
                }
                $parts[] = $str;
            }
        }
    }
    $json = implode(',', $parts);

    if ($is_list) {
        return '[' . $json . ']';//Return numerical JSON
    }
    return '{' . $json . '}';//Return associative JSON
}


/*
 * Parse string separated by char into array of numeric IDs.
 */
function string2array4ID($string, $char = ",")
{
    $array_temas_id=explode($char, $string);

    foreach ($array_temas_id as $tema_id) {
        $temas_id[]=secure_data($tema_id, "int");
    }

    $csv_temas_id=implode($char, $temas_id);

    return $csv_temas_id;
}

/*
Check if the string is an accepted letter
 */
function isValidLetter($string)
{

    global $CFG;

    $string=trim((string) $string);

    $string=(in_array($string, $CFG["_EXCLUDED_CHARS"])) ?   '' : $string;

    $string=XSSprevent(urldecode($string));


    return $string;
}

/* 
    Return base URL of the current URL or instance of vocabulary
    source: https://stackoverflow.com/questions/1175096/how-to-find-out-if-youre-using-https-without-serverhttps/16076965#16076965
    @Julia Neumann
*/
function getURLbase()
{
    //$s = empty($_SERVER["HTTPS"]) ? '' : (($_SERVER["HTTPS"] == "on") ? "s" : "");
    //$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;

    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $isSecure = true;
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
        !empty($_SERVER['HTTP_X_FORWARDED_SSL']) &&
        $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
                $isSecure = true;
    }
    $protocol = $isSecure ? 'https' : 'http';    
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    $uri = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    $segments = explode('?', $uri, 2);
    $url = $segments[0];

    $url_base=substr($url, 0, strripos($url, "/")+1);

    return $url_base;
}



function loadPageTerm($tema_id)
{

    $tema_id=secure_data($tema_id, "int");

    return header("Location:index.php?tema=$tema_id");
}

//load empty page
function loadPage($page)
{

    $page=in_array($page, array('admin.php','index.php','login.php','sobre.php','install.php','sparql.php')) ? $page : 'index.php';
    return header("Location:$page");
}

//Check if is allow to public view the vocabulary
function checkAllowPublication($file)
{

    if ((!isset($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]))
        && ($_SESSION[$_SESSION["CFGURL"]]["CFG_PUBLISH"]==0)
        && ($file!=='login.php')
    ) {
        return 0;
    } else {
        return 1;
    }

    ;
}

function toASCII($str)
{
    include_once 'URLify.php';
    return URLify::downcode($str);
}

//Check if URL is alive
function URL_exists($url)
{
    $headers=get_headers($url);
    return stripos($headers[0], "200 OK")?true:false;
}




//only for active users. retrive simple data about user
function ARRAYUserData($user_id)
{
    global $DBCFG;
    $sql=SQL(
        "select",
        "u.id as user_id,u.apellido,u.nombres,u.orga,u.mail,u.nivel
    from
    $DBCFG[DBprefix]usuario u
    where u.id='$user_id'
    and u.estado=1"
    );

    return $sql->FetchRow();
};



//check specific task for specifi roles
function checkValidRol($arrayUser, $task)
{

    if (!$arrayUser["nivel"]) {
        $arrayUser=ARRAYdatosUser($arrayUser["user_id"]);
    }
    if (!$arrayUser["nivel"]) {
        return false;
    }

    $adminTask=array("adminReports","adminUsers","config","reports","terms","notes","termStatus");
    $editorTask=array("reports","terms","notes","termStatus");
    $colabTask=array("reports","terms","notes");

    //check if it is a valid task
    if (!in_array($task, $adminTask)) {
        return false;
    }
    switch ($arrayUser["nivel"]) {
        case '1'://admin
            $result=in_array($task, $adminTask);
            break;

        case '2':
            $result=in_array($task, $editorTask);
            break;

        case '3':
            $result=in_array($task, $colabTask);
            break;

        default:
            $result=false;
            break;
    }
    return $result;
}


//retrive array about URL usefuls in the URI= URL base of service, URL of the vocabulary, URL of the term
function URIterm2array($URI_term)
{
    $ARRAY_URL_BASE=explode("services.php", $URI_term);

    if (count($ARRAY_URL_BASE)>0) {
        return array( "tterm_url"=>str_replace('services.php?task=fetchTerm&arg=', 'index.php?tema=', $URI_term),
                  "tterm_id"=>(int)substr(strrchr($URI_term, "="), 1),
                  "URL_service"=>$ARRAY_URL_BASE[0].'services.php',
                  "URL_vocab"=>$ARRAY_URL_BASE[0]);
    } else {
        return array();
    }
}



function check2Date($stringDate, $char = "-")
{
    $arrayDate  = explode('-', $stringDate);
    if (count($arrayDate)!==3) {
        return false;
    }

    if (checkdate((int) $arrayDate[1], (int) $arrayDate[2], (int) $arrayDate[0])) {
        return $stringDate;
    } else {
        return false;
    };
}


/**
 * Get the boolean value of a variable
 *
 * @param  mixed   The scalar value being converted to a boolean.
 * @return boolean The boolean value of var.
 * @refer  http://php.net/manual/en/function.boolval.php#114013
 */
if (!function_exists('boolval')) {
  
    function boolval($var)
    {
        return !! $var;
    }
}

function extract4url($url)
{

    $output=array("tema"=>false,"letra"=>false);

    $url_parser=parse_url($url);

    parse_str($url_parser["query"],$output);
 
    return array("url"=>$url,"tema_id"=>$output["tema"],"letra"=>$output["letra"]);
}


/** Unique hask for string */
function hashmaker($seed, $string2hash)
{
    include_once T3_ABSPATH . 'common/include/Hashids/HashGenerator.php';
    include_once T3_ABSPATH . 'common/include/Hashids/Hashids.php';
/* create the class object with minimum hashid length of 12 */

    $hashids = new Hashids\Hashids($seed, 12, 'abcdefghijklmnopqrstuvwxyz0123456789');

    $string2hash=(is_numeric($string2hash)) ? $string2hash : abs(crc32(html2txt($string2hash)));
 
    return $hashids->encode($string2hash);
}


/**exctract hash from ark */
function ark2hash($seed, $string2hash)
{
    return str_replace($seed, "", $string2hash);
}




/**
 * Check for values and not null in a variable
 *
 * @param string $value         value name to evaluete
 * @param string $default       default value to asign if value is null
 * @param array  $defaultValues array values to asign if value and default is null
 * 
 * @return if value is null, return defaul, else return value
 */
function configValue($value, $default = false, $defaultValues = array())
{


    if (strlen((string) $value)<1) {
        return $default;
    }

    //si es que ser uno de una lista de valores
    if (count($defaultValues)>0) {
        if (!in_array($value, $defaultValues)) {
            return $default;
        }
    }

    return $value;
}


/**
 * Path and metadata about localization labels file
 * 
 * @param string    lang code
 * @param array     array with enable langs
 * 
 * @return array with path and metadata about selected lang
 */
function selectLangLabels($lang_code,$langs){
    $lang_default="en-EN";
    /*prevent empt data */
    $lang_code=(strlen((string) $lang_code)>1) ? $lang_code : $lang_default;

    /*legacy lang_code with 2 letters */
    $lang_code=normalizeLangCode($lang_code);


    if(is_array($langs["$lang_code"])) return $langs["$lang_code"];


    return $langs["$lang_default"];

}


/** 
* Normalize lang code from 2 to 4 letters
*
* @param chars lang code to normalize
*
* @return check format of lang code (xx-XX or xx)
*/
function normalizeLangCode($lang_code){
 
    $array_code=explode("-",$lang_code);

    if(count($array_code)==2){
    }elseif(strlen((string) $lang_code)==2){
        $lang_code=normalizeLangCode(strtolower(substr($lang_code, 0,2)).'-'.strtoupper(substr($lang_code, 0,2)));
    }else{
        $lang_code=configValue(null,"en-EN");
    }
    configValue(null,$lang_code);

    return $lang_code;
}

/**
 * Create value from key array
 *
 * @param string $key   key in array to assign
 * @param array  $array array to use as source value, if the value is null, the value is null.
 * 
 * @return return $value as value
 */
function array2value($key,$array=array())
{
    $array=(is_array($array)) ? $array : array();

    return (isset($array["$key"])) ? $array["$key"] : null;
}


/**
 * Eval user rights
 *
 * @param array $user_session session data  
 * 
 * @return return level of rights for the user
 */
function evalUserLevel($user_session)
{

    if (!is_array($user_session)) { 
        return 0; 
    };

    if (!isset($user_session["ssuser_nivel"])) {
        return 0;
    };

    if (!in_array($user_session["ssuser_nivel"], array(1,2,3))) {
        return 0;
    };

    return (int) $user_session["ssuser_nivel"];
}


/**
 * Eval user rights to edit or delete term
 *
 * @param array $user_session session data  
 * @param array $term_data term data  
 * 
 * @return return bool true or false
 */
function evalUser4Term($user_session,$term_data)
{

    $owner_id=$term_data["uid"];
    $status_id=$term_data["estado_id"];

    if (!is_array($user_session)) { 
        return 0; 
    };

    if (!isset($user_session["ssuser_nivel"])) {
        return 0;
    };

    if (!in_array($user_session["ssuser_nivel"], array(1,2,3))) {
        return 0;
    };


    /*user is collab and the term no in candidate status*/
    if(( (int) $user_session["ssuser_nivel"]==3) && ($status_id!=12)){
        return 0;
    }

    /*user is collab and isnt the owner of the term*/
    if(( (int) $user_session["ssuser_nivel"]==3) && ($user_session["ssuser_id"]!=$owner_id)){
        return 0;
    }

    return 1;
}

/** 
 * Check if there are already a tematres instance
 * 
 * 
 * @return boolean
 */

function checkT3instance(){

    global $DBCFG,$CFG;

    //default driver
    $DBCFG["DBdriver"]=($DBCFG["DBdriver"]) ? $DBCFG["DBdriver"] : "mysqli";

    $DB = NewADOConnection($DBCFG["DBdriver"]);

    if (!$DB->Connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"])) {
        return array("version"=>$CFG["Version"],
                    "dbconnect"=>0,
                    "cantTables"=>0);
    };

    $sqlCantTables=$DB->Execute('SHOW TABLES from `'.$DBCFG["DBName"].'` where `tables_in_'.$DBCFG["DBName"].'` in (\''.$DBCFG["DBprefix"].'config\',\''.$DBCFG["DBprefix"].'indice\',\''.$DBCFG["DBprefix"].'notas\',\''.$DBCFG["DBprefix"].'tabla_rel\',\''.$DBCFG["DBprefix"].'tema\',\''.$DBCFG["DBprefix"].'usuario\',\''.$DBCFG["DBprefix"].'values\')');
    $cantTables=(is_object($sqlCantTables)) ? $sqlCantTables->RecordCount() : 0;

    //7 tables = pre-3.2 version 

    return array("version"=>"",
                    "dbconnect"=>0,
                    "cantTables"=>$cantTables);

}

/**
 * Create value from key array 
 * source: https://stackoverflow.com/a/8680364
 *
 * @param string $index   key in array to assign
 * @param array  $var array to use as source value, if the value is null, the value is null.
 * 
 * @return return $value as value
 */
function ifexistsidx($var,$index)
{
  return(isset($var[$index]) ? $var[$index] : null);
}




// Función para calcular el coeficiente de clustering
function clusteringCoefficient($data) {

    $totalCoefficients = 0;
    $nodesCount = count($data);

    foreach ($data as $node => $links) {
        $links = intval($links); // Asegurarse de que el número de enlaces sea un entero

        if ($links < 2) {
            continue; // Ignorar nodos con menos de dos enlaces
        }

        // Calcular el máximo número de enlaces posibles entre los enlaces del nodo
        $maxPossibleLinks = ($links * ($links - 1)) / 2;

        // Calcular el coeficiente de clustering del nodo
        $clusteringCoefficient = $maxPossibleLinks > 0 ? ($node / $maxPossibleLinks) : 0;

        // Sumar el coeficiente de clustering del nodo al total
        $totalCoefficients += $clusteringCoefficient;
    }

    if ($nodesCount <= 2) {
        return 0; // Para grafos con 0 o 1 nodos, el coeficiente de clustering es indefinido, así que se devuelve 0
    }

    // Calcular el coeficiente de clustering promedio
    return $totalCoefficients / $nodesCount;
}


// Function to calculate the logarithmic scale
function calculateLogScale($data) {
    $logScale = []; // Array to store the logarithmic scale for each node

    foreach ($data as $node => $links) {
        // Ensure the number of links is greater than zero to avoid log(0) error
        if ($links > 0) {
            // Calculate the logarithmic scale for the number of links
            $logValue = log($links);
            $logScale[$node] = $logValue;
        } else {
            // If number of links is zero, log(0) is undefined, so assign a placeholder value
            $logScale[$node] = null;
        }
    }

    return $logScale;
}