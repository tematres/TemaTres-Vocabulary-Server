<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Maribel Cuadrado

# 2014-03-06 jsau arreglant i completant catala
###############################################################################################################
#

define("LANG","ca");

define("TR_acronimo","TR");
define("TE_acronimo","TE");
define("TG_acronimo","TG");
define("UP_acronimo","UP");

define("TR_termino","Terme relacionat");
define("TE_termino","Terme específic");
define("TG_termino","Terme genèric");
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
define("MENU_AgregarTG","subordinar a terme genèric"); # era 'subordinar a terme'
define("MENU_AgregarTE","terme específic"); # era 'terme subordinat'
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
define("LABEL_AgregarTG","Subordinar %s a terme genèric"); # era ...  terme superior
define("LABEL_AgregarTE","Alta d'un terme específic de "); # era ...terme subordinat
define("LABEL_AgregarUP","Alta d'un terme equivalent de ");
define("LABEL_AgregarTR","Alta d'un terme relacionat amb ");
define("LABEL_EliminarTE","Eliminar terme");
define("LABEL_Detalle","detalls");
define("LABEL_EditarNota","editar nota");


define("LABEL_Autor","Autor");
define("LABEL_URI","URI");
define("LABEL_Version","Generat per");
define("LABEL_Idioma","Llengua");
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
define("LABEL_Acciones","Accions completades"); # era realitzades
define("LABEL_verEsquema","veure esquema");
define("LABEL_actualizar","Actualitzar");
define("LABEL_terminosLibres","Termes lliures");
define("LABEL_busqueda","Cerca");
define("LABEL_borraRelacion","eliminar relació");

define("MSG_ResultBusca","terme/s trobats a la cerca");
define("MSG_ResultLetra","Lletra");
define("MSG_ResultCambios","Els canvis s'han fet amb èxit."); # era realitzat
define("MSG_noUser","Usuari no registrat");

define("FORM_JS_check","Si us plau reviseu les dades de "); # canvi vos
define("FORM_JS_confirm","Segur que voleu eliminar el terme o la relació?"); # canvi vos
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
define("FORM_LABEL_Idioma","Llengua");
define("FORM_LABEL_FechaDia","dia");
define("FORM_LABEL_FechaMes","mes");
define("FORM_LABEL_FechaAno","any");
define("FORM_LABEL_Keywords","keywords");
define("FORM_LABEL_TipoLenguaje","tipus de llenguatge");
define("FORM_LABEL_Cobertura","cobertura");
define("FORM_LABEL_Terminos","termes");
define("FORM_LABEL_RelTerminos","relacions entre termes");
define("FORM_LABEL_TerminosUP","termes equivalents");
define("FORM_LABEL_Guardar","Desar");

define("LABEL_verDetalle","veure detalls de ");
define("LABEL_verTerminosLetra","veure termes que comencen amb ");

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
define("LABEL_italica","cursiva");
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

$MONTHS=array("01"=>"Gen",
              "02"=>"Feb",
              "03"=>"Mar",
              "04"=>"Abr",
              "05"=>"Mai",
              "06"=>"Jun",
              "07"=>"Jul",
              "08"=>"Ago",
              "09"=>"Set",
              "10"=>"Oct",
              "11"=>"Nov",
              "12"=>"Des"
              );

/* v 9.4 */
define("LABEL_SI","SÍ");
define("LABEL_NO","NO");
define("FORM_LABEL_jeraquico","polijerarquia");
define("LABEL_jeraquico","polijeràrquic");
define("LABEL_terminoLibre","terme lliure");

/* v 9.5 */
define("LABEL_URL_busqueda","Cercar %s a: ");


/* v 9.6 */
define("LABEL_relacion_vocabulario","relació amb un altre vocabulari");
define("FORM_LABEL_relacion_vocabulario","equivalència");
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
define("FORM_LABEL_format_export","triar format");
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
define("LABEL_TERMINO_SUGERIDO","potser volíeu dir:");


/* v 1.02 */
define("LABEL_esSuperUsuario","és administrador");
define("LABEL_Cancelar","cancel·lar");
define("LABEL_Guardar","desar");

/* v 1.033 */
define("MENU_AgregarTEexist","Subordinar un terme lliure");
define("MENU_AgregarUPexist","Associar un terme no-preferit (lliure)");
define("LABEL_existAgregarUP","Associar un terme no-preferit %s");
define("LABEL_existAgregarTE","Subordinar un terme lliure %s ");
define("MSG_minCharSerarch","L'expressió de cerca <i>%s</i> té només <strong>%s</strong> caràcters. Ha de ser més llarga de <strong>%s</strong> caràcters");

/* v 1.04 */
define("LABEL_terminoExistente","terme ja existent");
define("HELP_variosTerminos","Podeu afegir més d'un terme alhora si entreu <strong>un terme per ratlla</strong>.");


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
     "pt"  => array("portugués","", "pt"),
	 "ru"  => array("Pусский","", "ru")
    );


/* Install messages */

define("FORM","Form") ;
define("ERROR","Error") ;
define("LABEL_bienvenida","Benvinguts a TemaTres...") ;

// COMMON SQL
define("PARAM_SERVER","Server address") ;
define("PARAM_DBName","Database name") ;
define("PARAM_DBLogin","Database User") ;
define("PARAM_DBPass","Database Password") ;
define("PARAM_DBprefix","Prefix tables") ;


$install_message[101] = "Instal·lació de TemaTres" ;

$install_message[201] = "No es troba l'arxiu de configuració de la base de dades (%s)." ;
$install_message[202] = "Arxiu de configuració de la base de dades trobat." ;
$install_message[203] = "No es pot connectar amb el servidor  <em>%s</em> fent servir l'usuari <em>%s</em>. Si us plau reviseu les dades de l'arxiu de configuració de la base de dades (%s)" ;
$install_message[204] = "Connexió amb el servidor <em>%s</em> completada" ;
$install_message[205] = "No es pot  connectar amb la base de dades <em>%s</em> a <em>%s</em>. Si us plau reviseu les dades de l'arxiu de configuració de la base de dades (%s)." ;
$install_message[206] = "Connexió amb la base de dades <em>%s</em> en <em>%s</em> verificada." ;

$install_message[301] = 'Parece que las tablas ya han sido creadas para la configuración establecida. <a href="index.php">Comience a utilizar su vocabulario</a>' ;
$install_message[305] = "Indicació sobre el grau de seguretat de la clau.";
$install_message[306] = 'Instal·lació completada, <a href="index.php">Ja podeu començar a fer el vocabulari</a>' ;
/* end Install messages */



/* v 1.1 */
define('MSG_ERROR_CODE',"codi duplicat");
define('LABEL_CODE',"codi");
define('LABEL_Ver',"veure");
define('LABEL_OpcionesTermino',"terme");
define('LABEL_CambiarEstado',"canviar estat");
define('LABEL_ClickEditar',"cliqueu per a editar...");
define('LABEL_TopTerm',"Té aquest terme capçalera");
define('LABEL_esFraseExacta',"amb la frase exacta");
define('LABEL_DesdeFecha',"creat el o després del");
define('LABEL_ProfundidadTermino',"Nivell de jerarquia");
define('LABEL_esNoPreferido',"terme no preferit");
define('LABEL_BusquedaAvanzada',"cerca avançada");
define('LABEL_Todos',"tots");
define('LABEL_QueBuscar',"Què cercar?");

define("LABEL_import","Importar") ;
define("IMPORT_form_legend","Importar un arxiu de text tabulat") ;
define("IMPORT_form_label","Arxiu") ;
define("IMPORT_file_already_exists","Un arxiu txt ja existeix al servidor") ;
define("IMPORT_file_not_exists","No hi ha arxius encara") ;
define("IMPORT_do_it","Podeu iniciar la importació") ;
define("IMPORT_working","procés d’importació en marxa") ;
define("IMPORT_finish","importació finalitzada") ;
define("LABEL_reIndice","Recrear índexs de termes") ;
define("LABEL_dbMantenimiento","Manteniment de la base de dades") ;

/*
v 1.2
*/

define('LABEL_relacion_vocabularioWebService',"Relació amb un terme d'un altre vocabulari");
define('LABEL_vocabulario_referenciaWS',"Vocabulari extern via serveis web");
define('LABEL_TargetVocabularyWS',"Vocabulari extern via serveis web");
define('LABEL_tvocab_label',"llegenda de la referència");
define('LABEL_tvocab_tag',"etiqueta de la referència");
define('LABEL_tvocab_uri_service',"URL del servei web de referència");
define('LABEL_targetTermsforUpdate',"termes amb actualitzacions pendents");
define('LABEL_ShowTargetTermsforUpdate',"revisar actualitzacions de termes");
define('LABEL_enable',"habilitat");
define('LABEL_disable',"Inhabilitat");
define('LABEL_notFound',"terme no trobat");
define('LABEL_termUpdated',"terme actualitzat");
define('LABEL_ShowTargetTermforUpdate',"actualitzar");
define('LABEL_relbetweenVocabularies',"relacions entre vocabularis");
define('LABEL_update1_1x1_2',"Update Tematres (1.1 -> 1.3)");
define('LABEL_update1x1_2',"Update Tematres (1.0x -> 1.3)");
define('LABEL_TargetTerm',"terme extern (mapeig terminològic)");
define('LABEL_TargetTerms',"termes externs (mapeig terminològic)");
define('LABEL_seleccionar',"triar");
define('LABEL_poliBT',"més d'un terme genèric");
define('LABEL_FORM_simpleReport','Informes');
define('LABEL_FORM_advancedReport','Informes avançats');
define('LABEL_FORM_nullValue','Tant fa');
define('LABEL_FORM_haveNoteType','amb nota tipus');
define('LABEL_haveEQ','amb equivalències');
define('LABEL_nohaveEQ','sense equivalències');
define('LABEL_start','comencen amb');
define('LABEL_end','acaben amb');
define('LABEL_equalThisWord','iguals a');
define('LABEL_haveWords','inclouen paraules');
define('LABEL_encode','codificació');

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
define('LABEL_termsxNTterms','Termes segons quantitat de termes específics');
define('LABEL_termsNoBT','Termes sense relacions jerárquiques');
define('MSG_noTermsNoBT','No hi ha termes sense relacions jerárquiques');
define('LABEL_termsXcantWords','Termes segons quantitat de paraules');

define('LABEL__USE_CODE','permetre codi identificador únic per terme');
define('LABEL__SHOW_CODE','publicar codi identificador únic per terme');
define('LABEL_CFG_MAX_TREE_DEEP',"Màxim nivell de profunditat a l'arbre de temes per a la visualització");
define('LABEL_CFG_VIEW_STATUS',"publicar detalls de l'estat dels termes");
define('LABEL_CFG_SIMPLE_WEB_SERVICE','habilitar web services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS','quantitat de termes per a visualització de llistats segons estats');
define('LABEL_CFG_MIN_SEARCH_SIZE','mínim de caràcters per a operacions de cerca');
define('LABEL__SHOW_TREE',"publicar navegació jeràrquica a la pàgina d'inici");
define('LABEL__PUBLISH_SKOS','permetre consultes SKOS-core a través de serveis web; això podria extreure tot el vocabulari.');

define('LABEL_update1_3x1_4',"Actualitzar Tematres (1.3x -> 1.4)");
define("FORM_LABEL_format_import","triar format");
define("LABEL_importTab","text tabulat");
define("LABEL_importTag","text etiquetat");
define("LABEL_importSkos","Skos-core");
define("LABEL_configTypeNotes","Configurar tipus de notes");
define("LABEL_notes","notes");
define("LABEL_saved","desat");
define("FORM_JS_confirmDeleteTypeNote","Segur que voleu eliminar aquest tipus de nota?");


/*
v1.5
*/
define("LABEL_relationEditor","editor de relacions");
define("LABEL_relationDelete","eliminar relació");
define('LABEL_relationSubType',"tipus de relació");
define('LABEL_relationSubTypeCode',"codi del tipus de relació");
define('LABEL_relationSubTypeLabel',"llegenda del tipus de relació");
define('LABEL_optative',"opcional");
define('FORM_JS_confirmDeleteTypeRelation','Segur que voleu eliminar aquest tipus de relació?');

define("LABEL_URItypeEditor","editor de tipus d'enllaços");
define("LABEL_URIEditor","Gestionar enllaços relacionats al terme");
define("LABEL_URItypeDelete","eliminar tipus d'enllaç");
define('LABEL_URItype',"tipus d'enllaç");
define('LABEL_URItypeCode',"alias del tipus d'enllaç");
define('LABEL_URItypeLabel',"llegenda del tipus d'enllaç");
define('FORM_JS_confirmDeleteURIdefinition',"Segur que voleu eliminar aquest tipus d'enllaç?");
define('LABEL_URI2term','recurs web');
define('LABEL_URI2termURL','Adreça del recurs web');
define('LABEL_update1_4x1_5','Actualitzar (1.4 -> 1.5)');
define('LABEL_Contributor','Coautor/Col·laborador');
define('LABEL_Rights','Drets');
define('LABEL_Publisher','Publicador');


/*
v1.6
*/
define('LABEL_Prev','anteriors');
define('LABEL_Next','següents');
define('LABEL_PageNum','pàgina de resultats número ');
define('LABEL_selectMapMethod','Trieu mètode de mapeig terminològic');
define('LABEL_string2search','expressió de cerca');
define('LABEL_reverseMappign','mapeig invers');
define('LABEL_warningMassiverem',"Esteu a punt d'eliminar dades massivament. Aquesta acció serà IRREVERSIBLE!");
define('LABEL_target_terms','termes mapejats des de vocabularis externs');
define('LABEL_URI2terms','recursos web');
define('MENU_massiverem','Esborrat massiu de dades');
define('LABEL_more','més');
define('LABEL_less','menys');
define('LABEL_lastChangeDate',"data d'última modificació");
define('LABEL_update1_5x1_6','Actualitzar (1.5 -> 1.6)');
define('LABEL_login','accedir');
define('LABEL_user_recovery_password','Obtenir una nova contrasenya');
define('LABEL_user_recovery_password1','Sisplau, entreu el vostre correu electrònic. Rebreu un enllaç per a crear la contrasenya.');
define('LABEL_mail_recoveryTitle',"Recuperar clau d'accés");
define('LABEL_mail_recovery_pass1','Algú ha demanat una nova contrasenya per al compte:');
define('LABEL_mail_recovery_pass2',"Nom d'usuari: %s2");
define('LABEL_mail_recovery_pass3',"Si és un error, no feu cas d'aquest missatge.");
define('LABEL_mail_recovery_pass4',"Per a canviar la contrasenya, visiteu aquest enllaç:");

define('LABEL_mail_passTitle','Nova clau ');
define('LABEL_mail_pass1','Nova clau per a ');
define('LABEL_mail_pass2','Clau: ');
define('LABEL_mail_pass3','Podeu modificar-la.');
define('MSG_check_mail_link',"Reviseu el correu electrònic per a obtenir l'enllaç de confirmació.");
define('MSG_check_mail','Sisplau, reviseu el correu electrònic.');
define('MSG_no_mail',"No s'ha pogut enviar el correu.");
define('LABEL_user_lost_password','Heu perdut la contrasenya?');

## v1.7
define('LABEL_includeMetaTerm','Incloure meta-termes');
define('NOTE_isMetaTerm','És un meta-terme.');
define('NOTE_isMetaTermNote','Un meta-terme es un terme que NO es pot fer servir per a indexació. És un terme que descriu altres termes, com termes guia, facetes, categories, etc.');
define('LABEL_turnOffMetaTerm','no és un meta-terme');
define('LABEL_turnOnMetaTerm','és un meta-terme');
define('LABEL_meta_term','meta-terme');
define('LABEL_meta_terms','meta-termes');
define('LABEL_relatedTerms','termes relacionats');
define('LABEL_nonPreferedTerms','termes no preferits');
define('LABEL_update1_6x1_7','Actualitzar (1.6 -> 1.7)');
define('LABEL_include_data','incloure');
define('LABEL_updateEndpoint','actualitzar punt de consulta SPARQL');
define('MSG__updateEndpoint',"A continuació s'actualizaran les dades exposades al punt de consulta SPARQL. Aquesta operació pot trigar uns quants minuts.");
define('MSG__updatedEndpoint',"El punt de consulta SPARQL s'ha actualitzat.");
define('MSG__dateUpdatedEndpoint',"Data d'última actualització del punt de consulta SPARQL");
define('LABEL__ENABLE_SPARQL','Cal actualitzar el punt de consulta: Menú Administració -> Manteniment de la base de dades -> Actualitzar punt de consulta SPARQL.');
define('MSG__disable_endpoint','El punt de consulta SPARQL està deshabilitat.');
define('MSG__need2setup_endpoint',"El punt de consulta SPARQL ha de ser actualizat. Contacteu amb l'administrador");
define('LABEL_SPARQLEndpoint','punt de consulta SPARQL');
define('LABEL_AgregarRTexist','associar un terme associat existent amb ');
define('MENU_selectExistTerm','triar terme existent');
define("TT_terminos","Termes superiors");

## v1.72
define('MSG__warningDeleteTerm',"El terme <i>%s</i> será <strong>ELIMINAT</strong>.");
define('MSG__warningDeleteTerm2row',"S'eliminaran <strong>totes</strong> les seves notes i relacions terminològiques. Aquesta acció serà IRREVERSIBLE!");

## v1.8
define('LABEL__getForRecomendation','buscar recomendaciones');
define('LABEL__getForRecomendationFor','buscar recomendaciones para ');
define('FORM_LABEL__contactMail','Correo electrónico de contacto');
define('LABEL_addMapLink','agregar mapeo entre vocabularios');
define('LABEL_addExactLink','agregar enlace de referencia');
define('LABEL_addSourceNote','agregar nota de fuente');

## v1.82
define('LABEL_FORM_mappedTermReport','Relaciones entre vocabularios');
define('LABEL_eliminar','Eliminar');


##v.2
define('MSG_termsNoDeleted','términos no fueron eliminados');
define('MSG_termsDeleted','términos eliminados');
define('LABEL_selectAll','seleccionar todo');
define('LABEL_metadatos','metadatos');
define('LABEL_totalTermsDescendants','términos descendentes');
define('LABEL_altTerms','términos alternativos');
define('LABEL_narrowerTerms','términos específicos');
define('LABEL_results','resultados');
define('LABEL_showFreeTerms','lista de términos libres');
define('LABEL_helpSearchFreeTerms','Sólo se buscarán términos libres.');
define('LABEL_broatherTerms','términos genéricos');
define('LABEL_type2filter','tipee para filtrar términos');
define('LABEL_defaultEQmap','Utilice "eq" para indicar relación de equivalencia');
define("MSG_repass_error","las claves no coinciden");
define("MSG_lengh_error","mínimo de %d caracteres");
define("MSG_errorPostData","Ha ocurrido un error, por favor revise los datos correspondiente al campo ");
define('LABEL_preferedTerms','términos preferidos');
define('LABEL_FORM_NULLnotesTermReport','términos SIN notas');
define('MSG_FORM_NULLnotesTermReport','términos que no tienen notas de tipo');
define('LABELnoNotes','términos sin ninguna nota');
define('LABEL_termsXdeepLevel','términos según nivel de profundidad');
define('LABEL_deepLevel','nivel');
define('LABEL_cantTerms','# de términos');
define('LINK_publicKnownVocabularies','<a href="http://www.vocabularyserver.com/vocabularies/" title="Lista de vocabularios controlados conocidos" target="_blank">Lista de vocabularios controlados conocidos</a>');
define('LABEL_showNewsTerm','ver cambios recientes');
define('LABEL_newsTerm','cambios recientes');
define('MSG_contactAdmin','contacte al administardor');
define('LABEL_addTargetVocabulary','agregar vocabularios de referencia (servicios web terminológicos)');
?>
