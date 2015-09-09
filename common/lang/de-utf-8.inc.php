<?php
#   TemaTres: open source thesaurus management #       #
#                                                                        #
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Version 0.97
#
###############################################################################################################
#
define("LANG","de");

define("TR_acronimo","Verwandter Begriff: ");
define("TE_acronimo","Unterbegriff: ");
define("TG_acronimo","Oberbegriff: ");
define("UP_acronimo","Synonymbegriff: ");

define("TR_termino","Verwandter Begriff: ");
define("TE_termino","Unterbegriff: ");
define("TG_termino","Oberbegriff: ");
define("UP_termino","Synonymbegriff: ");
/* v 9.5 */
define("USE_termino","siehe");

define("MENU_ListaSis","Hierarchisch");
define("MENU_ListaAbc","Alphabetisch");
define("MENU_Sobre","Info & Statistik");
define("MENU_Inicio","Hauptindex");

define("MENU_MiCuenta","Mein Konto");
define("MENU_Usuarios","Benutzer");
define("MENU_NuevoUsuario","Benutzer anlegen");
define("MENU_DatosTesauro","Thesaurus-Info");

define("MENU_AgregarT","Neuer Begriff");
define("MENU_EditT","Begriff bearbeiten");
define("MENU_BorrarT","Begriff löschen");
define("MENU_AgregarTG","Mit existierenden Oberbegriffen");
define("MENU_AgregarTE","Mit Unterbegriffen");
define("MENU_AgregarTR","Mit sonstigen verwandten Begriffen");
define("MENU_AgregarUP","Mit Synonymen");

define("MENU_MisDatos","Mein Konto");
define("MENU_Caducar","inaktiv");
define("MENU_Habilitar","aktiv");
define("MENU_Salir","Abmelden");

define("LABEL_Menu","Hauptmenü");
define("LABEL_Opciones","Aktionen");
define("LABEL_Admin","System");
define("LABEL_Agregar","Relationen erzeugen");
define("LABEL_editT","Begriff bearbeiten");
define("LABEL_EditorTermino","Begriffe bearbeiten");
define("LABEL_Termino","Begriff(e)");
define("LABEL_NotaAlcance","Definition");
define("LABEL_EliminarTE","Begriff löschen");

define("LABEL_AgregarT","Begriff(e) anlegen");
define("LABEL_AgregarTG","Oberbegriff für %s wählen:");
define("LABEL_AgregarTE","Begriff(e) anlegen und als Unterbegriff(e) verknüpfen mit: ");
define("LABEL_AgregarUP","Begriff(e) anlegen und als Synonymbegriff(e) verknüpfen mit: ");
define("LABEL_AgregarTR","Begriff(e) anlegen und als verwandte(n) Begriff(e) verknüpfen mit: ");
define("LABEL_Detalle","Details");

define("LABEL_Autor","Autor");
define("LABEL_URI","URL");
define("LABEL_Version","Version");
define("LABEL_Idioma","Sprache");
define("LABEL_Fecha","Angelegt");
define("LABEL_Keywords","Keywords");
define("LABEL_TipoLenguaje","Typ");
define("LABEL_Cobertura","Beschreibung");
define("LABEL_Terminos","Angelegte Begriffe");
define("LABEL_RelTerminos","Angelegte Begriffsrelationen");
define("LABEL_TerminosUP","Angelegte Synonymbegriffe");

define("LABEL_BuscaTermino","Suchbegriff");
define("LABEL_Buscar","Suche");
define("LABEL_Enviar","Start");
define("LABEL_Cambiar","Aktualisieren");
define("LABEL_Anterior","<b>Zurück</b>");
define("LABEL_AdminUser","Benutzerverwaltung");
define("LABEL_DatosUser","Benutzerangaben");
define("LABEL_Acciones","Aufgaben");
define("LABEL_verEsquema","Eintrag konvertieren nach ");
define("LABEL_actualizar","Aktualisieren");
define("LABEL_terminosLibres","Begriffe ohne Relationen");
define("LABEL_busqueda","Suchergebnis");
define("LABEL_borraRelacion","Relation löschen");
define("MSG_ResultBusca","Begriff(e) gefunden für: ");
define("MSG_ResultLetra","Buchstabe");
define("MSG_ResultCambios","Die Änderung wurde gespeichert");
define("MSG_noUser","Benutzer unbekannt");
define("FORM_JS_check","Bitte Angaben prüfen für: ");
define("FORM_JS_confirm","Möchten Sie diese Relation wirklich löschen?");
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
define("LABEL_nombre","Vorname");
define("LABEL_apellido","Nachname");
define("LABEL_mail","E-Mail (Kennung)");
define("LABEL_pass","Passwort");
define("LABEL_repass","Passwort wiederholen");
define("LABEL_orga","Organisation");

define("LABEL_lcConfig","Thesauri");
define("LABEL_lcDatos","Metadaten");
define("LABEL_Titulo","Bezeichnung");
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
define("FORM_LABEL_Guardar","Speichern");
define("LABEL_verDetalle","Details für: ");
define("LABEL_verTerminosLetra","Begriffe mit Anfangsbuchstabe ");

define("LABEL_NB","Quelle");
define("LABEL_NH","Entstehungsgeschichte");
define("LABEL_NA","Definition");   /* version 0.9.1 */
define("LABEL_NP","Allgemein"); /* version 0.9.1 */


define("LABEL_EditorNota","Kommentar bearbeiten ");
define("LABEL_EditorNotaTermino","Kommentarfeld für den Begriff ");
define("LABEL_tipoNota","Kommentartyp");
define("FORM_LABEL_tipoNota","note_type");
define("LABEL_nota","Kommentartext");
define("FORM_LABEL_nota","_note");
define("LABEL_EditarNota","Kommentar bearbeiten");
define("LABEL_EliminarNota","Kommentar löschen");

define("LABEL_OptimizarTablas","Tabellenoptimierung");
define("LABEL_TotalZthesLine","Export nach Zthes");

/* v 9.2 */
define("LABEL_negrita","fett");
define("LABEL_italica","kursiv");
define("LABEL_subrayado","unterstrichen");
define("LABEL_textarea","Anmerkungen");
define("MSGL_relacionIlegal","Relation nicht zulässig!");


/* v 9.3 */
define("LABEL_fecha_modificacion","<br>Aktualisiert");
define("LABEL_TotalUsuarios","Benutzer gesamt");
define("LABEL_TotalTerminos","Begriffe gesamt");
define("LABEL_ordenar","Sortieren nach");
define("LABEL_auditoria","Statistik über angelegte Begriffe");
define("LABEL_dia","Tag");
define("LABEL_mes","Monat");
define("LABEL_ano","Jahr");
define("LABEL_terminosRepetidos","Dubletten");
define("MSG_noTerminosLibres","Keine Begriffe ohne Relationen gefunden.");
define("MSG_noTerminosRepetidos","Keine Dubletten gefunden.");
define("LABEL_TotalSkosLine","export on Skos-core");

$MONTHS=array("01"=>"Januar",
              "02"=>"Februar",
              "03"=>"März",
              "04"=>"April",
              "05"=>"Mai",
              "06"=>"Juni",
              "07"=>"Juli",
              "08"=>"August",
              "09"=>"September",
              "10"=>"Oktober",
              "11"=>"November",
              "12"=>"Dezember"
              );

/* v 9.4 */
define("LABEL_SI","YES");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","Polihierarchical");
define("LABEL_jeraquico","Polyhierarchische Strukturen aktivieren");
define("LABEL_terminoLibre","free term");


/* v 9.5 */
define("LABEL_URL_busqueda","Search %s in:");

/* v 9.6 */
define("LABEL_relacion_vocabulario","Begriff aus einem anderen Thesaurus finden und verknüpfen mit ");
define("FORM_LABEL_relacion_vocabulario","equivalence");
define("FORM_LABEL_nombre_vocabulario","Interner Thesaurus");
define("LABEL_vocabulario_referencia","Interner Thesaurus");
define("LABEL_NO_vocabulario_referencia","Kein Thesaurus gefunden");
define("FORM_LABEL_tipo_equivalencia","Äquivalenztyp");
define("LABEL_vocabulario_principal","Thesaurus");
define("LABEL_tipo_vocabulario","Typ");

define("LABEL_termino_equivalente","Volläquivalenz");
define("LABEL_termino_parcial_equivalente","Teiläquivalenz");
define("LABEL_termino_no_equivalente","Nichtäquivalenz");

define("EQ_acronimo","Volläquivanlenz");
define("EQP_acronimo","Teiläqivalenz");
define("NEQ_acronimo","Nichtäquivalenz");
define("LABEL_NC","Sonstiges");

define("LABEL_resultados_suplementarios","Weitere Treffer");
define("LABEL_resultados_relacionados","Verwandte Treffer");

/* v 9.7 */
define("LABEL_export","Datenexport");
define("FORM_LABEL_format_export","Zielformat wählen");


/* v 1.0 */
define("LABEL_fecha_creacion","created");
define("NB_acronimo","BN");
define("NH_acronimo","HN");
define("NA_acronimo","SN");
define("NP_acronimo","PN");
define("NC_acronimo","CN");

define("LABEL_Candidato","Ist Begriffskandidat?");
define("LABEL_Aceptado","Freigegeben");
define("LABEL_Rechazado","Abgelehnt");
define("LABEL_Ultimos_aceptados","last accepted terms");
define("MSG_ERROR_ESTADO","ilegal status");

define("LABEL_Candidatos","Begriffskandidaten");
define("LABEL_Aceptados","Freigegebene Begriffe");
define("LABEL_Rechazados","Abgelehnte Begriffe");

define("LABEL_User_NoHabilitado","deaktiviert");
define("LABEL_User_Habilitado","aktiviert");

// define("LABEL_CandidatearTermino","Candidatear término");
define("LABEL_CandidatearTermino","Begriffskandidat");
define("LABEL_AceptarTermino","Begriff freigeben");
define("LABEL_RechazarTermino","Begriff ablehnen");


/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO","Meinten Sie:");


/* v 1.02 */
define("LABEL_esSuperUsuario","Ist Systemadministrator?");
define("LABEL_Cancelar","Abbrechen");
define("LABEL_Guardar","Speichern");


/* v 1.033 */
define("MENU_AgregarTEexist","Existierender Begriff");
define("MENU_AgregarUPexist","Existierender Begriff");
define("LABEL_existAgregarUP","Existierenden Begriff finden und als Synonymbegriff verknüpfen mit: %s");
define("LABEL_existAgregarTE","Existierenden Begriff finden und als Unterbegriff verknüpfen mit: %s ");
define("MSG_minCharSerarch","Ihr Suchbegriff <i>%s</i> ist <strong>%s </strong> Zeichen lang. Eine Suche ist erst ab <strong>%s</strong> Zeichen möglich");

/* v 1.04 */
define("LABEL_terminoExistente","existierender Begriff");
define("HELP_variosTerminos","HINWEIS: Um mehrere Begriffe anzulegen, geben Sie <strong>einen Begriff pro Zeile</strong> ein.");


/* v 1.05 */
$idiomas_disponibles = array(
     "de"  => array("Deutsch","", "de"),
     "en"  => array("English", "", "en"),
     "fr"  => array("Französisch","", "fr"),
     "es"  => array("Spanisch", "", "es"),
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


$install_message[101] = "TemaTres Setup" ;

$install_message[201] = "Can not found the file configuration for the database connection (%s)." ;
$install_message[202] = "File configuration for the database connection found." ;
$install_message[203] = "Unable to connect to database server <em>%s</em> with the user <em>%s</em>. Please check your file configuration for the database connection (%s)." ;
$install_message[204] = "Connect to Server <em>%s</em> success" ;
$install_message[205] = "Unable to connect to database <em>%s</em> in server <em>%s</em>. Please check your file configuration for the database connection (%s)." ;
$install_message[206] = "Connect to database <em>%s</em> in server <em>%s</em> success." ;

$install_message[301] = 'Woppsss... There is already an Tematres instance for the configuration. Please check your file configuration for the database connection (%s) or <a href="index.php">Enjoy your Vocabulary Server</a>' ;
$install_message[305] = " Checking Security password." ;
$install_message[306] = 'Setup is completed, <a href="index.php">Enjoy your Vocabulary Server</a>' ;
/* end Install messages */


/* v 1.1 */
define('MSG_ERROR_CODE',"invalid code");
define('LABEL_CODE',"Code");
define('LABEL_Ver',"Abfragen");
define('LABEL_OpcionesTermino',"term");
define('LABEL_CambiarEstado',"Status ändern");
define('LABEL_ClickEditar',"Click to edit...");
define('LABEL_TopTerm',"Nur im folgenden Begriff und seinen Unterbegriffen)");
define('LABEL_esFraseExacta',"Exakt wie angegeben");
define('LABEL_DesdeFecha',"Angelegedatum gleich oder größer");
define('LABEL_ProfundidadTermino',"Suchtiefe: bis Unterebene");
define('LABEL_esNoPreferido',"Synonyme");
define('LABEL_BusquedaAvanzada',"Erweiterte Suche");
define('LABEL_Todos',"Alle");
define('LABEL_QueBuscar',"Suchen im Feld");

define("LABEL_import","Datenimport") ;
define("IMPORT_form_legend","Datenimport") ;
define("IMPORT_form_label","Datei") ;
define("IMPORT_file_already_exists","a txt file is already present on the server") ;
define("IMPORT_file_not_exists","no import txt file yet") ;
define("IMPORT_do_it","You can start the import") ;
define("IMPORT_working","import task are working") ;
define("IMPORT_finish","import task finished") ;
define("LABEL_reIndice","Reindizierung") ;
define("LABEL_dbMantenimiento","Datenbank");


/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService',"Begriff aus einem anderen Thesaurus finden und verknüpfen mit ");
define('LABEL_vocabulario_referenciaWS',"Externer Thesaurus");
define('LABEL_TargetVocabularyWS',"Externer Thesaurus");
define('LABEL_tvocab_label',"Bezeichnung");
define('LABEL_tvocab_tag',"Kürzel");
define('LABEL_tvocab_uri_service',"Webservice-URL");
define('LABEL_targetTermsforUpdate',"terms with pending update");
define('LABEL_ShowTargetTermsforUpdate',"check terms update");
define('LABEL_enable',"aktiviert");
define('LABEL_disable',"deaktiviert");
define('LABEL_notFound',"Begriff nicht gefunden");
define('LABEL_termUpdated',"Begriff aktualisiert");
define('LABEL_ShowTargetTermforUpdate',"aktualisiert");
define('LABEL_relbetweenVocabularies',"Mit anderen existierenden Thesauri");
define('LABEL_update1_1x1_2',"Update (1.1 -> 1.3)");
define('LABEL_update1x1_2',"Update (1.0x -> 1.3)");
define('LABEL_TargetTerm',"terminological mapping");
define('LABEL_TargetTerms',"terms (terminological mapping)");
define('LABEL_seleccionar','Wählen...');
define('LABEL_poliBT','Begriffe mit mehr als einem Oberbegriff');
define('LABEL_FORM_simpleReport','Berichte');
define('LABEL_FORM_advancedReport','Zusatzkriterien');
define('LABEL_FORM_nullValue','alle');
define('LABEL_FORM_haveNoteType','Nur mit Kommentar- feld vom Typ');
define('LABEL_haveEQ','mit Äquivalenzen');
define('LABEL_nohaveEQ','ohne Äquivalenzen');
define('LABEL_start','beginnt mit');
define('LABEL_end','endet mit');
define('LABEL_equalThisWord','gleich');
define('LABEL_haveWords','enthält');
define('LABEL_encode','Kodierung');


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
define('LABEL_termsNoBT','Begriffe ohne hierarchische Relationen');
define('MSG_noTermsNoBT','There are no terms without hierarchical relations');
define('LABEL_termsXcantWords','number of words x term');

define('LABEL__USE_CODE','Codes für Sortierung verwenden');
define('LABEL__SHOW_CODE','Codes auch für Nur-Leser anzeigen');
define('LABEL_CFG_MAX_TREE_DEEP','Maximale Anzahl Unterebenen für die Anzeige');
define('LABEL_CFG_VIEW_STATUS','Statusdetails auch für Nur-Leser anzeigen');
define('LABEL_CFG_SIMPLE_WEB_SERVICE','Webservices aktivieren');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS','Anzahl Begriffe in der Statusansicht');
define('LABEL_CFG_MIN_SEARCH_SIZE','Minimale Anzahl Zeichen für Suchoperationen');
define('LABEL__SHOW_TREE','Hierarchische Ansicht aktivieren');
define('LABEL__PUBLISH_SKOS','Skos-core Format für Webservices aktivieren');

define('LABEL_update1_3x1_4',"Update (1.3x -> 1.4)");
define("FORM_LABEL_format_import","Dateiformat");
define("LABEL_importTab","TXT, tab-delimitiert");
define("LABEL_importTag","tXT, tagged");
define("LABEL_importSkos","Skos-core");
define("LABEL_configTypeNotes","Konfiguration der Kommentarfelder");
define("LABEL_notes","Kommentarfeld(er)");
define("LABEL_saved","Speichern erfolgreich");
define("FORM_JS_confirmDeleteTypeNote","Möchten Sie diesen Typ wirklich löschen?");

/*
v1.5
*/
define("LABEL_relationEditor","Konfiguration der Relationen");
define("LABEL_relationDelete","löschen");
define('LABEL_relationSubType',"Relationstyp");
define('LABEL_relationSubTypeCode',"Kürzel");
define('LABEL_relationSubTypeLabel',"Bezeichnung");
define('LABEL_optative',"optional");
define('FORM_JS_confirmDeleteTypeRelation','Möchten Sie diesen Relationstyp wirklich löschen?');

define("LABEL_URItypeEditor","Konfiguration der Verknüpfungen zwischen Thesauri");
define("LABEL_URIEditor","Relation zu einer URL hinzufügen");
define("LABEL_URItypeDelete","Löschen");
define('LABEL_URItype',"Typ");
define('LABEL_URItypeCode',"Kürzel");
define('LABEL_URItypeLabel',"Bezeichnung");
define('FORM_JS_confirmDeleteURIdefinition','Typ löschen?');
define('LABEL_URI2term','Mit existierender URL');
define('LABEL_URI2termURL','URL');
define('LABEL_update1_4x1_5','Update (1.4 -> 1.5)');
define('LABEL_Contributor','Weitere Autoren');
define('LABEL_Rights','Rechte');
define('LABEL_Publisher','Verlag');

/*
v1.6
*/
define('LABEL_Prev','previous');
define('LABEL_Next','next');
define('LABEL_PageNum','page results number ');
define('LABEL_selectMapMethod','select terminological mapping method');
define('LABEL_string2search','search expression');
define('LABEL_reverseMappign','reverse mapping');
define('LABEL_warningMassiverem','Sie sind dabei, eine Massendatenlöschung auszuführen. Dieser Vorgang kann nicht rückgängig gemacht werden!');
define('LABEL_target_terms','Verknüpfungen mit externen Thesauri');
define('LABEL_URI2terms','Web-Verknüpfungen');
define('MENU_massiverem','Daten pauschal löschen');
define('LABEL_more','more');
define('LABEL_less','less');
define('LABEL_lastChangeDate','Letzte Aktualisierung am');
define('LABEL_update1_5x1_6','Update (1.5 -> 1.6)');
define('LABEL_login','Anmeldung');
define('LABEL_user_recovery_password','Neues Passwort erzeugen');
define('LABEL_user_recovery_password1','Geben Sie Ihre Kennung ein. Sie erhalten einen Link, mit dem Sie das Passwort zurücksetzen können.');
define('LABEL_mail_recoveryTitle','Passwort zurücksetzen');
define('LABEL_mail_recovery_pass1','Someone requested that the password be reset for the following account:');
define('LABEL_mail_recovery_pass2','Username: %s');
define('LABEL_mail_recovery_pass3','If this was a mistake, just ignore this email and nothing will happen.');
define('LABEL_mail_recovery_pass4','To reset your password, visit the following address:');

define('LABEL_mail_passTitle','Neues Passwort ');
define('LABEL_mail_pass1','Neues Passwort für ');
define('LABEL_mail_pass2','Passwort: ');
define('LABEL_mail_pass3','Sie können es ändern.');
define('MSG_check_mail_link','prüfen Sie den Link aus der E-Mail.');
define('MSG_check_mail','Bitte prüfen Sie Ihre E-Mails.');
define('MSG_no_mail','Е-Мail konnte nicht versendet werden.');
define('LABEL_user_lost_password',' Passwort vergessen? - ACHTUNG: FUNKTIONIERT NICHT IM BSPRA!');

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
