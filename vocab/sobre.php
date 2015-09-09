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
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo T3_WEBPATH;?>bootstrap/submenu/css/bootstrap-submenu.min.css" rel="stylesheet">
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
               <input class="form-control" id="query" name="<?php echo FORM_LABEL_buscar;?>"  type="text">
               <input class="btn btn-default" type="submit" value="<?php echo LABEL_Buscar ?>" />
             </div>
           </div>
         </form>

       </div>

     </div>
   </nav>
   <div class="container">
    <?php
    $resumen=ARRAYresumen($_SESSION["id_tesa"],"G","");
    $fecha_crea=do_fecha($_SESSION["CFGCreacion"]);
    $fecha_mod=do_fecha($_SESSION["CFGlastMod"]);
    $ARRAYmailContact=ARRAYfetchValue('CONTACT_MAIL');
    ?>
<div class="container" id="bodyText">

     <h1><?php echo $_SESSION[CFGTitulo];?> / <?php echo $_SESSION[CFGAutor];?></h1>
        <dl class="dl-horizontal" id="sumario">
        <dt><?php echo ucfirst(LABEL_URI);?></dt><dd><?php echo $_SESSION[CFGURL];?> </dd>
        <dt><?php echo ucfirst(LABEL_Idioma);?></dt><dd><?php echo $_SESSION[CFGIdioma];?></dd>
        <dt><?php echo ucfirst(FORM_LABEL__contactMail);?></dt><dd><?php echo $ARRAYmailContact["value"];?></dd>
        <dt><?php echo ucfirst(LABEL_Fecha);?></dt><dd><?php echo $fecha_crea[dia].'/'.$fecha_crea[mes].'/'.$fecha_crea[ano];?></dd>
		<dt><?php echo ucfirst(LABEL_lastChangeDate);?></dt><dd><?php echo $fecha_mod[dia].'/'.$fecha_mod[mes].'/'.$fecha_mod[ano];;?>
        <dt><?php echo ucfirst(LABEL_Keywords);?></dt><dd><?php echo $_SESSION[CFGKeywords];?></dd>
        <dt><?php echo ucfirst(LABEL_TipoLenguaje);?></dt><dd><?php echo $_SESSION[CFGTipo];?></dd>
        <dt><?php echo ucfirst(LABEL_Cobertura);?></dt><dd><?php echo $_SESSION[CFGCobertura];?></dd>
        <dt><?php echo ucfirst(LABEL_Terminos);?></dt><dd><?php echo $resumen[cant_total];?>

        <?php  echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>'; ?>

        <ul>
	<?php

	if($_SESSION[$_SESSION["CFGURL"]]["CFG_VIEW_STATUS"]==1)
	{
		if($resumen[cant_candidato]>0){
			echo '<li><a href="index.php?estado_id=12">'.ucfirst(LABEL_Candidato).': '.$resumen[cant_candidato].'</a></li>';
			}

		if($resumen[cant_rechazado]>0){
			echo '<li><a href="index.php?estado_id=14">'.ucfirst(LABEL_Rechazado).': '.$resumen[cant_rechazado].'</a></li>';
			}
	}
	?>
	</ul></dd>
  <?php
  //show tree
  if(($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) && ($_SESSION[$_SESSION["CFGURL"]]["_SHOW_TREE"]==1)){

    echo '<dt>'.ucfirst(LABEL_termsXdeepLevel).'</dt><dd>'.HTMLdeepStats().'</dd>';
  }
  ?>
        <dt><?php echo ucfirst(LABEL_RelTerminos);?></dt><dd><?php echo $resumen[cant_rel];?></dd>
        <dt><?php echo ucfirst(LABEL_TerminosUP);?></dt><dd><?php echo $resumen[cant_up];?></dd>
		<?php
		//Evaluar si hay notas
		if (is_array($resumen["cant_notas"]))
		{

			  $sqlNoteType=SQLcantNotas();
			  $arrayNoteType=array();

			  while ($array=$sqlNoteType->FetchRow()){
			  		 if($array[cant]>0)
			  		 {
			  		 	 echo '<dt>';
				  		 echo  (in_array($array["value_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array(LABEL_NA,LABEL_NH,LABEL_NB,LABEL_NP,LABEL_NC),$array["value_id"]) : $array["value"];
				    	 echo '</dt><dd> '.$array[cant].'</dd>';
			  		 }
			  };
		}

		//are enable SPARQL
		if(CFG_ENABLE_SPARQL==1)
		{
			echo '<dt>'.LABEL_SPARQLEndpoint.'</dt> <dd><a href="'.$_SESSION["CFGURL"].'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.$_SESSION["CFGURL"].'sparql.php</a></dd>';
		}
		//are enable SPARQL
		if(CFG_SIMPLE_WEB_SERVICE ==1)
		{
			echo '<dt>API </dt> <dd><a href="'.$_SESSION["CFGURL"].'services.php" title="API">'.$_SESSION["CFGURL"].'services.php</a></dd>';
		}
		?>
    <dt><?php echo LABEL_Version ?></dd><dd><a href="http://www.vocabularyserver.com/" title="TemaTres: vocabulary server"><?php echo $CFG["Version"];?></a></dd>
	</dl>
	<?php


	if($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]){
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
</div><!-- /.container -->
<!-- ###### Footer ###### -->

<div id="footer" class="footer">
      <div class="container">
        <div class="row">
          <a href="http://www.vocabularyserver.com/" title="TemaTres: vocabulary server">
            <img src="<?php echo T3_WEBPATH;?>/images/tematres-logo.gif"  width="42" alt="TemaTres"/></a>
            <a href="http://www.vocabularyserver.com/" title="TemaTres: vocabulary server">TemaTres</a>
    <p class="navbar-text pull-left">
  				<?php
  				if(CFG_ENABLE_SPARQL==1)
  				{
  					echo '<a class="label label-info" href="'.$_SESSION["CFGURL"].'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
  				}
  				if(CFG_SIMPLE_WEB_SERVICE==1)
  				{
  					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
  				}
  					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
          ?>
  			</p>
    	</div>
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

<script type="application/javascript" src="js.php" charset="utf-8"></script>
 <script type='text/javascript'>

  $("#myTermTab").tabCollapse();
  $('.dropdown-submenu > a').submenupicker();

        </script>
    </body>
</html>
