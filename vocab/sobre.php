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
  <?php echo HTMLheader($metadata);?>
  </head>
 <body>
   <div class="container">
     <div class="header">
         <h1><a href="<?php echo URL_BASE;?>index.php" title="<?php echo $_SESSION[CFGTitulo].': '.MENU_ListaSis;?> "><?php echo $_SESSION[CFGTitulo];?></a></h1>
    </div>
   </div>
   
  <?php echo HTMLnavHeader(); ?>

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

        <?php  echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>'; ?>

        <ul>
	<?php

	if($_SESSION[$_SESSION["CFGURL"]]["CFG_VIEW_STATUS"]==1)
	{
		if($resumen[cant_candidato]>0){
			echo '<li><a href="'.URL_BASE.'index.php?estado_id=12">'.ucfirst(LABEL_Candidato).': '.$resumen[cant_candidato].'</a></li>';
			}

		if($resumen[cant_rechazado]>0){
			echo '<li><a href="'.URL_BASE.'index.php?estado_id=14">'.ucfirst(LABEL_Rechazado).': '.$resumen[cant_rechazado].'</a></li>';
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
		if(CFG_ENABLE_SPARQL==1)	{
			echo '<dt>'.LABEL_SPARQLEndpoint.'</dt> <dd><a href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.$_SESSION["CFGURL"].'sparql.php</a></dd>';
		}
		//are enable SPARQL
		if(CFG_SIMPLE_WEB_SERVICE ==1)
		{
			echo '<dt>API </dt> <dd><a href="'.URL_BASE.'services.php" title="API">'.$_SESSION["CFGURL"].'services.php</a></dd>';
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
        //are enable SPARQL
        if(CFG_ENABLE_SPARQL==1)        {
          echo '<a class="label label-info" href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
        }

        if(CFG_SIMPLE_WEB_SERVICE==1)       {
          echo '  <a class="label label-info" href="'.URL_BASE.'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
        }

          echo '  <a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
          echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
        ?>

        <?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
      </p>
    	</div>
	</div>

		  </div>
<?php echo HTMLjsInclude();?>
    </body>
</html>
