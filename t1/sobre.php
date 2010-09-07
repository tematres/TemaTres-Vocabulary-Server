<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
#
include("config.tematres.php");
$metadata=do_meta_tag();
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG;?>">
  <head>
  <?php echo $metadata["metadata"]; ?>
  <meta content="text/css" />
		<style type="text/css" media="screen">
			@import "../common/css/marron.css";
			@import "../common/css/forms.css";
			@import "../common/css/tables.css";
 		</style>

		<style type="text/css" media="print">
			@import "../common/css/print.css";
 		</style>

		<style type="text/css" media="handheld">
			@import "../common/css/mobile.css";
 		</style>
<script type="text/javascript" src="../common/jq/lib/jquery-1.4.2.min.js"></script>
<script type='text/javascript' src='../common/jq/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='../common/jq/jquery.autocomplete.min.js'></script>
<link rel="stylesheet" type="text/css" href="../common/jq/jquery.autocomplete.css" />
<script type="text/javascript" src="../common/jq/fg.menu.js"></script>
<link type="text/css" href="../common/jq/fg.menu.css" media="screen" rel="stylesheet" />
<link type="text/css" href="../common/jq/theme/ui.all.css" media="screen" rel="stylesheet" />			
<?php
/*
 * Load tinyMCE only if there are login
*/
if ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0) 
{
?>

 <script type="text/javascript">    
    $(function(){
    	// BUTTONS
    	$('.fg-button').hover(
    		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
    		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
    	);
    	
    	// MENUS    	
		$('#hierarchybreadcrumb').menu({
			content: $('#hierarchybreadcrumb').next().html(),
			maxHeight: 180,
			showSpeed: 300,
			backLink: false,
			flyOut: false,
			topLinkText: '<?php echo LABEL_Menu;?>',
			callerOnState: 'ui-state-active' ,
			crumbDefaultText: '<?php echo LABEL_Opciones;?>:'
		});
		$('#hierarchybreadcrumbTermMenu').menu({
			content: $('#hierarchybreadcrumbTermMenu').next().html(),
			maxHeight: 200,
			showSpeed: 300,
			backLink: false,
			flyOut: true,
			callerOnState: 'ui-state-active' ,
			crumbDefaultText: 'Choose an aaa:'
		});
		
    });
    </script>

<?php
}
?>
<script type="text/javascript" src="js.php" ></script>
</head>
  <body>
   <div id="arriba"></div>
			<div id="hd">
			  <div id="search-container" class="floatRight">
			<form method="get" id="simple-search" action="index.php" onsubmit="return checkrequired(this)">		  		  
			<input type="text" id="search-q" name="<?php echo FORM_LABEL_buscar;?>" size="20" value="<?php echo stripslashes($_REQUEST[FORM_LABEL_buscar]);?>"/>
			<div id="results"></div>
			<input class="enlace" type="submit" value="<?php echo LABEL_Buscar ?>" />
			</form>
		  </div>

				<!-- id portal_navigation_bar used to denote the top links -->
				<div class="hd" id="portal_navigation_bar">
			
				
				<!-- browse_navigation used to denote the top portal navigation links -->
					 <ul id="browse_navigation" class="inline_controls">
					 <li class="first"><a title="<?php echo MENU_Inicio;?>" href="index.php"><?php echo MENU_Inicio;?></a></li>
				<?php
				//hay sesion de usuario
				if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]){
					echo HTMLmainMenu();
				//no hay session de usuario
				}else{
				?>
					 <li><a href="login.php" title="<?php echo MENU_MiCuenta;?>"><?php echo MENU_MiCuenta;?></a></li>

				<?php
				};
				?>				
	
				<li><a title="<?php echo MENU_Sobre;?>" href="sobre.php"><?php echo MENU_Sobre;?></a></li>
				<li><a title="<?php echo LABEL_busqueda;?>" href="index.php?xsearch=1"><?php echo ucfirst(LABEL_BusquedaAvanzada);?></a></li>				
					</ul>
				</div>
			</div>	
<!-- body, or middle section of our header -->   

    <!-- ###### Header ###### -->
    <div id="header">
      <h1><a href="index.php" title="<?php echo $_SESSION[CFGTitulo].': '.MENU_ListaSis;?> "><?php echo $_SESSION[CFGTitulo];?></a></h1>
	</div>	

    <?php   
    $resumen=ARRAYresumen($_SESSION[id_tesa],"G","");
    $fecha_crea=do_fecha($_SESSION[CFGCreacion]);
    ?>
<div id="bodyText">
     <h1><?php echo $_SESSION[CFGTitulo];?> / <?php echo $_SESSION[CFGAutor];?></h1>
        <dl id="sumario">
        <dt><?php echo ucfirst(LABEL_URI);?></dt><dd><?php echo $_SESSION[CFGURL];?> </dd>
        <dt><?php echo ucfirst(LABEL_Idioma);?></dt><dd><?php echo $_SESSION[CFGIdioma];?></dd>
        <dt><?php echo ucfirst(LABEL_Fecha);?></dt><dd><?php echo $fecha_crea[dia].'/'.$fecha_crea[mes].'/'.$fecha_crea[ano];?></dd>
        <dt><?php echo ucfirst(LABEL_Keywords);?></dt><dd><?php echo $_SESSION[CFGKeywords];?></dd>
        <dt><?php echo ucfirst(LABEL_TipoLenguaje);?></dt><dd><?php echo $_SESSION[CFGTipo];?></dd>
        <dt><?php echo ucfirst(LABEL_Cobertura);?></dt><dd><?php echo $_SESSION[CFGCobertura];?></dd>
        <dt><?php echo ucfirst(LABEL_Terminos);?></dt><dd><?php echo $resumen[cant_total];?> <ul>
	<?php
	if($resumen[cant_candidato]>0){
		echo '<li><a href="index.php?estado_id=12">'.ucfirst(LABEL_Candidato).': '.$resumen[cant_candidato].'</a></li>';
		}

	if($resumen[cant_rechazado]>0){
		echo '<li><a href="index.php?estado_id=14">'.ucfirst(LABEL_Rechazado).': '.$resumen[cant_rechazado].'</a></li>';
		}
	?>
	</ul></dd>
        <dt><?php echo ucfirst(LABEL_RelTerminos);?></dt><dd><?php echo $resumen[cant_rel];?></dd>
        <dt><?php echo ucfirst(LABEL_TerminosUP);?></dt><dd><?php echo $resumen[cant_up];?></dd>
		
		<?php
		//Evaluar si hay notas
		if (is_array($resumen["cant_notas"])) 
		{
			
			$arrayTiposNotas= array('NA'=>LABEL_NA,'NH'=>LABEL_NH,'NC'=>LABEL_NC,'NB'=>LABEL_NB,'NP'=>LABEL_NP);

			foreach ($resumen["cant_notas"] as $knotas => $vnotas) 
			{
				echo '<dt>'.ucfirst($arrayTiposNotas[$knotas]).'</dt><dd>'.$vnotas.'</dd>';
				 
			}
		}	
		?>	
	</dl>
	<?php


	if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
		//es admin y quiere ver un usuario
  		if(($_GET[user_id])	&&	($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]==1))
  		{
		echo doBrowseTermsFromUser(secure_data($_GET[user_id],$_GET[ord]));
		//no es admin y quiere verse a si mismo
  		}
  		elseif($_GET[user_id])
  		{
		echo doBrowseTermsFromUser(secure_data($_SESSION[$_SESSION["CFGURL"]][ssuser_id],"sql"),secure_data($_GET[ord],"sql"));
		//quiere ver un año
		}
		elseif($_GET[y])
		{
		echo doBrowseTermsFromDate(secure_data($_GET[m],"sql"),secure_data($_GET[y],"sql"),secure_data($_GET[ord],"sql"));
		}
		else
		{
		//ver lista agregada
		echo doBrowseTermsByDate();
		}
	};
	?>
    <!-- ###### Footer ###### -->
    </div>

    <div><div id="footer">  <!-- NB: outer <div> required for correct rendering in IE -->
      <div>
        <strong><?php echo LABEL_Autor ?>: </strong>
        <span class="footerCol2"><?php echo $_SESSION["CFGAutor"];?></span>
      </div>
      <div>
        <strong><?php echo LABEL_URI ?>: </strong>
        <span class="footerCol2"> <?php echo $_SESSION["CFGURL"];?></span>
      </div>
      <div>
        <strong><?php echo LABEL_Version ?>: </strong>
        <span class="footerCol2"><?php echo $_SESSION["CFGVersion"];?></span>
      </div>
    </div></div>
  </body>
</html>
