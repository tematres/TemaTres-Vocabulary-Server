<?php
#   TemaTres: open source thesaurus management #       #
#                                                                        #
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Version 0.97
#
###############################################################################################################
#
define("LANG","en");

define("TR_acronimo","RT");
define("TE_acronimo","NT");
define("TG_acronimo","BT");
define("UP_acronimo","UF");

define("TR_termino","Related Term");
define("TE_termino","Narrower Term");
define("TG_termino","Broader Term");
define("UP_termino","Use for");
/* v 9.5 */
define("USE_termino","USE");

define("MENU_ListaSis","Hierarchical list");
define("MENU_ListaAbc","Alphabetic list");
define("MENU_Sobre","About...");
define("MENU_Inicio","Home");

define("MENU_MiCuenta","My account");
define("MENU_Usuarios","Users");
define("MENU_NuevoUsuario","New user");
define("MENU_DatosTesauro","About thesaurus");

define("MENU_AgregarT","Add Term");
define("MENU_EditT","Edit Term");
define("MENU_BorrarT","Delete Term");
define("MENU_AgregarTG","Subordinate the Term");
define("MENU_AgregarTE","Subordinated Term");
define("MENU_AgregarTR","Related Term");
define("MENU_AgregarUP","non preferred Term");

define("MENU_MisDatos","My account");
define("MENU_Caducar","disable");
define("MENU_Habilitar","available");
define("MENU_Salir","Logout");

define("LABEL_Menu","Menu");
define("LABEL_Opciones","Options");
define("LABEL_Admin","Administration");
define("LABEL_Agregar","Add");
define("LABEL_editT","Edit Term ");
define("LABEL_EditorTermino","Term Editor");
define("LABEL_Termino","Term");
define("LABEL_NotaAlcance","Scope Note");
define("LABEL_EliminarTE","Delete term");

define("LABEL_AgregarT","New Term");
define("LABEL_AgregarTG","Add broader Term to %s ");
define("LABEL_AgregarTE","New Term subordinated to ");
define("LABEL_AgregarUP","New UF term for ");
define("LABEL_AgregarTR","New related Term for ");
define("LABEL_Detalle","details");

define("LABEL_Autor","Author");
define("LABEL_URI","URI");
define("LABEL_Version","Powered by");
define("LABEL_Idioma","Language");
define("LABEL_Fecha","Date of creation");
define("LABEL_Keywords","Keywords");
define("LABEL_TipoLenguaje","Language type");
define("LABEL_Cobertura","Scope");
define("LABEL_Terminos","terms");
define("LABEL_RelTerminos","relations between terms");
define("LABEL_TerminosUP","non preferred terms");

define("LABEL_BuscaTermino","Search term");
define("LABEL_Buscar","Search");
define("LABEL_Enviar","Submit");
define("LABEL_Cambiar","Update");
define("LABEL_Anterior","back");
define("LABEL_AdminUser","Users admin");
define("LABEL_DatosUser","User data");
define("LABEL_Acciones","Tasks");
define("LABEL_verEsquema","show schema");
define("LABEL_actualizar","Update");
define("LABEL_terminosLibres","Free terms");
define("LABEL_busqueda","Search");
define("LABEL_borraRelacion","delete relation");
define("MSG_ResultBusca","term/s found for search expression");
define("MSG_ResultLetra","Letter");
define("MSG_ResultCambios","change succefully");
define("MSG_noUser","Not a Registered User");
define("FORM_JS_check","Pelease check the data of ");
define("FORM_JS_confirm","eliminate this relation?");
define("FORM_JS_pass","_pass");
define("FORM_JS_confirmPass","_confirm_pass");
define("FORM_LABEL_termino","_term");
define("FORM_LABEL_buscar","_search_expresion");
define("FORM_LABEL_buscarTermino","_term_related");
define("FORM_LABEL_nombre","_name");
define("FORM_LABEL_apellido","_surname");
define("FORM_LABEL_mail","_mail");
define("FORM_LABEL_pass","_pass");
define("FORM_LABEL_repass","_confirm_pass");
define("FORM_LABEL_orga","orga");
define("LABEL_nombre","name");
define("LABEL_apellido","surname");
define("LABEL_mail","mail");
define("LABEL_pass","password");
define("LABEL_repass","Confirm password");
define("LABEL_orga","organization");

define("LABEL_lcConfig","vocabulary configuration");
define("LABEL_lcDatos","vocabulary metadata");
define("LABEL_Titulo","title");
define("FORM_LABEL_Titulo","_title");
define("FORM_LABEL_Autor","_author");
define("FORM_LABEL_URI","_URI");
define("FORM_LABEL_Idioma","language");
define("FORM_LABEL_FechaDia","day");
define("FORM_LABEL_FechaMes","month");
define("FORM_LABEL_FechaAno","year");
define("FORM_LABEL_Keywords","keywords");
define("FORM_LABEL_TipoLenguaje","language_type");
define("FORM_LABEL_Cobertura","scope");
define("FORM_LABEL_Terminos","terms");
define("FORM_LABEL_RelTerminos","relations between terms");
define("FORM_LABEL_TerminosUP","Non preferred terms");
define("FORM_LABEL_Guardar","Save");
define("LABEL_verDetalle","see details from ");
define("LABEL_verTerminosLetra","see terms initiated with ");

define("LABEL_NB","Bibliographic note");
define("LABEL_NH","Historic note");
define("LABEL_NA","Scope note");   /* version 0.9.1 */
define("LABEL_NP","Private note"); /* version 0.9.1 */


define("LABEL_EditorNota","Notes Editor ");
define("LABEL_EditorNotaTermino","note for ");
define("LABEL_tipoNota","note type");
define("FORM_LABEL_tipoNota","note_type");
define("LABEL_nota","note");
define("FORM_LABEL_nota","_note");
define("LABEL_EditarNota","edit note");
define("LABEL_EliminarNota","Delete note");

define("LABEL_OptimizarTablas","Optimize tables");
define("LABEL_TotalZthesLine","export on Zthes");

/* v 9.2 */
define("LABEL_negrita","bold");
define("LABEL_italica","italic");
define("LABEL_subrayado","underline");
define("LABEL_textarea","body notes");
define("MSGL_relacionIlegal","Ilegal relation between terms");


/* v 9.3 */
define("LABEL_fecha_modificacion","modified");
define("LABEL_TotalUsuarios","total users");
define("LABEL_TotalTerminos","total terms");
define("LABEL_ordenar","order by");
define("LABEL_auditoria","terms supervision");
define("LABEL_dia","day");
define("LABEL_mes","month");
define("LABEL_ano","year");
define("LABEL_terminosRepetidos","duplicates terms");
define("MSG_noTerminosLibres","there are no free terms");
define("MSG_noTerminosRepetidos","there are no duplicates terms");
define("LABEL_TotalSkosLine","export on Skos-core");

$MONTHS=array("01"=>"Jan",
              "02"=>"Feb",
              "03"=>"Mar",
              "04"=>"Apr",
              "05"=>"May",
              "06"=>"Jun",
              "07"=>"Jul",
              "08"=>"Ago",
              "09"=>"Sep",
              "10"=>"Oct",
              "11"=>"Nov",
              "12"=>"Dec"
              );

/* v 9.4 */
define("LABEL_SI","YES");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","polihierarchical");
define("LABEL_jeraquico","Polihierarchical");
define("LABEL_terminoLibre","free term");


/* v 9.5 */
define("LABEL_URL_busqueda","Search %s in:");

/* v 9.6 */
define("LABEL_relacion_vocabulario","relación con otro vocabulario");
define("FORM_LABEL_relacion_vocabulario","equivalence");
define("FORM_LABEL_nombre_vocabulario","target vocabulary");
define("LABEL_vocabulario_referencia","target vocabulary");
define("LABEL_NO_vocabulario_referencia","there are no target vocabulary to make terminology relation");
define("FORM_LABEL_tipo_equivalencia","equivalence type");
define("LABEL_vocabulario_principal","vocabulary");
define("LABEL_tipo_vocabulario","type");

define("LABEL_termino_equivalente","equivalent");
define("LABEL_termino_parcial_equivalente","partial equivalent");
define("LABEL_termino_no_equivalente","not equivalent");

define("EQ_acronimo","EQ");
define("EQP_acronimo","EQP");
define("NEQ_acronimo","NEQ");
define("LABEL_NC","Cataloger's note");

define("LABEL_resultados_suplementarios","supplemental results");
define("LABEL_resultados_relacionados","related results");

/* v 9.7 */
define("LABEL_export","export");
define("FORM_LABEL_format_export","select XML schema");


/* v 1.0 */
define("LABEL_fecha_creacion","created");
define("NB_acronimo","BN");
define("NH_acronimo","HN");
define("NA_acronimo","SN");
define("NP_acronimo","PN");
define("NC_acronimo","CN");

define("LABEL_Candidato","candidate term");
define("LABEL_Aceptado","accepted term");
define("LABEL_Rechazado","rejected term");
define("LABEL_Ultimos_aceptados","last accepted terms");
define("MSG_ERROR_ESTADO","ilegal status");

define("LABEL_Candidatos","candidate terms");
define("LABEL_Aceptados","accepted terms");
define("LABEL_Rechazados","rejected terms");

define("LABEL_User_NoHabilitado","disable");
define("LABEL_User_Habilitado","enable");

// define("LABEL_CandidatearTermino","Candidatear término");
define("LABEL_CandidatearTermino","candidate term");
define("LABEL_AceptarTermino","accept term");
define("LABEL_RechazarTermino","reject term");


/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO","did you mean:");


/* v 1.02 */
define("LABEL_esSuperUsuario","is admin");
define("LABEL_Cancelar","cancel");
define("LABEL_Guardar","save");


/* v 1.033 */
define("MENU_AgregarTEexist","Subordinate An Existing Term");
define("MENU_AgregarUPexist","Associate An Existing Non-Preferred Term");
define("LABEL_existAgregarUP","Add UF term to %s");
define("LABEL_existAgregarTE","Add narrow Term to %s ");
define("MSG_minCharSerarch","The search expression <i>%s</i> has only <strong>%s </strong> characters. Must be greater than <strong>%s</strong> characters");

/* v 1.04 */
define("LABEL_terminoExistente","exist term");
define("HELP_variosTerminos","To add multiple terms at once please put <strong>one a term per line</strong>.");


/* v 1.05 */
$idiomas_disponibles = array(
     "ca"  => array("català", "", "ca"),
     "cn"  => array("中文","", "cn"),
     "de"  => array("deutsch","", "de"),
     "en"  => array("english", "", "en"),
     "es"  => array("español", "", "es"),
     "eu"  => array("euskera", "", "eu"),
     "fr"  => array("français","", "fr"),
     "gl"  => array("galego","", "gl"),
     "it"  => array("italiano","", "it"),
     "nl"  => array("nederlands","", "nl"),
     "pl"  => array("polski","", "pl"),
     "pt"  => array("portugüés","", "pt"),
     "ru"  => array("Pусский","", "ru")
    );

/* Install messages */

define("FORM","Form") ;
define("ERROR","Error") ;
define("LABEL_bienvenida","Welcome to TemaTres Vocabulary Server") ;

// COMMON SQL
define("PARAM_SERVER","Server address") ;
define("PARAM_DBName","Database name") ;
define("PARAM_DBLogin","Database User") ;
define("PARAM_DBPass","Database Password") ;
define("PARAM_DBprefix","Prefix tables") ;


$install_message[101] = 'TemaTres Setup' ;

$install_message[201] = 'Can not found the file configuration for the database connection (%s).';
$install_message[202] = 'File configuration for the database connection found.';
$install_message[203] = 'Unable to connect to database server <em>%s</em> with the user <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[204] = 'Connect to Server <em>%s</em> success ';
$install_message[205] = 'Unable to connect to database <em>%s</em> in server <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[206] = 'Connect to database <em>%s</em> in server <em>%s</em> success.' ;

$install_message[301] = 'Woppsss... There is already an Tematres instance for the configuration. Please check your file configuration for the database connection (%s) or <a href="index.php">Enjoy your Vocabulary Server</a>' ;
$install_message[305] = ' Checking Security password.' ;
$install_message[306] = 'Setup is completed, <a href="index.php">Enjoy your Vocabulary Server</a>' ;
/* end Install messages */


/* v 1.1 */
define('MSG_ERROR_CODE',"invalid code");
define('LABEL_CODE',"code");
define('LABEL_Ver',"Show");
define('LABEL_OpcionesTermino',"term");
define('LABEL_CambiarEstado',"Change term status");
define('LABEL_ClickEditar',"Click to edit...");
define('LABEL_TopTerm',"Has this top term");
define('LABEL_esFraseExacta',"exact phrase");
define('LABEL_DesdeFecha',"created on or after");
define('LABEL_ProfundidadTermino',"is located in deep level");
define('LABEL_esNoPreferido',"non preferred term");
define('LABEL_BusquedaAvanzada',"advanced search");
define('LABEL_Todos',"all");
define('LABEL_QueBuscar',"what search?");

define("LABEL_import","import") ;
define("IMPORT_form_legend","import thesaurus from file") ;
define("IMPORT_form_label","file") ;
define("IMPORT_file_already_exists","a txt file is already present on the server") ;
define("IMPORT_file_not_exists","no import txt file yet") ;
define("IMPORT_do_it","You can start the import") ;
define("IMPORT_working","import task are working") ;
define("IMPORT_finish","import task finished") ;
define("LABEL_reIndice","recreate indexes") ;
define("LABEL_dbMantenimiento","maintenance database");


/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService',"relation with term from remote target vocabulary");
define('LABEL_vocabulario_referenciaWS',"remote target vocabulary (web  services)");
define('LABEL_TargetVocabularyWS',"remote target vocabulary (web  services)");
define('LABEL_tvocab_label',"label for the reference");
define('LABEL_tvocab_tag',"tag for the reference");
define('LABEL_tvocab_uri_service',"URL for the web services reference");
define('LABEL_targetTermsforUpdate',"terms with pending update");
define('LABEL_ShowTargetTermsforUpdate',"check terms update");
define('LABEL_enable',"enable");
define('LABEL_disable',"disable");
define('LABEL_notFound',"term not found");
define('LABEL_termUpdated',"term updated");
define('LABEL_ShowTargetTermforUpdate',"update");
define('LABEL_relbetweenVocabularies',"relations between vocabularies");
define('LABEL_update1_1x1_2',"Update (1.1 -> 1.3)");
define('LABEL_update1x1_2',"Update (1.0x -> 1.3)");
define('LABEL_TargetTerm',"terminological mapping");
define('LABEL_TargetTerms',"terms (terminological mapping)");
define('LABEL_seleccionar','select');
define('LABEL_poliBT','more than one broader term');
define('LABEL_FORM_simpleReport','reports');
define('LABEL_FORM_advancedReport','advances reports');
define('LABEL_FORM_nullValue','no matters');
define('LABEL_FORM_haveNoteType','have note type');
define('LABEL_haveEQ','have equivalences');
define('LABEL_nohaveEQ','no equivalences');
define('LABEL_start','beginning with');
define('LABEL_end','ending with');
define('LABEL_equalThisWord','exact match to');
define('LABEL_haveWords','include words');
define('LABEL_encode','encoding');


/*
v1.21
*/
define('LABEL_import_skos','Skos-Core Import');
define('IMPORT_skos_file_already_exists','The Skos-Core source are in the server');
define('IMPORT_skos_form_legend','Import Skos-Core');
define('IMPORT_skos_form_label','Skos-Core File');

/*
v1.4
*/
define('LABEL_termsxNTterms','Narrower terms x term');
define('LABEL_termsNoBT','Terms without hierarchical relations');
define('MSG_noTermsNoBT','There are no terms without hierarchical relations');
define('LABEL_termsXcantWords','number of words x term');

define('LABEL__USE_CODE','use term codes to sort the terms');
define('LABEL__SHOW_CODE','Shown term codes in public view');
define('LABEL_CFG_MAX_TREE_DEEP','Maximum level of depth in the tree of items for display on the same page');
define('LABEL_CFG_VIEW_STATUS','Status details visible for any users');
define('LABEL_CFG_SIMPLE_WEB_SERVICE','enable web services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS','Number of terms display by status view');
define('LABEL_CFG_MIN_SEARCH_SIZE','Minimum characters for search operations');
define('LABEL__SHOW_TREE','publish hierarchical view in home');
define('LABEL__PUBLISH_SKOS','enable Skos-core format in web services. This could to expose entire your vocabulary.');

define('LABEL_update1_3x1_4',"Update (1.3x -> 1.4)");
define("FORM_LABEL_format_import","choose format");
define("LABEL_importTab","tabulated text");
define("LABEL_importTag","tagged text");
define("LABEL_importSkos","Skos-core");
define("LABEL_configTypeNotes","configure types notes");
define("LABEL_notes","notes");
define("LABEL_saved","saved");
define("FORM_JS_confirmDeleteTypeNote","eliminate this type of note?");

/*
v1.5
*/
define("LABEL_relationEditor","relations editor");
define("LABEL_relationDelete","delete relation sub-type");
define('LABEL_relationSubType',"relation type");
define('LABEL_relationSubTypeCode',"relation sub-type alias");
define('LABEL_relationSubTypeLabel',"relation sub-type label");
define('LABEL_optative',"opcional");
define('FORM_JS_confirmDeleteTypeRelation','delete this relation sub-type?');

define("LABEL_URItypeEditor","link type editor");
define("LABEL_URIEditor","manage links associated to the term");
define("LABEL_URItypeDelete","delete link type");
define('LABEL_URItype',"link type");
define('LABEL_URItypeCode',"link type alias");
define('LABEL_URItypeLabel',"link type label");
define('FORM_JS_confirmDeleteURIdefinition','delete this link type?');
define('LABEL_URI2term','web resource');
define('LABEL_URI2termURL','web resource URL');
define('LABEL_update1_4x1_5','Update (1.4 -> 1.5)');
define('LABEL_Contributor','contributor');
define('LABEL_Rights','rights');
define('LABEL_Publisher','publisher');

/*
v1.6
*/
define('LABEL_Prev','previous');
define('LABEL_Next','next');
define('LABEL_PageNum','page results number ');
define('LABEL_selectMapMethod','select terminological mapping method');
define('LABEL_string2search','search expression');
define('LABEL_reverseMappign','reverse mapping');
define('LABEL_warningMassiverem','You will eliminate data massively. These actions are irreversible!');
define('LABEL_target_terms','mapped terms from external vocabularies');
define('LABEL_URI2terms','web resources');
define('MENU_massiverem','Delete data massively');
define('LABEL_more','more');
define('LABEL_less','less');
define('LABEL_lastChangeDate','last change date');
define('LABEL_update1_5x1_6','Update (1.5 -> 1.6)');
define('LABEL_login','acceder');
define('LABEL_user_recovery_password','Get new password');
define('LABEL_user_recovery_password1','Please enter your username or email address. You will receive a link to create a new password via email.');
define('LABEL_mail_recoveryTitle','Password Reset');
define('LABEL_mail_recovery_pass1','Someone requested that the password be reset for the following account:');
define('LABEL_mail_recovery_pass2','Username: %s');
define('LABEL_mail_recovery_pass3','If this was a mistake, just ignore this email and nothing will happen.');
define('LABEL_mail_recovery_pass4','To reset your password, visit the following address:');

define('LABEL_mail_passTitle','New Password ');
define('LABEL_mail_pass1','New password for ');
define('LABEL_mail_pass2','Password: ');
define('LABEL_mail_pass3','You can change it.');
define('MSG_check_mail_link','Check your e-mail for the confirmation link.');
define('MSG_check_mail','Please check your e-mail.');
define('MSG_no_mail','The e-mail could not be sent.');
define('LABEL_user_lost_password',' Lost your password?');

## v1.7
define('LABEL_includeMetaTerm','Include meta-terms');
define('NOTE_isMetaTerm','Is a meta-term.');
define('NOTE_isMetaTermNote','A Meta-term is a term that can\'t be use in indexing process. Is a term to describe others terms. Ej: Guide terms, Facets, Categories, etc.');
define('LABEL_turnOffMetaTerm','Is not a meta-term');
define('LABEL_turnOnMetaTerm','Is a meta-term');
define('LABEL_meta_term','meta-term');
define('LABEL_meta_terms','meta-terms');
define('LABEL_relatedTerms','related terms');
define('LABEL_nonPreferedTerms','non preferred terms');
define('LABEL_update1_6x1_7','Update TemaTres (1.6 -> 1.7)');
define('LABEL_include_data','include');
define('LABEL_updateEndpoint','update SPARQL endpoint');
define('MSG__updateEndpoint','The data will be updated to be exposed in SPARQL endpoint. This operation may take several minutes.');
define('MSG__updatedEndpoint','The SPARQL endpoint is updated.');
define('MSG__dateUpdatedEndpoint','Last updated of SPARQL endpoint');
define('LABEL__ENABLE_SPARQL','You must update the SPARQL endpoint: Menu -> Administration -> Database maintance -> Update SPARQL endpoint.');
define('MSG__disable_endpoint','The SPARQL endpoint is disable.');
define('MSG__need2setup_endpoint','The SPARQL endpoint need to be updated. Please contact to the administrator.');
define('LABEL_SPARQLEndpoint','SPARQL endpoint');
define('LABEL_AgregarRTexist','Select terms to link as related term with');
define('MENU_selectExistTerm','select existing term');
define("TT_terminos","top terms");


## v1.72
define('MSG__warningDeleteTerm','The term <i>%s</i> will be <strong>DELETED</strong>.');
define('MSG__warningDeleteTerm2row','Will be deleted <strong>all</strong> his notes and relations. These action are irreversible!');


## v1.8
define('LABEL__getForRecomendation','get for recommendations');
define('LABEL__getForRecomendationFor','get for recommendations to');
define('FORM_LABEL__contactMail','contact mail');
define('LABEL_addMapLink','add mapping between vocabularies');
define('LABEL_addExactLink','add reference link');
define('LABEL_addSourceNote','add source note');

## v1.82
define('LABEL_FORM_mappedTermReport','Relationships between vocabularies');
define('LABEL_eliminar','Delete');
##v.2
define('MSG_termsNoDeleted','the terms was deleted');
define('MSG_termsDeleted','deleted terms');
define('LABEL_selectAll','select all');
define('LABEL_metadatos','metadata');
define('LABEL_totalTermsDescendants','descendant terms');
define('LABEL_altTerms','alternative terms');
define('LABEL_narrowerTerms','more specific terms');
define('LABEL_results','results');
define('LABEL_showFreeTerms','free terms list');
define('LABEL_helpSearchFreeTerms','Only free terms.');
define('LABEL_broatherTerms','broader Terms');
define('LABEL_type2filter','type to filter the terms');
define('LABEL_defaultEQmap','Type "eq" to define equivalence relationship');
define("MSG_repass_error","the passwords are not matched");
define("MSG_lengh_error","please type at least %d caracteres");
define("MSG_errorPostData","A mistake was detected, Please review the data to the field");
define('LABEL_preferedTerms','preferred terms');
define('LABEL_FORM_NULLnotesTermReport','terms WITHOUT notes');
define('MSG_FORM_NULLnotesTermReport','terms without note type');
define('LABELnoNotes','terms that have no note');
define('LABEL_termsXdeepLevel','terms for each depth level');
define('LABEL_deepLevel','deep level');
define('LABEL_cantTerms','# of terms');
define('LINK_publicKnownVocabularies','<a href="http://www.vocabularyserver.com/vocabularies/" title="List of enabled vocabularies" target="_blank">List of enabled vocabularies</a>');
define('LABEL_showNewsTerm','show recent changes');
define('LABEL_newsTerm','recent changes');
define('MSG_contactAdmin','contact to the administrator');
define('LABEL_addTargetVocabulary','add external vocabularies (terminological web services)');
?>
