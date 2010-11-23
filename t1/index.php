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
 /*
term reporter
*/
if(($_GET[mod]=='csv') && (substr($_GET[task],0,3)=='csv') && ($_SESSION[$_SESSION["CFGURL"]][ssuser_id]))  
{
	return wichReport($_GET[task]);
}
?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG;?>">
<head>
  <?php echo $metadata["metadata"]; ?>
	<meta content="text/css" />
		<style type="text/css" media="screen">
			@import "../common/css/style.css";
 		</style>

		<style type="text/css" media="print">
			@import "../common/css/print.css";
 		</style>

		<style type="text/css" media="handheld">
			@import "../common/css/mobile.css";
 		</style>

<script type="text/javascript" src="../common/jq/lib/jquery-1.4.3.min.js"></script>
<script type='text/javascript' src='../common/jq/lib/jquery.bgiframe.min.js'></script>
<script type='text/javascript' src='../common/jq/jquery.autocomplete.min.js'></script>
<?php
/*
 * Load tinyMCE only if there are login
*/
if ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0) 
{
	?>
	<script type="text/javascript" src="../common/jq/fg.menu.js"></script>    
	<link type="text/css" href="../common/jq/fg.menu.css" media="screen" rel="stylesheet" />
	<link type="text/css" href="../common/jq/theme/ui.all.css" media="screen" rel="stylesheet" />			
	
	<script type="text/javascript" src="../common/tinymce/tiny_mce_gzip.js"></script>
	<script type="text/javascript">
	tinyMCE_GZ.init({
		themes : 'advanced',
		languages : '<?php echo LANG;?>',
		disk_cache : true,
		debug : false
	});
	</script>
	
	<script type="text/javascript">
		tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "<?php echo LABEL_nota;?>",
		language : "<?php echo LANG;?>",
		theme_advanced_buttons1 : "bold,italic,underline,|,bullist,numlist,|,undo,redo,|,link,unlink,image,|,removeformat,cleanup,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		content_css : "../common/css/style.css",
		entity_encoding : "raw",
		add_unload_trigger : false,
		remove_linebreaks : false,
		inline_styles : false,
		convert_fonts_to_spans : false,
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true
		});
	</script>
	
<script type="text/javascript" src="../common/jq/jquery.jeditable.mini.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	$(function() {
	 $(".editable_textarea").editable("searcher.php", { 
		  indicator : '<img src="../common/images/indicator.gif"/>',
		  placeholder : '[<?php echo LABEL_CODE;?>]',
		  tooltip : '<?php echo LABEL_ClickEditar;?>',
		  style  : "inherit",
		  width : '100px',
		  id   : 'code_tema_id',
		  name : 'code_tema',
		  type   : 'text',
		  onblur : 'cancel', 
		  submitdata: { _method: "put" },
		  select : true,      
		  submit : '<?php echo ucfirst(LABEL_Guardar);?>',
		  cancel : '<?php echo ucfirst(LABEL_Cancelar);?>',
		  cssclass : "editable",
		  onerror : function(settings, original, xhr) {
			original.reset()
			alert(xhr.responseText)
		}
	  });

	 $(".edit_area_term").editable("searcher.php", { 
		  indicator : '<img src="../common/images/indicator.gif"/>',
		  tooltip : '<?php echo LABEL_ClickEditar;?>',
		  id   : 'edit_tema_id',
		  name : 'edit_tema',
		  width : '300px',		  
		  rows : '2',		  
		  onblur : 'cancel',
		  type   : 'textarea',
		  submitdata: { _method: "put" },
		  select : true,      
		  submit : '<?php echo ucfirst(LABEL_Guardar);?>',
		  cancel : '<?php echo ucfirst(LABEL_Cancelar);?>',
		  cssclass : "editable",
	  });
	});
	</script>

 <script type="text/javascript">    
 window.onload=function() {
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
		
    };
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

<!-- ###### Body Text ###### -->
<?php
$search_string ='';
$search_string = (doValue($_POST,FORM_LABEL_buscar)) ? (doValue($_POST,FORM_LABEL_buscar)) : (doValue($_GET,FORM_LABEL_buscar));

if($search_string){
	echo resultaBusca($search_string,$_GET[tipo]);
	}else{
	include("../common/include/inc.inicio.php");
	};
?>
<p></p>
<!-- ###### Footer ###### -->

    <div id="footer">   
		<div id="subsidiary">  <!-- NB: outer <div> required for correct rendering in IE -->
			<div id="first">
				<?php    
				 if(count($_GET)>0) 
				 {
					 echo HTMLlistaAlfabeticaUnica();
				 }
				 ?>				
 		    </div>  		  
   		    
   		    <div id="second">
				<div>				
					<div class="clearer"></div>
					<strong><?php echo LABEL_URI ?>: </strong><span class="footerCol2"> <?php echo $_SESSION["CFGURL"];?></span>
					<div class="clearer"></div>
					<strong><?php echo LABEL_Autor ?>: </strong><span class="footerCol2"><?php echo $_SESSION["CFGAutor"];?></span>
					<div class="clearer"></div>
					<?php echo LABEL_Version ?>: <span class="footerCol2"><a href="http://tematres.r020.com.ar" title="<?php echo LABEL_Version.' '.$_SESSION["CFGVersion"]?>"><?php echo $_SESSION["CFGVersion"];?></a></span>				
					<div class="clearer"></div>
					<?php echo doMenuLang(); ?>
				</div>			
					
		    </div>
    </div>
  </div>  
 </body>
</html>
