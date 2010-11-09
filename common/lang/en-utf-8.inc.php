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
define("MENU_AgregarUP","non prefered Term");

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
define("LABEL_TerminosUP","non prefered terms");

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
define("MSG_ResultBusca","term/s founded for search expresion ");
define("MSG_ResultLetra","Letter");
define("MSG_ResultCambios","change succefully");
define("MSG_noUser","<p>Not a Registered User</p>");
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
define("FORM_LABEL_TerminosUP","non prefered terms");
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

$MONTHS=array("01"=>Jan,
              "02"=>Feb,
              "03"=>Mar,
              "04"=>Apr,
              "05"=>May,
              "06"=>Jun,
              "07"=>Jul,
              "08"=>Ago,
              "09"=>Sep,
              "10"=>Oct,
              "11"=>Nov,
              "12"=>Dec
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
     "fr"  => array("français","", "fr"),
     "it"  => array("italiano","", "it"),
     "nl"  => array("nederlands","", "nl"),
     "pl"  => array("polski","", "pl"),    
     "pt"  => array("portugüés","", "pt")
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


$install_message[101] = "TemaTres Setup" ;

$install_message[201] = "Can not found the file configuration for the database connection (/include/db.tematres.php)." ;
$install_message[202] = "File configuration for the database connection found." ;
$install_message[203] = "Unable to connect to database server <em>%s</em> with the user <em>%s</em>. Please check your file configuration for the database connection (/include/db.tematres.php)." ;
$install_message[204] = "Connect to Server <em>%s</em> success" ;
$install_message[205] = "Unable to connect to database <em>%s</em> in server <em>%s</em>. Please check your file configuration for the database connection (/include/db.tematres.php)." ;
$install_message[206] = "Connect to database <em>%s</em> in server <em>%s</em> success." ;

$install_message[301] = "Woppsss... There is already an Tematres instance for the configuration. Please check your file configuration for the database connection (/include/db.tematres.php)." ;
$install_message[305] = " Checking Security password." ;
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
define('LABEL_esNoPreferido',"no prefered term");
define('LABEL_BusquedaAvanzada',"advanced search");
define('LABEL_Todos',"all");
define('LABEL_QueBuscar',"what search?");

define("LABEL_import","import") ;
define("IMPORT_form_legend","import thesaurus from tabulated txt file") ;
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
define('LABEL_update1_1x1_2',"Update Tematres (1.1 -> 1.2)");
define('LABEL_TargetTerm',"terminological mapping)");
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
define('LABEL_haveWords','include words');
?>
