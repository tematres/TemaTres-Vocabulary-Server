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
			callerOnState: 'ui-state-active'
		});
		
    });
</script>
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
    <!-- ###### Body Text ###### -->
          <?php
            if($_SESSION[$_SESSION["CFGURL"]][ssuser_id]){
            include("../common/include/inc.misTerminos.php");
            }else{
	?>
     <div id="bodyText">
      <fieldset><legend><?php echo MENU_MiCuenta;?></legend>
      <form action="<?php echo $PHP_SELF;?>" method="post" onsubmit="return checkrequired(this)">
                <label for="mail" accesskey="c">
                        <?php echo LABEL_mail;?>:</label>
                        <input         name="id_correo_electronico" class="campo"
                        id="mail"
                        maxlength="64"
                        size="11"
                        />

                <label for="clave" accesskey="l">
                        <?php echo LABEL_pass;?>:</label>
                        <input name="id_password" class="campo"
                        id="clave"
                        type="password"
                        size="11"
                        />
                        
						<div class="submit_form" align="center">
                        <input name="password"
                        id="boton"
                        type="submit"
                        value="<?php echo LABEL_Enviar;?>"
                        />
                        <?php echo $msgLogin;?>
                        </div>
        </form></fieldset>
  	</div>
<?php
            }
           ?>
    <!-- ###### Footer ###### -->
    
    <div><div id="footer">  <!-- NB: outer <div> required for correct rendering in IE -->
      <div>
        <strong>Autor: </strong>
        <span class="footerCol2"><?php echo $_SESSION["CFGAutor"];?></span>
      </div>

      <div>
        <strong>URI: </strong>
        <span class="footerCol2"><?php echo $_SESSION["CFGURL"];?></span>
      </div>

      <div>
        <strong>Version: </strong>
        <span class="footerCol2"><?php echo $_SESSION["CFGVersion"];?></span>
      </div>
    </div></div>
  </body>
</html>
