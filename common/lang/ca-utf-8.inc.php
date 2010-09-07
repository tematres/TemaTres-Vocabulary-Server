<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Maribel Cuadrado 
#
###############################################################################################################
#

define("LANG","ca");

define("TR_acronimo","TR");
define("TE_acronimo","TE");
define("TG_acronimo","TG");
define("UP_acronimo","UP");

define("TR_termino","Terme relacionat");
define("TE_termino","Terme específic");
define("TG_termino","Terme general");
define("UP_termino","Usat per");
/* v 9.5 */
define("USE_termino","USEU");

define("MENU_ListaSis","Llista sistemàtica");
define("MENU_ListaAbc","Llista alfabètica");
define("MENU_Sobre","Quant a...");
define("MENU_Inicio","Inici");

define("MENU_MiCuenta","El Meu compte");
define("MENU_Usuarios","Usuaris");
define("MENU_NuevoUsuario","Nou usuari");
define("MENU_DatosTesauro","Dades del vocabulari");

define("MENU_AgregarT","Afegir Terme");
define("MENU_EditT","Editar Terme");
define("MENU_BorrarT","eliminar Terme");
define("MENU_AgregarTG","subordinar a un terme");
define("MENU_AgregarTE","terme subordinat");
define("MENU_AgregarTR","terme relacionat");
define("MENU_AgregarUP","terme equivalent");



define("MENU_MisDatos","Les meves dades");
define("MENU_Caducar","Caducar");
define("MENU_Habilitar","Habilitar");
define("MENU_Salir","Sortir");

define("LABEL_Menu","Menú");
define("LABEL_Opciones","Opcions");
define("LABEL_Admin","Administració");
define("LABEL_Agregar","Afegir");
define("LABEL_editT","Modificar terme ");
define("LABEL_EditorTermino","Editor de terme");
define("LABEL_Termino","Terme");
define("LABEL_NotaAlcance","Nota d'abast");
define("LABEL_AgregarT","Alta de terme");
define("LABEL_AgregarTG","Subordinar %s a terme superior");
define("LABEL_AgregarTE","Alta d'un terme subordinat a ");
define("LABEL_AgregarUP","Alta d'un terme equivalent per a ");
define("LABEL_AgregarTR","Alta d'un terme relacionat amb ");
define("LABEL_EliminarTE","Eliminar terme");
define("LABEL_Detalle","detalls");
define("LABEL_EditarNota","editar nota");


define("LABEL_Autor","Autor");
define("LABEL_URI","URI");
define("LABEL_Version","Generat per");
define("LABEL_Idioma","Idioma");
define("LABEL_Fecha","Data de creació");
define("LABEL_Keywords","Paraules clau");
define("LABEL_TipoLenguaje","Tipus de llenguatge");
define("LABEL_Cobertura","Cobertura");
define("LABEL_Terminos","termes");
define("LABEL_RelTerminos","relacions entre termes");
define("LABEL_TerminosUP","termes equivalents");

define("LABEL_BuscaTermino","Cercar terme");
define("LABEL_Buscar","Cercar");
define("LABEL_Enviar","Enviar");
define("LABEL_Cambiar","Guardar canvis");
define("LABEL_Anterior","anterior");
define("LABEL_AdminUser","Administració d'usuaris");
define("LABEL_DatosUser","Dades de l'usuari");
define("LABEL_Acciones","Accions realitzades");
define("LABEL_verEsquema","veure esquema");
define("LABEL_actualizar","Actualitzar");
define("LABEL_terminosLibres","Termes lliures");
define("LABEL_busqueda","Cerca");
define("LABEL_borraRelacion","eliminar relació");

define("MSG_ResultBusca","terme/s trobats a la cerca");
define("MSG_ResultLetra","Lletra");
define("MSG_ResultCambios","Els canvis han estat realitzats amb èxit.");
define("MSG_noUser","<p>Usuari no registrat</p>");

define("FORM_JS_check","Si us plau revisi les dades de ");
define("FORM_JS_confirm","Està segur que desitja eliminar el terme o la relació?");
define("FORM_JS_pass","_clau");
define("FORM_JS_confirmPass","_repetir_clau");

define("FORM_LABEL_termino","_terme");
define("FORM_LABEL_buscar","_expressio_de_cerca");
define("FORM_LABEL_buscarTermino","_terme_relacionat");

define("FORM_LABEL_nombre","_nom");
define("FORM_LABEL_apellido","_cognom");
define("FORM_LABEL_mail","_correu_electronic");
define("FORM_LABEL_pass","_clau");
define("FORM_LABEL_repass","_confirmar_clau");
define("FORM_LABEL_orga","orga");

define("LABEL_nombre","nom");
define("LABEL_apellido","cognom");
define("LABEL_mail","correu electrònic");
define("LABEL_pass","clau");
define("LABEL_repass","confirmar clau");
define("LABEL_orga","organització");

define("LABEL_lcConfig","configuració");
define("LABEL_lcDatos","dades del vocabulari");

define("LABEL_Titulo","Títol");

define("FORM_LABEL_Titulo","_titol");
define("FORM_LABEL_Autor","_autor");
define("FORM_LABEL_URI","_URI");
define("FORM_LABEL_Idioma","Idioma");
define("FORM_LABEL_FechaDia","dia");
define("FORM_LABEL_FechaMes","mes");
define("FORM_LABEL_FechaAno","any");
define("FORM_LABEL_Keywords","keywords");
define("FORM_LABEL_TipoLenguaje","language_type");
define("FORM_LABEL_Cobertura","scope");
define("FORM_LABEL_Terminos","terms");
define("FORM_LABEL_RelTerminos","relacions entre termes");
define("FORM_LABEL_TerminosUP","termes equivalents");
define("FORM_LABEL_Guardar","Guardar");

define("LABEL_verDetalle","veure detalls de ");
define("LABEL_verTerminosLetra","veure termes iniciats amb ");

define("LABEL_NB","Nota bibliogràfica");
define("LABEL_NH","Nota històrica");
define("LABEL_NA","Nota d'abast"); /* version 0.9.1 */
define("LABEL_NP","Nota privada");    /* version 0.9.1 */

define("LABEL_EditorNota","Editor de notes");
define("LABEL_EditorNotaTermino","Notes del terme ");
define("LABEL_tipoNota","tipus de nota");
define("FORM_LABEL_tipoNota","tipus_nota");
define("LABEL_nota","nota");
define("FORM_LABEL_nota","_nota");
define("LABEL_EliminarNota","Eliminar nota");

define("LABEL_OptimizarTablas","Optimitzar taules");
define("LABEL_TotalZthesLine","exportar en Zthes");

/* v 9.2 */
define("LABEL_negrita","negreta");
define("LABEL_italica","itàlica");
define("LABEL_subrayado","subratllat");
define("LABEL_textarea","espai per a notes");
define("MSGL_relacionIlegal","Relació no permesa entre termes");

/* v 9.3 */
define("LABEL_fecha_modificacion","modificació");
define("LABEL_TotalUsuarios","total d'usuaris");
define("LABEL_TotalTerminos","total de termes");
define("LABEL_ordenar","ordenar per");
define("LABEL_auditoria","auditoria de termes");
define("LABEL_dia","dia");
define("LABEL_mes","mes");
define("LABEL_ano","any");
define("LABEL_terminosRepetidos","termes repetits");
define("MSG_noTerminosLibres","no existeixen termes lliures");
define("MSG_noTerminosRepetidos","no existeixen termes repetits");
define("LABEL_TotalSkosLine","exportar en Skos-Core");

$MONTHS=array("01"=>Gen,
              "02"=>Febr,
              "03"=>Març,
              "04"=>Abr,
              "05"=>Maig,
              "06"=>Juny,
              "07"=>Jul,
              "08"=>Ag,
              "09"=>Set,
              "10"=>Oct,
              "11"=>Nov,
              "12"=>Des
              );

/* v 9.4 */
define("LABEL_SI","SI");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","polijerarquia");
define("LABEL_jeraquico","Polijerarquia");
define("LABEL_terminoLibre","terme lliure");

/* v 9.5 */
define("LABEL_URL_busqueda","Cercar %s a: ");


/* v 9.6 */
define("LABEL_relacion_vocabulario","relació amb altre vocabulari");
define("FORM_LABEL_relacion_vocabulario","equivalencia");
define("FORM_LABEL_nombre_vocabulario","vocabulari de referència");
define("LABEL_vocabulario_referencia","vocabulari de referència");
define("LABEL_NO_vocabulario_referencia","no es troben vocabularis de referència per a establir relació terminològica");
define("FORM_LABEL_tipo_equivalencia","tipus d'equivalència");
define("LABEL_vocabulario_principal","vocabulari");
define("LABEL_tipo_vocabulario","tipus");

define("LABEL_termino_equivalente","equival");
define("LABEL_termino_parcial_equivalente","equival parcialment");
define("LABEL_termino_no_equivalente","no equival");

define("EQ_acronimo","EQ");
define("EQP_acronimo","EQP");
define("NEQ_acronimo","NEQ");
define("LABEL_NC","Nota de catalogació");

define("LABEL_resultados_suplementarios","resultats suplementaris");
define("LABEL_resultados_relacionados","resultats relacionats");

/* v 9.7 */
define("LABEL_export","exportar");
define("FORM_LABEL_format_export","seleccionar format");
define("LABEL_siteMap","SiteMap");
define("LABEL_TotalTopicMap","exportar en TopicMap");


/* v 1.0 */
define("LABEL_fecha_creacion","creat");
define("NB_acronimo","NB");
define("NH_acronimo","NH");
define("NA_acronimo","NA");
define("NP_acronimo","NP");
define("NC_acronimo","NC");

define("LABEL_Candidato","terme candidat");
define("LABEL_Aceptado","terme acceptat");
define("LABEL_Rechazado","terme refusat");
define("LABEL_Ultimos_aceptados","últims termes acceptats");
define("MSG_ERROR_ESTADO","Estat no acceptable");

define("LABEL_Candidatos","termes candidats");
define("LABEL_Aceptados","termes acceptats");
define("LABEL_Rechazados","termes refusats");

define("LABEL_User_NoHabilitado","no habilitat");
define("LABEL_User_Habilitado","habilitat");

define("LABEL_CandidatearTermino","Passar a estat candidat");
define("LABEL_AceptarTermino","Acceptar terme");
define("LABEL_RechazarTermino","Refusar terme");


/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO","potser volia dir:");


/* v 1.02 */
define("LABEL_esSuperUsuario","es administrador");
define("LABEL_Cancelar","cancel·lar");
define("LABEL_Guardar","guardar");

/* v 1.033 */
define("MENU_AgregarTEexist","Subordinar un terme lliure");
define("MENU_AgregarUPexist","Associar un terme no-preferit (lliure)");
define("LABEL_existAgregarUP","Associar un terme no-preferit %s");
define("LABEL_existAgregarTE","Subordinar un terme lliure %s ");
define("MSG_minCharSerarch","L'expressió de cerca <i>%s</i> té només <strong>%s</strong> caràcters. Deu ser més gran de <strong>%s</strong> caràcters");

/* v 1.04 */
define("LABEL_terminoExistente","terme existente");
define("HELP_variosTerminos","Para agregar varios términos a la vez consigne <strong>un término por línea</strong>.");


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
     "pt"  => array("portugüés","", "pt")    
    );



/* Install messages */

define("FORM","Form") ;
define("ERROR","Error") ;
define("LABEL_bienvenida","Benvingut a TemaTres...") ;

// COMMON SQL
define("PARAM_SERVER","Server address") ;
define("PARAM_DBName","Database name") ;
define("PARAM_DBLogin","Database User") ;
define("PARAM_DBPass","Database Password") ;
define("PARAM_DBprefix","Prefix tables") ;


$install_message[101] = "Instal·lació de TemaTres" ;

$install_message[201] = "No es troba l'arxiu de configuració de la base de dades (/include/db.tematres.php) n'hi ha arxiu." ;
$install_message[202] = "Arxiu de configuració de la base de dades trobat." ;
$install_message[203] = "No es possible connectar amb el servidor  <em>%s</em> fent servir l'usuari <em>%s</em>. Si us plau revisi les dades de l'arxiu de configuració de la base de dades (/include/db.tematres.php)" ;
$install_message[204] = "Connexió amb el servidor <em>%s</em> exitosa" ;
$install_message[205] = "No es possible connectar amb la base de dades <em>%s</em> en <em>%s</em>. Si us plau revisi les dades de l'arxiu de configuració de la base de dades (/include/db.tematres.php)." ;
$install_message[206] = "Connexió amb la base de dades <em>%s</em> en <em>%s</em> verificada." ;

$install_message[301] = "Sembla que les taules ja han estat creades per a la configuració establerta." ;
$install_message[305] = "Indicació sobre el grau de seguretat de la clau.";
$install_message[306] = 'Instal·lació completa, <a href="index.php">comenci a fer servir el seu vocabulari</a>' ;
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
?>
