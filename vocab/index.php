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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/submenu/css/bootstrap-submenu.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet" />
	 <link href="<?php echo T3_WEBPATH;?>css/t3style.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <?php echo $metadata["metadata"]; ?>
  <link type="image/x-icon" href="<?php echo T3_WEBPATH;?>images/tematres.ico" rel="icon" />
  <link type="image/x-icon" href="<?php echo T3_WEBPATH;?>images/tematres.ico" rel="shortcut icon" />
</head>
 <body>
<div class="container">
  <div class="header">
      <h1><a href="index.php" title="<?php echo $_SESSION[CFGTitulo].': '.MENU_ListaSis;?> "><?php echo $_SESSION[CFGTitulo];?></a></h1>
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
      <a class="navbar-brand" title="<?php echo MENU_Inicio.' '.$_SESSION[CFGTitulo];?>" href="index.php"><?php echo MENU_Inicio;?></a>
    </div>
    <div class="navbar-collapse collapse" id="navbar-collapsible">
      <ul class="nav navbar-nav navbar-right">
        <li><a title="<?php echo LABEL_busqueda;?>" href="index.php?xsearch=1"><?php echo ucfirst(LABEL_BusquedaAvanzada);?></a></li>

        <li><a title="<?php echo MENU_Sobre;?>" href="sobre.php"><?php echo MENU_Sobre;?></a></li>
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
      <form method="get" id="simple-search" name="simple-search" action="index.php" class="navbar-form">
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
				if(CFG_ENABLE_SPARQL==1)
				{
					echo '<a class="label label-info" href="'.$_SESSION["CFGURL"].'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
				}

				if(CFG_SIMPLE_WEB_SERVICE==1)
				{
					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
				}

					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
				?>

				<?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
			</p>

		  </div>

</div>
  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo T3_WEBPATH;?>bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/jquery.autocomplete.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/jquery.mockjax.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/tree.jquery.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jquery.autocomplete.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jqtree.css" />
 <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/submenu/js/bootstrap-submenu.min.js"></script>
 <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/bootstrap-tabcollapse.js"></script>

	<link type="text/css" src="<?php echo T3_WEBPATH;?>bootstrap/forms/css/styles.css"/>

<?php
if ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0)
{
	?>
<!-- Load TinyMCE -->
<script type="text/javascript" src="<?php echo T3_WEBPATH;?>tiny_mce/jquery.tinymce.js"></script>
<!-- /TinyMCE -->

	<link type="text/css" href="<?php echo T3_WEBPATH;?>jq/theme/ui.all.css" media="screen" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/jquery.jeditable.mini.js" charset="utf-8"></script>
<?php
}
?>
<script type="application/javascript" src="js.php" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo T3_WEBPATH;?>forms/jquery.validate.min.js"></script>
<?php
 if($_SESSION[$_SESSION["CFGURL"]]["lang"][2]!=='en')
		echo '<script src="'.T3_WEBPATH.'forms/localization/messages_'.$_SESSION[$_SESSION["CFGURL"]]["lang"][2].'.js" type="text/javascript"></script>';
?>

<script type='text/javascript'>

  $("#myTermTab").tabCollapse();
  $('.dropdown-submenu > a').submenupicker();

        </script>
    </body>
</html>
