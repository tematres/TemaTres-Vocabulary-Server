<?php
#   TemaTres : aplicaciÛn para la gestiÛn de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versiÛn 2 (de junio de 1.991) Free Software Foundation
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
# Arma un intervalo de n˙meros o meses
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
function doSelectForm($valores,$valor_selec){
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

function SqlSelectForm($sql){
    $sqlDos=SQL("select","$sql");
    while ($cons=mysqli_fetch_row($sqlDos[datos])){
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
# Abre y cierra un cÛdigo html
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
		case "sql" :
		
			GLOBAL $db;
			// vire les balises
			$data = strip_tags($data) ;
			// zappe le magic_quote dÈprÈciÈ
			if(get_magic_quotes_gpc()) {
				if(ini_get('magic_quotes_sybase'))
					$data = str_replace("''", "'", $data) ;
				else $data = stripslashes($data) ;
			}
			$data = trim($data) ;

			$data = mysqli_real_escape_string($db,$data) ;
		break ;

		case "sqlhtml" :
			
			GLOBAL $db;
			 //SQL secure with HTML tags
			// zappe le magic_quote dÈprÈciÈ
			if(get_magic_quotes_gpc()) {
				if(ini_get('magic_quotes_sybase'))
					$data = str_replace("''", "'", $data) ;
				else $data = stripslashes($data) ;
			}
			$data = trim($data) ;
			$data = mysqli_real_escape_string($db,$data) ;
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


// string 2 URL legible
// based on source from http://code.google.com/p/pan-fr/
function string2url ( $string )
{
		$string = strtr($string,
		"¿¡¬√ƒ≈‡·‚„‰Â«Á“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸æ›ˇ˝—Ò",
		"AAAAAAaaaaaaCcOOOOOOooooooEEEEeeeeIIIIiiiiUUUUuuuuYYyyNn");

		$string = str_replace('∆','AE',$string);
		$string = str_replace('Ê','ae',$string);
		$string = str_replace('º','OE',$string);
		$string = str_replace('Ω','oe',$string);

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
    $ret = strtr($html, array_flip(get_html_translation_table(HTML_ENTITIES)));
    $ret = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $ret);
    $ret = strip_tags(br2nl($ret));
    $ret = str_replace ( array ('[[',']]' ), array ('',''), $ret );
    return $ret;
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
			$href	= 'index.php?'.FORM_LABEL_buscar.'='.$link;
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

	public function __construct(array $lista, $palavra, $metodo = self::SIMILAR)
	{
		$this->lista = array_map("strtolower", $lista);
		
		$this->palavra = strtolower($palavra);
		usort($this->lista, array($this, $metodo));
	}

	/**
	* MÈtodo helper st·tico
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
		$pb = levenshtein($b, $this->palavra);
		if ($pa == $pb) return 0;
		return $pa < $pb ? -1 : 1;
	}
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



########################################################################################################################
########################################################################################################################
function ConectarseMySqli($server, $dbUser, $dbPass, $dataBase){


if(!$link = @mysqli_connect($server, $dbUser, $dbPass))
{
	//echo "<h1>Could not connect to MySQL Server at $server with user $dbUser. Please check your settings in config.tematres.php.</h1>";
	return false;
}

	   
if (!mysqli_select_db($link,$dataBase))
{
	//echo "<h1>Could not select $_SERVER[REQUEST_URI].$dataBase database. Please check your settings in config.tematres.php.</h1>";
	return false;
}
		
return $link;
}


function SQL($todo,$sql){

GLOBAL $DBCFG,$db;

// Si se establecio un charset para la conexion
if(@$DBCFG["DBcharset"]){
	mysqli_query($db,"SET NAMES $DBCFG[DBcharset]");
	}

$sql=$todo.' '.$sql;

$sql=mysqli_query($db,"$sql");


	if($todo=='insert') 
	{
		$cant=mysqli_insert_id($db);
	}
	else 
	{    
		$cant=mysqli_affected_rows($db);
	};

	$result=array("datos"=>$sql,
		"cant"=>$cant,
		"error"=>mysqli_error($db),
		"error_no"=>mysqli_errno($db)
		);

//Si debug
if(($DBCFG[debugMode]==1) && ($result[error_no]) )
	{ echo $result[error_no].': '.$result[error]; };

return $result;
};


#
# Datos del Tesauro
#
function SQLdatosTesaruo($tesauro_id){
GLOBAL $DBCFG;

$tesauro_id=secure_data($tesauro_id,"sql");

return SQL("select","id,
		titulo,
		autor,
		idioma,
		cobertura,
		keywords,
		tipo,
		cuando,
		url_base
		 from $DBCFG[DBprefix]config as config
		 where id='$tesauro_id'");
};


function SQLAuthUser($mail,$pass) 
{
GLOBAL $DBCFG;

$mail=secure_data($mail,"sql");
$pass=secure_data($pass,"sql");

return SQL("select","usuario.id,
			usuario.mail,
			usuario.nivel,
			concat(usuario.apellido,', ',usuario.nombres) as nombre
		from $DBCFG[DBprefix]usuario as usuario
			 where usuario.mail='$mail'
			 and usuario.pass='$pass'
			 and estado=1");
}


//////////////////// ADMINISTRACION y GESTION ////////////////////////////
if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
  require('fun.admin.php');
  };
?>
