<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################


###################################################################################
############################### FUNCIONES GENERALES ###############################
###################################################################################
###################################################################################


// Funcion tomada de PHPBB: http://www.phpbb.com/
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//

function PHP_magic_quotes(){

if( !get_magic_quotes_gpc() )
{
        if( is_array($_GET) )
        {
                while( list($k, $v) = each($_GET) )
                {
                        if( is_array($_GET[$k]) )
                        {
                                while( list($k2, $v2) = each($_GET[$k]) )
                                {
                                        $_GET[$k][$k2] = addslashes($v2);
                                }
                                @reset($_GET[$k]);
                        }
                        else
                        {
                                $_GET[$k] = addslashes($v);
                        }
                }
                @reset($_GET);
        }

        if( is_array($_POST) )
        {
                while( list($k, $v) = each($_POST) )
                {
                        if( is_array($_POST[$k]) )
                        {
                                while( list($k2, $v2) = each($_POST[$k]) )
                                {
                                        $_POST[$k][$k2] = addslashes($v2);
                                }
                                @reset($_POST[$k]);
                        }
                        else
                        {
                                $_POST[$k] = addslashes($v);
                        }
                }
                @reset($_POST);
        }

        if( is_array($HTTP_COOKIE_VARS) )
        {
                while( list($k, $v) = each($HTTP_COOKIE_VARS) )
                {
                        if( is_array($HTTP_COOKIE_VARS[$k]) )
                        {
                                while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
                                {
                                        $HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
                                }
                                @reset($HTTP_COOKIE_VARS[$k]);
                        }
                        else
                        {
                                $HTTP_COOKIE_VARS[$k] = addslashes($v);
                        }
                }
                @reset($HTTP_COOKIE_VARS);
        }
}
}


TrimArray($_GET);
TrimArray($_POST);




#
# Concatena nombrs y variables de GET
#
function doValFromGET(){
    $keys_get = array_keys($_GET);

    foreach ($keys_get as $key_get){
            if($key_get!=='setLang'){
                $i=++$i;
                $$key_get = $_GET[$key_get];
                }
             }
     if($i){
     return '&amp;'.$key_get.'='.$$key_get;
     };
}

function TrimArray(&$array) {
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



# Seleccionar un valor del array
function doValue($array,$nombreValor){
        if(count($array[$nombreValor])>'0'){
        return $array[$nombreValor];
        }else{
        return FALSE;
        }
};




###################################################################################
##################      FUNCIONES DE PARSEO         ###############################
###################################################################################




#
# Revisa un check de un form
#
 function do_check($campo,$value,$tipo){
           if ($campo==$value){
              return $tipo;
              }
           };


#
# Arma un array con una fecha
#
function do_fecha($fecha){
   GLOBAL $MONTHS;
   $array=array(
   		min=>date("i",strtotime($fecha)),
   		hora=>date("G",strtotime($fecha)),
                dia=>date("d",strtotime($fecha)),
                mes=>date("m",strtotime($fecha)),
		descMes=>$MONTHS[date("m",strtotime($fecha))],
                ano=>date("Y",strtotime($fecha))
               );
   return $array;
   }



#
# Arma un intervalo de n�meros o meses
#
function do_intervalDate($inicio,$fin,$tipo){
   for($interval="$inicio"; $interval<="$fin"; ++$interval){
       if($tipo=='MES'){
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
         }
         else{
         $listInterval.=$interval.'#'.$interval.'&';
         };
       };
   $listToform=substr("$listInterval",0,-1);
   $listToform=explode("&",$listInterval);
   return $listToform;
};


#
# Arma un select form a partir de un Array
#
function doSelectForm($valores,$valor_selec)
{
  for($i=0; $i<sizeof($valores);++$i){
	 $valor=explode("#",$valores[$i]);
	 if($valor[0]){
		if($valor[0]==$valor_selec){
				$selec_values.='<option value="'.$valor[0].'" selected="selected">'.$valor[1].'</option>'."\n\r";
				}
				else{
				$selec_values.='<option value="'.$valor[0].'">'.$valor[1].'</option>'."\n\r";
		};
	   };
	 };
  return $selec_values;
};


#
# Arma un select form a partir de un SQL
#

function SqlSelectForm($sql)
{
    $sqlDos=SQL("select","$sql");
    while ($cons=$sqlDos->FetchRow()){
		$array.=$cons[0].'#'.$cons[1].'&';
		};
          $array=substr("$array",0,-1);
          $array=explode("&",$array);

   return $array;
}

#
# alternador de colores en filas
#
function do_color_row($i,$selec_color1,$selec_color2){
         $color_row=$selec_color1;
         if(is_int($i/2)){$color_row=$selec_color2;}

         return $color_row;
         };


#
# Abre y cierra un c�digo html
#
function doListaTag($i,$tag,$contenidoTag,$id=""){
         if($i>0){
                if($id){
                	$idTag=' id="'.$id.'"';
                };
                $rows='<'.$tag.$idTag.'>'."\n\r";
                $rows.=$contenidoTag;
                $rows.='</'.$tag.'>'."\n\r";
         }

        return $rows;
};

#
# Empaqueta salida y envia por Header como attach
# Basada en clase PHP ExcelGen Class de (c) Erh-Wen,Kuo (erhwenkuo@yahoo.com).
function sendFile($input,$filename){
                header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT");
                header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
                header ( "Pragma: no-cache" );
                header ( "Content-type: application/octet-stream; name=$filename" );
                header ( "Content-Disposition: attachment; filename=$filename");
                header ( "Content-Description: Zthes tesauro" );
                print $input;
}



//sql 2 CSV and send as attach
//based on http://www.phpclasses.org/browse/file/16237.html
function sql2csv($sql,$filename,$encode="utf8")
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
	$CSV .= str_replace ( array("tema_id","cuando","tema","date_estado") , array("internal_term_id","date","term","date_status"), implode(";", $colnames) );

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
/*
		$CSV=substr($CSV,0,-1);
*/
		$CSV.="\n";
		//$CSV .= "\n".implode(";", $array);
	}
}

// send output to browser as attachment (force to download file
header('Expires: Mon, 1 Jan 1990 00:00:00 GMT');
header('Last-Modified: '.gmdate("D,d M Y H:i:s").' GMT');
header('Pragma: no-cache');
header('Content-type: text/csv;charset=latin1');
header('Content-Disposition: attachment; filename='.$filename);

// print the final contents of .csv file
print ($encode=='latin1') ? latin1($CSV) : utf8($CSV);

}


//From TematresView by Nicolas Poulain
function secure_data($data,$type="alnum") {

	switch ( $type ) {
		case "alnum" :
			// suppression des caracteres pas catholiques
			$data = preg_replace('/^\W+|\W+$/', '', $data);
			$data = preg_replace('/\s/', '', $data) ;
		break ;

		case "alpha" :
			// suppression des caracteres pas catholiques
 		    $data = preg_replace('/^\W+|\W+$/', '', $data);
		    $data = arrayReplace ( array("0","1","2","3","4","5","6","7","8","9"), array(""),$data );
			$data = preg_replace('/\s/', '', $data) ;
		break ;


		case "ADOsql" :
		GLOBAL $DB;
		$data = trim($data);
		$data=$DB->qstr($data,get_magic_quotes_gpc());
		break ;


		case "sql" :
			$data = trim($data);
			// vire les balises
			$data = strip_tags($data) ;

			if (is_numeric($data)  || $data === null)
			{
                return $data;
            }
			// zappe le magic_quote d�pr�ci�
			$data = str_replace("''", "'", $data) ;

			if(get_magic_quotes_gpc()) $data = stripslashes($data);

			$data= addslashes($data);
		break ;

		case "sqlhtml" :
			 //SQL secure with HTML tags
			// zappe le magic_quote d�pr�ci�
			if(get_magic_quotes_gpc()) {
				if(ini_get('magic_quotes_sybase'))
					$data = str_replace("''", "'", $data) ;
				else $data = stripslashes($data) ;
			}
			$data = trim($data) ;
		break ;

		case "int" : // int
			$data =(int)preg_replace('|[^0-9.]|i', '', $data);

			if ( $data == "" ) $data = 0 ;
		break ;

		default : // int
			$data =(int)preg_replace('|[^0-9.]|i', '', $data);

			if ( $data == "" ) $data = 0 ;
		break ;
	}
	return $data ;
}




function is_alpha($inStr) { return (preg_match("/^[a-zA-Z]+$/",$inStr) != 0); }


function is_alpha_numeric($inStr) { return (preg_match("/^[a-zA-Z0-9]+$/",$inStr) != 0); }


// XML Entity Mandatory Escape Characters or CDATA
function xmlentities ( $string , $pcdata=FALSE)
{
if($pcdata == TRUE)
	{
	return  '<![CDATA[ '.str_replace ( array ('[[',']]' ), array ('',''), $string ).' ]]>';
	}
	else
	{
	return str_replace ( array ( '&', '"', "'", '<', '>','[[',']]' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;','',''), $string );
	}

}

//Reemplaza un valor de una matriz por otro
function arrayReplace ( $arrayInicio, $arrayFinal, $string )
{
    return str_replace ( $arrayInicio , $arrayFinal, $string );
}



//
function prepare2sqlregexp($string)
{
	$arrayPossibleSpecialChar=array('a','e','i','o','u','c','y','n');
	$arraySpecialChar=array('[a������]','[c�]','[o������]','[e����]','[i����]','[u����]','[y��]','[n�]');

	return str_replace($arrayPossibleSpecialChar, $arraySpecialChar, $string);
}


// string 2 URL legible
// based on source from http://code.google.com/p/pan-fr/
function string2url ( $string )
{
		$string = strtr($string,
		"�������������������������������������������������������",
		"AAAAAAaaaaaaCcOOOOOOooooooEEEEeeeeIIIIiiiiUUUUuuuuYYyyNn");

		$string = str_replace('�','AE',$string);
		$string = str_replace('�','ae',$string);
		$string = str_replace('�','OE',$string);
		$string = str_replace('�','oe',$string);

		$string = preg_replace('/[^a-z0-9_\s\'\:\/\[\]-]/','',strtolower($string));

		$string = preg_replace('/[\s\'\:\/\[\]-]+/',' ',trim($string));

		$res = str_replace(' ','-',$string);

		return $res;
}

//This function is a part of DAlbum.  Copyright (c) 2003 Alexei Shamov, DeltaX Inc.
// replace <BR> with /n for text mode
function br2nl($text)
{
    return preg_replace("/<br[\s\/]*>/i", "\n",$text,-1);
}

//This function is a part of DAlbum.  Copyright (c) 2003 Alexei Shamov, DeltaX Inc.
// convert html to text
function html2txt($html)
{
    //$ret = strtr($html, array_flip(get_html_translation_table(HTML_ENTITIES)));
    $ret = strtr($html, array_flip(get_html_translation_table()));
    $ret = strip_tags(br2nl($ret));
    $ret = str_replace ( array ('[[',']]' ), array ('',''), $ret );

    require_once 'htmlpurifier/HTMLPurifier.auto.php';

	$config = HTMLPurifier_Config::createDefault();
	$config->set('HTML.Allowed', '');
	$purifier = new HTMLPurifier($config);
	$txt = $purifier->purify($ret);

    return $txt;
}



/* Convert wiki text to html for output */
//This function is a part of http://svn.studentrobotics.org/ ide2/
function wiki2html($wikitext)
{
	if(!isset($wikitext) || $wikitext == "")
		return FALSE;

	$inter_text	= $wikitext;
	while(strpos($inter_text,"[[") && strpos($inter_text,"]]"))
	{
		$link	= str_replace(array("[[", "]]"), "", substr($inter_text, strpos($inter_text, "[["), (strpos($inter_text, "]]")-strpos($inter_text, "[["))));
		if(strpos($link, "|"))
			list($href, $title)	= explode("|", $link);
		else
			$href	= 'index.php?'.FORM_LABEL_buscar.'='.$link.'&amp;sgs=off';
			$inter_text	= str_replace('[['.$link.']]', '<a href="'.$href.'" title="'.LABEL_verDetalle.$link.'">'.$link.'</a>', $inter_text);
	}


	return $inter_text;
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
		if ($limit === null) return $this->lista;
		return array_slice($this->lista, 0, $limit);
	}

	private function similar($a, $b)
	{
		$pa = $pb = 0;
		similar_text($a, $this->palavra, $pa);
		similar_text($b, $this->palavra, $pb);
		if ($pa == $pb) return 0;
		return $pa < $pb ? 1 : -1;
	}

	private function levenshtein($a, $b)
	{

		$pa = $pb = 0;
		$pa = levenshtein($a, $this->palavra);
		$pb = levenshtein($b, $this->palavra);//123
		//echo $pa.' < '.$pb.'<br>';
		if ($pa == $pb) return 0;
		return $pa < $pb ? -1 : 1;
	}
}



function evalSimiliarResults($string_a,$string_b)
{

GLOBAL $CFG;

$_MIN_DISTANCE=($CFG["_MIN_DISTANCE"]>0) ? $CFG["_MIN_DISTANCE"] : 6;

// Config values to evaluate distance between to strings (Levenstein distance)
$CFG["_COST_INST"] ='1';
$CFG["_COST_REP"] ='2';
$CFG["_COST_DEL"] ='3';


$evalSimilar=levenshtein($string_a,$string_b,$CFG["_COST_INST"],$CFG["_COST_REP"],$CFG["_COST_DEL"]);


return ($evalSimilar<$_MIN_DISTANCE);
}

function outputCosas($line){
       global $time_start;

                $time_now = time();

            if ($time_start >= $time_now + 10) {
                $time_start = $time_now;
                header('X-pmaPing: Pong');
            };
echo $line;
};


function fixEncoding($input, $output_encoding="UTF-8")
{
	return $input;
	// For some reason this is missing in the php4 in NMT
	$encoding = mb_detect_encoding($input);
	switch($encoding) {
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
 * @since 1.2.1
 *
 * @param string $str The string to be checked
 * @return bool True if $str fits a UTF-8 model, false otherwise.
 * From WordPress
 */
function seems_utf8($str) {
	$length = strlen($str);
	for ($i=0; $i < $length; $i++) {
		$c = ord($str[$i]);
		if ($c < 0x80) $n = 0; # 0bbbbbbb
		elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
		elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
		elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
		elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
		elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
		else return false; # Does not match any model
		for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
			if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
				return false;
		}
	}
	return true;
}


/*
convierte una cadena a latin1
* http://gmt-4.blogspot.com/2008/04/conversion-de-unicode-y-latin1-en-php-5.html
*/
function latin1($txt) {
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
function utf8($txt) {
 $encoding = mb_detect_encoding($txt, 'ASCII,UTF-8,ISO-8859-1');
 if ($encoding == "ISO-8859-1") {
     $txt = utf8_encode($txt);
 }
 return $txt;
}


function XSSprevent($string){

  require_once 'htmlpurifier/HTMLPurifier.auto.php';

	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	$clean_string = $purifier->purify($string);

	return $clean_string;
}


function clean($val) {
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
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // &#x0040 @ search for the hex values
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // &#00064 @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
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

########################################################################################################################
########################################################################################################################
function DBconnect(){


	include_once('adodb5/adodb.inc.php');
/*
 * Only for debug propouse
*/
//	include_once('adodb5/adodb-exceptions.inc.php');


	GLOBAL $DBCFG;

	//default driver
	$DBCFG["DBdriver"] = (!$DBCFG["DBdriver"]) ? 'mysqli' : $DBCFG["DBdriver"];

	$DB = NewADOConnection($DBCFG["DBdriver"]);

	$DB->Connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"], $DBCFG["DBName"]);



	// Si se establecio un charset para la conexion
	if(@$DBCFG["DBcharset"]){
		$DB->Execute("set names $DBCFG[DBcharset]");
		}

	//Si debug
	if($DBCFG["debugMode"]=='1'){
		echo $DB->ErrorMsg();
		};

return $DB;
}


function SQL($todo,$sql){

GLOBAL $DB;

$sql=$todo.' '.$sql;

$rs = $DB->Execute($sql);

if (!$rs) return array("error"=>$DB->ErrorMsg());

	switch($todo)
		{
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


function SQLo($todo,$sql,$array){

GLOBAL $DB;

$sql=$todo.' '.$sql;

$rs = $DB->Prepare($sql);

$rs = $DB->Execute($rs,$array);

if (!$rs) return array("error"=>$DB->ErrorMsg());

	switch($todo)
		{
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


#
# Datos del Tesauro
#
function SQLdatosTesaruo($tesauro_id){
GLOBAL $DBCFG;

$tesauro_id=secure_data($tesauro_id,"int");

return SQLo("select","id,
		titulo,
		autor,
		idioma,
		cobertura,
		keywords,
		tipo,
		cuando,
		url_base
		from $DBCFG[DBprefix]config as config
		where id=?",array($tesauro_id));
};


function SQLAuthUser($mail,$pass)
{
GLOBAL $DBCFG;

return SQLo("select","usuario.id,
			usuario.mail,
			usuario.nivel,
			concat(usuario.apellido,', ',usuario.nombres) as nombre
		from $DBCFG[DBprefix]usuario as usuario
			 where usuario.mail=?
			 and usuario.pass=?
			 and estado=1",array($mail,$pass));
};


function ARRAYcheckLogin($mail)
{
GLOBAL $DBCFG;

$sql=SQLo("select","u.id,
			u.id as user_id,
			u.mail,
			u.nivel,
			concat(u.apellido,', ',u.nombres) as nombre,
			u.pass
		from $DBCFG[DBprefix]usuario as u
			 where u.mail=?
			 and u.estado=1",array($mail));

return (is_object($sql)) ? $sql->FetchRow() : array("result"=>false);
}



//fix ADOdb5 problem to response 0 result
function SQLcount($object)
{
	return (is_object($object)) ? $object->RecordCount() : '0';
}


function loadConfigValues($renew="0")
{

	GLOBAL $arrayCFGs;

	//renovar valores
	if($renew=='1')
	{
		GLOBAL $DBCFG;

		$sql=SQL("select","v.value_id,v.value_type,v.value,v.value_code,v.value_order
						from $DBCFG[DBprefix]values v
						where v.value_type='config'");
	    if(SQLcount($sql)>0)
	    {
	    	$NEWarrayCFGs=array();
			while ($array=$sql->FetchRow()){

				switch ($array[value]){
						case 'CFG_MAX_TREE_DEEP':
						$array[value_code] = (in_array($array[value_code],array(1,2,3,4,5,6))) ? $array[value_code] : $arrayCFGs[$array[value]];
						break;

						case 'CFG_MIN_SEARCH_SIZE':
						$array[value_code] = (in_array($array[value_code],array(1,2,3,4,5,6))) ? $array[value_code] : $arrayCFGs[$array[value]];
						break;

						case 'CFG_NUM_SHOW_TERMSxSTATUS':
						$array[value_code] = (in_array($array[value_code],array(50,100,150,200,250))) ? $array[value_code] : $arrayCFGs[$array[value]];
						break;

						default:
						$array[value_code] = (in_array($array[value_code],array(1,0))) ? $array[value_code] : $arrayCFGs[$array[value]];
					}

			$NEWarrayCFGs[$array["value"]]= $array["value_code"];
			}
	    }

	  }

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


function doLastModified($thes_change=false)
{
	GLOBAL $DBCFG;
	$lastTerm=ARRAYlastTermMod();
	//select max value
	$lastTermMod=max($lastTerm["last_create"],$lastTerm["last_mod"],$lastTerm["last_status"]);
	$lastTtermMod=ARRAYlastTtermMod();
	$lastNoteMod=ARRAYlastNoteMod();

	$sqlTerm=SQL("update"," $DBCFG[DBprefix]values set value='$lastTermMod' where value_type='DATESTAMP' and value_code='TERM_CHANGE'");
	$sqlTterm=SQL("update"," $DBCFG[DBprefix]values set value='$lastTtermMod' where value_type='DATESTAMP' and value_code='TTERM_CHANGE'");
	$sqlNotes=SQL("update"," $DBCFG[DBprefix]values set value='$lastNoteMod' where value_type='DATESTAMP' and value_code='NOTE_CHANGE'");


	if($thes_change==true)
	{
		$sql=SQL("update"," $DBCFG[DBprefix]values set value='now()' where  value_type='DATESTAMP' and value_code='THES_CHANGE'");
	}
}

//last term modified
function ARRAYlastTermMod()
{
	GLOBAL $DBCFG;
	$sql=SQL("select","max(t.cuando) as last_create,max(t.cuando_final) as  last_mod,max(t.cuando_estado) as last_status from $DBCFG[DBprefix]tema t");
	$array=$sql->FetchRow();
	return $array;
}

//last foreign term modified
function ARRAYlastTtermMod()
{
	GLOBAL $DBCFG;
	$sql=SQL("select","max(tt.cuando) last from $DBCFG[DBprefix]term2tterm tt");
	$array=$sql->FetchRow();
	return $array[last];
}

//last note modified
function ARRAYlastNoteMod()
{
	GLOBAL $DBCFG;
	$sql=SQL("select","max(n.cuando) last from $DBCFG[DBprefix]notas n");
	$array=$sql->FetchRow();
	return $array[last];
}


################################# SOME GENERAL FUNCTIOS FROM WordPress #################################
############################   http://codex.wordpress.org/Function_Reference/  #########################


/**
 * Merge user defined arguments into defaults array.
 *
 * This function is used throughout WordPress to allow for both string or array
 * to be merged into another array.
 *
 * @since 2.2.0
 *
 * @param string|array $args Value to merge with $defaults
 * @param array $defaults Array that serves as the defaults.
 * @return array Merged user defined values with defaults.
 */
function t3_parse_args( $args, $defaults = '' ) {
	if ( is_object( $args ) )
		$r = get_object_vars( $args );
	elseif ( is_array( $args ) )
		$r =& $args;
	else
		t3_parse_str( $args, $r );

	if ( is_array( $defaults ) )
		return array_merge( $defaults, $r );
	return $r;
}


/**
 * Parses a string into variables to be stored in an array.
 *
 * Uses {@link http://www.php.net/parse_str parse_str()} and stripslashes if
 * {@link http://www.php.net/magic_quotes magic_quotes_gpc} is on.
 *
 * @since 2.2.1
 * @uses apply_filters() for the 'wp_parse_str' filter.
 *
 * @param string $string The string to be parsed.
 * @param array $array Variables will be stored in this array.
 */
function t3_parse_str( $string, &$array ) {
	parse_str( $string, $array );
	if ( get_magic_quotes_gpc() )
		$array = stripslashes_deep( $array );
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
 * @param array|string $value The array or string to be stripped.
 * @return array|string Stripped array (or string in the callback).
 */
function stripslashes_deep($value) {
	if ( is_array($value) ) {
		$value = array_map('stripslashes_deep', $value);
	} elseif ( is_object($value) ) {
		$vars = get_object_vars( $value );
		foreach ($vars as $key=>$data) {
			$value->{$key} = stripslashes_deep( $data );
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
	return substr($url,0,strripos($url,"/")+1);
}



function sendMail($to_address,$subject,$message,$extra=array())
{
	require_once("mailer/class.phpmailer.php");

	$mail = new PHPMailer();

/*
 * Exmple with SMTP from gmail
 *
	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = 'ssl://smtp.gmail.com';
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->Username = 'username@gmail.com';
	$mail->Password = 'password';
*/

	$mail->From = 'tematres@'.string2url($_SESSION["CFGTitulo"]);
	$mail->CharSet = "UTF-8";
	$mail->AddAddress($to_address);
	$mail->WordWrap = 50;                                 // set word wrap to 50 characters
	$mail->IsHTML(false);                                  // set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $message;

/*
 * Debug
 *
 $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
 // 1 = errors and messages
 // 2 = messages only

	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	echo $mail->ErrorInfo;
*/
 return ($mail->Send()) ? true  : false;

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

		default :

		break;
	}

	return $msg;
}

/**
 ** * From WordPress !!!
 * Create a hash (encrypt) of a plain text password.
 *
 * For integration with other applications, this function can be overwritten to
 * instead use the other package password checking algorithm.
 *
 * @since 2.5
 * @global object $wp_hasher PHPass object
 * @uses PasswordHash::HashPassword
 *
 * @param string $password Plain text user password to hash
 * @return string The hash string of the password
 */
function t3_hash_password($password) {

	require_once( 'class-phpass.php');
	// By default, use the portable hash from phpass
	$hasher = new PasswordHash(8, true);

	return $hasher->HashPassword($password);
}


/**
 ** * From WordPress !!!
 * Create a hash (encrypt) of a plain text password.
 * *
 * @param string $password Plaintext user's password
 * @param string $hash Hash of the user's password to check against.
 * @return bool False, if the $password does not match the hashed password
 */
require_once( 'class-phpass.php');

function check_password($password,$hash)
{

	if(CFG_HASH_PASS==1)
	{
		$hasher = new PasswordHash(8, true);
		return $hasher->CheckPassword($password,$hash);
	}
	else
	{
		return ($password==$hash);
	};

}
/*
 *
 * Update password for user
 */
function setPassword($user_id,$user_pass,$to_hash=0)
{
	GLOBAL $DBCFG;

	$user_pass=($to_hash==1) ? t3_hash_password($user_pass) : $user_pass;

	$sql_update_pass=SQLo("update","$DBCFG[DBprefix]usuario set pass= ? where id= ?",array($user_pass,$user_id));

	return;
};

/*
 *
 * Sanitice unidimensional arrays
 */
function XSSpreventArray($array)
{

	if( is_array($array) )
	{
		while( list($k, $v) = each($array) )
		{
						$array[$k] = XSSprevent($v);
		}
		@reset($array);
	}
	else
	{
			$array=array();
	};

return $array;
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


/*
 * Parse string separated by char into array of numeric IDs.
 */
function string2array4ID($string,$char=",")
{
	$array_temas_id=explode($char,$string);

foreach ($array_temas_id as $tema_id)
{
	$temas_id[]=secure_data($tema_id,"int");
}

	$csv_temas_id=implode($char,$temas_id);

	return $csv_temas_id;
}

/*
Check if the string is an accepted letter
 */
function isValidLetter($string)
{

	GLOBAL $CFG;

	$string=trim($string);

	$string=(in_array($string,$CFG["_EXCLUDED_CHARS"])) ?   '' : $string;

	$string=XSSprevent(urldecode($string));


	return $string;

}

#Return base URL of the current URL or instance of vocabulary
function getURLbase()
{
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	$uri = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	$segments = explode('?', $uri, 2);
	$url = $segments[0];

	$url_base=substr($url,0,strripos($url,"/")+1);

	return $url_base;
}



function loadPageTerm($tema_id){

  $tema_id=secure_data($tema_id,"int");

  return header("Location:index.php?tema=$tema_id");
}
?>
