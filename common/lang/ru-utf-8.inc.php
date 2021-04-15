<?php
#   TemaTres: open source thesaurus management #       #
#                                                                        #
#   Copyright (C) 2004-2018 Diego Ferreyra <tematres@r020.com.ar>
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#   Translation: Community collaborative translation https://crowdin.com/project/tematres
#
###############################################################################################################
#
define("LANG", "ru");
define("TR_acronimo", "RT"); /* Related Term */
define("TE_acronimo", "NT"); /* Narrower term > Specific term */
define("TG_acronimo", "BT"); /* Broader term > Generic term */
define("UP_acronimo", "UF"); /* Used for > instead */
define("TR_termino", "Взаимосвязанный термин");
define("TE_termino", "Термин с более узким значением");
define("TG_termino", "Термин с более общим значением");
define("UP_termino", "Использовать для"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "ИСПОЛЬЗОВАТЬ"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "Иерархический список");
define("MENU_ListaAbc", "Алфавитный список");
define("MENU_Sobre", "О...");
define("MENU_Inicio", "Главная страница");
define("MENU_MiCuenta", "Моя учетная запись");
define("MENU_Usuarios", "Пользователи");
define("MENU_NuevoUsuario", "Новый пользователь");
define("MENU_DatosTesauro", "О тезаурусе");
define("MENU_AgregarT", "Добавить термин");
define("MENU_EditT", "Редактировать термин");
define("MENU_BorrarT", "Удалить термин");
define("MENU_AgregarTG", "Определить статус термина");
define("MENU_AgregarTE", "Субтермин");
define("MENU_AgregarTR", "Взаимосвязанный термин");
define("MENU_AgregarUP", "нежелательный термин");  /* Non-descriptor */
define("MENU_MisDatos", "Моя учетная запись");
define("MENU_Caducar", "отключить");
define("MENU_Habilitar", "доступен");
define("MENU_Salir", "Выход");
define("LABEL_Menu", "Меню");
define("LABEL_Opciones", "Опции");
define("LABEL_Admin", "Администрирование");
define("LABEL_Agregar", "Добавить");
define("LABEL_editT", "Редактировать термин ");
define("LABEL_EditorTermino", "Редактор терминов");
define("LABEL_Termino", "Термин");
define("LABEL_NotaAlcance", "Примечание по области применения");
define("LABEL_EliminarTE", "Удалить термин");
define("LABEL_AgregarT", "Новый термин");
define("LABEL_AgregarTG", "Добавить термин с более общим значением к %s ");
define("LABEL_AgregarTE", "Новый термин подконтролен ");
define("LABEL_AgregarUP", "Новый термин UF для ");
define("LABEL_AgregarTR", "Новый взаимосвязанный термин для ");
define("LABEL_Detalle", "детали");
define("LABEL_Autor", "Автор");
define("LABEL_URI", "URI");
define("LABEL_Version", "На базе");
define("LABEL_Idioma", "Язык");
define("LABEL_Fecha", "Дата создания");
define("LABEL_Keywords", "Ключевые слова");
define("LABEL_TipoLenguaje", "Тип языка");
define("LABEL_Cobertura", "Область применения");
define("LABEL_Terminos", "термины");
define("LABEL_RelTerminos", "взаимосвязь между терминами");
define("LABEL_TerminosUP", "нежелательные термины");
define("LABEL_BuscaTermino", "Поиск термина");
define("LABEL_Buscar", "Поиск");
define("LABEL_Enviar", "Отправить");
define("LABEL_Cambiar", "Обновить");
define("LABEL_Anterior", "назад");
define("LABEL_AdminUser", "Администратор пользователей");
define("LABEL_DatosUser", "Данные пользователя");
define("LABEL_Acciones", "Задания");
define("LABEL_verEsquema", "показать схему");
define("LABEL_actualizar", "Обновить");
define("LABEL_terminosLibres", "Свободные термины"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "Поиск");
define("LABEL_borraRelacion", "удалить взаимосвязь");
define("MSG_ResultBusca", "термины, найденные для выражения поиска");
define("MSG_ResultLetra", "Буква");
define("MSG_ResultCambios", "замена выполнена успешно");
define("MSG_noUser", "Незарегистрированный пользователь");
define("FORM_JS_check", "Проверьте данные ");
define("FORM_JS_confirm", "удалить эту взаимосвязь?");
define("FORM_JS_pass", "_пароль");
define("FORM_JS_confirmPass", "_подтвердить_пароль");
define("FORM_LABEL_termino", "_термин");
define("FORM_LABEL_buscar", "_выражение_поиска");
define("FORM_LABEL_buscarTermino", "_связанный_термин");
define("FORM_LABEL_nombre", "_имя");
define("FORM_LABEL_apellido", "_фамилия");
define("FORM_LABEL_mail", "_электронная_почта");
define("FORM_LABEL_pass", "_пароль");
define("FORM_LABEL_repass", "_подтвердить_пароль");
define("FORM_LABEL_orga", "orga");
define("LABEL_nombre", "имя");
define("LABEL_apellido", "фамилия");
define("LABEL_mail", "электронная почта");
define("LABEL_pass", "пароль");
define("LABEL_repass", "Подтвердить пароль");
define("LABEL_orga", "организация");
define("LABEL_lcConfig", "конфигурация словаря");
define("LABEL_lcDatos", "метаданные словаря");
define("LABEL_Titulo", "название");
define("FORM_LABEL_Titulo", "_название");
define("FORM_LABEL_Autor", "_автор");
define("FORM_LABEL_URI", "_URI");
define("FORM_LABEL_Idioma", "язык");
define("FORM_LABEL_FechaDia", "день");
define("FORM_LABEL_FechaMes", "месяц");
define("FORM_LABEL_FechaAno", "год");
define("FORM_LABEL_Keywords", "ключевые слова");
define("FORM_LABEL_TipoLenguaje", "тип_языка");
define("FORM_LABEL_Cobertura", "область применения");
define("FORM_LABEL_Terminos", "термины");
define("FORM_LABEL_RelTerminos", "взаимосвязь между терминами");
define("FORM_LABEL_TerminosUP", "Нежелательные термины");
define("FORM_LABEL_Guardar", "Сохранить");
define("LABEL_verDetalle", "см. детали ");
define("LABEL_verTerminosLetra", "см. термины, начинающиеся с ");
define("LABEL_NB", "Библиографическое примечание");
define("LABEL_NH", "Историческое примечание");
define("LABEL_NA", "Примечание по области применения");   /* version 0.9.1 */
define("LABEL_NP", "Индивидуальное примечание"); /* version 0.9.1 */
define("LABEL_EditorNota", "Редактор примечаний ");
define("LABEL_EditorNotaTermino", "примечание для ");
define("LABEL_tipoNota", "тип примечания");
define("FORM_LABEL_tipoNota", "тип_примечания");
define("LABEL_nota", "примечание");
define("FORM_LABEL_nota", "_примечание");
define("LABEL_EditarNota", "редактировать примечание");
define("LABEL_EliminarNota", "Удалить примечание");
define("LABEL_OptimizarTablas", "Оптимизировать таблицы");
define("LABEL_TotalZthesLine", "Экспортировать в Zthes");
/* v 9.2 */
define("LABEL_negrita", "жирный");
define("LABEL_italica", "курсив");
define("LABEL_subrayado", "подчеркивание");
define("LABEL_textarea", "текст примечаний");
define("MSGL_relacionIlegal", "неверная взаимосвязь между терминами");
/* v 9.3 */
define("LABEL_fecha_modificacion", "изменено");
define("LABEL_TotalUsuarios", "всего пользователей");
define("LABEL_TotalTerminos", "всего терминов");
define("LABEL_ordenar", "сортировать по");
define("LABEL_auditoria", "просмотр терминов");
define("LABEL_dia", "день");
define("LABEL_mes", "месяц");
define("LABEL_ano", "год");
define("LABEL_terminosRepetidos", "дублирование терминов");
define("MSG_noTerminosLibres", "свободные термины отсутствуют");
define("MSG_noTerminosRepetidos", "дубликаты терминов отсутствуют");
define("LABEL_TotalSkosLine", "экспортировать в Skos-core");
$MONTHS=array("01"=>"Янв",
              "02"=>"Фев",
              "03"=>"Март",
              "04"=>"Март",
              "05"=>"Май",
              "06"=>"Июнь",
              "07"=>"Июль",
              "08"=>"Авг",
              "09"=>"Сен",
              "10"=>"Сен",
              "11"=>"Ноя",
              "12"=>"Дек"
              );
/* v 9.4 */
define("LABEL_SI", "ДА");
define("LABEL_NO", "НЕТ");
define("FORM_LABEL_jeraquico", "полииерархический");
define("LABEL_jeraquico", "Полииерархический"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "свободный термин");
/* v 9.5 */
define("LABEL_URL_busqueda", "Искать %s в:");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "связь с другим словарем");
define("FORM_LABEL_relacion_vocabulario", "эквивалентность");
define("FORM_LABEL_nombre_vocabulario", "словарь языка перевода");
define("LABEL_vocabulario_referencia", "словарь языка перевода");
define("LABEL_NO_vocabulario_referencia", "невозможно установить взаимосвязь терминологии по причине отсутствия словаря языка перевода");
define("FORM_LABEL_tipo_equivalencia", "тип эквивалентности");
define("LABEL_vocabulario_principal", "словарь");
define("LABEL_tipo_vocabulario", "тип");
define("LABEL_termino_equivalente", "эквивалент");
define("LABEL_termino_parcial_equivalente", "частичный эквивалент");
define("LABEL_termino_no_equivalente", "не эквивалент");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "EQP"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "Примечание к каталогизатору");
define("LABEL_resultados_suplementarios", "дополнительные результаты");
define("LABEL_resultados_relacionados", "взаимосвязанные результаты");
/* v 9.7 */
define("LABEL_export", "экспорт");
define("FORM_LABEL_format_export", "выбрать схему XML ");
/* v 1.0 */
define("LABEL_fecha_creacion", "создано");
define("NB_acronimo", "BN"); /* Bibliographic note */
define("NH_acronimo", "HN"); /* Historical note */
define("NA_acronimo", "SN"); /* Scope or Explanatory note */
define("NP_acronimo", "PN"); /* Private note */
define("NC_acronimo", "CN"); /* Cataloger's note */
define("LABEL_Candidato", "предлагаемый термин");
define("LABEL_Aceptado", "одобренный термин");
define("LABEL_Rechazado", "отклоненный термин");
define("LABEL_Ultimos_aceptados", "последние одобренные термины");
define("MSG_ERROR_ESTADO", "несоответствующий статус");
define("LABEL_Candidatos", "предлагаемые термины");
define("LABEL_Aceptados", "одобренные термины");
define("LABEL_Rechazados", "отклоненные термины");
define("LABEL_User_NoHabilitado", "отключить");
define("LABEL_User_Habilitado", "включить");

define("LABEL_CandidatearTermino", "предложить термин");
define("LABEL_AceptarTermino", "одобрить термин");
define("LABEL_RechazarTermino", "отклонить термин");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "Вы имели в виду:");
/* v 1.02 */
define("LABEL_esSuperUsuario", "является администратором");
define("LABEL_Cancelar", "отменить");
define("LABEL_Guardar", "сохранить");
/* v 1.033 */
define("MENU_AgregarTEexist", "Определить статус существующего термина");
define("MENU_AgregarUPexist", "Присоединить существующий нежелательный термин ");
define("LABEL_existAgregarUP", "Добавить термин UF к %s");
define("LABEL_existAgregarTE", "Добавить термин с более узким значением к %s ");
define("MSG_minCharSerarch", "Выражение поиска <i>%s</i> содержит только <strong>%s </strong> символы. Должно содержать другие данные помимо <strong>%s</strong> символов");
/* v 1.04 */
define("LABEL_terminoExistente", "существующий термин");
define("HELP_variosTerminos", "Чтобы добавить несколько терминов сразу, укажите по <strong>одному термину в каждой линии</strong>.");
/* Install messages */
define("FORM", "Форма") ;
define("ERROR", "Ошибка") ;
define("LABEL_bienvenida", "Добро пожаловать на сервер словаря TemaTres") ;
// COMMON SQL
define("PARAM_SERVER", "Адрес сервера") ;
define("PARAM_DBName", "Название базы данных") ;
define("PARAM_DBLogin", "Пользователь базы данных") ;
define("PARAM_DBPass", "Пароль базы данных") ;
define("PARAM_DBprefix", "Таблицы префиксов") ;
$install_message[101] = 'TemaTres Setup' ;
$install_message[201] = 'Can not find the file configuration for the database connection (%s).';
$install_message[202] = 'File configuration for the database connection found.';
$install_message[203] = 'Unable to connect to database server <em>%s</em> with the user <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[204] = 'Connection to Server <em>%s</em> successful ';
$install_message[205] = 'Unable to connect to database <em>%s</em> in server <em>%s</em>. Please check your file configuration for the database connection (%s).';
$install_message[206] = 'Connection to database <em>%s</em> in server <em>%s</em> successful.' ;
$install_message[301] = 'Whoops... There is already a TemaTres instance for the configuration. Please check your file configuration for the database connection (%s) or <a href="index.php">Enjoy your Vocabulary Server</a>' ;
$install_message[305] = 'Checking Security password.' ;
$install_message[306] = 'Setup is completed, <a href="index.php">Enjoy your Vocabulary Server</a>' ;
/* end Install messages */
/* v 1.1 */
define('MSG_ERROR_CODE', "неверный код");
define('LABEL_CODE', "код");
define('LABEL_Ver', "Показать");
define('LABEL_OpcionesTermino', "термин");
define('LABEL_CambiarEstado', "Изменить статус термина");
define('LABEL_ClickEditar', "Нажать для редактирования...");
define('LABEL_TopTerm', "Имеет этот верхний термин");
define('LABEL_esFraseExacta', "точная фраза");
define('LABEL_DesdeFecha', "создано на дату или после");
define('LABEL_ProfundidadTermino', "расположен в глубоком уровне");
define('LABEL_esNoPreferido', "нежелательный термин");
define('LABEL_BusquedaAvanzada', "расширенный поиск");
define('LABEL_Todos', "все");
define('LABEL_QueBuscar', "что искать?");
define("LABEL_import", "импорт") ;
define("IMPORT_form_legend", "импортировать тезаурус из файла") ;
define("IMPORT_form_label", "файл") ;
define("IMPORT_file_already_exists", "txt файл уже имеется на сервере") ;
define("IMPORT_file_not_exists", "txt файл еще не импортирован") ;
define("IMPORT_do_it", "Можно начинать импорт") ;
define("IMPORT_working", "выполняется импорт") ;
define("IMPORT_finish", "импорт закончен") ;
define("LABEL_reIndice", "восстановить индексы") ;
define("LABEL_dbMantenimiento", "обслуживание базы данных");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "соотношение с термином из удаленного конечного словаря");
define('LABEL_vocabulario_referenciaWS', "удаленный конечный словарь (интернет-услуги)");
define('LABEL_TargetVocabularyWS', "удаленный конечный словарь (интернет-услуги)");
define('LABEL_tvocab_label', "метка для справки");
define('LABEL_tvocab_tag', "тэг для справки");
define('LABEL_tvocab_uri_service', "URL для ссылки на интернет-услуги");
define('LABEL_targetTermsforUpdate', "термины с ожиданием обновления");
define('LABEL_ShowTargetTermsforUpdate', "проверить обновление терминов");
define('LABEL_enable', "включить");
define('LABEL_disable', "отключить");
define('LABEL_notFound', "термин не найден");
define('LABEL_termUpdated', "термин обновлен");
define('LABEL_ShowTargetTermforUpdate', "обновить");
define('LABEL_relbetweenVocabularies', "взаимосвязь между словарями");
define('LABEL_update1_1x1_2', "Обновить (1.1 -> 1.3)");
define('LABEL_update1x1_2', "Обновить (1.0x -> 1.3)");
define('LABEL_TargetTerm', "терминологическое картирование");
define('LABEL_TargetTerms', "термины (терминологическое картирование)");
define('LABEL_seleccionar', 'выбрать');
define('LABEL_poliBT', 'более одного термина с более общим значением');
define('LABEL_FORM_simpleReport', 'отчеты');
define('LABEL_FORM_advancedReport', 'расширенные отчеты');
define('LABEL_FORM_nullValue', 'не имеет значения');
define('LABEL_FORM_haveNoteType', 'имеет тип примечания');
define('LABEL_haveEQ', 'имеет эквиваленты');
define('LABEL_nohaveEQ', 'не имеет эквиваленты');
define('LABEL_start', 'начинается с');
define('LABEL_end', 'заканчивается на');
define('LABEL_equalThisWord', 'точное совпадение с');
define('LABEL_haveWords', 'содержит слова');
define('LABEL_encode', 'кодировка');
/*
v1.21
*/
define('LABEL_import_skos', 'Импорт Skos-Core');
define('IMPORT_skos_file_already_exists', 'Источник Skos-Core находится на сервере');
define('IMPORT_skos_form_legend', 'Импорт Skos-Core');
define('IMPORT_skos_form_label', 'Файл Skos-Core');
/*
v1.4
*/
define('LABEL_termsxNTterms', 'Термины с более узким значением х термин');
define('LABEL_termsNoBT', 'Термины без иерархической взаимосвязи');
define('MSG_noTermsNoBT', 'Термины без иерархической взаимосвязи отсутствуют');
define('LABEL_termsXcantWords', 'количество слов х термин');
define('LABEL__USE_CODE', 'использовать коды терминов для сортировки терминов');
define('LABEL__SHOW_CODE', 'Показаны коды терминов для общественного просмотра');
define('LABEL_CFG_MAX_TREE_DEEP', 'Максимальный уровень глубины в дереве, отображаемый на той же странице');
define('LABEL_CFG_VIEW_STATUS', 'Информация о статусе, доступная всем пользователям');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', 'включить веб-услуги');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', 'Количество отображаемых терминов в виде статуса');
define('LABEL_CFG_MIN_SEARCH_SIZE', 'Минимальное количество символов для поиска');
define('LABEL__SHOW_TREE', 'опубликовать иерархический вид на главной странице');
define('LABEL__PUBLISH_SKOS', 'включить формат Skos-core для веб-услуг. Это может привести к открытию доступа ко всему Вашему словарю.');
define('LABEL_update1_3x1_4', "Update (1.3x -> 1.4)");
define("FORM_LABEL_format_import", "выбрать формат");
define("LABEL_importTab", "табулированный текст");
define("LABEL_importTag", "тегированный текст");
define("LABEL_importSkos", "Skos-core");
define("LABEL_configTypeNotes", "конфигурировать типы примечаний");
define("LABEL_notes", "примечания");
define("LABEL_saved", "сохранено");
define("FORM_JS_confirmDeleteTypeNote", "удалить этот тип примечания?");
/*
v1.5
*/
define("LABEL_relationEditor", "редактор взаимосвязей");
define("LABEL_relationDelete", "удалить подтип взаимосвязи");
define('LABEL_relationSubType', "relation type");
define('LABEL_relationSubTypeCode', "relation sub-type alias");
define('LABEL_relationSubTypeLabel', "relation sub-type label");
define('LABEL_optative', "optional");
define('FORM_JS_confirmDeleteTypeRelation', 'удалить этот подтип взаимосвязи?');
define("LABEL_URItypeEditor", "редактор типов ссылок");
define("LABEL_URIEditor", "управление ссылками, касающимися термина");
define("LABEL_URItypeDelete", "удалить тип ссылки");
define('LABEL_URItype', "link type");
define('LABEL_URItypeCode', "link type alias");
define('LABEL_URItypeLabel', "link type label");
define('FORM_JS_confirmDeleteURIdefinition', 'удалить этот тип ссылки?');
define('LABEL_URI2term', 'веб-ресурс');
define('LABEL_URI2termURL', 'URL веб-ресурса');
define('LABEL_update1_4x1_5', 'Обновить (1.4 -> 1.5)');
define('LABEL_Contributor', 'автор');
define('LABEL_Rights', 'права');
define('LABEL_Publisher', 'публикатор');
/*
v1.6
*/
define('LABEL_Prev', 'предыдущий');
define('LABEL_Next', 'следующий');
define('LABEL_PageNum', 'номер страницы с результатами ');
define('LABEL_selectMapMethod', 'выбрать способ терминологического отображения');
define('LABEL_string2search', 'выражение поиска');
define('LABEL_reverseMappign', 'обратное отображение');
define('LABEL_warningMassiverem', 'Это приведет к массовому удалению данных. Такие действия не подлежат отмене!');
define('LABEL_target_terms', 'выявленные термины из внешних словарей');
define('LABEL_URI2terms', 'веб-ресурсы');
define('MENU_massiverem', 'Массовое удаление данных');
define('LABEL_more', 'больше');
define('LABEL_less', 'меньше');
define('LABEL_lastChangeDate', 'дата последнего изменения');
define('LABEL_update1_5x1_6', 'Обновить (1.5 -> 1.6)');
define('LABEL_login', 'получить доступ');
define('LABEL_user_recovery_password', 'Получить новый пароль');
define('LABEL_user_recovery_password1', 'Введите Ваше имя пользователя или адрес электронной почты. Вы получите ссылку для создания нового пароля по электронной почте.');
define('LABEL_mail_recoveryTitle', 'Сброс пароля');
define('LABEL_mail_recovery_pass1', 'Был запрошен сброс пароля для следующей учетной записи:');
define('LABEL_mail_recovery_pass2', 'Имя пользователя: %s');
define('LABEL_mail_recovery_pass3', 'Если это произошло по ошибке, игнорируйте данное сообщение, и ничего не произойдет.');
define('LABEL_mail_recovery_pass4', 'Для сброса пароля перейдите на следующий адрес:');
define('LABEL_mail_passTitle', 'Новый пароль ');
define('LABEL_mail_pass1', 'Новый пароль для ');
define('LABEL_mail_pass2', 'Пароль: ');
define('LABEL_mail_pass3', 'Вы можете его изменить.');
define('MSG_check_mail_link', 'Ссылка подтверждения отправлена Вам по электронной почте.');
define('MSG_check_mail', 'If that email address is valid, we will send you an email to reset your password.');
define('MSG_no_mail', 'Сообщение не было отправлено.');
define('LABEL_user_lost_password', ' Забыли пароль?');
## v1.7
define('LABEL_includeMetaTerm', 'Содержит мета-термины');
define('NOTE_isMetaTerm', 'Является мета-термином.');
define('NOTE_isMetaTermNote', 'Мета-термин – это термин, который невозможно использовать в процессе индексирования. Термин, используемый для описания других терминов. Например: направляющие термины, аспекты, категории и др.');
define('LABEL_turnOffMetaTerm', 'Не является мета-термином');
define('LABEL_turnOnMetaTerm', 'Является мета-термином');
define('LABEL_meta_term', 'мета-термин');
define('LABEL_meta_terms', 'мета-термины');
define('LABEL_relatedTerms', 'взаимосвязанные термины');
define('LABEL_nonPreferedTerms', 'нежелательные термины');
define('LABEL_update1_6x1_7', 'Обновить TemaTres (1.6 -> 2.2)');
define('LABEL_include_data', 'включить');
define('LABEL_updateEndpoint', 'обновить конечную точку SPARQL');
define('MSG__updateEndpoint', 'Данные будут обновлены в указанной конечной точке SPARQL. Эта операция может занять несколько минут.');
define('MSG__updatedEndpoint', 'Конечная точка SPARQL обновлена.');
define('MSG__dateUpdatedEndpoint', 'Последняя обновленная конечная точка SPARQL');
define('LABEL__ENABLE_SPARQL', 'Необходимо обновить конечную точку SPARQL: Меню -> Администрирование -> Обслуживание базы данных -> Обновить конечную точку SPARQL.');
define('MSG__disable_endpoint', 'Конечная точка SPARQL отключена.');
define('MSG__need2setup_endpoint', 'Необходимо обновить конечную точку SPARQL. Свяжитесь с администратором.');
define('LABEL_SPARQLEndpoint', 'Конечная точка SPARQL');
define('LABEL_AgregarRTexist', 'Выберите термины, которые будут указаны в качестве взаимосвязанного термина с');
define('MENU_selectExistTerm', 'выберите существующий термин');
define("TT_terminos", "популярные термины");
## v1.72
define('MSG__warningDeleteTerm', 'Термин <i>%s</i> будет <strong>УДАЛЕН</strong>.');
define('MSG__warningDeleteTerm2row', 'Его примечания и взаимосвязи <strong>all</strong> будут удалены. Это действие не подлежит отмене!');
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
define('LABEL_altTerms', 'alternative terms');
define('LABEL_narrowerTerms', 'more specific terms');
define('LABEL_results', 'results');
define('LABEL_showFreeTerms', 'free terms list');
define('LABEL_helpSearchFreeTerms', 'Only free terms.');
define('LABEL_broatherTerms', 'broader Terms');
define('LABEL_type2filter', 'type to filter the terms');
define('LABEL_defaultEQmap', 'Type "eq" to define equivalence relationship');
define("MSG_repass_error", "the passwords do not match");
define("MSG_lengh_error", "please type at least %d characters");
define("MSG_errorPostData", "A mistake was detected, Please review the data to the field ");
define('LABEL_preferedTerms', 'preferred terms');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', 'terms WITHOUT notes');
define('MSG_FORM_NULLnotesTermReport', 'terms without note type');
define('LABELnoNotes', 'terms that have no note');
define('LABEL_termsXdeepLevel', 'terms for each depth level');
define('LABEL_deepLevel', 'deep level');
define('LABEL_cantTerms', '# of terms');
define('LINK_publicKnownVocabularies', '<a href="http://www.vocabularyserver.com/vocabularies/" title="List of enabled vocabularies" target="_blank">List of enabled vocabularies</a>');
define('LABEL_showNewsTerm', 'show recent changes');
define('LABEL_newsTerm', 'recent changes');
define('MSG_contactAdmin', 'contact the administrator');
define('LABEL_addTargetVocabulary', 'add external vocabularies (terminological web services)');
#v.2.1
define('LABEL_duplicatedTerm', 'duplicated term');
define('LABEL_duplicatedTerms', 'duplicated terms');
define('MSG_duplicatedTerms', 'The configuration of the vocabulary does not allow duplicate terms.');
define('LABEL_bulkReplace', 'bulk editor (search and replace)');
define('LABEL_searchFor', 'string to search and replace');
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
define('LABEL_selectRelation', 'select type relation');
define('LABEL_withSelected', 'with selected terms:');
define('LABEL_rejectTerms', 'reject terms');
define('LABEL_doMetaTerm', 'turn to meta-terms');
define('LABEL_associateFreeTerms', 'associate as UF,NTE or RT');
define('MSG_associateFreeTerms', 'in the next step you can select the type of relationship.');
define('MSG_termsSuccessTask', 'terms affected by the process');
define('LABEL_TTTerms', 'популярные термины');
define('MSG__GLOSSincludeAltLabel', 'include alternative terms');
define('MSG__GLOSSdocumentationJSON', 'You can add Glossary to any HTML content using this JSON file with <a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>');
define('LABEL_configGlossary', 'export source file for glossary');
define('MSG_includeNotes', 'use type note:');
define('LABEL_SHOW_RANDOM_TERM', 'Show a randomly selected term on the home page.  You must select the type of term to show.');
define('LABEL_opt_show_rando_term', 'show terms with type note:');
define('MSG_helpNoteEditor', 'You can link terms using double brackets. Ex: Only [[love]] will save the world');
define('LABEL_GLOSS_NOTES', 'Select which type note will be used to enrich (glossary) the terms who are marked with double brackets : [[glossary]]');
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
// Translation versioning
define('LABEL_i18n_MasterDate', '2018-09-12'); /* Master language file creation date (YYYY-MM-DD). Do not translate */
define('LABEL_i18n_MasterVersion', '3.0.03'); /* Master language file version. Do not translate */
define('LABEL_i18n_TranslationVersion', '01'); /* Translation language file version. Will be used after the master version number. Can be changed to track minor changes to your translation file */
define('LABEL_i18n_TranslationAuthor', 'Community translation for TemaTres.'); /* Do not include emails or personal details */

#v.3.1
define('LABEL_noResults', 'Sorry, no matching results');
define('LABEL_globalOrganization', 'global organization of the vocabulary');
define('LABEL_rel_associative', 'associative relationships');
define('LABEL_rel_hierarchical', 'hierarchical relationships');
define('LABEL_rel_synonymy', 'synonym relationships');
define('LABEL_prototypeTerms', 'central terms');
define('LABEL_copy_click', 'copy term to clipboard');
define('LABEL__ENABLE_COPY_CLICK', 'Enable button to copy term in clipboard.');
#v.3.2
define('LABEL_order', 'orden');
define('LABEL_alias', 'alias');
define('LEGEND_alias', 'enter a short alias');
define('LABEL_src_note', 'source');
define('LEGEND_src_note', 'enter a bibliographic citation');
define('LABEL_source', 'normalized sources of authority');
define('LABEL_source4term', 'reference sources for terms');
define('LABEL_add_new', 'add new');
define('LABEL_sources4vocab', 'reference sources');
define('LABEL_update2_2x3_2', 'update (2.x -> 3.2)');
define('LABEL__getForTargetVocabularyNews', 'get for news');
define('LABEL__example', 'example');
