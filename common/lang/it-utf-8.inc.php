<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#   Author for this i18n: Andrea Garelli
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   
#  
###############################################################################################################
#

define("LANG","it");

define("TR_acronimo","RT");   // conforme iso 2788
define("TE_acronimo","NT");   // conforme iso 2788
define("TG_acronimo","BT");   // conforme iso 2788
define("UP_acronimo","UF");   // conforme iso 2788

define("TR_termino","Termine associato ");
define("TE_termino","Termine pi&ugrave; specifico ");
define("TG_termino","Termine pi&ugrave; generico ");
define("UP_termino","Usa per ");

define("MENU_ListaSis","Elenco sistematico");
define("MENU_ListaAbc","Elenco alfabetico");
define("MENU_Sobre","Info...");
define("MENU_Inicio","Home");

define("MENU_MiCuenta","Il mio accesso");
define("MENU_Usuarios","Utenti");
define("MENU_NuevoUsuario","Nuovo utente");
define("MENU_DatosTesauro","Metadati");

define("MENU_AgregarT","Aggiungi termine");
define("MENU_EditT","Modifica termine");
define("MENU_BorrarT","Cancella termine");
define("MENU_AgregarTG","Termine pi&ugrave; generico (BT)");
define("MENU_AgregarTE","Termine pi&ugrave; specifico (NT)");
define("MENU_AgregarTR","Termine associato (RT)");
define("MENU_AgregarUP","Termine non preferito (UF)");

define("MENU_MisDatos","Il mio accesso");
define("MENU_Caducar","Disabilita");
define("MENU_Habilitar","Abilita");
define("MENU_Salir","Esci");

define("LABEL_Menu","Menu");
define("LABEL_Opciones","Opzioni");
define("LABEL_Admin","Gestione");
define("LABEL_Agregar","Aggiungi");
define("LABEL_editT","Modifica termine");
define("LABEL_EditorTermino","Editor termini");
define("LABEL_Termino","Termine");
define("LABEL_NotaAlcance","Nota");
define("LABEL_AgregarT","Aggiungi termine");
define("LABEL_AgregarTG","Aggiungi termine pi&ugrave; generico a %s ");
define("LABEL_AgregarTE","Nuovo termine pi&ugrave; specifico di ");
define("LABEL_AgregarUP","Nuovo termine non preferito di ");
define("LABEL_AgregarTR","Collega termine associato a ");
define("LABEL_EliminarTE","Cancella termine");
define("LABEL_Detalle","Dettagli");


define("LABEL_Autor","Autore");
define("LABEL_URI","URI");
define("LABEL_Version","Powered by");
define("LABEL_Idioma","Lingua");
define("LABEL_Fecha","Data di creazione");
define("LABEL_Keywords","Parole chiave");
define("LABEL_TipoLenguaje","Tipo linguaggio");
define("LABEL_Cobertura","Ambito");
define("LABEL_Terminos","termini");
define("LABEL_RelTerminos","relazioni fra termini");
define("LABEL_TerminosUP","termini non preferiti");

define("LABEL_BuscaTermino","Cerca termine");
define("LABEL_Buscar","Cerca");
define("LABEL_Enviar","Conferma");
define("LABEL_Cambiar","Modifica");
define("LABEL_Anterior","Indietro");
define("LABEL_AdminUser","Gestione utenti");
define("LABEL_DatosUser","Dati utenti");
define("LABEL_Acciones","Attivit&agrave;");
define("LABEL_verEsquema","Mostra schema");
define("LABEL_actualizar","Aggiorna");
define("LABEL_terminosLibres","termini liberi");
define("LABEL_busqueda","Cerca");
define("LABEL_borraRelacion","Cancella relazione");

define("MSG_ResultBusca","termini trovati per la ricerca ");
define("MSG_ResultLetra","Lettera");
define("MSG_ResultCambios","modifiche riuscite");
define("MSG_noUser","<p>Utente non registrato</p>");

define("FORM_JS_check","Prego verifica i dati di ");
define("FORM_JS_confirm","Conferma eliminazione del termine o della relazione?");
define("FORM_JS_pass","_password");
define("FORM_JS_confirmPass","_conferma_password");

define("FORM_LABEL_termino","_termine");
define("FORM_LABEL_buscar","_condizione_di_ricerca");
define("FORM_LABEL_buscarTermino","_termine_correlato");

define("FORM_LABEL_nombre","_cognome");
define("FORM_LABEL_apellido","_nome");
define("FORM_LABEL_mail","_email");
define("FORM_LABEL_pass","_password");
define("FORM_LABEL_repass","_conferma_password");
define("FORM_LABEL_orga","_ente");

define("LABEL_nombre","nome");
define("LABEL_apellido","cognome");
define("LABEL_mail","email");
define("LABEL_pass","password");
define("LABEL_repass","conferma password");
define("LABEL_orga","ente");

define("LABEL_lcConfig","Configura");
define("LABEL_lcDatos","Metadati");

define("LABEL_Titulo","Titolo");

define("FORM_LABEL_Titulo","_titolo");
define("FORM_LABEL_Autor","_autore");
define("FORM_LABEL_URI","_URI");
define("FORM_LABEL_Idioma","_lingua");
define("FORM_LABEL_FechaDia","giorno");
define("FORM_LABEL_FechaMes","mese");
define("FORM_LABEL_FechaAno","anno");
define("FORM_LABEL_Keywords","_parole_chiave");
define("FORM_LABEL_TipoLenguaje","_tipo_linguaggio");
define("FORM_LABEL_Cobertura","_ambito");
define("FORM_LABEL_Terminos","_termini");
define("FORM_LABEL_RelTerminos","_termini_correlati");
define("FORM_LABEL_TerminosUP","_termini_non_preferiti");
define("FORM_LABEL_Guardar","Salva");

define("LABEL_verDetalle","vedi dettagli di ");
define("LABEL_verTerminosLetra","vedi termini che iniziano per ");

define("LABEL_NB","Nota bibliografica");
define("LABEL_NH","Nota storica");
define("LABEL_NA","Nota di ambito (SN)");   /* version 0.9.1 */
define("LABEL_NP","Nota riservata"); /* version 0.9.1 */

define("LABEL_EditorNota","Editor note");
define("LABEL_EditorNotaTermino","Nota per il termine ");
define("LABEL_tipoNota","tipo nota");
define("FORM_LABEL_tipoNota","_tipo_nota");
define("LABEL_nota","nota");
define("FORM_LABEL_nota","_nota");
define("LABEL_EditarNota","Modifica nota");
define("LABEL_EliminarNota","Cancella nota");

define("LABEL_OptimizarTablas","Ottimizza tabelle");
define("LABEL_TotalZthesLine","Tesauro completo in Zthes");

/* v 9.2 */
define("LABEL_negrita","grassetto");
define("LABEL_italica","corsivo");
define("LABEL_subrayado","sottolineato");
define("LABEL_textarea","note");
define("MSGL_relacionIlegal","Relazione fra termini non consentita");


/* v 9.3 */
define("LABEL_fecha_modificacion","modificato");
define("LABEL_TotalUsuarios","totale utenti");
define("LABEL_TotalTerminos","totale termini");
define("LABEL_ordenar","ordina per");
define("LABEL_auditoria","riepilogo termini");
define("LABEL_dia","giorno");
define("LABEL_mes","mese");
define("LABEL_ano","anno");
define("LABEL_terminosRepetidos","termini duplicati");
define("MSG_noTerminosLibres","non ci sono termini liberi");
define("MSG_noTerminosRepetidos","non ci sono termini duplicati");
define("LABEL_TotalSkosLine","Tesauro completo in Skos-core");

$MONTHS=array("01"=>Gen,
              "02"=>Feb,
              "03"=>Mar,
              "04"=>Apr,
              "05"=>Mag,
              "06"=>Giu,
              "07"=>Lug,
              "08"=>Ago,
              "09"=>Set,
              "10"=>Ott,
              "11"=>Nov,
              "12"=>Dic
              );

/* v 9.4 */
define("LABEL_SI","SI");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","poligerarchico");
define("LABEL_jeraquico","Poligerarchico");
define("LABEL_terminoLibre","termine libero");

/* v 9.5 */
define("LABEL_URL_busqueda","Cerca %s in: ");

/* v 9.5 */
define("USE_termino","USE");

/* v 9.6 */
define("LABEL_relacion_vocabulario","Relazione con altro vocabolario");
define("FORM_LABEL_relacion_vocabulario","equivalenza");
define("FORM_LABEL_nombre_vocabulario","vocabolario di supporto");
define("LABEL_vocabulario_referencia","vocabolario di supporto");
define("LABEL_NO_vocabulario_referencia","non c'&egrave; un vocabolario di supporto per impostare la relazione fra termini");
define("FORM_LABEL_tipo_equivalencia","tipo di equivalenza");
define("LABEL_vocabulario_principal","vocabolario");
define("LABEL_tipo_vocabulario","tipo");

define("LABEL_termino_equivalente","Equivale");
define("LABEL_termino_parcial_equivalente","Equivale parzialmente");
define("LABEL_termino_no_equivalente","Non equivale");

define("EQ_acronimo","EQ");
define("EQP_acronimo","EQP");
define("NEQ_acronimo","NEQ");
define("LABEL_NC","Nota del compilatore");

define("LABEL_resultados_suplementarios","Risultati aggiuntivi");
define("LABEL_resultados_relacionados","Risultati associati");

// define("MENU_NuevoVocabularioReferencia","Nuovo vocabolario di supporto");

/* v 9.7 */
define("LABEL_export","esporta");
define("FORM_LABEL_format_export","seleziona formato");
define("LABEL_siteMap","SiteMap");
define("LABEL_TotalTopicMap","Tesauro completo in TopicMaps");


/* v 1.0 */
define("LABEL_fecha_creacion","creato il");
// define("NB_acronimo","BN");
// define("NH_acronimo","HN");
// define("NA_acronimo","SN");
// define("NP_acronimo","PN");
// define("NC_acronimo","CN");
define("NB_acronimo","NB");  // nota bibliografica
define("NH_acronimo","NS");  // nota storica
define("NA_acronimo","SN");  // nota d'ambito - scope note
define("NP_acronimo","NP");  // nota privata
define("NC_acronimo","NC");  // nota compilatore


define("LABEL_Candidato","termine proposto");
define("LABEL_Aceptado","termine accettato");
define("LABEL_Rechazado","termine rifiutato");
define("LABEL_Ultimos_aceptados","ultimi termini accettati");
define("MSG_ERROR_ESTADO","Stato non consentito");

define("LABEL_Candidatos","termini proposti");
define("LABEL_Aceptados","termini accettati");
define("LABEL_Rechazados","termini rifiutati");

define("LABEL_User_NoHabilitado","non abilitato");
define("LABEL_User_Habilitado","abilitato");

define("LABEL_CandidatearTermino","proporre il termine");
define("LABEL_AceptarTermino","accetta termine");
define("LABEL_RechazarTermino","rifiuta termine");

/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO","forse cercavi:");


/* v 1.02 */
define("LABEL_esSuperUsuario","&egrave; admin");
define("LABEL_Cancelar","annulla");
define("LABEL_Guardar","salva");

/* v 1.033 */
define("MENU_AgregarTEexist","Subordinate An Existing Term");
define("MENU_AgregarUPexist","Associate An Existing Non-Preferred Term");
define("LABEL_existAgregarUP","Add UF term to %s");
define("LABEL_existAgregarTE","Add narrow Term to %s ");
define("MSG_minCharSerarch","The search expression <i>%s</i> has only <strong>%s </strong> characters. Must be greater than <strong>%s</strong> characters");

/* v 1.04 */
define("LABEL_terminoExistente","termini existente");
define("HELP_variosTerminos","Per aggiungere termini contemporaneamente incarna <strong>una parola per linea</strong>.");


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
?>
