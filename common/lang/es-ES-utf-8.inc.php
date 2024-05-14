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
define('LABEL_i18n_TranslationAuthor', 'Traducción de la comunidad de TemaTres'); /* Can be changed by translators. Do not include emails or personal details */
/* Strings to translate */
define("LANG", "es");
define("TR_acronimo", "TR"); /* Related Term */
define("TE_acronimo", "TE"); /* Narrower term > Specific term */
define("TG_acronimo", "TG"); /* Broader term > Generic term */
define("UP_acronimo", "UP"); /* Used for > instead */
define("TR_termino", "Término relacionado");
define("TE_termino", "Término específico");
define("TG_termino", "Término general");
define("UP_termino", "Usados por"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "USE"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "Lista sistemática");
define("MENU_ListaAbc", "Lista alfabética");
define("MENU_Sobre", "Sobre...");
define("MENU_Inicio", "Inicio");
define("MENU_MiCuenta", "Mi cuenta");
define("MENU_Usuarios", "Usuarios");
define("MENU_NuevoUsuario", "Nuevo usuario");
define("MENU_DatosTesauro", "Datos del vocabulario");
define("MENU_AgregarT", "Agregar término");
define("MENU_EditT", "Editar término");
define("MENU_BorrarT", "eliminar término");
define("MENU_AgregarTG", "subordinar a un término");
define("MENU_AgregarTE", "término subordinado");
define("MENU_AgregarTR", "término relacionado");
define("MENU_AgregarUP", "término alternativo");  /* Non-descriptor */
define("MENU_MisDatos", "Mis datos");
define("MENU_Caducar", "Caducar");
define("MENU_Habilitar", "habilitar");
define("MENU_Salir", "Salir");
define("LABEL_Menu", "Menú");
define("LABEL_Opciones", "Opciones");
define("LABEL_Admin", "Administración");
define("LABEL_Agregar", "Agregar");
define("LABEL_editT", "Modificar término ");
define("LABEL_EditorTermino", "Editor de término");
define("LABEL_Termino", "Término");
define("LABEL_NotaAlcance", "Nota de alcance");
define("LABEL_EliminarTE", "Eliminar término");
define("LABEL_AgregarT", "Alta de término");
define("LABEL_AgregarTG", "Subordinar %s a término superior ");
define("LABEL_AgregarTE", "Alta de un término subordinado a ");
define("LABEL_AgregarUP", "Alta de un término equivalente para ");
define("LABEL_AgregarTR", "Alta de término relacionado con ");
define("LABEL_Detalle", "detalles");
define("LABEL_Autor", "Autor");
define("LABEL_URI", "URI");
define("LABEL_Version", "Generado por");
define("LABEL_Idioma", "Idioma");
define("LABEL_Fecha", "Fecha de creación");
define("LABEL_Keywords", "Palabras clave");
define("LABEL_TipoLenguaje", "Tipo de lenguaje");
define("LABEL_Cobertura", "Cobertura");
define("LABEL_Terminos", "términos");
define("LABEL_RelTerminos", "relaciones entre términos");
define("LABEL_TerminosUP", "términos alternativos");
define("LABEL_BuscaTermino", "Buscar término");
define("LABEL_Buscar", "Buscar");
define("LABEL_Enviar", "Enviar");
define("LABEL_Cambiar", "Guardar cambios");
define("LABEL_Anterior", "anterior");
define("LABEL_AdminUser", "Administración de usuarios");
define("LABEL_DatosUser", "Datos del usuario");
define("LABEL_Acciones", "Acciones realizadas");
define("LABEL_verEsquema", "ver esquema");
define("LABEL_actualizar", "Actualizar");
define("LABEL_terminosLibres", "Términos libres"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "Búsqueda");
define("LABEL_borraRelacion", "eliminar relación");
define("MSG_ResultBusca", "término/s encontrados para la búsqueda");
define("MSG_ResultLetra", "Letra");
define("MSG_ResultCambios", "Los cambios han sido realizados con &eacute;xito.");
define("MSG_noUser", "Los datos de acceso son incorrectos. Por favor, vuelve a intentarlo.");
define("FORM_JS_check", "Por favor revise los datos de ");
define("FORM_JS_confirm", "¿Esta seguro de que desea eliminar el termino o la relación?");
define("FORM_JS_pass", "_clave");
define("FORM_JS_confirmPass", "_repetir_clave");
define("FORM_LABEL_termino", "_termino");
define("FORM_LABEL_buscar", "_expresion_de_busqueda");
define("FORM_LABEL_buscarTermino", "_termino_relacionado");
define("FORM_LABEL_nombre", "_nombre");
define("FORM_LABEL_apellido", "_apellido");
define("FORM_LABEL_mail", "_correo_electronico");
define("FORM_LABEL_pass", "_clave");
define("FORM_LABEL_repass", "_confirmar_clave");
define("FORM_LABEL_orga", "orga");
define("LABEL_nombre", "nombre");
define("LABEL_apellido", "apellido");
define("LABEL_mail", "correo electrónico");
define("LABEL_pass", "clave");
define("LABEL_repass", "confirmar clave");
define("LABEL_orga", "organización");
define("LABEL_lcConfig", "configuración");
define("LABEL_lcDatos", "datos del vocabulario");
define("LABEL_Titulo", "Título");
define("FORM_LABEL_Titulo", "_titulo");
define("FORM_LABEL_Autor", "_autor");
define("FORM_LABEL_URI", "_URI");
define("FORM_LABEL_Idioma", "Idioma");
define("FORM_LABEL_FechaDia", "dia");
define("FORM_LABEL_FechaMes", "mes");
define("FORM_LABEL_FechaAno", "ano");
define("FORM_LABEL_Keywords", "keywords");
define("FORM_LABEL_TipoLenguaje", "language_type");
define("FORM_LABEL_Cobertura", "scope");
define("FORM_LABEL_Terminos", "términos");
define("FORM_LABEL_RelTerminos", "relaciones entre términos");
define("FORM_LABEL_TerminosUP", "términos alternativos");
define("FORM_LABEL_Guardar", "Guardar");
define("LABEL_verDetalle", "ver detalles de ");
define("LABEL_verTerminosLetra", "ver términos iniciados con ");
define("LABEL_NB", "Nota bibliográfica");
define("LABEL_NH", "Nota histórica");
define("LABEL_NA", "Nota de alcance");   /* version 0.9.1 */
define("LABEL_NP", "Nota privada"); /* version 0.9.1 */
define("LABEL_EditorNota", "Editor de notas ");
define("LABEL_EditorNotaTermino", "Notas del término ");
define("LABEL_tipoNota", "tipo de nota");
define("FORM_LABEL_tipoNota", "tipo_nota");
define("LABEL_nota", "nota");
define("FORM_LABEL_nota", "_nota");
define("LABEL_EditarNota", "editar nota");
define("LABEL_EliminarNota", "Eliminar nota");
define("LABEL_OptimizarTablas", "Optimizar tablas");
define("LABEL_TotalZthesLine", "exportar en Zthes");
/* v 9.2 */
define("LABEL_negrita", "negrita");
define("LABEL_italica", "itálica");
define("LABEL_subrayado", "subrayado");
define("LABEL_textarea", "espacio para notas");
define("MSGL_relacionIlegal", "Relación no permitida entre términos");
/* v 9.3 */
define("LABEL_fecha_modificacion", "modificación");
define("LABEL_TotalUsuarios", "total de usuarios");
define("LABEL_TotalTerminos", "total de términos");
define("LABEL_ordenar", "ordenar por");
define("LABEL_auditoria", "auditoría de términos");
define("LABEL_dia", "día");
define("LABEL_mes", "mes");
define("LABEL_ano", "año");
define("LABEL_terminosRepetidos", "términos repetidos");
define("MSG_noTerminosLibres", "no existen términos libres");
define("MSG_noTerminosRepetidos", "no existen términos repetidos");
define("LABEL_TotalSkosLine", "exportar en Skos-Core");
$MONTHS=array("01"=>"Ene",
              "02"=>"Feb",
              "03"=>"Mar",
              "04"=>"Abr",
              "05"=>"May",
              "06"=>"Jun",
              "07"=>"Jul",
              "08"=>"Ago",
              "09"=>"Sep",
              "10"=>"Oct",
              "11"=>"Nov",
              "12"=>"Dic"
              );
/* v 9.4 */
define("LABEL_SI", "SI");
define("LABEL_NO", "NO");
define("FORM_LABEL_jeraquico", "polijerarquia");
define("LABEL_jeraquico", "Polijerarquía"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "término libre");
/* v 9.5 */
define("LABEL_URL_busqueda", "Buscar %s en: ");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "relación con otro vocabulario");
define("FORM_LABEL_relacion_vocabulario", "equivalencia");
define("FORM_LABEL_nombre_vocabulario", "vocabulario de referencia");
define("LABEL_vocabulario_referencia", "vocabulario de referencia");
define("LABEL_NO_vocabulario_referencia", "no se encuentran vocabularios de referencia para establer relación terminológica");
define("FORM_LABEL_tipo_equivalencia", "tipo de equivalencia");
define("LABEL_vocabulario_principal", "vocabulario");
define("LABEL_tipo_vocabulario", "tipo");
define("LABEL_termino_equivalente", "equivale");
define("LABEL_termino_parcial_equivalente", "equivale parcialmente");
define("LABEL_termino_no_equivalente", "no equivale");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "EQP"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "Nota de catalogación");
define("LABEL_resultados_suplementarios", "resultados suplementarios");
define("LABEL_resultados_relacionados", "resultados relacionados");
/* v 9.7 */
define("LABEL_export", "exportar");
define("FORM_LABEL_format_export", "seleccionar formato");
/* v 1.0 */
define("LABEL_fecha_creacion", "creado");
define("NB_acronimo", "NB"); /* Bibliographic note */
define("NH_acronimo", "NH"); /* Historical note */
define("NA_acronimo", "NA"); /* Scope or Explanatory note */
define("NP_acronimo", "NP"); /* Private note */
define("NC_acronimo", "NC"); /* Cataloger's note */
define("LABEL_Candidato", "término candidato");
define("LABEL_Aceptado", "término aceptado");
define("LABEL_Rechazado", "término rechazado");
define("LABEL_Ultimos_aceptados", "aceptados recientes");
define("MSG_ERROR_ESTADO", "Estado no aceptable");
define("LABEL_Candidatos", "términos candidatos");
define("LABEL_Aceptados", "términos aceptados");
define("LABEL_Rechazados", "términos rechazados");
define("LABEL_User_NoHabilitado", "no habilitado");
define("LABEL_User_Habilitado", "habilitado");

define("LABEL_CandidatearTermino", "Pasar a estado candidato");
define("LABEL_AceptarTermino", "Aceptar término");
define("LABEL_RechazarTermino", "Rechazar término");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "quizás quiso decir:");
/* v 1.02 */
define("LABEL_esSuperUsuario", "es administrador");
define("LABEL_Cancelar", "cancelar");
define("LABEL_Guardar", "guardar");
/* v 1.033 */
define("MENU_AgregarTEexist", "Subordinar un término libre");
define("MENU_AgregarUPexist", "Asociar un término alternativo (libre)");
define("LABEL_existAgregarUP", "Asociar un término alternativo a %s");
define("LABEL_existAgregarTE", "Subordinar un término a %s ");
define("MSG_minCharSerarch", "La expresión de búsqueda <i>%s</i> tiene sólo <strong>%s</strong> caracteres. Debe ser mayor a <strong>%s</strong> caracteres");
/* v 1.04 */
define("LABEL_terminoExistente", "término existente");
define("HELP_variosTerminos", "Para agregar varios términos a la vez consigne <strong>un término por línea</strong>.");
/* Install messages */
define("FORM", "Form") ;
define("ERROR", "Error") ;
define("LABEL_bienvenida", "Bienvenido a TemaTres") ;
// COMMON SQL
define("PARAM_SERVER", "Server address") ;
define("PARAM_DBName", "Database name") ;
define("PARAM_DBLogin", "Database User") ;
define("PARAM_DBPass", "Database Password") ;
define("PARAM_DBprefix", "Prefix tables") ;
$install_message[101] = 'Instalación de TemaTres' ;
$install_message[201] = 'No se encuentra el archivo de configuración de la base de datos (%s).';
$install_message[202] = 'Archivo de configuración de la base de datos encontrado.';
$install_message[203] = 'No es posible conectar con el servidor <em>%s</em> utilizando el usuario <em>%s</em>. Por favor revise los datos del archivo de configuración de la base de datos (%s).';
$install_message[204] = 'Conexión con el servidor <em>%s</em> exitosa ';
$install_message[205] = 'No es posible conectar con la base de datos <em>%s</em> en <em>%s</em>. Por favor revise los datos del archivo de configuración de la base de datos (%s).';
$install_message[206] = 'Conexión con la base de datos <em>%s</em> en <em>%s</em> verificada.' ;
$install_message[301] = 'Parece que las tablas ya han sido creadas para la configuración establecida. Por favor, compruebe su configuración de archivo para la conexión de base de datos (%s) o <a href="index.php">Comience a utilizar su vocabulario</a>' ;
$install_message[305] = 'Indiación acerca del grado de seguridad de la clave.' ;
$install_message[306] = 'Instalación completa, <a href="index.php">comience a utilizar su vocabulario</a>' ;
/* end Install messages */
/* v 1.1 */
define('MSG_ERROR_CODE', "código duplicado");
define('LABEL_CODE', "código");
define('LABEL_Ver', "ver");
define('LABEL_OpcionesTermino', "término");
define('LABEL_CambiarEstado', "cambiar estado");
define('LABEL_ClickEditar', "click para editar...");
define('LABEL_TopTerm', "Tiene este término tope");
define('LABEL_esFraseExacta', "con la frase exacta");
define('LABEL_DesdeFecha', "creado en o después de");
define('LABEL_ProfundidadTermino', "Ubicado en profundidad");
define('LABEL_esNoPreferido', "término alternativo");
define('LABEL_BusquedaAvanzada', "búsqueda avanzada");
define('LABEL_Todos', "todos");
define('LABEL_QueBuscar', "¿Qué buscar?");
define("LABEL_import", "Importar") ;
define("IMPORT_form_legend", "Importar desde un archivo") ;
define("IMPORT_form_label", "Archivo") ;
define("IMPORT_file_already_exists", "Un archivo txt ya está presente en el servidor") ;
define("IMPORT_file_not_exists", "No hay archivos todavía") ;
define("IMPORT_do_it", "Puede iniciar la importación") ;
define("IMPORT_working", "proceso de importanción en marcha") ;
define("IMPORT_finish", "importación finalizada") ;
define("LABEL_reIndice", "Recrear índices de términos") ;
define("LABEL_dbMantenimiento", "Mantenimiento de la base de datos");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "Relación con un término de otro vocabulario");
define('LABEL_vocabulario_referenciaWS', "Vocabulario externo vía servicios web");
define('LABEL_TargetVocabularyWS', "Vocabulario externo vía servicios web");
define('LABEL_tvocab_label', "leyenda de la referencia");
define('LABEL_tvocab_tag', "etiqueta de la referencia");
define('LABEL_tvocab_uri_service', "URL del servicio web de referencia");
define('LABEL_targetTermsforUpdate', "términos con actualizaciones pendientes");
define('LABEL_ShowTargetTermsforUpdate', "actualizar términos");
define('LABEL_enable', "habilitado");  /* web services status info: in use */
define('LABEL_disable', "no habilitado");  /* web services status info: not in use */
define('LABEL_notFound', "término no encontrado");
define('LABEL_termUpdated', "término actualizado");
define('LABEL_ShowTargetTermforUpdate', "actualizar");
define('LABEL_relbetweenVocabularies', "relaciones entre vocabularios");
define('LABEL_update1_1x1_2', "Actualizar (1.1 -> 1.3)");
define('LABEL_update1x1_2', "Actualizar (1.0x -> 1.3)");
define('LABEL_TargetTerm', "término externo (mapeo terminológico)");
define('LABEL_TargetTerms', "términos externos (mapeo terminológico)");
define('LABEL_seleccionar', 'seleccionar');
define('LABEL_poliBT', 'más de un término genérico');
define('LABEL_FORM_simpleReport', 'Reportes');
define('LABEL_FORM_advancedReport', 'Reportes avanzados');
define('LABEL_FORM_nullValue', 'no importa');
define('LABEL_FORM_haveNoteType', 'tienen nota de tipo');
define('LABEL_haveEQ', 'tienen equivalencias');
define('LABEL_nohaveEQ', 'no tienen equivalencias');
define('LABEL_start', 'que comienzan con');
define('LABEL_end', 'finalizadas en');
define('LABEL_equalThisWord', 'iguales a');
define('LABEL_haveWords', 'incluyen palabras');
define('LABEL_encode', 'codificación');
/*
v1.21
*/
define('LABEL_import_skos', 'Importar Skos-Core');
define('IMPORT_skos_file_already_exists', 'Ya se dispone de una fuente Skos-Core');
define('IMPORT_skos_form_legend', 'Importar Skos-Core');
define('IMPORT_skos_form_label', 'Archivo Skos-Core');
/*
v1.4
*/
define('LABEL_termsxNTterms', 'Términos según cantidad de términos específicos');
define('LABEL_termsNoBT', 'Términos sin relaciones jerárquicas');
define('MSG_noTermsNoBT', 'No hay términos sin relaciones jerárquicas');
define('LABEL_termsXcantWords', 'Términos según cantidad de palabras');
define('LABEL__USE_CODE', 'permitir código identificador único por término');
define('LABEL__SHOW_CODE', 'publicar código identificador único por término');
define('LABEL_CFG_MAX_TREE_DEEP', 'Máximo nivel de profundidad en el árbol de temas para la visualización');
define('LABEL_CFG_VIEW_STATUS', 'publicar detalles del estado de terminos');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', 'habilitar web services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', 'cantidad de términos para visualización de listados según estados');
define('LABEL_CFG_MIN_SEARCH_SIZE', 'número mínimo de caracteres para operaciones de búsqueda');
define('LABEL__SHOW_TREE', 'publicar navegación jerárquica en página de inicio');
define('LABEL__PUBLISH_SKOS', 'permitir consultas SKOS-core a través de servicios web. Esto podría exponer todo su vocabulario.');
define('LABEL_update1_3x1_4', "Actualizar (1.3x -> 1.4)");
define("FORM_LABEL_format_import", "seleccionar formato");
define("LABEL_importTab", "texto tabulado");
define("LABEL_importTag", "texto etiquetado");
define("LABEL_importSkos", "Skos-core");
define("LABEL_configTypeNotes", "Configurar tipos de notas");
define("LABEL_notes", "notas");
define("LABEL_saved", "guardado");
define("FORM_JS_confirmDeleteTypeNote", "¿Realmente quiere eliminar este tipo de nota?");
/*
v1.5
*/
define("LABEL_relationEditor", "editor de relaciones");
define("LABEL_relationDelete", "eliminar relación");
define('LABEL_relationSubType', "tipo de relación");
define('LABEL_relationSubTypeCode', "código del tipo de relación");
define('LABEL_relationSubTypeLabel', "leyenda del tipo de relación");
define('LABEL_optative', "opcional");
define('FORM_JS_confirmDeleteTypeRelation', '¿Realmente quiere eliminar este tipo de relación?');
define("LABEL_URItypeEditor", "editor de tipos de enlaces");
define("LABEL_URIEditor", "Gestionar enlaces relacionados al término");
define("LABEL_URItypeDelete", "eliminar tipo de enlace");
define('LABEL_URItype', "tipo de enlace");
define('LABEL_URItypeCode', "alias del tipo de enlace");
define('LABEL_URItypeLabel', "leyenda del tipo de enlaces");
define('FORM_JS_confirmDeleteURIdefinition', '¿Realmente quiere eliminar este tipo de enlace?');
define('LABEL_URI2term', 'recurso web');
define('LABEL_URI2termURL', 'Dirección del recurso web');
define('LABEL_update1_4x1_5', 'Actualizar (1.4 -> 1.5)');
define('LABEL_Contributor', 'Coautor/Colaborador');
define('LABEL_Rights', 'Derechos');
define('LABEL_Publisher', 'Publicador');
/*
v1.6
*/
define('LABEL_Prev', 'previos');
define('LABEL_Next', 'siguientes');
define('LABEL_PageNum', 'página de resultados número ');
define('LABEL_selectMapMethod', 'Seleccione método de mapeo terminológico');
define('LABEL_string2search', 'expresión de búsqueda');
define('LABEL_reverseMappign', 'mapeo reverso');
define('LABEL_warningMassiverem', 'Usted va a eliminar masivamente datos ¡Estas acciones son IRREVERSIBLES!');
define('LABEL_target_terms', 'términos mapeados desde vocabularios externos');
define('LABEL_URI2terms', 'recursos web');
define('MENU_massiverem', 'Borrado masivo de datos');
define('LABEL_more', 'más');
define('LABEL_less', 'menos');
define('LABEL_lastChangeDate', 'fecha de última modificación');
define('LABEL_update1_5x1_6', 'Actualizar (1.5 -> 1.6)');
define('LABEL_login', 'acceder');
define('LABEL_user_recovery_password', 'Obtener una contraseña nueva');
define('LABEL_user_recovery_password1', 'Por favor, escribe tu correo electrónico. Recibirás un enlace para crear la contraseña nueva por correo electrónico.');
define('LABEL_mail_recoveryTitle', 'Recuperar clave de acceso');
define('LABEL_mail_recovery_pass1', 'Alguien ha solicitado que sea restaurada la contraseña de la siguiente cuenta:');
define('LABEL_mail_recovery_pass2', 'Nombre de usuario: %s');
define('LABEL_mail_recovery_pass3', 'Si ha sido un error, ignora este correo y no pasará nada.');
define('LABEL_mail_recovery_pass4', 'Para restaurar la contraseña, visita la siguiente dirección:');
define('LABEL_mail_passTitle', 'Clave nueva ');
define('LABEL_mail_pass1', 'Clave nueva for ');
define('LABEL_mail_pass2', 'Clave: ');
define('LABEL_mail_pass3', 'Usted puede modificarla.');
define('MSG_check_mail_link', 'Revisa tu correo electrónico para obtener el enlace de confirmación.');
define('MSG_check_mail', 'Si la dirección de correo consignada es correcta, por favor revisa tu correo electrónico.');
define('MSG_no_mail', 'No se pudo enviar el correo.');
define('LABEL_user_lost_password', '¿Has perdido tu contraseña?');
## v1.7
define('LABEL_includeMetaTerm', 'Incluir meta-términos');
define('NOTE_isMetaTerm', 'Es un meta-término.');
define('NOTE_isMetaTermNote', 'Un meta-término es un término que NO debe utilizarse para indización. Es un término que describe otros términos. Ej: Términos guía, Facetas, Categorías, etc.');
define('LABEL_turnOffMetaTerm', 'no es un meta-término');
define('LABEL_turnOnMetaTerm', 'es un meta-término');
define('LABEL_meta_term', 'meta-término');
define('LABEL_meta_terms', 'meta-términos');
define('LABEL_relatedTerms', 'términos relacionados');
define('LABEL_nonPreferedTerms', 'términos alternativos');
define('LABEL_update1_6x1_7', 'Actualizar (1.6 -> 2.2)');
define('LABEL_include_data', 'incluir');
define('LABEL_updateEndpoint', 'actualizar punto de consulta SPARQL');
define('MSG__updateEndpoint', 'A continuación se actualizarán los datos para ser expuestos a través del punto de consulta SPARQL. Esta operación puede demorar varios minutos.');
define('MSG__updatedEndpoint', 'El punto de consulta SPARQL se encuentra actualizado.');
define('MSG__dateUpdatedEndpoint', 'Fecha de última actualización del punto de consulta SPARQL');
define('LABEL__ENABLE_SPARQL', 'Deberá actualizar el punto de consulta: Menú Administración -> Mantenimiento de la base de datos -> Actualizar punto de consulta SPARQL.');
define('MSG__disable_endpoint', 'El punto de consulta SPARQL se encuentra deshabilitado.');
define('MSG__need2setup_endpoint', 'El punto de consulta SPARQL se necesita ser actualizado. Contacte al administrador.');
define('LABEL_SPARQLEndpoint', 'SPARQL endpoint');
define('LABEL_AgregarRTexist', 'asociar un término asociado existente con ');
define('MENU_selectExistTerm', 'seleccionar término existente');
define("TT_terminos", "Términos tope");
## v1.72
define('MSG__warningDeleteTerm', 'El término <i>%s</i> será <strong>ELIMINADO</strong>.');
define('MSG__warningDeleteTerm2row', 'Se eliminarán <strong>todas</strong> sus notas y relaciones terminológicas. Esta acción es irreversible.');
## v1.8
define('LABEL__getForRecomendation', 'buscar recomendaciones');
define('LABEL__getForRecomendationFor', 'buscar recomendaciones para ');
define('FORM_LABEL__contactMail', 'Correo electrónico de contacto');
define('LABEL_addMapLink', 'agregar mapeo entre vocabularios');
define('LABEL_addExactLink', 'agregar enlace de referencia');
define('LABEL_addSourceNote', 'agregar nota de fuente');
## v1.82
define('LABEL_FORM_mappedTermReport', 'Relaciones entre vocabularios');
define('LABEL_eliminar', 'Eliminar');
##v.2
define('MSG_termsNoDeleted', 'términos no fueron eliminados');
define('MSG_termsDeleted', 'términos eliminados');
define('LABEL_selectAll', 'seleccionar todo');
define('LABEL_metadatos', 'metadatos');
define('LABEL_totalTermsDescendants', 'términos descendentes');
define('LABEL_altTerms', 'términos alternativos');
define('LABEL_narrowerTerms', 'términos específicos');
define('LABEL_results', 'resultados');
define('LABEL_showFreeTerms', 'lista de términos libres');
define('LABEL_helpSearchFreeTerms', 'Sólo se buscarán términos libres.');
define('LABEL_broatherTerms', 'términos genéricos');
define('LABEL_type2filter', 'tipee para filtrar términos');
define('LABEL_defaultEQmap', 'Utilice "eq" para indicar relación de equivalencia');
define("MSG_repass_error", "las claves no coinciden");
define("MSG_lengh_error", "mínimo de %d caracteres");
define("MSG_errorPostData", "Ha ocurrido un error, por favor revise los datos correspondiente al campo ");
define('LABEL_preferedTerms', 'términos preferidos');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', 'términos SIN notas');
define('MSG_FORM_NULLnotesTermReport', 'términos que no tienen notas de tipo');
define('LABELnoNotes', 'términos sin ninguna nota');
define('LABEL_termsXdeepLevel', 'términos según nivel de profundidad');
define('LABEL_deepLevel', 'nivel');
define('LABEL_cantTerms', '# de términos');
define('LINK_publicKnownVocabularies', '<a href="https://www.vocabularyserver.com/vocabularies/" title="Lista de vocabularios controlados conocidos" target="_blank">Lista de vocabularios controlados conocidos</a>');
define('LABEL_showNewsTerm', 'ver cambios recientes');
define('LABEL_newsTerm', 'cambios recientes');
define('MSG_contactAdmin', 'contacte al administardor');
define('LABEL_addTargetVocabulary', 'agregar vocabularios de referencia (servicios web terminológicos)');
#v.2.1
define('LABEL_duplicatedTerm', 'término duplicado');
define('LABEL_duplicatedTerms', 'términos duplicados');
define('MSG_duplicatedTerms', 'La configuración del vocabulario no permite términos duplicados.');
define('LABEL_bulkReplace', 'cambios globales (buscar y reemplazar)');
define('LABEL_searchFor', 'Texto a buscar');
define('LABEL_replaceWith', 'reemplazar con');
define('LABEL_bulkNotesWillReplace', 'notas serán modificadas');
define('LABEL_bulkNotesReplaced', 'notas fueron modificadas');
define('LABEL_bulkTermsWillReplace', 'términos serán modificados');
define('LABEL_bulkTermsReplaced', 'términos fueron modificados');
define('LABEL_termMOD', 'términos modificado');
define('LABEL_noteMOD', 'nota modificada');
define('MENU_bulkEdition', 'cambios globales');
define('MSG_searchFor', 'texto que desea buscar (sensible a mayúsculas)');
define('MSG_replaceWith', 'texto que reemplazará (sensible a mayúsculas)');
define('LABEL_warningBulkEditor', 'Usted va a modificar masivamente datos ¡Estas acciones son IRREVERSIBLES!');
define('LABEL_CFG_SUGGESTxWORD', '¿se deben sugerir términos según palabras o frases?');
define('LABEL_ALLOW_DUPLICATED', '¿se permiten términos duplicados?');
define('LABEL_CFG_PUBLISH', '¿el vocabulario puede ser consultado por cualquiera?');
define('LABEL_Replace', 'reemplazar');
define('LABEL_Preview', 'vista previa');
#v.2.2
define('LABEL_selectRelation', 'seleccionar relación');
define('LABEL_withSelected', 'con los seleccionados:');
define('LABEL_rejectTerms', 'rechazar términos');
define('LABEL_doMetaTerm', 'convertir en meta-términos');
define('LABEL_associateFreeTerms', 'vincular como UF, TE o TR');
define('MSG_associateFreeTerms', 'en el siguiente paso podrá seleccionar el tipo de relación.');
define('MSG_termsSuccessTask', 'términos afectados en la operación');
define('LABEL_TTTerms', 'términos tope');
define('MSG__GLOSSincludeAltLabel', 'incluir términos alternativos');
define('MSG__GLOSSdocumentationJSON', 'La fuente JSON del glosario puede ser integrada con cualquier contenido HTML utilizando la librería <a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>');
define('LABEL_configGlossary', 'exportar fuente de datos para glosario');
define('MSG_includeNotes', 'utilizar notas de tipo:');
define('LABEL_SHOW_RANDOM_TERM', 'presentar en la página de inicio un término seleccionado al azar. Se debe seleccionar un tipo de nota.');
define('LABEL_opt_show_rando_term', 'presentar términos con nota:');
define('MSG_helpNoteEditor', 'Puede vincular términos utilizando corchetes dobles. Ej: Sólo el [[amor]] salvará el mundo');
define('LABEL_GLOSS_NOTES', 'Seleccionar tipo de nota para glosar términos marcados con corchetes dobles: [[glosario]]');
define('LABEL_bulkGlossNotes', 'glosar la nota de tipo');
define('MSG__autoGlossInfo', 'Este proceso vincula términos existentes en el vocabulario con sus menciones en notas utilizando la notación Wiki (Ej: Sólo el [[amor]] salvará el mundo). Es una operación de búsqueda y reemplazo de texto <strong>sensible a mayúsculas</strong>.');
define('MSG__autoGlossDanger', 'Esta operación modifica datos de manera IRREVERSIBLE. Antes de proceder, realice un respaldo de seguridad.');
define('LABEL_replaceBinary', 'Sensible mayúsculas y acentos');
define('MSG_notesAffected', 'notas afectadas');
define('MSG_cantTermsFound', 'términos encontrados');
define('MENU_glossConfig', 'configurar autoglosario'); /* Used as menu entry. Keep it short */
define('LABEL_generateAutoGlossary', 'generación de auto-glosario');
define('LABEL_AlphaPDF', 'Alfabético (PDF)');
define('LABEL_SystPDF', 'Sistemático (PDF)');
define('LABEL_references', 'referencias');
define('LABEL_printData', 'fecha de impresión');
##v.3
define('MENU_bulkTranslate', 'editor multilingüe');
define('LABEL_bulkTranslate', 'editor de traducciones y equivalencias');
define('LABEL_termsEQ', 'con correspondencias');
define('LABEL_termsNoEQ', 'sin correspondencias');
define('LABEL_close', 'cerrar');
define('LABEL_allTerms', 'todos los términos');
define('LABEL_allNotes', 'todas las notas');
define('LABEL_allRelations', 'todas las relaciones entre términos');
#v.3.1
define('LABEL_noResults', 'no se encontraron resultados parecidos');
define('LABEL_globalOrganization', 'organización global del vocabulario');
define('LABEL_rel_associative', 'relaciones asociativas');
define('LABEL_rel_hierarchical', 'relaciones jerárquicas');
define('LABEL_rel_synonymy', 'relaciones de sinonimia');
define('LABEL_prototypeTerms', 'términos centrales');
define('LABEL_copy_click', 'copiar término al portapapeles');
define('LABEL__ENABLE_COPY_CLICK', 'Habilitar botón para copiar términos al portapapeles.');
#v.3.2
define('LABEL_order', 'orden');
define('LABEL_alias', 'alias');
define('LEGEND_alias', 'consigne un alias breve');
define('LABEL_src_note', 'fuente');
define('LEGEND_src_note', 'consigne la cita bibliográfica');
define('LABEL_source', 'fuentes normalizadas');
define('LABEL_source4term', 'fuentes según términos');
define('LABEL_add_new', 'agregar nuevo');
define('LABEL_sources4vocab', 'fuentes de consulta');
define('LABEL_update2_2x3_2', 'Actualizar (2.x -> 3.2)');
define('LABEL__getForTargetVocabularyNews', 'buscar novedades');
define('LABEL__example', 'ejemplo');
#3.4
 define('KOS_categorization_scheme','esquema de categorización');
 define('KOS_classification_scheme','esquema de clasificación');
 define('KOS_dictionary','diccionario');
 define('KOS_gazetteer','diccionario geográfico');
 define('KOS_glossary','glosario');
 define('KOS_list','lista');
 define('KOS_name_authority_list','lista de autoridades');
 define('KOS_ontology','ontología');
 define('KOS_semantic_network','red semántica');
 define('KOS_subject_heading_scheme','lista de encabezamientos de materia');
 define('KOS_taxonomy','taxonomía');
 define('KOS_terminology','terminología ');
 define('KOS_thesaurus','tesauro');
 #3.4.1
 define('LABEL_userIsAdmin','administador');
 define('LABEL_userIsEditor','editor');
 define('LABEL_userIsColab','colaborador');
 define('LABEL_userType','tipo de usuario');
  #3.5
 define('LABEL_hubs','concentraciones');
 define('LABEL_clusteringCoefficient','coeficiente de agrupamiento');
 define('LABEL_logScale','escala logarítmica');
 