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
define("LANG", "pl");
define("TR_acronimo", "RT"); /* Related Term */
define("TE_acronimo", "NT"); /* Narrower term > Specific term */
define("TG_acronimo", "BT"); /* Broader term > Generic term */
define("UP_acronimo", "UF"); /* Used for > instead */
define("TR_termino", "Termin powiązany");
define("TE_termino", "Termin węższy");
define("TG_termino", "Termin szerszy");
define("UP_termino", "Używany dla"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "Użyj"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "Lista hierarchiczna");
define("MENU_ListaAbc", "Lista alfabetyczna");
define("MENU_Sobre", "O ...");
define("MENU_Inicio", "Home");
define("MENU_MiCuenta", "Moje konto");
define("MENU_Usuarios", "Użytkownicy");
define("MENU_NuevoUsuario", "Nowy użytkownik");
define("MENU_DatosTesauro", "O tezaurusie");
define("MENU_AgregarT", "Dodaj termin");
define("MENU_EditT", "Edytuj termin");
define("MENU_BorrarT", "Usuń termin");
define("MENU_AgregarTG", "Podporządkuj ten termin");
define("MENU_AgregarTE", "Subordinated Term");
define("MENU_AgregarTR", "Termin powiązany");
define("MENU_AgregarUP", "Termin alternatywny");  /* Non-descriptor */
define("MENU_MisDatos", "Moje konto");
define("MENU_Caducar", "Deaktywuj");
define("MENU_Habilitar", "włącz");
define("MENU_Salir", "Wyloguj");
define("LABEL_Menu", "Menu");
define("LABEL_Opciones", "Opcje");
define("LABEL_Admin", "Administracja");
define("LABEL_Agregar", "Dodaj");
define("LABEL_editT", "Edytuj termin ");
define("LABEL_EditorTermino", "Edytor terminów");
define("LABEL_Termino", "Termin");
define("LABEL_NotaAlcance", "Nota o zakresie");
define("LABEL_EliminarTE", "Usuń termin");
define("LABEL_AgregarT", "Nowy termin");
define("LABEL_AgregarTG", "Dodaj szerszy termin do %s ");
define("LABEL_AgregarTE", "Nowy termin podporządkowny dla ");
define("LABEL_AgregarUP", "Nowy UF termin dla ");
define("LABEL_AgregarTR", "Nowy termin powiązany dla ");
define("LABEL_Detalle", "szczegóły");
define("LABEL_Autor", "Autor");
define("LABEL_URI", "URI");
define("LABEL_Version", "Powered by");
define("LABEL_Idioma", "Język");
define("LABEL_Fecha", "Data utworzenia");
define("LABEL_Keywords", "Słowa kluczowe");
define("LABEL_TipoLenguaje", "Typ języka");
define("LABEL_Cobertura", "Scope");
define("LABEL_Terminos", "terminy");
define("LABEL_RelTerminos", "relacje pomiędzy terminami");
define("LABEL_TerminosUP", "terminy alternatywne");
define("LABEL_BuscaTermino", "Znajdź termin");
define("LABEL_Buscar", "Szukaj");
define("LABEL_Enviar", "Zatwierdź");
define("LABEL_Cambiar", "zapisz zmiany");
define("LABEL_Anterior", "wstecz");
define("LABEL_AdminUser", "Administracja użytkownikami");
define("LABEL_DatosUser", "Dane użytkownika");
define("LABEL_Acciones", "Zadania");
define("LABEL_verEsquema", "Pokaż schemat");
define("LABEL_actualizar", "Aktualizuj");
define("LABEL_terminosLibres", "Wolne terminy"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "Szukaj");
define("LABEL_borraRelacion", "Usuń relację");
define("MSG_ResultBusca", "Znaleziono termin/ów");
define("MSG_ResultLetra", "Liter");
define("MSG_ResultCambios", "zatwierdzono zmianę.");
define("MSG_noUser", "The login information is incorrect. Please try again.");
define("FORM_JS_check", "Proszę sprawdzić datę ");
define("FORM_JS_confirm", "Usunąć tę relację?");
define("FORM_JS_pass", "_hasło");
define("FORM_JS_confirmPass", "_potwierdź_hasło");
define("FORM_LABEL_termino", "_termin");
define("FORM_LABEL_buscar", "_wyszukiwane_wyrażenie");
define("FORM_LABEL_buscarTermino", "_termin_powiązany");
define("FORM_LABEL_nombre", "_imię");
define("FORM_LABEL_apellido", "_nazwisko");
define("FORM_LABEL_mail", "_mail");
define("FORM_LABEL_pass", "_hasło");
define("FORM_LABEL_repass", "_potwierdź_hasło");
define("FORM_LABEL_orga", "orga");
define("LABEL_nombre", "imię");
define("LABEL_apellido", "nazwisko");
define("LABEL_mail", "mail");
define("LABEL_pass", "hasło");
define("LABEL_repass", "Potwierdź hasło");
define("LABEL_orga", "organizcja");
define("LABEL_lcConfig", "konfiguracja słownictwa");
define("LABEL_lcDatos", "metadane dla słownictwa");
define("LABEL_Titulo", "tytuł");
define("FORM_LABEL_Titulo", "_tytuł");
define("FORM_LABEL_Autor", "_autor");
define("FORM_LABEL_URI", "_URI");
define("FORM_LABEL_Idioma", "język");
define("FORM_LABEL_FechaDia", "dzień");
define("FORM_LABEL_FechaMes", "miesiąc");
define("FORM_LABEL_FechaAno", "rok");
define("FORM_LABEL_Keywords", "słowa kluczowe");
define("FORM_LABEL_TipoLenguaje", "typ_języka");
define("FORM_LABEL_Cobertura", "zakres");
define("FORM_LABEL_Terminos", "terminy");
define("FORM_LABEL_RelTerminos", "relacje pomiędzy terminami");
define("FORM_LABEL_TerminosUP", "terminy alternatywne");
define("FORM_LABEL_Guardar", "Zapisz");
define("LABEL_verDetalle", "zobacz szczególy z ");
define("LABEL_verTerminosLetra", "zobacz terminy zaczynjące się z ");
define("LABEL_NB", "Nota bibliograficzna");
define("LABEL_NH", "Nota historyczna");
define("LABEL_NA", "Nota o zakresie");   /* version 0.9.1 */
define("LABEL_NP", "Nota prywatna"); /* version 0.9.1 */
define("LABEL_EditorNota", "Edytor not ");
define("LABEL_EditorNotaTermino", "nota dla ");
define("LABEL_tipoNota", "typ noty");
define("FORM_LABEL_tipoNota", "typ_noty");
define("LABEL_nota", "nota");
define("FORM_LABEL_nota", "_nota");
define("LABEL_EditarNota", "Edytuj notę");
define("LABEL_EliminarNota", "Usuń notę");
define("LABEL_OptimizarTablas", "Optymalizuj tabele");
define("LABEL_TotalZthesLine", "eksportuje do Zthes");
/* v 9.2 */
define("LABEL_negrita", "pogrubienie");
define("LABEL_italica", "italic");
define("LABEL_subrayado", "podkreślenie");
define("LABEL_textarea", "body notes");
define("MSGL_relacionIlegal", "Niepoprawna relacja pomiędzy terminami");
/* v 9.3 */
define("LABEL_fecha_modificacion", "modyfikowany");
define("LABEL_TotalUsuarios", "Całkowita liczba użytkowników");
define("LABEL_TotalTerminos", "Całkowita liczba terminów");
define("LABEL_ordenar", "wybierz według");
define("LABEL_auditoria", "nadzór nad terminami");
define("LABEL_dia", "dzień");
define("LABEL_mes", "miesiąc");
define("LABEL_ano", "rok");
define("LABEL_terminosRepetidos", "zduplikowane terminy");
define("MSG_noTerminosLibres", "brak wolnych terminów");
define("MSG_noTerminosRepetidos", "brak zduplikowanych terminów");
define("LABEL_TotalSkosLine", "eksportuj do Skos-core");
$MONTHS=array("01"=>"Sty",
              "02"=>"Lut",
              "03"=>"Mar",
              "04"=>"Kwi",
              "05"=>"Maj",
              "06"=>"Cze",
              "07"=>"Lip",
              "08"=>"Sie",
              "09"=>"Wrz",
              "10"=>"Paź",
              "11"=>"Lis",
              "12"=>"Gru"
              );
/* v 9.4 */
define("LABEL_SI", "TAK");
define("LABEL_NO", "NIE");
define("FORM_LABEL_jeraquico", "polihierarchiczny");
define("LABEL_jeraquico", "Polihierarchiczny"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "wolny termin");
/* v 9.5 */
define("LABEL_URL_busqueda", "Znajdź %s w: ");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "relationship with another vocabulary");
define("FORM_LABEL_relacion_vocabulario", "równowartość");
define("FORM_LABEL_nombre_vocabulario", "docelowe słownictwo");
define("LABEL_vocabulario_referencia", "docelowe słownictwo");
define("LABEL_NO_vocabulario_referencia", "brak docelowego słownictwa do utworzenia relacji dla terminologii");
define("FORM_LABEL_tipo_equivalencia", "typ równowartości");
define("LABEL_vocabulario_principal", "słownictwo");
define("LABEL_tipo_vocabulario", "typ");
define("LABEL_termino_equivalente", "równoważny");
define("LABEL_termino_parcial_equivalente", "częściowo równoważny");
define("LABEL_termino_no_equivalente", "nie równoważny");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "EQP"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "Cataloger's note");
define("LABEL_resultados_suplementarios", "dodatkowe wyniki");
define("LABEL_resultados_relacionados", "powiązane wyniki");
/* v 9.7 */
define("LABEL_export", "eksport");
define("FORM_LABEL_format_export", "wybierz schemat XML");
/* v 1.0 */
define("LABEL_fecha_creacion", "utworzony");
define("NB_acronimo", "BN"); /* Bibliographic note */
define("NH_acronimo", "HN"); /* Historical note */
define("NA_acronimo", "SN"); /* Scope or Explanatory note */
define("NP_acronimo", "PN"); /* Private note */
define("NC_acronimo", "CN"); /* Cataloger's note */
define("LABEL_Candidato", "proponowany termin");
define("LABEL_Aceptado", "zatwierdzony termin");
define("LABEL_Rechazado", "odrzucony termin");
define("LABEL_Ultimos_aceptados", "ostatnio zatwierdzone terminy");
define("MSG_ERROR_ESTADO", "niewłaściwy status");
define("LABEL_Candidatos", "proponowane terminy");
define("LABEL_Aceptados", "zatwierdzone terminy");
define("LABEL_Rechazados", "odrzucone terminy");
define("LABEL_User_NoHabilitado", "wyłącz");
define("LABEL_User_Habilitado", "włącz");

define("LABEL_CandidatearTermino", "proponowany termin");
define("LABEL_AceptarTermino", "zatwierdź termin");
define("LABEL_RechazarTermino", "odrzuć termin");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "chodziło o:");
/* v 1.02 */
define("LABEL_esSuperUsuario", "jest administratorem");
define("LABEL_Cancelar", "anuluj");
define("LABEL_Guardar", "zapisz");
/* v 1.033 */
define("MENU_AgregarTEexist", "Podporządkuj istniejący termin");
define("MENU_AgregarUPexist", "Przypisz istniejący równoważny termin");
define("LABEL_existAgregarUP", "Dodaj UF termin do %s");
define("LABEL_existAgregarTE", "Dodaj węższy termin do %s ");
define("MSG_minCharSerarch", "Wyszukiwane wyrażenie <i>%s</i> ma tylko <strong>%s </strong> znaków. Należy zwiększyć wartość do <strong>%s </strong> znaków");
/* v 1.04 */
define("LABEL_terminoExistente", "istniejący termin");
define("HELP_variosTerminos", "Aby dodać jednocześnie wiele terminów należy je umieścić <strong>jako jedno słowo na linię</strong>.");
/* Install messages */
define("FORM", "Formularz") ;
define("ERROR", "Błąd") ;
define("LABEL_bienvenida", "Witaj na Serwerze Słownictwa TemaTres") ;
// COMMON SQL
define("PARAM_SERVER", "Adres serwera") ;
define("PARAM_DBName", "Nazwa bazy danych") ;
define("PARAM_DBLogin", "Użytkownik bazy danych") ;
define("PARAM_DBPass", "Hasło do bazy danych") ;
define("PARAM_DBprefix", "Prefix dla tabel") ;
$install_message[101] = 'Konfiguracja TemaTres' ;
$install_message[201] = 'Nie mogę odnaleźć pliku z konfiguracją połączenia do bazy danych (%s).';
$install_message[202] = 'Znaleziono plik z konfiguracją połączenia do bazy danych.';
$install_message[203] = 'Nie udało się połączyć z serwerem bazy danych <em>%s</em> jako użytkownik <em>%s</em>. Proszę sprawdzić konfigurację (%s).';
$install_message[204] = 'Pomyślnie nawiązano połączenie z serwerem <em>%s</em> ';
$install_message[205] = 'Nie udało się połączyć do bazy danych <em>%s</em> na serwerze <em>%s</em>. Proszę sprawdzić konfigurację (%s).';
$install_message[206] = 'Pomyślnie nawiązano połączenie z bazą danych <em>%s</em> na serwerze <em>%s</em>.' ;
$install_message[301] = 'Ooppsss... Dla tej konfiguracji istnieje już instalacja TemaTres. Proszę sprawdzić konfigurację z bazą danych (%s) złoto <a href="index.php">Ciesz się swoim serwerem Vocabulary</a>' ;
$install_message[305] = 'Sprawdzanie hasła.' ;
$install_message[306] = 'Konfiguracja zakończona pomyślnie, <a href="index.php">Miłego korzystania z Serwera TemaTres</a>' ;
/* end Install messages */
/* v 1.1 */
define('MSG_ERROR_CODE', "niewłaściwy kod");
define('LABEL_CODE', "kod");
define('LABEL_Ver', "Pokaż");
define('LABEL_OpcionesTermino', "Termin");
define('LABEL_CambiarEstado', "Zmień status terminu");
define('LABEL_ClickEditar', "Kliknij aby edytować...");
define('LABEL_TopTerm', "Posiada ten top termin");
define('LABEL_esFraseExacta', "dokładna fraza");
define('LABEL_DesdeFecha', "Utworzone dokładnie lub później");
define('LABEL_ProfundidadTermino', "jest umiejscowiony na poziomie");
define('LABEL_esNoPreferido', "brak preferowanego terminu");
define('LABEL_BusquedaAvanzada', "wyszukiwanie zaawansowane");
define('LABEL_Todos', "wszystko");
define('LABEL_QueBuscar', "jakie wyszukiwanie?");
define("LABEL_import", "importowanie") ;
define("IMPORT_form_legend", "importuj tezaurus z pliku txt") ;
define("IMPORT_form_label", "plik") ;
define("IMPORT_file_already_exists", "plik txt już istnieje na serwerze") ;
define("IMPORT_file_not_exists", "jeszcze nie zaimportowano pliku txt") ;
define("IMPORT_do_it", "Można rozpocząć importowanie") ;
define("IMPORT_working", "trwa importowanie") ;
define("IMPORT_finish", "importowanie zakończone") ;
define("LABEL_reIndice", "odtwórz indeksy") ;
define("LABEL_dbMantenimiento", "utrzymywanie bazy danych");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "relation with term from remote target vocabulary");
define('LABEL_vocabulario_referenciaWS', "remote target vocabulary (web  services)");
define('LABEL_TargetVocabularyWS', "remote target vocabulary (web  services)");
define('LABEL_tvocab_label', "label for the reference");
define('LABEL_tvocab_tag', "tag for the reference");
define('LABEL_tvocab_uri_service', "URL for the web services reference");
define('LABEL_targetTermsforUpdate', "terms with pending update");
define('LABEL_ShowTargetTermsforUpdate', "check terms update");
define('LABEL_enable', "włącz");  /* web services status info: in use */
define('LABEL_disable', "wyłącz");  /* web services status info: not in use */
define('LABEL_notFound', "term not found");
define('LABEL_termUpdated', "term updated");
define('LABEL_ShowTargetTermforUpdate', "aktualizuj");
define('LABEL_relbetweenVocabularies', "relations between vocabularies");
define('LABEL_update1_1x1_2', "Update (1.1 -> 1.3)");
define('LABEL_update1x1_2', "Update (1.0x -> 1.3)");
define('LABEL_TargetTerm', "terminological mapping");
define('LABEL_TargetTerms', "terms (terminological mapping)");
define('LABEL_seleccionar', 'select');
define('LABEL_poliBT', 'more than one broader term');
define('LABEL_FORM_simpleReport', 'Reports');
define('LABEL_FORM_advancedReport', 'advanced reports');
define('LABEL_FORM_nullValue', 'no matters');
define('LABEL_FORM_haveNoteType', 'have note type');
define('LABEL_haveEQ', 'have equivalences');
define('LABEL_nohaveEQ', 'no equivalences');
define('LABEL_start', 'beginning with');
define('LABEL_end', 'ending with');
define('LABEL_equalThisWord', 'exact match to');
define('LABEL_haveWords', 'include words');
define('LABEL_encode', 'encoding');
/*
v1.21
*/
define('LABEL_import_skos', 'Skos-Core Import');
define('IMPORT_skos_file_already_exists', 'The Skos-Core source are in the server');
define('IMPORT_skos_form_legend', 'Import Skos-Core');
define('IMPORT_skos_form_label', 'Skos-Core File');
/*
v1.4
*/
define('LABEL_termsxNTterms', 'Narrower terms x term');
define('LABEL_termsNoBT', 'Terms without hierarchical relations');
define('MSG_noTermsNoBT', 'There are no terms without hierarchical relations');
define('LABEL_termsXcantWords', 'number of words x term');
define('LABEL__USE_CODE', 'use term codes to sort the terms');
define('LABEL__SHOW_CODE', 'Shown term codes in public view');
define('LABEL_CFG_MAX_TREE_DEEP', 'Maximum level of depth in the tree of items for display on the same page');
define('LABEL_CFG_VIEW_STATUS', 'Status details visible for any users');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', 'enable web services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', 'Number of terms display by status view');
define('LABEL_CFG_MIN_SEARCH_SIZE', 'Minimum characters for search operations');
define('LABEL__SHOW_TREE', 'publish hierarchical view in home');
define('LABEL__PUBLISH_SKOS', 'enable SKOS-Core format in web services. This will expose your entire vocabulary.');
define('LABEL_update1_3x1_4', "Update (1.3x -> 1.4)");
define("FORM_LABEL_format_import", "choose format");
define("LABEL_importTab", "tabulated text");
define("LABEL_importTag", "tagged text");
define("LABEL_importSkos", "Skos-core");
define("LABEL_configTypeNotes", "configure notes types");
define("LABEL_notes", "notes");
define("LABEL_saved", "saved");
define("FORM_JS_confirmDeleteTypeNote", "eliminate this type of note?");
/*
v1.5
*/
define("LABEL_relationEditor", "relations editor");
define("LABEL_relationDelete", "delete relation sub-type");
define('LABEL_relationSubType', "relation type");
define('LABEL_relationSubTypeCode', "relation sub-type alias");
define('LABEL_relationSubTypeLabel', "relation sub-type label");
define('LABEL_optative', "optional");
define('FORM_JS_confirmDeleteTypeRelation', 'delete this relation sub-type?');
define("LABEL_URItypeEditor", "link type editor");
define("LABEL_URIEditor", "manage links associated to the term");
define("LABEL_URItypeDelete", "delete link type");
define('LABEL_URItype', "link type");
define('LABEL_URItypeCode', "link type alias");
define('LABEL_URItypeLabel', "link type label");
define('FORM_JS_confirmDeleteURIdefinition', 'delete this link type?');
define('LABEL_URI2term', 'web resource');
define('LABEL_URI2termURL', 'web resource URL');
define('LABEL_update1_4x1_5', 'Update (1.4 -> 1.5)');
define('LABEL_Contributor', 'contributor');
define('LABEL_Rights', 'rights');
define('LABEL_Publisher', 'publisher');
/*
v1.6
*/
define('LABEL_Prev', 'previous');
define('LABEL_Next', 'next');
define('LABEL_PageNum', 'page results number ');
define('LABEL_selectMapMethod', 'select terminological mapping method');
define('LABEL_string2search', 'search expression');
define('LABEL_reverseMappign', 'reverse mapping');
define('LABEL_warningMassiverem', 'You will eliminate data massively. These actions are irreversible!');
define('LABEL_target_terms', 'mapped terms from external vocabularies');
define('LABEL_URI2terms', 'web resources');
define('MENU_massiverem', 'Delete data massively');
define('LABEL_more', 'more');
define('LABEL_less', 'less');
define('LABEL_lastChangeDate', 'last change date');
define('LABEL_update1_5x1_6', 'Update (1.5 -> 1.6)');
define('LABEL_login', 'login');
define('LABEL_user_recovery_password', 'Get new password');
define('LABEL_user_recovery_password1', 'Please enter your username or email address. You will receive a link to create a new password via email.');
define('LABEL_mail_recoveryTitle', 'Password Reset');
define('LABEL_mail_recovery_pass1', 'Someone requested that the password be reset for the following account:');
define('LABEL_mail_recovery_pass2', 'Username: %s');
define('LABEL_mail_recovery_pass3', 'If this was a mistake, just ignore this email and nothing will happen.');
define('LABEL_mail_recovery_pass4', 'To reset your password, visit the following address:');
define('LABEL_mail_passTitle', 'New Password ');
define('LABEL_mail_pass1', 'New password for ');
define('LABEL_mail_pass2', 'Password: ');
define('LABEL_mail_pass3', 'You can change it.');
define('MSG_check_mail_link', 'If that email address is valid, we will send you an email for the confirmation link.');
define('MSG_check_mail', 'If that email address is valid, we will send you an email to reset your password.');
define('MSG_no_mail', 'The e-mail could not be sent.');
define('LABEL_user_lost_password', 'Lost your password?');
## v1.7
define('LABEL_includeMetaTerm', 'Include meta-terms');
define('NOTE_isMetaTerm', 'Is a meta-term.');
define('NOTE_isMetaTermNote', 'A Meta-term is a term that can\'t be used in the indexing process. It is a term to describe other terms. For example: Guide terms, Facets, Categories, etc.');
define('LABEL_turnOffMetaTerm', 'Is not a meta-term');
define('LABEL_turnOnMetaTerm', 'Is a meta-term');
define('LABEL_meta_term', 'meta-term');
define('LABEL_meta_terms', 'meta-terms');
define('LABEL_relatedTerms', 'termin powiązany');
define('LABEL_nonPreferedTerms', 'terminy alternatywne');
define('LABEL_update1_6x1_7', 'Update (1.6 -> 2.2)');
define('LABEL_include_data', 'include');
define('LABEL_updateEndpoint', 'update SPARQL endpoint');
define('MSG__updateEndpoint', 'The data will be updated to be exposed in SPARQL endpoint. This operation may take several minutes.');
define('MSG__updatedEndpoint', 'The SPARQL endpoint is updated.');
define('MSG__dateUpdatedEndpoint', 'Last updated of SPARQL endpoint');
define('LABEL__ENABLE_SPARQL', 'You must update the SPARQL endpoint: Menu -> Administration -> Database maintenance -> Update SPARQL endpoint.');
define('MSG__disable_endpoint', 'The SPARQL endpoint is disabled.');
define('MSG__need2setup_endpoint', 'The SPARQL endpoint needs to be updated. Please contact the administrator.');
define('LABEL_SPARQLEndpoint', 'SPARQL endpoint');
define('LABEL_AgregarRTexist', 'Select terms to link as related term with ');
define('MENU_selectExistTerm', 'select existing term');
define("TT_terminos", "top terms");
## v1.72
define('MSG__warningDeleteTerm', 'The term <i>%s</i> will be <strong>DELETED</strong>.');
define('MSG__warningDeleteTerm2row', 'Will delete <strong>all</strong> the term\'s notes and relations. These actions are irreversible!');
## v1.8
define('LABEL__getForRecomendation', 'get for recommendations');
define('LABEL__getForRecomendationFor', 'get for recommendations to ');
define('FORM_LABEL__contactMail', 'contact mail');
define('LABEL_addMapLink', 'add mapping between vocabularies');
define('LABEL_addExactLink', 'add reference link');
define('LABEL_addSourceNote', 'add source note');
## v1.82
define('LABEL_FORM_mappedTermReport', 'Relationships between vocabularies');
define('LABEL_eliminar', 'Delete');
##v.2
define('MSG_termsNoDeleted', 'the terms were not deleted');
define('MSG_termsDeleted', 'deleted terms');
define('LABEL_selectAll', 'select all');
define('LABEL_metadatos', 'metadata');
define('LABEL_totalTermsDescendants', 'descendant terms');
define('LABEL_altTerms', 'terminy alternatywne');
define('LABEL_narrowerTerms', 'more specific terms');
define('LABEL_results', 'results');
define('LABEL_showFreeTerms', 'free terms list');
define('LABEL_helpSearchFreeTerms', 'Only free terms will be searched.');
define('LABEL_broatherTerms', 'broader Terms');
define('LABEL_type2filter', 'type to filter the terms');
define('LABEL_defaultEQmap', 'Type "eq" to define equivalence relationship');
define("MSG_repass_error", "the passwords do not match");
define("MSG_lengh_error", "please type at least %d characters");
define("MSG_errorPostData", "A mistake was detected, please review the data of the field ");
define('LABEL_preferedTerms', 'preferred terms');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', 'terms WITHOUT notes');
define('MSG_FORM_NULLnotesTermReport', 'terms without note type');
define('LABELnoNotes', 'terms that have no note');
define('LABEL_termsXdeepLevel', 'terms for each depth level');
define('LABEL_deepLevel', 'deep level');
define('LABEL_cantTerms', '# of terms');
define('LINK_publicKnownVocabularies', '<a href="https://www.vocabularyserver.com/vocabularies/" title="List of enabled vocabularies" target="_blank">List of enabled vocabularies</a>');
define('LABEL_showNewsTerm', 'show recent changes');
define('LABEL_newsTerm', 'recent changes');
define('MSG_contactAdmin', 'contact the administrator');
define('LABEL_addTargetVocabulary', 'add external vocabularies (terminological web services)');
#v.2.1
define('LABEL_duplicatedTerm', 'duplicated term');
define('LABEL_duplicatedTerms', 'duplicated terms');
define('MSG_duplicatedTerms', 'The configuration of the vocabulary does not allow duplicate terms.');
define('LABEL_bulkReplace', 'bulk editor (search and replace)');
define('LABEL_searchFor', 'string to search');
define('LABEL_replaceWith', 'replace with');
define('LABEL_bulkNotesWillReplace', 'notes will be modified');
define('LABEL_bulkNotesReplaced', 'notes were modified');
define('LABEL_bulkTermsWillReplace', 'terms will be modified');
define('LABEL_bulkTermsReplaced', 'terms were modified');
define('LABEL_termMOD', 'terms changed');
define('LABEL_noteMOD', 'notes changed');
define('MENU_bulkEdition', 'bulk editor');
define('MSG_searchFor', 'Input text you want to search for (case sensitive)');
define('MSG_replaceWith', 'Input text you want to replace with (case sensitive)');
define('LABEL_warningBulkEditor', 'You will modify data massively. These actions are irreversible!');
define('LABEL_CFG_SUGGESTxWORD', 'suggest terms by words or phrases?');
define('LABEL_ALLOW_DUPLICATED', 'enable duplicate terms?');
define('LABEL_CFG_PUBLISH', 'Publish the vocabulary so anyone can view it?');
define('LABEL_Replace', 'replace');
define('LABEL_Preview', 'preview');
#v.2.2
define('LABEL_selectRelation', 'select relation type');
define('LABEL_withSelected', 'with selected terms:');
define('LABEL_rejectTerms', 'reject terms');
define('LABEL_doMetaTerm', 'turn to meta-terms');
define('LABEL_associateFreeTerms', 'associate as UF, NT or RT');
define('MSG_associateFreeTerms', 'in the next step you can select the type of relationship.');
define('MSG_termsSuccessTask', 'terms affected by the process');
define('LABEL_TTTerms', 'top terms');
define('MSG__GLOSSincludeAltLabel', 'include alternative terms');
define('MSG__GLOSSdocumentationJSON', 'You can add Glossary to any HTML content using this JSON file with <a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>');
define('LABEL_configGlossary', 'export source file for glossary');
define('MSG_includeNotes', 'use type note:');
define('LABEL_SHOW_RANDOM_TERM', 'Show a randomly selected term on the home page.  You must select the type of term to show.');
define('LABEL_opt_show_rando_term', 'show terms with type note:');
define('MSG_helpNoteEditor', 'You can link terms using double brackets. Ex: Only [[love]] will save the world');
define('LABEL_GLOSS_NOTES', 'Select which type note will be used to enrich (glossary) the terms who are marked with double brackets: [[glossary]]');
define('LABEL_bulkGlossNotes', 'type note to gloss');
define('MSG__autoGlossInfo', 'This process will create wiki links between terms from the vocabulary with the terms found in notes (Ex: Only [[love]] will save the world). Is <strong>case sensitive</strong> search and replace operation.');
define('MSG__autoGlossDanger', 'This process is IRREVERSIBLE. Please create a backup before proceeding.');
define('LABEL_replaceBinary', 'case sensitive');
define('MSG_notesAffected', 'affected notes');
define('MSG_cantTermsFound', 'terms found');
define('MENU_glossConfig', 'config auto-gloss'); /* Used as menu entry. Keep it short */
define('LABEL_generateAutoGlossary', 'auto-gloss generation');
define('LABEL_AlphaPDF', 'alphabetic (PDF)');
define('LABEL_SystPDF', 'systematic (PDF)');
define('LABEL_references', 'references');
define('LABEL_printData', 'date of print');
##v.3
define('MENU_bulkTranslate', 'multilingual editor');
define('LABEL_bulkTranslate', 'mapping and multilingual editor');
define('LABEL_termsEQ', 'with mapping');
define('LABEL_termsNoEQ', 'without mapping');
define('LABEL_close', 'close');
define('LABEL_allTerms', 'all terms');
define('LABEL_allNotes', 'all notes');
define('LABEL_allRelations', 'all terms relations');
#v.3.1
define('LABEL_noResults', 'Sorry, no results');
define('LABEL_globalOrganization', 'global organization of the vocabulary');
define('LABEL_rel_associative', 'associative relationships');
define('LABEL_rel_hierarchical', 'hierarchical relationships');
define('LABEL_rel_synonymy', 'synonym relationships');
define('LABEL_prototypeTerms', 'central terms');
define('LABEL_copy_click', 'copy term to clipboard');
define('LABEL__ENABLE_COPY_CLICK', 'Enable button to copy terms to the clipboard.');
#v.3.2
define('LABEL_order', 'order');
define('LABEL_alias', 'alias');
define('LEGEND_alias', 'enter a short alias');
define('LABEL_src_note', 'source');
define('LEGEND_src_note', 'enter a bibliographic citation');
define('LABEL_source', 'normalized sources of authority');
define('LABEL_source4term', 'reference sources for terms');
define('LABEL_add_new', 'add new');
define('LABEL_sources4vocab', 'reference sources');
define('LABEL_update2_2x3_2', 'update (2.x -> 3.2)');
define('LABEL__getForTargetVocabularyNews', 'get news');
define('LABEL__example', 'example');
#3.4
 define('KOS_categorization_scheme','categorization scheme');
 define('KOS_classification_scheme','classification scheme');
 define('KOS_dictionary','dictionary');
 define('KOS_gazetteer','gazetteer');
 define('KOS_glossary','glossary');
 define('KOS_list','list');
 define('KOS_name_authority_list','name authority list');
 define('KOS_ontology','ontology');
 define('KOS_semantic_network','semantic network');
 define('KOS_subject_heading_scheme','subject heading scheme');
 define('KOS_taxonomy','taxonomy');
 define('KOS_terminology','terminology');
 define('KOS_thesaurus','thesaurus');
 #3.4.1
 define('LABEL_userIsAdmin','administrator');
 define('LABEL_userIsEditor','editor');
 define('LABEL_userIsColab','collaborator');
 define('LABEL_userType','user type');
 #3.5
 define('LABEL_hubs','hubs');
 define('LABEL_clusteringCoefficient','clustering coefficient');