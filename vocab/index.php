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
 /*term reporter*/
if(($_GET[mod]=='csv') && (substr($_GET[task],0,3)=='csv') && ($_SESSION[$_SESSION["CFGURL"]][ssuser_id]))
{
	return wichReport($_GET[task]);
}
$search_string ='';
$search_string = (doValue($_GET,FORM_LABEL_buscar)) ? XSSprevent(doValue($_GET,FORM_LABEL_buscar)) : '';
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
  <?php echo HTMLheader($metadata);?>
 </head>
 <body>
<div class="container">
  <div class="header">
      <h1><a href="<?php echo URL_BASE;?>index.php" title="<?php echo $_SESSION[CFGTitulo].': '.MENU_ListaSis;?> "><?php echo $_SESSION[CFGTitulo];?></a></h1>
 </div>
</div>
<nav class="navbar navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapsible">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" title="<?php echo MENU_Inicio.' '.$_SESSION[CFGTitulo];?>" href="<?php echo URL_BASE;?>index.php"><?php echo MENU_Inicio;?></a>
    </div>
    <div class="navbar-collapse collapse" id="navbar-collapsible">
      <ul class="nav navbar-nav navbar-right">
        <li><a title="<?php echo LABEL_busqueda;?>" href="<?php echo URL_BASE;?>index.php?xsearch=1"><?php echo ucfirst(LABEL_BusquedaAvanzada);?></a></li>

        <li><a title="<?php echo MENU_Sobre;?>" href="<?php echo URL_BASE;?>sobre.php"><?php echo MENU_Sobre;?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <?php
				//hay sesion de usuario
        if($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]){
          echo HTMLmainMenu();
        }else{//no hay session de usuario
        ?>
           <li><a href="login.php" title="<?php echo MENU_MiCuenta;?>"><?php echo MENU_MiCuenta;?></a></li>
        <?php
        };
        ?>
      </ul>
      <form method="get" id="simple-search" name="simple-search" action="<?php echo URL_BASE;?>index.php" class="navbar-form">
        <div class="form-group" style="display:inline;">
          <div class="fill col2">
            <input class="form-control" id="query" name="<?php echo FORM_LABEL_buscar;?>"  type="search">
            <input class="btn btn-default" type="submit" value="<?php echo LABEL_Buscar ?>" />
          </div>
        </div>
      </form>

    </div>

  </div>
</nav>


<div id="wrap" class="container">

<?php
	require_once(T3_ABSPATH . 'common/include/inc.inicio.php');
?>

</div><!-- /.container -->
<div class="push"></div>
<!-- ###### Footer ###### -->
<div id="footer" class="footer">
		  <div class="container">
		    	<?php
					 if(!$_GET["letra"])
					 {
						 echo HTMLlistaAlfabeticaUnica();
					 }
					 ?>


				<p class="navbar-text pull-left">
				<?php
				//are enable SPARQL
				if(CFG_ENABLE_SPARQL==1)				{
					echo '<a class="label label-info" href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
				}

				if(CFG_SIMPLE_WEB_SERVICE==1)				{
					echo '  <a class="label label-info" href="'.URL_BASE.'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
				}

					echo '  <a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
					echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
				?>

				<?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
			</p>

		  </div>

</div>
<?php echo HTMLjsInclude();?>
    </body>
</html>
