<?php
#   TemaTres : applicazione per la gestione di linguaggi documentali #       #
#   Author for this i18n: Andrea Garelli - revisione 2013: Paolo Plini
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
define("MSG_noUser","Utente non registrato");

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
define("LABEL_TotalZthesLine","Thesaurus completo in Zthes");

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
define("LABEL_TotalSkosLine","Thesaurus completo in Skos-core");

$MONTHS=array("01"=>"Gen",
              "02"=>"Feb",
              "03"=>"Mar",
              "04"=>"Apr",
              "05"=>"Mag",
              "06"=>"Giu",
              "07"=>"Lug",
              "08"=>"Ago",
              "09"=>"Set",
              "10"=>"Ott",
              "11"=>"Nov",
              "12"=>"Dic"
              );

/* v 9.4 */
define("LABEL_SI","SI");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","poligerarchico");
define("LABEL_jeraquico","Poligerarchico");
define("LABEL_terminoLibre","Termine libero");

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

define("LABEL_resultados_suplementarios","Risultati supplementari");
define("LABEL_resultados_relacionados","Risultati associati");

// define("MENU_NuevoVocabularioReferencia","Nuovo vocabolario di supporto");

/* v 9.7 */
define("LABEL_export","esporta");
define("FORM_LABEL_format_export","seleziona formato");
define("LABEL_siteMap","Mappa del sito");
define("LABEL_TotalTopicMap","Thesaurus completo in TopicMaps");


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
define("MENU_AgregarTEexist","Subordinare un termine esistente");
define("MENU_AgregarUPexist","Associare un termine non preferito esistente");
define("LABEL_existAgregarUP","Aggiungere un termine UF a %s");
define("LABEL_existAgregarTE","Aggiungere un narrower term a %s ");
define("MSG_minCharSerarch","L'espressione di ricerca <i>%s</i> ha solo <strong>%s </strong> caratteri. Deve essere maggiore di <strong>%s</strong> caratteri");

/* v 1.04 */
define("LABEL_terminoExistente","termine esistente");
define("HELP_variosTerminos","Per aggiungere termini contemporaneamente incarna <strong>una parola per linea</strong>.");


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


/* v 1.1 */
define('MSG_ERROR_CODE',"codice non valido");
define('LABEL_CODE',"codice");
define('LABEL_Ver',"Mostra");
define('LABEL_OpcionesTermino',"termine");
define('LABEL_CambiarEstado',"Modifica status del termine");
define('LABEL_ClickEditar',"Clicca per modificare...");
define('LABEL_TopTerm',"Ha questo top term");
define('LABEL_esFraseExacta',"frase esatta");
define('LABEL_DesdeFecha',"creato il o dopo il");
define('LABEL_ProfundidadTermino',"&egrave; collocato ad un lilvello pi&ugrave; basso");
define('LABEL_esNoPreferido',"nessun termine preferito");
define('LABEL_BusquedaAvanzada',"ricerca avanzata");
define('LABEL_Todos',"tutto");
define('LABEL_QueBuscar',"quale ricerca?");

define("LABEL_import","importa") ;
define("IMPORT_form_legend","importa thesaurus da un file") ;
define("IMPORT_form_label","file") ;
define("IMPORT_file_already_exists","un file txt è già presente sul server") ;
define("IMPORT_file_not_exists","non esiste ancora un file txt da importare") ;
define("IMPORT_do_it","&Egrave; possibile iniziare l'importazione") ;
define("IMPORT_working","importazione in corso") ;
define("IMPORT_finish","importazione completata") ;
define("LABEL_reIndice","ricreare gli indici") ;
define("LABEL_dbMantenimiento","manutenzione database");




/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService',"relazione con un termine da un target vocabulary remoto");
define('LABEL_vocabulario_referenciaWS',"target vocabulary remoto (web  services)");
define('LABEL_TargetVocabularyWS',"target vocabulary remoto (web  services)");
define('LABEL_tvocab_label',"etichetta per il riferimento");
define('LABEL_tvocab_tag',"tag per il riferimento");
define('LABEL_tvocab_uri_service',"URL per il web service di riferimento");
define('LABEL_targetTermsforUpdate',"termini in attesa di aggiornamento");
define('LABEL_ShowTargetTermsforUpdate',"controlla l'aggiornamento dei termini");
define('LABEL_enable',"abilita");
define('LABEL_disable',"disabilita");
define('LABEL_notFound',"termine non trovato");
define('LABEL_termUpdated',"termine aggiornato");
define('LABEL_ShowTargetTermforUpdate',"aggiorna");
define('LABEL_relbetweenVocabularies',"relazione tra vocabolari");
define('LABEL_update1_1x1_2',"Aggiorna Tematres (1.1 -> 1.3)");
define('LABEL_update1x1_2',"Aggiorna Tematres (1.0x -> 1.3)");
define('LABEL_TargetTerm',"mapping terminologico)");
define('LABEL_TargetTerms',"termini (mapping terminologico)");
define('LABEL_seleccionar','seleziona');
define('LABEL_poliBT','pi&ugrave; di un broader term');
define('LABEL_FORM_simpleReport','report');
define('LABEL_FORM_advancedReport','report avanzati');
define('LABEL_FORM_nullValue','no matters');
define('LABEL_FORM_haveNoteType','non ha tipo');
define('LABEL_haveEQ','ha equivalenti');
define('LABEL_nohaveEQ','non ha equivalenti');
define('LABEL_start','inizia per');
define('LABEL_end','termina con');
define('LABEL_equalThisWord','corrispondenza esatta con');
define('LABEL_haveWords','include parole');
define('LABEL_encode','encoding');


/*
v1.21
*/
define('LABEL_import_skos','Importa Skos-Core');
define('IMPORT_skos_file_already_exists','La fonte Skos-Core &egrave; nel server');
define('IMPORT_skos_form_legend','Importa Skos-Core');
define('IMPORT_skos_form_label','File Skos-Core');

/*
v1.4
*/
define('LABEL_termsxNTterms','Narrower terms x termine');
define('LABEL_termsNoBT','Termini senza relazioni gerarchiche');
define('MSG_noTermsNoBT','Non ci sono termini senza relazioni gerarchiche');
define('LABEL_termsXcantWords','numero di parole x termine');

define('LABEL__USE_CODE','utilizza il codice dei termini per ordinarli');
define('LABEL__SHOW_CODE','Mostra il codice dei termine nella visualizzazione pubblica');
define('LABEL_CFG_MAX_TREE_DEEP','Massimo livello di profondit&agrave; nell\'albero di elementi da visualizzare nella stessa pagina');
define('LABEL_CFG_VIEW_STATUS','Dettagli sullo status visibili per tutti gli utenti');
define('LABEL_CFG_SIMPLE_WEB_SERVICE','abilita web services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS','Numero di termini visualizzati per vista status');
define('LABEL_CFG_MIN_SEARCH_SIZE','Caratteri minimi per le operazioni di ricerca');
define('LABEL__SHOW_TREE','pubblica la vista gerarchica nella pagina home');
define('LABEL__PUBLISH_SKOS','abilita il formato Skos-core nei web service. Questo può esporre interamente il vocabolario.');

define('LABEL_update1_3x1_4',"Aggiorna Tematres (1.3x -> 1.4)");
define("FORM_LABEL_format_import","scelta format");
define("LABEL_importTab","testo con tabulazioni");
define("LABEL_importTag","testo con tag");
define("LABEL_importSkos","Skos-core");
define("LABEL_configTypeNotes","configura il tipo di note");
define("LABEL_notes","note");
define("LABEL_saved","salvato");
define("FORM_JS_confirmDeleteTypeNote","eliminare questo tipo di note?");

/*
v1.5
*/
define("LABEL_relationEditor","editor delle relazioni");
define("LABEL_relationDelete","cancella il sottotipo della relazione");
define('LABEL_relationSubType',"tipo di relazione");
define('LABEL_relationSubTypeCode',"alias del sottotipo di relazione");
define('LABEL_relationSubTypeLabel',"etichetta del sottotipo di relazione");
define('LABEL_optative',"opzionale");
define('FORM_JS_confirmDeleteTypeRelation','cancella questo sottotipo della relazione?');

define("LABEL_URItypeEditor","editor del tipo di link");
define("LABEL_URIEditor","gestisci i link associati al termine");
define("LABEL_URItypeDelete","cancella il tipo di link");
define('LABEL_URItype',"tipo di link");
define('LABEL_URItypeCode',"alias del tipo di link");
define('LABEL_URItypeLabel',"etichetta del tipo di link");
define('FORM_JS_confirmDeleteURIdefinition','cancella questo tipo di link?');
define('LABEL_URI2term','risorsa web');
define('LABEL_URI2termURL','URL della risorsa web');
define('LABEL_update1_4x1_5','Aggiorna (1.4 -> 1.5)');
define('LABEL_Contributor','contributori');
define('LABEL_Rights','diritti');
define('LABEL_Publisher','editore');
/*
v1.6
*/
define('LABEL_Prev','precedente');
define('LABEL_Next','successivo');
define('LABEL_PageNum','numero di pagina dei risultati');
define('LABEL_selectMapMethod','seleziona il metodo di mapping terminologico');
define('LABEL_string2search','espressione di ricerca');
define('LABEL_reverseMappign','mapping inverso');
define('LABEL_warningMassiverem','Si stanno per eliminare dati in massa. Queste azioni sono irreversibili!');
define('LABEL_target_terms','termini mappati da vocabolari esterni');
define('LABEL_URI2terms','risorse web');
define('MENU_massiverem','Cancella dati in massa');
define('LABEL_more','pi&ugrave;');
define('LABEL_less','meno');
define('LABEL_lastChangeDate','data dell\'ultima modifica');
define('LABEL_update1_5x1_6','Aggiorna (1.5 -> 1.6)');
define('LABEL_login','accedere');
define('LABEL_user_recovery_password','ottieni nuova password');
define('LABEL_user_recovery_password1','Digitare nome utente o indirizzo email. Si ricever&agrave; un link per creare unanuova password via email.');
define('LABEL_mail_recoveryTitle','Password Reset');
define('LABEL_mail_recovery_pass1','Qualcuno ha richiesto il reset della password per i seguenti account:');
define('LABEL_mail_recovery_pass2','Username: %s');
define('LABEL_mail_recovery_pass3','Se si tratta di un errore, ignorare questa email e non ci saranno variazioni.');
define('LABEL_mail_recovery_pass4','Per il reset della vostra password, visitare l\'indirizzo seguente:');

define('LABEL_mail_passTitle','Nuova Password ');
define('LABEL_mail_pass1','Nuova password per ');
define('LABEL_mail_pass2','Password: ');
define('LABEL_mail_pass3','Si pu&ograve; modificare.');
define('MSG_check_mail_link','Controllare la vostra e-mail per il link di conferma.');
define('MSG_check_mail','Controllare la vostra e-mail.');
define('MSG_no_mail','L\'e-mail non può essere inviata.');
define('LABEL_user_lost_password',' Password smarrita?');


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
define('MSG__warningDeleteTerm','Il termine <i>%s</i> sarà <strong>cancellato</strong>.');
define('MSG__warningDeleteTerm2row','Saranno cancellate <strong>tutte</strong> le sue note e le relazioni terminologiche.');


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
