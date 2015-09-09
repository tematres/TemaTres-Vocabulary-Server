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

if($_SESSION[$_SESSION["CFGURL"]]["ssuser_nivel"]!=='1'){
	header("Location:login.php");
	};

//Acciones de gestion de usuarios
if($_POST["userTask"]=='A'){
	$user_id=admin_users("alta");
	header("Location:admin.php?user_id=list");
	}

if($_POST["useactua"]){
	$user_id=admin_users("actua",$_POST["useactua"]);
	header("Location:admin.php?user_id=list");
	}

if($_GET["usestado"]){
	$user_id=admin_users("estado",$_GET["usestado"]);
	header("Location:admin.php?user_id=list");
	}

if(($_POST["task_config"]=='configvocab')&&(is_numeric($_POST["vocabulario_id"]))){
	abm_vocabulario("M",$_POST["vocabulario_id"]);
	header("Location:admin.php?vocabulario_id=list");
	};

if(($_POST["task_config"]=='configvocab')&&($_POST["vocabulario_id"]=='NEW')){
	abm_vocabulario("A");
	header("Location:admin.php?vocabulario_id=list");
	};


if(($_POST["doAdmin"]=='addTargetVocabulary')){
	abm_targetVocabulary("A");
	};

if(($_POST["doAdmin"]=='saveTargetVocabulary')){
	abm_targetVocabulary("M",$_POST["tvocab_id"]);
	};

if(($_POST["doAdmin"]=='saveUserTypeNote')){
	abm_UserTypeNote("M",$_POST["tvocab_id"]);
	};

if(($_POST["doAdmin"]=='massrem')){
	REMmassiveData($_POST);
	header("Location:index.php");
	};

if(($_POST["doAdmin"]=='updateEndpointNow')){
	doSparqlEndpoint($_POST);
	header("Location:sparql.php");
	};

//Acciones de gestion de vocabularios
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

	  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
if($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]){


	if($_GET["opTbl"]=='TRUE'){
		echo optimizarTablas();
		};

	if($_GET["user_id"]=='list'){
		echo HTMLListaUsers();
		};

	if(is_numeric($_GET["user_id"])){
		require_once(T3_ABSPATH . 'common/include/inc.formUsers.php');
		}

	if($_GET["user_id"]=='new'){
		require_once(T3_ABSPATH . 'common/include/inc.formUsers.php');
	};


	if(is_numeric($_GET["vocabulario_id"])){
		require_once(T3_ABSPATH . 'common/include/inc.abmConfig.php');
		}


	if(($_GET["vocabulario_id"]=='list')||(count($_GET)<1)){
		echo HTMLlistaVocabularios();
		echo HTMLlistaTargetVocabularios();
		echo HTMLformUserNotes();
		echo HTMLformUserRelations();
		echo HTMLformURIdefinition();
		};

	//Formulario de exportación
	if($_GET["doAdmin"]=='export'){
		echo HTMLformExport();
		}

	//Regenerate indice table
	if($_GET["doAdmin"]=='reindex'){
		$sql=SQLreCreateTermIndex();
		echo $sql[cant_terms_index].' '.LABEL_Terminos;
		}

	if($_GET["doAdmin"]=='import' && empty($_REQUEST["taskAdmin"]) ){ // change Nicolas Poulain, http://tounoki.Org - 2015
		echo HTMLformImport();
	}


	if($_GET["doAdmin"]=='massiverem'){
		echo HTMLformMasiveDelete();
	}


	if($_GET["doAdmin"]=='updateEndpoint'){
		echo HTMLformUpdateEndpoit();
	}

	//Formulario de import
	if($_POST["taskAdmin"]=='importTab'){
			require_once(T3_ABSPATH . 'common/include/inc.import.php');
		};
	//Formulario de import
	if($_POST["taskAdmin"]=='importTag'){
			require_once(T3_ABSPATH . 'common/include/inc.importTXT.php');
		};
	//Formulario de import line 127 after Formulario de exportación
	if($_POST["taskAdmin"]=='importSkos'){
			require_once(T3_ABSPATH . 'common/include/inc.importSkos.php');
		};

	//Form to add / edit foreing target vocabulary
	if($_GET["doAdmin"]=='seeformTargetVocabulary'){
			echo HTMLformTargetVocabulary($_GET[tvocab_id]);
			}

	//Form to add / edit foreing target vocabulary
	if($_GET["doAdmin"]=='seeTermsTargetVocabulary'){
			echo HTMLlistaTermsTargetVocabularios($_GET[tvocab_id],$_GET[f]);
			}

	//update from tematres 1.1 -> tematres 1.2
	if($_GET["doAdmin"]=='updte1_1x1_2'){
				echo updateTemaTres('1_1x1_2');
				}

	//update from tematres 1.1 -> tematres 1.2
	if($_GET["doAdmin"]=='updte1x1_2'){
				echo updateTemaTres('1x1_2');
				}

	//update from tematres 1.3 -> tematres 1.4
	if($_GET["doAdmin"]=='updte1_3x1_4'){
				echo updateTemaTres('1_3x1_4');
				}
	//update from tematres 1.4 -> tematres 1.5
	if($_GET["doAdmin"]=='updte1_4x1_5'){
				echo updateTemaTres('1_4x1_5');
				}
	//update from tematres 1.5 -> tematres 1.6
	if($_GET["doAdmin"]=='updte1_5x1_6'){
				echo updateTemaTres('1_5x1_6');
				}
	//update from tematres 1.6 -> tematres 1.7
	if($_GET["doAdmin"]=='updte1_6x1_7'){
				echo updateTemaTres('1_6x1_7');
				}
	}
?>

</div><!-- /.container -->

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
					echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'services.php" title="API">API</a>';
				}
				echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
				echo '  <a class="label label-info" href="'.$_SESSION["CFGURL"].'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
				?>
				<?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
			</p>
		  </div>

</div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo T3_WEBPATH;?>bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/jquery.autocomplete.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/jquery.mockjax.js"></script>
  <script type="text/javascript" src="<?php echo T3_WEBPATH;?>jq/tree.jquery.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jquery.autocomplete.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo T3_WEBPATH;?>css/jqtree.css" />
 <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/submenu/js/bootstrap-submenu.min.js"></script>
 <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/js/validator.min.js"></script>
 <script type="text/javascript" src="<?php echo T3_WEBPATH;?>bootstrap/bootstrap-tabcollapse.js"></script>

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
