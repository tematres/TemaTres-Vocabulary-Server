<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Gestion de sesiones #
  session_start();
  $SQL_CFG_LC=SQL("select","id,titulo,autor,idioma,cobertura,keywords,tipo,cuando,url_base,polijerarquia from $DBCFG[DBprefix]config where id='$CFG[DFT_TESA]'");
  
  if($SQL_CFG_LC[cant]!==1)
	{
		header("Location:install.php");
	}
  
  $CFG_LC=mysqli_fetch_row($SQL_CFG_LC[datos]);

    $_SESSION["id_tesa"]      =$CFG_LC[0];
    $_SESSION["CFGTitulo"]    =$CFG_LC[1];
    $_SESSION["CFGAutor"]     =$CFG_LC[2];
    $_SESSION["CFGIdioma"]    =$CFG_LC[3];
    $_SESSION["CFGCobertura"] =$CFG_LC[4];
    $_SESSION["CFGKeywords"]  =$CFG_LC[5];
    $_SESSION["CFGTipo"]      =$CFG_LC[6];
    $_SESSION["CFGCreacion"]  =$CFG_LC[7];
    $_SESSION["CFGURL"]       =$CFG_LC[8];
    $_SESSION["CFGPolijerarquia"]  =$CFG_LC[9];
    $_SESSION["CFGVersion"]   =$CFG[Version];


   if($_GET[setLang]){
   $_SESSION[$_SESSION["CFGURL"]][lang]=$idiomas_disponibles[$_GET[setLang]];
   }

   $_SESSION["CFGIdioma"] = ($_SESSION["CFGIdioma"]) ? $_SESSION["CFGIdioma"] : $idiomas_disponibles[0][2];
   
   
   //NO hay idioma, idioma por default ES
   if(!$_SESSION[$_SESSION["CFGURL"]][lang])
   {
   		$_SESSION[$_SESSION["CFGURL"]][lang]=$idiomas_disponibles[$_SESSION["CFGIdioma"]];
   }

   require('../common/lang/'.$_SESSION[$_SESSION["CFGURL"]][lang][1]);


 if($_GET[cmdlog]==substr(md5(date("Ymd")),"5","10")){
    unset($_SESSION[$_SESSION["CFGURL"]]);
    header("Location:index.php");
    };

if($_POST[id_correo_electronico]){
 $sql_user='';

	$sql_user=SQLAuthUser($_POST[id_correo_electronico],$_POST[id_password]);
	 if($sql_user[cant]){
		
		$array_user=mysqli_fetch_row($sql_user[datos]);

		$_SESSION[$_SESSION["CFGURL"]][ssuser_id]=$array_user[0];
		$_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=$array_user[2];
		$_SESSION[$_SESSION["CFGURL"]][ssuser_nombre]=$array_user[3];
		//redirigir
		header("Location:index.php");
	}
	else
	{
		$msgLogin=MSG_noUser;
	};
 }


?>
