<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#   Author for this i18n: Tiago Murakami
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Version 0.97	
#  
###############################################################################################################

define("LANG","pt");

define("TR_acronimo","TR");
define("TE_acronimo","TE");
define("TG_acronimo","TG");
define("UP_acronimo","UP");

define("TR_termino","Termo relacionado");
define("TE_termino","Termo específico");
define("TG_termino","Termo geral");
define("UP_termino","Usado para");
/* v 9.5 */
define("USE_termino","USE");

define("MENU_ListaSis","Lista sistemática");
define("MENU_ListaAbc","Lista alfabética");
define("MENU_Sobre","Sobre...");
define("MENU_Inicio","Início");

define("MENU_MiCuenta","Minha conta");
define("MENU_Usuarios","Usuários");
define("MENU_NuevoUsuario","Novo usuário");
define("MENU_DatosTesauro","Dados do tesauro");

define("MENU_AgregarT","Adicionar termo");
define("MENU_EditT","Editar termo");
define("MENU_BorrarT","Apagar termo");
define("MENU_AgregarTG","Subordinar a um termo");
define("MENU_AgregarTE","Termo subordinado");
define("MENU_AgregarTR","Termo relacionado");
define("MENU_AgregarUP","Termo não preferido");



define("MENU_MisDatos","Minha conta");
define("MENU_Caducar","Desabilitar");
define("MENU_Habilitar","Habilitar");
define("MENU_Salir","Sair");

define("LABEL_Menu","Menu");
define("LABEL_Opciones","Opcões");
define("LABEL_Admin","Administracão");
define("LABEL_Agregar","Adicionar");
define("LABEL_editT","Editar termo ");
define("LABEL_EditorTermino","Editor de termo");
define("LABEL_Termino","Termo");
define("LABEL_NotaAlcance","Nota de escopo");
define("LABEL_AgregarT","Novo termo subordinado");
define("LABEL_AgregarTG","Subordinar %s a um termo superior");
define("LABEL_AgregarTE","Novo termo subordinado a ");
define("LABEL_AgregarUP","Novo termo não preferido para ");
define("LABEL_AgregarTR","Novo termo relacionado com ");
define("LABEL_EliminarTE","Excluir termo");
define("LABEL_Detalle","detalhes");
define("LABEL_EditarNota","editar nota");


define("LABEL_Autor","Autor");
define("LABEL_URI","URI");
define("LABEL_Version","Criado por");
define("LABEL_Idioma","Idioma");
define("LABEL_Fecha","Data de criação");
define("LABEL_Keywords","Palavras chave");
define("LABEL_TipoLenguaje","Tipo de linguagem");
define("LABEL_Cobertura","Cobertura");
define("LABEL_Terminos","termos");
define("LABEL_RelTerminos","relacões entre termos");
define("LABEL_TerminosUP","termos não preferidos");

define("LABEL_BuscaTermino","Buscar termo");
define("LABEL_Buscar","Buscar");
define("LABEL_Enviar","Enviar");
define("LABEL_Cambiar","Salvar modificações");
define("LABEL_Anterior","Voltar");
define("LABEL_AdminUser","Administração de usuários");
define("LABEL_DatosUser","Dados do usuário");
define("LABEL_Acciones","Tarefas");
define("LABEL_verEsquema","Mostrar esquema");
define("LABEL_actualizar","Atualizar");
define("LABEL_terminosLibres","Termos livres");
define("LABEL_busqueda","Busca");
define("LABEL_borraRelacion","eliminar relação");

define("MSG_ResultBusca","termo/s encontrados na busca");
define("MSG_ResultLetra","Letra");
define("MSG_ResultCambios","As alterações foram realizadas com sucesso.");
define("MSG_noUser","<p>Usuário não registrado</p>");

define("FORM_JS_check","Por favor confira os dados de ");
define("FORM_JS_confirm","Tem certeza que quer excluir o termo ou a relação?");
define("FORM_JS_pass","_clave");
define("FORM_JS_confirmPass","_repetir_clave");

define("FORM_LABEL_termino","_termino");
define("FORM_LABEL_buscar","_expresion_de_busqueda");
define("FORM_LABEL_buscarTermino","_termino_relacionado");

define("FORM_LABEL_nombre","_nombre");
define("FORM_LABEL_apellido","_apellido");
define("FORM_LABEL_mail","_correo_electronico");
define("FORM_LABEL_pass","_clave");
define("FORM_LABEL_repass","_confirmar_clave");
define("FORM_LABEL_orga","orga");

define("LABEL_nombre","nome");
define("LABEL_apellido","sobrenome");
define("LABEL_mail","e-mail");
define("LABEL_pass","senha");
define("LABEL_repass","confirmar senha");
define("LABEL_orga","organização");

define("LABEL_lcConfig","Configuracão do tesauro");
define("LABEL_lcDatos","Dados do tesauro");

define("LABEL_Titulo","Título");

define("FORM_LABEL_Titulo","_titulo");
define("FORM_LABEL_Autor","_autor");
define("FORM_LABEL_URI","_URI");
define("FORM_LABEL_Idioma","Idioma");
define("FORM_LABEL_FechaDia","dia");
define("FORM_LABEL_FechaMes","mês");
define("FORM_LABEL_FechaAno","ano");
define("FORM_LABEL_Keywords","Palavras_chave");
define("FORM_LABEL_TipoLenguaje","language_type");
define("FORM_LABEL_Cobertura","escope");
define("FORM_LABEL_Terminos","termos");
define("FORM_LABEL_RelTerminos","relações entre termos");
define("FORM_LABEL_TerminosUP","termos não preferidos");
define("FORM_LABEL_Guardar","Salvar");

define("LABEL_verDetalle","mostrar detalhes de ");
define("LABEL_verTerminosLetra","mostrar termos iniciados com ");

define("LABEL_NB","Nota bibliográfica");
define("LABEL_NH","Nota histórica");
define("LABEL_NA","Nota de escopo"); /* version 0.9.1 */
define("LABEL_NP","Nota privada");   /* version 0.9.1 */


define("LABEL_EditorNota","Editor de notas");
define("LABEL_EditorNotaTermino","Notas do termo ");
define("LABEL_tipoNota","tipo de nota");
define("FORM_LABEL_tipoNota","tipo_nota");
define("LABEL_nota","nota");
define("FORM_LABEL_nota","_nota");
define("LABEL_EliminarNota","Excluir nota");

define("LABEL_OptimizarTablas","Otimizar tabelas");
define("LABEL_TotalZthesLine","Tesauro completo em Zthes");


/* v 9.2 */
define("LABEL_negrita","negrito");
define("LABEL_italica","itálico");
define("LABEL_subrayado","sublinhado");
define("LABEL_textarea","área para notas");
define("MSGL_relacionIlegal","Relação não permitida entre termos");

/* v 9.3 */
define("LABEL_fecha_modificacion","modificacão");
define("LABEL_TotalUsuarios","total de usuários");
define("LABEL_TotalTerminos","total de termos");
define("LABEL_ordenar","ordenar por");
define("LABEL_auditoria","auditoria do termos");
define("LABEL_dia","dia");
define("LABEL_mes","mês");
define("LABEL_ano","ano");
define("LABEL_terminosRepetidos","termos repetidos");
define("MSG_noTerminosLibres","não existem termos livres");
define("MSG_noTerminosRepetidos","não existem termos repetidos");
define("LABEL_TotalSkosLine","Tesauro completo em Skos-Core");

$MONTHS=array("01"=>Jan,
              "02"=>Fev,
              "03"=>Mar,
              "04"=>Abr,
              "05"=>Mai,
              "06"=>Jun,
              "07"=>Jul,
              "08"=>Ago,
              "09"=>Set,
              "10"=>Out,
              "11"=>Nov,
              "12"=>Dez,
              );

/* v 9.4 */
define("LABEL_SI","SIM");
define("LABEL_NO","NÃO");
define("FORM_LABEL_jeraquico","hierárquicos");
define("LABEL_jeraquico","Poli-hierárquicos");
define("LABEL_terminoLibre","termo livre");


/* v 9.5 */
define("LABEL_URL_busqueda","Buscar %s em: ");

/* v 9.6 */
define("LABEL_relacion_vocabulario","relacão com outro vocabulário");
define("FORM_LABEL_relacion_vocabulario","equivalência");
define("FORM_LABEL_nombre_vocabulario","vocabulário de referência");
define("LABEL_vocabulario_referencia","vocabulário de referência");
define("LABEL_NO_vocabulario_referencia","não existe vocabulários de referência para se estabelecer uma relação terminológica");
define("FORM_LABEL_tipo_equivalencia","tipo de equivalência");
define("LABEL_vocabulario_principal","vocabulário");
define("LABEL_tipo_vocabulario","tipo");

define("LABEL_termino_equivalente","equivalente");
define("LABEL_termino_parcial_equivalente","parcialmente equivalente");
define("LABEL_termino_no_equivalente","não equivalente");

define("EQ_acronimo","EQ");
define("EQP_acronimo","EQP");
define("NEQ_acronimo","NEQ");
define("LABEL_NC","Nota do catalogador");

define("LABEL_resultados_suplementarios","resultados suplementários");
define("LABEL_resultados_relacionados","resultados relacionados");

/* v 9.7 */
define("LABEL_export","exportação");
define("FORM_LABEL_format_export","selecione esquema XML");


/* v 1.0 */
define("LABEL_fecha_creacion","criado");
define("NB_acronimo","BN");
define("NH_acronimo","HN");
define("NA_acronimo","SN");
define("NP_acronimo","PN");
define("NC_acronimo","CN");

define("LABEL_Candidato","termo candidato");
define("LABEL_Aceptado","termo aceito");
define("LABEL_Rechazado","termo não aceito");
define("LABEL_Ultimos_aceptados","termos aceitos");
define("MSG_ERROR_ESTADO","status não permitido");

define("LABEL_Candidatos","termos candidatos");
define("LABEL_Aceptados","termos aceitos");
define("LABEL_Rechazados","termos não aceitos");

define("LABEL_User_NoHabilitado","não habilitado");
define("LABEL_User_Habilitado","habilitado");

// define("LABEL_CandidatearTermino","Candidatear término");
define("LABEL_CandidatearTermino","Passar a termo candidato");
define("LABEL_AceptarTermino","Aceitar termo");
define("LABEL_RechazarTermino","Não aceitar termo");


/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO","será que quis dizer:");

/* v 1.02 */
define("LABEL_esSuperUsuario","is admin");
define("LABEL_Cancelar","cancel");
define("LABEL_Guardar","guardar");

/* v 1.033 */
define("MENU_AgregarTEexist","Subordinate An Existing Term");
define("MENU_AgregarUPexist","Associate An Existing Non-Preferred Term");
define("LABEL_existAgregarUP","Add UF term to %s");
define("LABEL_existAgregarTE","Add narrow Term to %s ");
define("MSG_minCharSerarch","The search expression <i>%s</i> has only <strong>%s </strong> characters. Must be greater than <strong>%s</strong> characters");


/* v 1.04 */
define("LABEL_terminoExistente","termo existente");
define("HELP_variosTerminos","Para adicionar vários termos de uma vez encarna uma palavra por linha</strong>.");


/* v. 1.05 */

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
$install_message[204] = "Connect Server <em>%s</em> success" ;
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
define('LABEL_update1x1_2',"Update Tematres (1.0x -> 1.2)");
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
define('LABEL_encode','encoding');
?>
