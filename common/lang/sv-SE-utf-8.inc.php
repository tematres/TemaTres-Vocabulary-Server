<?php
#   TemaTres: open source thesaurus management
#   Website https://www.vocabularyserver.com
#   Copyright (C) 2004-2022 Diego Ferreyra <tematres@r020.com.ar>
#   License: distributed under the GNU General Public License Version 2 (June 1991) Free Software Foundation
#   Translation: Community collaborative translation https://crowdin.com/project/tematres
#
###############################################################################################################
#
// Translation versioning
define('LABEL_i18n_MasterDate', '2022-02-10'); /* Do not translate. Master language file creation date (YYYY-MM-DD). */
define('LABEL_i18n_MasterVersion', '3.3.1'); /* Do not translate. Master language file version. */
define('LABEL_i18n_TranslationVersion', '01'); /* Translation language file version. Will be used as a suffix for the language master version number. Can be changed by translators to track minor changes to your translation file */
define('LABEL_i18n_TranslationAuthor', 'Community translation for TemaTres'); /* Can be changed by translators. Do not include emails or personal details */
/* Strings to translate */
define("LANG", "sv-SE");
define("TR_acronimo", "RT"); /* Related Term */
define("TE_acronimo", "NT"); /* Narrower term > Specific term */
define("TG_acronimo", "BT"); /* Broader term > Generic term */
define("UP_acronimo", "UF"); /* Used for > instead */
define("TR_termino", "Relaterat begrepp");
define("TE_termino", "Underordnat begrepp");
define("TG_termino", "Överordnat begrepp");
define("UP_termino", "Används för"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "Se"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "Hierarkisk lista");
define("MENU_ListaAbc", "Alfabetisk lista");
define("MENU_Sobre", "Om...");
define("MENU_Inicio", "Start");
define("MENU_MiCuenta", "Mitt konto");
define("MENU_Usuarios", "Användare");
define("MENU_NuevoUsuario", "Ny användare");
define("MENU_DatosTesauro", "Om vokabulären");
define("MENU_AgregarT", "Nytt begrepp");
define("MENU_EditT", "Redigera begrepp");
define("MENU_BorrarT", "Radera begrepp");
define("MENU_AgregarTG", "Gör underordnat");
define("MENU_AgregarTE", "Underordnat begrepp");
define("MENU_AgregarTR", "Relaterat begrepp");
define("MENU_AgregarUP", "Synonym");  /* Non-descriptor */
define("MENU_MisDatos", "Mitt konto");
define("MENU_Caducar", "stäng av");
define("MENU_Habilitar", "aktivera");
define("MENU_Salir", "Logga ut");
define("LABEL_Menu", "Meny");
define("LABEL_Opciones", "Alternativ");
define("LABEL_Admin", "Administration");
define("LABEL_Agregar", "Lägg till");
define("LABEL_editT", "Redigera begrepp ");
define("LABEL_EditorTermino", "Begreppsredigerare");
define("LABEL_Termino", "Begrepp");
define("LABEL_NotaAlcance", "Omfattningsanteckning");
define("LABEL_EliminarTE", "Radera begrepp");
define("LABEL_AgregarT", "Nytt begrepp");
define("LABEL_AgregarTG", "Lägg till överordnat begrepp till %s ");
define("LABEL_AgregarTE", "Nytt begrepp underordnat ");
define("LABEL_AgregarUP", "Ny synonym till ");
define("LABEL_AgregarTR", "Nytt relaterat begrepp till ");
define("LABEL_Detalle", "detaljer");
define("LABEL_Autor", "Författare");
define("LABEL_URI", "URI");
define("LABEL_Version", "Drivs av");
define("LABEL_Idioma", "Språk");
define("LABEL_Fecha", "Skapad");
define("LABEL_Keywords", "Nyckelord");
define("LABEL_TipoLenguaje", "Typ av vokabulär");
define("LABEL_Cobertura", "Omfattning");
define("LABEL_Terminos", "begrepp");
define("LABEL_RelTerminos", "relationer mellan begrepp");
define("LABEL_TerminosUP", "synonymer");
define("LABEL_BuscaTermino", "Sök begrepp");
define("LABEL_Buscar", "Sök");
define("LABEL_Enviar", "Skicka");
define("LABEL_Cambiar", "Spara ändringar");
define("LABEL_Anterior", "tillbaka");
define("LABEL_AdminUser", "Hantera användare");
define("LABEL_DatosUser", "Användaruppgifter");
define("LABEL_Acciones", "Uppgifter");
define("LABEL_verEsquema", "visa schema");
define("LABEL_actualizar", "Uppdatera");
define("LABEL_terminosLibres", "Fristående begrepp"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "Sök");
define("LABEL_borraRelacion", "ta bort relation");
define("MSG_ResultBusca", "begrepp hittades för sökuttrycket");
define("MSG_ResultLetra", "Bokstav");
define("MSG_ResultCambios", "Ändringarna har sparats.");
define("MSG_noUser", "Inloggningsuppgifterna stämmer inte. Försök igen.");
define("FORM_JS_check", "Kontrollera uppgifterna i ");
define("FORM_JS_confirm", "ta bort den här relationen?");
define("FORM_JS_pass", "_pass");
define("FORM_JS_confirmPass", "_confirm_pass");
define("FORM_LABEL_termino", "_term");
define("FORM_LABEL_buscar", "_search_expresion");
define("FORM_LABEL_buscarTermino", "_term_related");
define("FORM_LABEL_nombre", "_name");
define("FORM_LABEL_apellido", "_surname");
define("FORM_LABEL_mail", "_mail");
define("FORM_LABEL_pass", "_pass");
define("FORM_LABEL_repass", "_confirm_pass");
define("FORM_LABEL_orga", "orga");
define("LABEL_nombre", "förnamn");
define("LABEL_apellido", "efternamn");
define("LABEL_mail", "e-post");
define("LABEL_pass", "lösenord");
define("LABEL_repass", "Bekräfta lösenord");
define("LABEL_orga", "organisation");
define("LABEL_lcConfig", "vokabulärinställningar");
define("LABEL_lcDatos", "vokabulärens metadata");
define("LABEL_Titulo", "titel");
define("FORM_LABEL_Titulo", "_title");
define("FORM_LABEL_Autor", "_author");
define("FORM_LABEL_URI", "_URI");
define("FORM_LABEL_Idioma", "language");
define("FORM_LABEL_FechaDia", "day");
define("FORM_LABEL_FechaMes", "month");
define("FORM_LABEL_FechaAno", "year");
define("FORM_LABEL_Keywords", "keywords");
define("FORM_LABEL_TipoLenguaje", "language_type");
define("FORM_LABEL_Cobertura", "scope");
define("FORM_LABEL_Terminos", "begrepp");
define("FORM_LABEL_RelTerminos", "relationer mellan begrepp");
define("FORM_LABEL_TerminosUP", "synonymer");
define("FORM_LABEL_Guardar", "Spara");
define("LABEL_verDetalle", "visa detaljer för ");
define("LABEL_verTerminosLetra", "visa termer som börjar på ");
define("LABEL_NB", "Bibliografisk anteckning");
define("LABEL_NH", "Historisk anteckning");
define("LABEL_NA", "Omfattningsanteckning");   /* version 0.9.1 */
define("LABEL_NP", "Privat anteckning"); /* version 0.9.1 */
define("LABEL_EditorNota", "Anteckningsredigerare ");
define("LABEL_EditorNotaTermino", "anteckning för ");
define("LABEL_tipoNota", "anteckningstyp");
define("FORM_LABEL_tipoNota", "note_type");
define("LABEL_nota", "anteckning");
define("FORM_LABEL_nota", "_note");
define("LABEL_EditarNota", "redigera anteckning");
define("LABEL_EliminarNota", "Radera anteckning");
define("LABEL_OptimizarTablas", "Optimera tabeller");
define("LABEL_TotalZthesLine", "exportera som Zthes");
/* v 9.2 */
define("LABEL_negrita", "fetstil");
define("LABEL_italica", "kursiv");
define("LABEL_subrayado", "understruken");
define("LABEL_textarea", "anteckningstext");
define("MSGL_relacionIlegal", "Otillåten relation mellan begrepp");
/* v 9.3 */
define("LABEL_fecha_modificacion", "Ändrad");
define("LABEL_TotalUsuarios", "antal användare");
define("LABEL_TotalTerminos", "antal begrepp");
define("LABEL_ordenar", "sortera efter");
define("LABEL_auditoria", "granskning av begrepp");
define("LABEL_dia", "dag");
define("LABEL_mes", "månad");
define("LABEL_ano", "År");
define("LABEL_terminosRepetidos", "dubbletter");
define("MSG_noTerminosLibres", "det finns inga fristående begrepp");
define("MSG_noTerminosRepetidos", "det finns inga dubbletter");
define("LABEL_TotalSkosLine", "exportera som SKOS-core");
$MONTHS=array("01"=>"Jan",
              "02"=>"Feb",
              "03"=>"Mar",
              "04"=>"Apr",
              "05"=>"Maj",
              "06"=>"Jun",
              "07"=>"Jul",
              "08"=>"Aug",
              "09"=>"Sep",
              "10"=>"Okt",
              "11"=>"Nov",
              "12"=>"Dec"
              );
/* v 9.4 */
define("LABEL_SI", "JA");
define("LABEL_NO", "NEJ");
define("FORM_LABEL_jeraquico", "polyhierarchical");
define("LABEL_jeraquico", "Flera överordnade tillåtna"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "fristående begrepp");
/* v 9.5 */
define("LABEL_URL_busqueda", "Sök %s i: ");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "relation till en annan vokabulär");
define("FORM_LABEL_relacion_vocabulario", "ekvivalens");
define("FORM_LABEL_nombre_vocabulario", "målvokabulär");
define("LABEL_vocabulario_referencia", "målvokabulär");
define("LABEL_NO_vocabulario_referencia", "det finns ingen målvokabulär att skapa begreppsrelation mot");
define("FORM_LABEL_tipo_equivalencia", "typ av ekvivalens");
define("LABEL_vocabulario_principal", "vokabulär");
define("LABEL_tipo_vocabulario", "typ");
define("LABEL_termino_equivalente", "ekvivalent");
define("LABEL_termino_parcial_equivalente", "delvis ekvivalent");
define("LABEL_termino_no_equivalente", "inte ekvivalent");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "EQP"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "Katalogisatörens anteckning");
define("LABEL_resultados_suplementarios", "kompletterande träffar");
define("LABEL_resultados_relacionados", "relaterade träffar");
/* v 9.7 */
define("LABEL_export", "exportera");
define("FORM_LABEL_format_export", "välj XML-schema");
/* v 1.0 */
define("LABEL_fecha_creacion", "skapad");
define("NB_acronimo", "BN"); /* Bibliographic note */
define("NH_acronimo", "HN"); /* Historical note */
define("NA_acronimo", "SN"); /* Scope or Explanatory note */
define("NP_acronimo", "PN"); /* Private note */
define("NC_acronimo", "CN"); /* Cataloger's note */
define("LABEL_Candidato", "kandidat");
define("LABEL_Aceptado", "godkänt begrepp");
define("LABEL_Rechazado", "avvisat begrepp");
define("LABEL_Ultimos_aceptados", "senast godkända begrepp");
define("MSG_ERROR_ESTADO", "otillåten status");
define("LABEL_Candidatos", "kandidater");
define("LABEL_Aceptados", "godkända begrepp");
define("LABEL_Rechazados", "avvisade begrepp");
define("LABEL_User_NoHabilitado", "avstängd");
define("LABEL_User_Habilitado", "aktiv");

define("LABEL_CandidatearTermino", "gör till kandidat");
define("LABEL_AceptarTermino", "godkänn begrepp");
define("LABEL_RechazarTermino", "avvisa begrepp");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "menade du:");
/* v 1.02 */
define("LABEL_esSuperUsuario", "är administratör");
define("LABEL_Cancelar", "avbryt");
define("LABEL_Guardar", "spara");
/* v 1.033 */
define("MENU_AgregarTEexist", "Gör ett befintligt begrepp underordnat");
define("MENU_AgregarUPexist", "Koppla en befintlig synonym");
define("LABEL_existAgregarUP", "Lägg till synonym till %s");
define("LABEL_existAgregarTE", "Lägg till underordnat begrepp till %s ");
define("MSG_minCharSerarch", "Sökuttrycket <i>%s</i> har bara <strong>%s </strong> tecken. Det måste vara fler än <strong>%s</strong> tecken");
/* v 1.04 */
define("LABEL_terminoExistente", "befintligt begrepp");
define("HELP_variosTerminos", "Vill du lägga till flera begrepp samtidigt? Skriv <strong>ett begrepp per rad</strong>.");
/* Install messages */
define("FORM", "Formulär") ;
define("ERROR", "Fel") ;
define("LABEL_bienvenida", "Välkommen till TemaTres Vocabulary Server") ;
// COMMON SQL
define("PARAM_SERVER", "Serveradress") ;
define("PARAM_DBName", "Databasnamn") ;
define("PARAM_DBLogin", "Databasanvändare") ;
define("PARAM_DBPass", "Databaslösenord") ;
define("PARAM_DBprefix", "Tabellprefix") ;
$install_message[101] = 'TemaTres Setup' ;
$install_message[201] = 'Cannot find the file configuration for the database connection (%s).';
$install_message[202] = 'File configuration for the database connection found.';
$install_message[203] = 'Unable to connect to database server <em>%s</em> with the user <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[204] = 'Connection to Server <em>%s</em> successful ';
$install_message[205] = 'Unable to connect to database <em>%s</em> in server <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[206] = 'Connection to database <em>%s</em> in server <em>%s</em> successful.' ;
$install_message[301] = 'Whoops... There is already a TemaTres instance for that configuration. Please check your file configuration for the database connection (%s) or <a href="index.php">Enjoy your Vocabulary Server</a>' ;
$install_message[305] = 'Checking security password.' ;
$install_message[306] = 'Setup is completed, <a href="index.php">Enjoy your Vocabulary Server</a>' ;
/* end Install messages */
/* v 1.1 */
define('MSG_ERROR_CODE', "ogiltig kod");
define('LABEL_CODE', "kod");
define('LABEL_Ver', "Visa");
define('LABEL_OpcionesTermino', "begrepp");
define('LABEL_CambiarEstado', "Ändra status");
define('LABEL_ClickEditar', "Klicka för att redigera...");
define('LABEL_TopTerm', "Har detta toppbegrepp");
define('LABEL_esFraseExacta', "exakt fras");
define('LABEL_DesdeFecha', "skapad den eller efter");
define('LABEL_ProfundidadTermino', "ligger på nivå");
define('LABEL_esNoPreferido', "synonym");
define('LABEL_BusquedaAvanzada', "avancerad sökning");
define('LABEL_Todos', "alla");
define('LABEL_QueBuscar', "vad vill du söka efter?");
define("LABEL_import", "importera") ;
define("IMPORT_form_legend", "importera vokabulär från fil") ;
define("IMPORT_form_label", "fil") ;
define("IMPORT_file_already_exists", "en txt-fil finns redan på servern") ;
define("IMPORT_file_not_exists", "ingen txt-fil för import ännu") ;
define("IMPORT_do_it", "Du kan starta importen") ;
define("IMPORT_working", "importen pågår") ;
define("IMPORT_finish", "importen är klar") ;
define("LABEL_reIndice", "bygg om index") ;
define("LABEL_dbMantenimiento", "databasunderhåll");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "relation till begrepp i extern målvokabulär");
define('LABEL_vocabulario_referenciaWS', "extern målvokabulär (webbtjänster)");
define('LABEL_TargetVocabularyWS', "extern målvokabulär (webbtjänster)");
define('LABEL_tvocab_label', "etikett för referensen");
define('LABEL_tvocab_tag', "tagg för referensen");
define('LABEL_tvocab_uri_service', "URL till referensens webbtjänst");
define('LABEL_targetTermsforUpdate', "begrepp som väntar på uppdatering");
define('LABEL_ShowTargetTermsforUpdate', "kontrollera uppdatering av begrepp");
define('LABEL_enable', "aktiverad");  /* web services status info: in use */
define('LABEL_disable', "avstängd");  /* web services status info: not in use */
define('LABEL_notFound', "begreppet hittades inte");
define('LABEL_termUpdated', "begreppet uppdaterat");
define('LABEL_ShowTargetTermforUpdate', "uppdatera");
define('LABEL_relbetweenVocabularies', "relationer mellan vokabulärer");
define('LABEL_update1_1x1_2', "Uppdatera (1.1 -> 1.3)");
define('LABEL_update1x1_2', "Uppdatera (1.0x -> 1.3)");
define('LABEL_TargetTerm', "begreppsmappning");
define('LABEL_TargetTerms', "begrepp (begreppsmappning)");
define('LABEL_seleccionar', 'välj');
define('LABEL_poliBT', 'fler än ett överordnat begrepp');
define('LABEL_FORM_simpleReport', 'Rapporter');
define('LABEL_FORM_advancedReport', 'avancerade rapporter');
define('LABEL_FORM_nullValue', 'spelar ingen roll');
define('LABEL_FORM_haveNoteType', 'har anteckningstyp');
define('LABEL_haveEQ', 'har ekvivalenser');
define('LABEL_nohaveEQ', 'har inga ekvivalenser');
define('LABEL_start', 'börjar med');
define('LABEL_end', 'slutar med');
define('LABEL_equalThisWord', 'exakt lika med');
define('LABEL_haveWords', 'innehåller orden');
define('LABEL_encode', 'teckenkodning');
/*
v1.21
*/
define('LABEL_import_skos', 'Import av SKOS-core');
define('IMPORT_skos_file_already_exists', 'SKOS-core-källan finns på servern');
define('IMPORT_skos_form_legend', 'Importera SKOS-core');
define('IMPORT_skos_form_label', 'SKOS-core-fil');
/*
v1.4
*/
define('LABEL_termsxNTterms', 'Underordnade begrepp per begrepp');
define('LABEL_termsNoBT', 'Begrepp utan hierarkiska relationer');
define('MSG_noTermsNoBT', 'Det finns inga begrepp utan hierarkiska relationer');
define('LABEL_termsXcantWords', 'antal ord per term');
define('LABEL__USE_CODE', 'använd begreppskoder för att sortera begreppen');
define('LABEL__SHOW_CODE', 'visa begreppskoder i den publika vyn');
define('LABEL_CFG_MAX_TREE_DEEP', 'Största antal nivåer i begreppsträdet som visas på samma sida');
define('LABEL_CFG_VIEW_STATUS', 'Statusuppgifter synliga för alla besökare');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', 'aktivera webbtjänster');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', 'Antal begrepp per sida i statusvyn');
define('LABEL_CFG_MIN_SEARCH_SIZE', 'Minsta antal tecken vid sökning');
define('LABEL__SHOW_TREE', 'visa hierarkisk vy på startsidan');
define('LABEL__PUBLISH_SKOS', 'aktivera SKOS-core i webbtjänsterna. Detta öppnar hela vokabulären.');
define('LABEL_update1_3x1_4', "Uppdatera (1.3x -> 1.4)");
define("FORM_LABEL_format_import", "välj format");
define("LABEL_importTab", "tabbseparerad text");
define("LABEL_importTag", "taggad text");
define("LABEL_importSkos", "SKOS-core");
define("LABEL_configTypeNotes", "konfigurera anteckningstyper");
define("LABEL_notes", "anteckningar");
define("LABEL_saved", "sparat");
define("FORM_JS_confirmDeleteTypeNote", "ta bort den här anteckningstypen?");
/*
v1.5
*/
define("LABEL_relationEditor", "relationsredigerare");
define("LABEL_relationDelete", "ta bort relationens undertyp");
define('LABEL_relationSubType', "relationstyp");
define('LABEL_relationSubTypeCode', "alias för relationens undertyp");
define('LABEL_relationSubTypeLabel', "etikett för relationens undertyp");
define('LABEL_optative', "valfritt");
define('FORM_JS_confirmDeleteTypeRelation', 'ta bort den här relationens undertyp?');
define("LABEL_URItypeEditor", "redigerare för länktyper");
define("LABEL_URIEditor", "hantera länkar kopplade till begreppet");
define("LABEL_URItypeDelete", "ta bort länktyp");
define('LABEL_URItype', "länktyp");
define('LABEL_URItypeCode', "alias för länktyp");
define('LABEL_URItypeLabel', "etikett för länktyp");
define('FORM_JS_confirmDeleteURIdefinition', 'ta bort den här länktypen?');
define('LABEL_URI2term', 'webbresurs');
define('LABEL_URI2termURL', 'webbresursens URL');
define('LABEL_update1_4x1_5', 'Uppdatera (1.4 -> 1.5)');
define('LABEL_Contributor', 'medverkande');
define('LABEL_Rights', 'rättigheter');
define('LABEL_Publisher', 'utgivare');
/*
v1.6
*/
define('LABEL_Prev', 'föregående');
define('LABEL_Next', 'nästa');
define('LABEL_PageNum', 'sida ');
define('LABEL_selectMapMethod', 'välj metod för begreppsmappning');
define('LABEL_string2search', 'sökuttryck');
define('LABEL_reverseMappign', 'omvänd mappning');
define('LABEL_warningMassiverem', 'Du är på väg att massradera data. Det går inte att ångra!');
define('LABEL_target_terms', 'mappade begrepp från externa vokabulärer');
define('LABEL_URI2terms', 'webbresurser');
define('MENU_massiverem', 'Massradera data');
define('LABEL_more', 'mer');
define('LABEL_less', 'mindre');
define('LABEL_lastChangeDate', 'senast ändrad');
define('LABEL_update1_5x1_6', 'Uppdatera (1.5 -> 1.6)');
define('LABEL_login', 'logga in');
define('LABEL_user_recovery_password', 'Få nytt lösenord');
define('LABEL_user_recovery_password1', 'Ange ditt användarnamn eller din e-postadress. Du får en länk för att skapa ett nytt lösenord via e-post.');
define('LABEL_mail_recoveryTitle', 'Återställning av lösenord');
define('LABEL_mail_recovery_pass1', 'Någon har begärt att lösenordet ska återställas för följande konto:');
define('LABEL_mail_recovery_pass2', 'Användarnamn: %s');
define('LABEL_mail_recovery_pass3', 'Om detta var ett misstag kan du bortse från det här e-postmeddelandet, så händer ingenting.');
define('LABEL_mail_recovery_pass4', 'Besök följande adress för att återställa ditt lösenord:');
define('LABEL_mail_passTitle', 'Nytt lösenord ');
define('LABEL_mail_pass1', 'Nytt lösenord för ');
define('LABEL_mail_pass2', 'Lösenord: ');
define('LABEL_mail_pass3', 'Du kan ändra det.');
define('MSG_check_mail_link', 'Om e-postadressen är giltig skickar vi ett e-postmeddelande med en bekräftelselänk.');
define('MSG_check_mail', 'Om e-postadressen är giltig skickar vi ett e-postmeddelande för att återställa lösenordet.');
define('MSG_no_mail', 'E-postmeddelandet kunde inte skickas.');
define('LABEL_user_lost_password', 'Har du glömt lösenordet?');
## v1.7
define('LABEL_includeMetaTerm', 'Ta med metatermer');
define('NOTE_isMetaTerm', 'Är en metaterm.');
define('NOTE_isMetaTermNote', 'En metaterm är ett begrepp som inte kan användas vid indexering. Den används för att beskriva andra begrepp, till exempel ledtermer, fasetter och kategorier.');
define('LABEL_turnOffMetaTerm', 'Är inte en metaterm');
define('LABEL_turnOnMetaTerm', 'Är en metaterm');
define('LABEL_meta_term', 'metaterm');
define('LABEL_meta_terms', 'metatermer');
define('LABEL_relatedTerms', 'relaterade begrepp');
define('LABEL_nonPreferedTerms', 'synonymer');
define('LABEL_update1_6x1_7', 'Uppdatera (1.6 -> 2.2)');
define('LABEL_include_data', 'ta med');
define('LABEL_updateEndpoint', 'uppdatera SPARQL-endpoint');
define('MSG__updateEndpoint', 'Data uppdateras för att visas i SPARQL-endpoint. Det kan ta flera minuter.');
define('MSG__updatedEndpoint', 'SPARQL-endpoint är uppdaterad.');
define('MSG__dateUpdatedEndpoint', 'SPARQL-endpoint senast uppdaterad');
define('LABEL__ENABLE_SPARQL', 'Du måste uppdatera SPARQL-endpoint: Meny -> Administration -> Databasunderhåll -> Uppdatera SPARQL-endpoint.');
define('MSG__disable_endpoint', 'SPARQL-endpoint är avstängd.');
define('MSG__need2setup_endpoint', 'SPARQL-endpoint behöver uppdateras. Kontakta administratören.');
define('LABEL_SPARQLEndpoint', 'SPARQL-endpoint');
define('LABEL_AgregarRTexist', 'Välj begrepp att koppla som relaterade till ');
define('MENU_selectExistTerm', 'välj befintligt begrepp');
define("TT_terminos", "toppbegrepp");
## v1.72
define('MSG__warningDeleteTerm', 'Begreppet <i>%s</i> kommer att <strong>RADERAS</strong>.');
define('MSG__warningDeleteTerm2row', 'Begreppets <strong>alla</strong> anteckningar och relationer raderas också. Det går inte att ångra!');
## v1.8
define('LABEL__getForRecomendation', 'hämta förslag');
define('LABEL__getForRecomendationFor', 'hämta förslag för ');
define('FORM_LABEL__contactMail', 'kontakt-e-post');
define('LABEL_addMapLink', 'lägg till mappning mellan vokabulärer');
define('LABEL_addExactLink', 'lägg till referenslänk');
define('LABEL_addSourceNote', 'lägg till källanteckning');
## v1.82
define('LABEL_FORM_mappedTermReport', 'Relationer mellan vokabulärer');
define('LABEL_eliminar', 'Radera');
##v.2
define('MSG_termsNoDeleted', 'begreppen raderades inte');
define('MSG_termsDeleted', 'raderade begrepp');
define('LABEL_selectAll', 'markera alla');
define('LABEL_metadatos', 'metadata');
define('LABEL_totalTermsDescendants', 'underordnade begrepp (alla nivåer)');
define('LABEL_altTerms', 'synonymer');
define('LABEL_narrowerTerms', 'underordnade begrepp');
define('LABEL_results', 'träffar');
define('LABEL_showFreeTerms', 'lista över fristående begrepp');
define('LABEL_helpSearchFreeTerms', 'Bara fristående begrepp söks.');
define('LABEL_broatherTerms', 'Överordnade begrepp');
define('LABEL_type2filter', 'skriv för att filtrera begreppen');
define('LABEL_defaultEQmap', 'Skriv "eq" för att ange ekvivalensrelation');
define("MSG_repass_error", "lösenorden stämmer inte överens");
define("MSG_lengh_error", "skriv minst %d tecken");
define("MSG_errorPostData", "Ett fel upptäcktes, kontrollera uppgifterna i fältet ");
define('LABEL_preferedTerms', 'föredragna termer');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', 'begrepp UTAN anteckningar');
define('MSG_FORM_NULLnotesTermReport', 'begrepp utan anteckningstyp');
define('LABELnoNotes', 'begrepp som saknar anteckning');
define('LABEL_termsXdeepLevel', 'begrepp per nivå');
define('LABEL_deepLevel', 'nivå');
define('LABEL_cantTerms', 'antal begrepp');
define('LINK_publicKnownVocabularies', '<a href="https://www.vocabularyserver.com/vocabularies/" title="Lista över aktiverade vokabulärer" target="_blank">Lista över aktiverade vokabulärer</a>');
define('LABEL_showNewsTerm', 'visa senaste ändringar');
define('LABEL_newsTerm', 'senaste ändringar');
define('MSG_contactAdmin', 'kontakta administratören');
define('LABEL_addTargetVocabulary', 'lägg till externa vokabulärer (terminologiska webbtjänster)');
#v.2.1
define('LABEL_duplicatedTerm', 'dubblett');
define('LABEL_duplicatedTerms', 'dubbletter');
define('MSG_duplicatedTerms', 'Vokabulärens inställningar tillåter inte dubbletter.');
define('LABEL_bulkReplace', 'massredigering (sök och ersätt)');
define('LABEL_searchFor', 'text att söka efter');
define('LABEL_replaceWith', 'ersätt med');
define('LABEL_bulkNotesWillReplace', 'anteckningar kommer att ändras');
define('LABEL_bulkNotesReplaced', 'anteckningar ändrades');
define('LABEL_bulkTermsWillReplace', 'begrepp kommer att ändras');
define('LABEL_bulkTermsReplaced', 'begrepp ändrades');
define('LABEL_termMOD', 'Ändrade begrepp');
define('LABEL_noteMOD', 'Ändrade anteckningar');
define('MENU_bulkEdition', 'massredigering');
define('MSG_searchFor', 'Skriv texten du vill söka efter (skiljer på stora och små bokstäver)');
define('MSG_replaceWith', 'Skriv texten du vill ersätta med (skiljer på stora och små bokstäver)');
define('LABEL_warningBulkEditor', 'Du är på väg att ändra många poster på en gång. Det går inte att ångra!');
define('LABEL_CFG_SUGGESTxWORD', 'föreslå begrepp utifrån ord eller fraser?');
define('LABEL_ALLOW_DUPLICATED', 'tillåt dubbletter?');
define('LABEL_CFG_PUBLISH', 'Publicera vokabulären så att alla kan se den?');
define('LABEL_Replace', 'ersätt');
define('LABEL_Preview', 'förhandsgranska');
#v.2.2
define('LABEL_selectRelation', 'välj relationstyp');
define('LABEL_withSelected', 'med markerade begrepp:');
define('LABEL_rejectTerms', 'avvisa begrepp');
define('LABEL_doMetaTerm', 'gör om till metatermer');
define('LABEL_associateFreeTerms', 'koppla som synonym, underordnat eller relaterat');
define('MSG_associateFreeTerms', 'i nästa steg väljer du typ av relation.');
define('MSG_termsSuccessTask', 'begrepp som berördes av åtgärden');
define('LABEL_TTTerms', 'toppbegrepp');
define('MSG__GLOSSincludeAltLabel', 'ta med synonymer');
define('MSG__GLOSSdocumentationJSON', 'Du kan lägga en ordlista på valfritt HTML-innehåll med den här JSON-filen och <a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>');
define('LABEL_configGlossary', 'exportera källfil för ordlista');
define('MSG_includeNotes', 'använd anteckningstyp:');
define('LABEL_SHOW_RANDOM_TERM', 'Visa ett slumpvist valt begrepp på startsidan (du måste välja vilken anteckningstyp som ska visas).');
define('LABEL_opt_show_rando_term', 'visa begrepp med anteckningstyp:');
define('MSG_helpNoteEditor', 'Du kan länka begrepp med dubbla hakparenteser. Exempel: Bara [[kärlek]] kan rädda världen');
define('LABEL_GLOSS_NOTES', 'Välj vilken anteckningstyp som visas utfälld på begreppssidan och som används för att berika (ordlista) begrepp som markerats med dubbla hakparenteser: [[ordlista]]');
define('LABEL_bulkGlossNotes', 'anteckningstyp att länka');
define('MSG__autoGlossInfo', 'Åtgärden skapar wikilänkar mellan begrepp i vokabulären och begrepp som hittas i anteckningar (t.ex. Bara [[kärlek]] kan rädda världen). Sökningen och ersättningen <strong>skiljer på stora och små bokstäver</strong>.');
define('MSG__autoGlossDanger', 'Åtgärden går INTE att ångra. Ta en säkerhetskopia först.');
define('LABEL_replaceBinary', 'skilj på stora och små bokstäver');
define('MSG_notesAffected', 'berörda anteckningar');
define('MSG_cantTermsFound', 'begrepp hittades');
define('MENU_glossConfig', 'inställningar för auto-länkning'); /* Used as menu entry. Keep it short */
define('LABEL_generateAutoGlossary', 'skapa auto-länkar');
define('LABEL_AlphaPDF', 'alfabetisk (PDF)');
define('LABEL_SystPDF', 'systematisk (PDF)');
define('LABEL_references', 'referenser');
define('LABEL_printData', 'utskriftsdatum');
##v.3
define('MENU_bulkTranslate', 'flerspråkig redigerare');
define('LABEL_bulkTranslate', 'mappning och flerspråkig redigerare');
define('LABEL_termsEQ', 'med mappning');
define('LABEL_termsNoEQ', 'utan mappning');
define('LABEL_close', 'stäng');
define('LABEL_allTerms', 'alla begrepp');
define('LABEL_allNotes', 'alla anteckningar');
define('LABEL_allRelations', 'alla relationer mellan begrepp');
#v.3.1
define('LABEL_noResults', 'Tyvärr, inga träffar');
define('LABEL_globalOrganization', 'vokabulärens övergripande uppbyggnad');
define('LABEL_rel_associative', 'associativa relationer');
define('LABEL_rel_hierarchical', 'hierarkiska relationer');
define('LABEL_rel_synonymy', 'synonymrelationer');
define('LABEL_prototypeTerms', 'centrala begrepp');
define('LABEL_copy_click', 'kopiera termen till urklipp');
define('LABEL__ENABLE_COPY_CLICK', 'Visa knapp för att kopiera begrepp till urklipp.');
#v.3.2
define('LABEL_order', 'ordning');
define('LABEL_alias', 'alias');
define('LEGEND_alias', 'ange ett kort alias');
define('LABEL_src_note', 'källa');
define('LEGEND_src_note', 'ange en bibliografisk referens');
define('LABEL_source', 'normerade auktoritetskällor');
define('LABEL_source4term', 'referenskällor för begrepp');
define('LABEL_add_new', 'lägg till ny');
define('LABEL_sources4vocab', 'referenskällor');
define('LABEL_update2_2x3_2', 'uppdatera (2.x -> 3.2)');
define('LABEL__getForTargetVocabularyNews', 'hämta nyheter');
define('LABEL__example', 'exempel');
#3.4
 define('KOS_categorization_scheme','kategoriseringsschema');
 define('KOS_classification_scheme','klassifikationsschema');
 define('KOS_dictionary','ordbok');
 define('KOS_gazetteer','ortnamnsregister');
 define('KOS_glossary','ordlista');
 define('KOS_list','lista');
 define('KOS_name_authority_list','auktoritetsregister för namn');
 define('KOS_ontology','ontologi');
 define('KOS_semantic_network','semantiskt nätverk');
 define('KOS_subject_heading_scheme','ämnesordsschema');
 define('KOS_taxonomy','taxonomi');
 define('KOS_terminology','terminologi');
 define('KOS_thesaurus','tesaurus');
 #3.4.1
 define('LABEL_userIsAdmin','administratör');
 define('LABEL_userIsEditor','redaktör');
 define('LABEL_userIsColab','medarbetare');
 define('LABEL_userType','användartyp');
 #3.5
 define('LABEL_hubs','nav');
 define('LABEL_clusteringCoefficient','klusterkoefficient');
 define('LABEL_logScale','logaritmisk skala');
#3.6
 define('LABEL__getForRecomendationWiki','Förslag från Wikidata');
 define('LABEL__getForWikidataTerms','Begreppsförslag från Wikidata');
 define('LABEL__noResult','Inga träffar hittades');
 define('LABEL__wikiEntity','Wikidata-objekt');
 define('LABEL__wikiSearch','sök i Wikidata');
 define('LABEL__wikiProperty','Wikidata-egenskap');
 define('LABEL__wikiEntityError','Det angivna Wikidata-ID:t för objekt är inte giltigt');
 define('LABEL__wikiPropertyError','Det angivna Wikidata-ID:t för egenskap är inte giltigt');
 define('LABEL__wikiServiceError','Fel vid begäran till Wikidata');
 define('LABEL__wikiConnectionError','Fel vid anslutning till Wikidata');
 define('LABEL__ParserError','Fel vid tolkning av svaret från servern'); 
 #3.6.1
 define('LABEL_StatusVocab','vokabulärens status');
 define('LABEL__STATUS_VOCAB_10','utkast');
 define('LABEL__STATUS_VOCAB_20','kandidat under granskning');
 define('LABEL__STATUS_VOCAB_30','experimentell');
 define('LABEL__STATUS_VOCAB_40','historisk – avslutad');
 define('LABEL__STATUS_VOCAB_50','publicerad – stabil');
 #3.6.3
 define('LABEL_toggleNavigation','Visa/dölj meny');
 define('LABEL_COPY_CLICK_EVERYWHERE','Överallt');
 define('LABEL_COPY_CLICK_HEADING','Bara i begreppets rubrik');
 define('LABEL_SHOW_REL_ACRONYMS','Visa relationernas förkortningar (BT, NT, RT, UF) för besökare');