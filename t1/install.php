<?php
//Config lang
$lang = $tematres_lang=(in_array($_REQUEST['lang_install'],array('ca','de','en','es','fr','it','nl','pt'))) ? $_REQUEST['lang_install'] : 'es'; ;

include('../common/lang/'.$lang.'-utf-8.inc.php') ;

function message($mess) {
	echo "" ;
	echo $mess ;
	echo "<br/>" ;
}


function checkInstall($lang)
{
	GLOBAL $install_message;
	
		
	//1. check if config file exist
	if ( !file_exists('db.tematres.php') )  
	{
		return message("<span class=\"error\">$install_message[201]</span>") ;
	}
	else
	{
		message("<span class=\"success\">$install_message[202]</span>") ;
		include('db.tematres.php');
	}
	
	//2. check connection to server
	if(!$linkDB = @mysqli_connect($DBCFG["Server"], $DBCFG["DBLogin"], $DBCFG["DBPass"]))
	{
		return message('<span class="error">'.sprintf($install_message[203],$DBCFG[Server],$DBCFG[DBLogin]).'</span>') ;
	}
	else
	{
		message('<span class="success">'.sprintf($install_message[204],$DBCFG[Server]).'</span>') ;
	}

	//3. check connection to database
	if(!mysqli_select_db($linkDB,$DBCFG["DBName"]))
	{
		return message('<span class="error">'.sprintf($install_message[205],$DBCFG[DBName],$DBCFG[Server]).'</span>');
	}
	else
	{
		message('<span class="success">'.sprintf($install_message[206],$DBCFG[DBName],$DBCFG[Server]).'</span>');
	
	}
	
	
	//4. check tables		
	$sql=mysqli_query($linkDB,"SHOW TABLES from $DBCFG[DBName] where Tables_in_$DBCFG[DBName] in ('$DBCFG[DBprefix]config','$DBCFG[DBprefix]indice','$DBCFG[DBprefix]notas','$DBCFG[DBprefix]tabla_rel','$DBCFG[DBprefix]tema','$DBCFG[DBprefix]usuario','$DBCFG[DBprefix]values')");
	if (mysqli_affected_rows($linkDB)=='7')
	{		
	return message("<span class=\"error\">$install_message[301]</span>") ;		
	}
	else
	{
	//Final step: dump or form	
	if ( isset($_POST['send']) ) 
		{
		$sqlInstall=SQLtematres($DBCFG,$linkDB);
		}
		else 
		{
		echo HTMLformInstall($lang);		
		}
	}
}


function SQLtematres($DBCFG,$linkDB)
{
	
// Si se establecio un charset para la conexion
if(@$DBCFG["DBcharset"]){
	mysqli_query($linkDB,"SET NAMES $DBCFG[DBcharset]");
	}
	
	
		$title = $_POST['title'] ;
		$author = $_POST['author'] ;
		$comment = $_POST['comment'] ;
		$prefix=$DBCFG['DBprefix'] ;

		$result1 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."config` (
		  `id` int(5) unsigned NOT NULL auto_increment,
		  `titulo` varchar(255) NOT NULL default '',
		  `autor` varchar(255) NOT NULL default '',
		  `idioma` char(3) NOT NULL default 'es',
		  `cobertura` tinytext,
		  `keywords` varchar(255) default NULL,
		  `tipo` varchar(100) default NULL,
		  `polijerarquia` tinyint(1) NOT NULL default '1',
		  `cuando` date NOT NULL default '0000-00-00',
		  `observa` text,
		  `url_base` varchar(255) default NULL,
		  PRIMARY KEY  (`id`)
		) TYPE=MyISAM AUTO_INCREMENT=1 ;") ;


		//If create table --> insert data
		if($result1)
		{
			$today = date("Y-m-d") ;
			$url =  str_replace("install.php","","http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']) ;
			$title = ($_POST['title']) ? $_POST['title'] : 'TemaTres';
			$author = ($_POST['author']) ? $_POST['author'] : 'TemaTres';
			$comment = ($_POST['comment']) ? $_POST['comment'] : '';
			
			$tematres_lang=(in_array($_POST[lang_install],array('ca','de','en','es','fr','it','nl','pt'))) ? $_POST[lang_install] : 'es';
			
			$result2 = mysqli_query($linkDB,"INSERT INTO `".$prefix."config` (`id`, `titulo`, `autor`, `idioma`, `cobertura`, `keywords`, `tipo`, `polijerarquia`, `cuando`, `observa`, `url_base`) 
			VALUES (1,'$title', '$author', '$tematres_lang','$comment', '', 'Thesaurus structuré', 2, '$today', NULL, '$url') ;") ;
			}
		$result3 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."indice` (
				  `tema_id` int(11) NOT NULL default '0',
				  `indice` varchar(250) NOT NULL default '',
				  PRIMARY KEY  (`tema_id`),
				  KEY `indice` (`indice`)
				) TYPE=MyISAM COMMENT='indice de temas';") ;

		$result4 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."notas` (
				  `id` int(11) NOT NULL auto_increment,
				  `id_tema` int(11) NOT NULL default '0',
				  `tipo_nota` char(3) NOT NULL default 'NA',
				  `lang_nota` varchar(7) default NULL,
				  `nota` mediumtext NOT NULL,
				  `cuando` datetime NOT NULL default '0000-00-00 00:00:00',
				  `uid` int(5) NOT NULL default '0',
				  PRIMARY KEY  (`id`),
				  KEY `id_tema` (`id_tema`),
				  KEY `orden_notas` (`tipo_nota`,`lang_nota`)
				) TYPE=MyISAM COMMENT='Tabla de notas' AUTO_INCREMENT=1 ;") ;

		$result5 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."tabla_rel` (
				  `id_mayor` int(5) NOT NULL default '0',
				  `id_menor` int(5) NOT NULL default '0',
				  `t_relacion` tinyint(1) unsigned NOT NULL default '0',
				  `id` int(9) unsigned NOT NULL auto_increment,
				  `uid` int(10) unsigned NOT NULL default '0',
				  `cuando` datetime NOT NULL default '0000-00-00 00:00:00',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `NewIndex` (`id_mayor`,`id_menor`),
				  KEY `unico` (`t_relacion`),
				  KEY `id_menor` (`id_menor`),
				  KEY `id_mayor` (`id_mayor`)
				) TYPE=MyISAM AUTO_INCREMENT=1 ;") ;

		$result6 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."tema` (
				  `tema_id` int(10) NOT NULL auto_increment,
				  `code` VARCHAR( 20 ) NULL COMMENT 'code_term' ,
				  `tema` varchar(250) default NULL,
				  `tesauro_id` int(5) NOT NULL default '0',
				  `uid` tinyint(3) unsigned NOT NULL default '0',
				  `cuando` datetime NOT NULL default '0000-00-00 00:00:00',
				  `uid_final` int(5) unsigned default NULL,
				  `cuando_final` datetime default NULL,
				  `estado_id` int(5) NOT NULL default '13',
				  `cuando_estado` datetime NOT NULL default '0000-00-00 00:00:00',
				  PRIMARY KEY  (`tema_id`),
				  KEY ( `code` ),
				  KEY `tema` (`tema`),
				  KEY `cuando` (`cuando`,`cuando_final`),
				  KEY `uid` (`uid`,`uid_final`),
				  KEY `tesauro_id` (`tesauro_id`),
				  KEY `estado_id` (`estado_id`)
				) TYPE=MyISAM AUTO_INCREMENT=1 ;") ;

		$result61 = mysqli_query($linkDB,"CREATE TABLE IF NOT EXISTS `".$prefix."term2tterm` (
				 `tterm_id` int(22) NOT NULL AUTO_INCREMENT,
				  `tvocab_id` int(22) NOT NULL,
				  `tterm_url` varchar(200) NOT NULL,
				  `tterm_uri` varchar(200) NOT NULL,
				  `tterm_string` varchar(250) NOT NULL,
				  `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  `cuando_last` timestamp NULL DEFAULT NULL,
				  `uid` int(22) NOT NULL,
				  `tema_id` int(22) NOT NULL,
				  PRIMARY KEY (`tterm_id`),
				  KEY `tvocab_id` (`tvocab_id`,`cuando`,`cuando_last`,`uid`),
				  KEY `tema_id` (`tema_id`)
				) ENGINE=MyISAM;") ;
				
		$result62 = mysqli_query($linkDB,"CREATE TABLE IF NOT EXISTS `".$prefix."tvocab` (
				 `tvocab_id` int(22) NOT NULL AUTO_INCREMENT,
				  `tvocab_label` varchar(150) NOT NULL,
				  `tvocab_tag` varchar(5) NOT NULL,
				  `tvocab_title` varchar(200) NOT NULL,
				  `tvocab_url` varchar(250) NOT NULL,
				  `tvocab_uri_service` varchar(250) NOT NULL,
				  `tvocab_status` tinyint(1) NOT NULL,
				  `cuando` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  `uid` int(22) NOT NULL,
				  PRIMARY KEY (`tvocab_id`),
				  KEY `uid` (`uid`),
				  KEY `status` (`tvocab_status`)
				) ENGINE=MyISAM ;") ;

		$result7 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."usuario` (
				  `APELLIDO` varchar(150) default NULL,
				  `NOMBRES` varchar(150) default NULL,
				  `uid` int(9) unsigned default NULL,
				  `cuando` date default NULL,
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `mail` varchar(255) default NULL,
				  `pass` varchar(50) NOT NULL default '',
				  `orga` varchar(255) default NULL,
				  `nivel` tinyint(1) unsigned NOT NULL default '2',
				  `estado` set('ACTIVO','BAJA') NOT NULL default 'BAJA',
				  `hasta` datetime NOT NULL default '0000-00-00 00:00:00',
				  PRIMARY KEY  (`id`),
				  UNIQUE KEY `mail` (`mail`),
				  KEY `pass` (`pass`)
				) TYPE=MyISAM AUTO_INCREMENT=3 ;") ;

		$result9 = mysqli_query($linkDB,"CREATE TABLE `".$prefix."values` (
				  `value_id` int(11) NOT NULL auto_increment,
				  `value_type` varchar(10) NOT NULL default '',
				  `value` varchar(100) NOT NULL default '',
				  `value_order` tinyint(4) default NULL,
				  `value_code` varchar(5) default NULL,
				  PRIMARY KEY  (`value_id`),
				  KEY `value_type` (`value_type`)
				) TYPE=MyISAM COMMENT='general values table' AUTO_INCREMENT=1 ;") ;

		$result10 = mysqli_query($linkDB,"INSERT INTO `".$prefix."values` (`value_id`, `value_type`, `value`, `value_order`, `value_code`) VALUES (2, 't_relacion', 'Termino relacionado', NULL, 'TR'),
				(3, 't_relacion', 'Termino superior', NULL, 'TG'),
				(4, 't_relacion', 'Usado por', NULL, 'UP'),
				(5, 't_relacion', 'Equivalencia parcial', NULL, 'EQ_P'),
				(6, 't_relacion', 'Equivalencia total', NULL, 'EQ'),
				(7, 't_relacion', 'No equivalencia', NULL, 'EQ_NO'),
				(8, 't_nota', 'Nota de alcance', 1, 'NA'),
				(9, 't_nota', 'Nota histerica', 2, 'NH'),
				(10, 't_nota', 'Nota bibliografica', 3, 'NB'),
				(11, 't_nota', 'Nota privada', 4, 'NP'),
				(1, 't_usuario', 'Admin', NULL, 'admin'),
				(12, 't_estado', 'termino candidato', 1, 'C'),
				(13, 't_estado', 'termino activo', 2, 'A'),
				(14, 't_estado', 'termino rechazado', 3, 'R');") ;


		//If create table --> insert data
		if($result7)
		{

		 $admin_mail=($_POST['mail']) ? $_POST['mail'] : 'admin@r020.com.ar';
		 $admin_pass=($_POST['mdp']) ? $_POST['mdp'] : 'admin';
		 $admin_name=($_POST['name']) ? $_POST['name'] : 'admin name';
		 $admin_surname=($_POST['s_name']) ? $_POST['s_name'] : 'admin sur name';
		 
		 $result8=mysqli_query($linkDB,"INSERT INTO
			`".$prefix."usuario` (`APELLIDO`, `NOMBRES`, `uid`, `cuando`, `id`, `mail`, `pass`, `orga`, `nivel`, `estado`, `hasta`)
			VALUES
			('".$admin_name."', '".$admin_surname."', 1, now(), 1, '".$admin_mail."', '".$admin_pass."', 'TemaTres', 1, 'ACTIVO', now()),
			('DEMOSTRACION', 'USUARIO', 1, now(), 3, 'info@r020.com.ar', 'demo', 'TemaTres', 2, 'ACTIVO', now());") ;
			
		//Tematres installed
		if($result8)
		{			
			GLOBAL $install_message;
			
			$return_true = '<ul class="information">';
			$return_true .= '<h2><a href="index.php">'.ucfirst(LABEL_bienvenida).'</a></h2>' ;				
			$return_true .= '<span>'.$install_message[306].'</span>' ;				
			$return_true .='<li>'.ucfirst(LABEL_mail).': '.$admin_mail.'</li>' ;
			$return_true .= '<li>'.ucfirst(LABEL_pass).' : '.$admin_pass.'</li>' ;
			$return_true .='</ul>';
		
			message($return_true);
		}
			
		}
		
	
}


function HTMLformInstall($lang)
{
	GLOBAL $install_message;
	
	$rows='<div><form id="formulaire" name="formulaire" method="post" action="">
		<fieldset>
		<legend style="margin-bottom: 5px;">'.ucfirst(LABEL_lcDatos).'</legend>';
				
	$rows.='<div><label for="title">'.ucfirst(LABEL_Titulo).'</label>
		<input type="text" class="campo" id="title" name="title"/></div>
		<div><label for="author">'.ucfirst(LABEL_Autor).'</label>
		<input type="text" name="author" id="author" class="campo"/></div>';
/*
	$rows.='<div><label for="comment">'.ucfirst(LABEL_Cobertura).'</label>
		<input type="text" name="comment" class="campo"/></div>';
*/
	$rows.='</fieldset>';

		
	$rows.='<fieldset>
	
	<legend style="margin-bottom: 5px;">'.ucfirst(MENU_NuevoUsuario).'</legend>

		<div><label for="name">'.ucfirst(LABEL_nombre).'</label>
		<input type="text" name="name"/></div>

		<div><label for="s_name">'.ucfirst(LABEL_apellido).'</label>
		<input type="text" name="s_name"/></div>

		<div><label for="mail">'.ucfirst(LABEL_mail).'</label>
		<input type="text" name="mail"/>
		</div>
		<div><label for="mdp">'.ucfirst(LABEL_pass).'</label>
		<input type="text" name="mdp" onkeyup="test_password();" onclick="if (document.formulaire.saisie.value == \'password\') this.value = \'\'; test_password();"/>
		<img src="images/sec0.png" name="img_secu" height="20" width="0"/>
		</div>		
		<input name="resultat" type="hidden" value="bon" />
		<input name="securite" type="hidden" value="" />
		';
		
		$rows.='<input type="hidden" name="lang" value="'.$lang.'" />
				<div><input type="submit" name="send" value="'.ucfirst(LABEL_Enviar).'" /></div>
		</fieldset>
	</form></div>';
	
	return $rows;
};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $install_message[101]; ?></title>
		<link rel="stylesheet" href="../common/css/install.css" type="text/css" media="all" />
		<link rel="stylesheet" href="../common/css/forms.css" type="text/css" media="all" />
		<script type="text/javascript">
			function test_password() {
			var securite = 0 ;
			document.formulaire.mdp.value = document.formulaire.mdp.value.replace(/[^A-Za-z0-9_-]/g,"_") ;
			document.formulaire.resultat.value = "rien" ;
			if ( document.formulaire.mdp.value.match(/[A-Z]/) ) securite++ ;
			if ( document.formulaire.mdp.value.match(/[a-z]/) ) securite++ ;
			if ( document.formulaire.mdp.value.match(/[0-9]/) ) securite++ ;
			//document.formulaire.resultat.value = document.formulaire.saisie.value.length ;
			var longueur = document.formulaire.mdp.value.length ;
			if ( longueur >= 4 ) securite++ ;
			if ( longueur >= 6 ) securite++ ;
			if ( longueur >= 8 ) securite++ ;

			//document.formulaire.securite.value = securite + " (de 1 Ã  6)";
			document.img_secu.width = securite * 9 *securite + 10 ;
			switch ( securite ) {
			case 0 :
				document.img_secu.src = "../common/images/sec0.png" ;
				break ;
			case 1 :
				document.img_secu.src = "../common/images/sec1.png" ;
				break ;
			case 2 :
				document.img_secu.src = "../common/images/sec1.png" ;
				break ;
			case 3 :
				document.img_secu.src = "../common/images/sec2.png" ;
				break ;
			case 4 :
				document.img_secu.src = "../common/images/sec3.png" ;
				break ;
			case 5 :
				document.img_secu.src = "../common/images/sec3.png" ;
				break ;
			case 6 :
				document.img_secu.src = "../common/images/sec4.png" ;
				break ;
			default :
				document.img_secu.src = "../common/images/sec1.png" ;
			}
		}
		</script>
		
	</head>
	<body onload="test_password();">

<div id="bodyText">	

	<h1><?php echo $install_message[101];?></h1>
		<form  id="select_lang" method="get" action="<?php echo $PHP_SELF;?>">
		<select name="lang_install" id="lang_install" onchange="this.form.submit();">
		<optgroup label="<?php echo LABEL_Idioma;?>">
			<option value=""><?php echo LABEL_Idioma;?></option>
			<option value="ca">català</option>
			<option value="en">english</option>
			<option value="es">español</option>			
			<option value="fr">fran&ccedil;ais</option>
			<option value="pt">portug&uuml;&eacute;s</option>
			</OPTGROUP>
		</select>
	</form>

	<?php	
	echo checkInstall($lang);
	?>
		</div>
	</body>
</html>
