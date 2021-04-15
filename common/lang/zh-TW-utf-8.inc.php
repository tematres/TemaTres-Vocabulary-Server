<?php
#   TemaTres: open source thesaurus management
#   Website http://www.vocabularyserver.com
#   Copyright (C) 2004-2020 Diego Ferreyra <tematres@r020.com.ar>
#   License: distributed under the GNU General Public License Version 2 (June 1991) Free Software Foundation
#   Translation: Community collaborative translation https://crowdin.com/project/tematres
#
###############################################################################################################
#
// Translation versioning
define('LABEL_i18n_MasterDate', '2020-06-18'); /* Do not translate. Master language file creation date (YYYY-MM-DD). */
define('LABEL_i18n_MasterVersion', '3.2.1'); /* Do not translate. Master language file version. */
define('LABEL_i18n_TranslationVersion', '01'); /* Translation language file version. Will be used as a sufix for the language master version number. Can be changed by translators to track minor changes to your translation file */
define('LABEL_i18n_TranslationAuthor', 'Community translation for TemaTres'); /* Can be changed by translators. Do not include emails or personal details */
/* Strings to translate */
define("LANG", "zh-TW");
define("TR_acronimo", "参"); /* Related Term */
define("TE_acronimo", "分"); /* Narrower term > Specific term */
define("TG_acronimo", "属"); /* Broader term > Generic term */
define("UP_acronimo", "代"); /* Used for > instead */
define("TR_termino", "相关词");
define("TE_termino", "下位词");
define("TG_termino", "上位词");
define("UP_termino", "代"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "用"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "等级体系表");
define("MENU_ListaAbc", "字顺表");
define("MENU_Sobre", "关于");
define("MENU_Inicio", "主页");
define("MENU_MiCuenta", "我的帐号");
define("MENU_Usuarios", "用户");
define("MENU_NuevoUsuario", "新用户");
define("MENU_DatosTesauro", "关于叙词表");
define("MENU_AgregarT", "新增词条");
define("MENU_EditT", "编辑词条");
define("MENU_BorrarT", "删除词条");
define("MENU_AgregarTG", "上位词");
define("MENU_AgregarTE", "下位词");
define("MENU_AgregarTR", "相关词");
define("MENU_AgregarUP", "非正式词");  /* Non-descriptor */
define("MENU_MisDatos", "我的帐号");
define("MENU_Caducar", "禁用");
define("MENU_Habilitar", "可用");
define("MENU_Salir", "注销");
define("LABEL_Menu", "菜单");
define("LABEL_Opciones", "选项");
define("LABEL_Admin", "管理");
define("LABEL_Agregar", "新增");
define("LABEL_editT", "编辑词条 ");
define("LABEL_EditorTermino", "词条编辑器");
define("LABEL_Termino", "词条");
define("LABEL_NotaAlcance", "范围注释");
define("LABEL_EliminarTE", "删除词条");
define("LABEL_AgregarT", "新词条");
define("LABEL_AgregarTG", "为%s新增上位词 ");
define("LABEL_AgregarTE", "新词条从属于 ");
define("LABEL_AgregarUP", "新代位词 ");
define("LABEL_AgregarTR", "新相关词 ");
define("LABEL_Detalle", "详情");
define("LABEL_Autor", "作者");
define("LABEL_URI", "唯一资源识别符");
define("LABEL_Version", "技术支持");
define("LABEL_Idioma", "语种");
define("LABEL_Fecha", "创建日期");
define("LABEL_Keywords", "关键词");
define("LABEL_TipoLenguaje", "词表类型");
define("LABEL_Cobertura", "简介");
define("LABEL_Terminos", "词条");
define("LABEL_RelTerminos", "词间关系");
define("LABEL_TerminosUP", "非正式词");
define("LABEL_BuscaTermino", "搜索词条");
define("LABEL_Buscar", "搜索词条");
define("LABEL_Enviar", "提交");
define("LABEL_Cambiar", "保存更改");
define("LABEL_Anterior", "返回");
define("LABEL_AdminUser", "用户管理");
define("LABEL_DatosUser", "用户数据");
define("LABEL_Acciones", "任务");
define("LABEL_verEsquema", "模式");
define("LABEL_actualizar", "更新");
define("LABEL_terminosLibres", "自由词"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "搜索");
define("LABEL_borraRelacion", "删除关系");
define("MSG_ResultBusca", "检索式找到如下词条");
define("MSG_ResultLetra", "字母");
define("MSG_ResultCambios", "修改成功");
define("MSG_noUser", "非注册用户");
define("FORM_JS_check", "请检查数据 ");
define("FORM_JS_confirm", "是否清除此关系？");
define("FORM_JS_pass", "密码");
define("FORM_JS_confirmPass", "确认密码");
define("FORM_LABEL_termino", "词条");
define("FORM_LABEL_buscar", "检索式");
define("FORM_LABEL_buscarTermino", "相关词");
define("FORM_LABEL_nombre", "名");
define("FORM_LABEL_apellido", "姓");
define("FORM_LABEL_mail", "邮箱");
define("FORM_LABEL_pass", "密码");
define("FORM_LABEL_repass", "确认密码");
define("FORM_LABEL_orga", "机构");
define("LABEL_nombre", "名");
define("LABEL_apellido", "姓");
define("LABEL_mail", "邮箱");
define("LABEL_pass", "密码");
define("LABEL_repass", "确认密码");
define("LABEL_orga", "机构");
define("LABEL_lcConfig", "词表配置");
define("LABEL_lcDatos", "词表元数据");
define("LABEL_Titulo", "名称");
define("FORM_LABEL_Titulo", "名称");
define("FORM_LABEL_Autor", "作者");
define("FORM_LABEL_URI", "唯一资源标识符");
define("FORM_LABEL_Idioma", "语种");
define("FORM_LABEL_FechaDia", "日");
define("FORM_LABEL_FechaMes", "月");
define("FORM_LABEL_FechaAno", "年");
define("FORM_LABEL_Keywords", "关键词");
define("FORM_LABEL_TipoLenguaje", "词表类型");
define("FORM_LABEL_Cobertura", "范围");
define("FORM_LABEL_Terminos", "词条");
define("FORM_LABEL_RelTerminos", "词间关系");
define("FORM_LABEL_TerminosUP", "非正式词");
define("FORM_LABEL_Guardar", "保存");
define("LABEL_verDetalle", "详见 ");
define("LABEL_verTerminosLetra", "从此处开始查看 ");
define("LABEL_NB", "书目注释");
define("LABEL_NH", "沿革注释");
define("LABEL_NA", "范围注释");   /* version 0.9.1 */
define("LABEL_NP", "内部注释"); /* version 0.9.1 */
define("LABEL_EditorNota", "注释编辑器 ");
define("LABEL_EditorNotaTermino", "注释 ");
define("LABEL_tipoNota", "注释类型");
define("FORM_LABEL_tipoNota", "注释类型");
define("LABEL_nota", "注释");
define("FORM_LABEL_nota", "注释");
define("LABEL_EditarNota", "编辑注释");
define("LABEL_EliminarNota", "删除注释");
define("LABEL_OptimizarTablas", "优化表");
define("LABEL_TotalZthesLine", "导出为Zthes");
/* v 9.2 */
define("LABEL_negrita", "粗体");
define("LABEL_italica", "斜体");
define("LABEL_subrayado", "下划线");
define("LABEL_textarea", "主体注释");
define("MSGL_relacionIlegal", "词间不合法关系");
/* v 9.3 */
define("LABEL_fecha_modificacion", "已修改");
define("LABEL_TotalUsuarios", "用户总数");
define("LABEL_TotalTerminos", "词条总数");
define("LABEL_ordenar", "排序");
define("LABEL_auditoria", "词条按时间统计");
define("LABEL_dia", "日");
define("LABEL_mes", "月");
define("LABEL_ano", "年");
define("LABEL_terminosRepetidos", "重复词条");
define("MSG_noTerminosLibres", "无自由词");
define("MSG_noTerminosRepetidos", "无重复词");
define("LABEL_TotalSkosLine", "导出为SKOS-Core");
$MONTHS=array("01"=>"一月",
              "02"=>"二月",
              "03"=>"三月",
              "04"=>"四月",
              "05"=>"五月",
              "06"=>"六月",
              "07"=>"七月",
              "08"=>"八月",
              "09"=>"九月",
              "10"=>"十月",
              "11"=>"十一月",
              "12"=>"十二月"
              );
/* v 9.4 */
define("LABEL_SI", "是");
define("LABEL_NO", "否");
define("FORM_LABEL_jeraquico", "复合等级体系");
define("LABEL_jeraquico", "复合等级体系"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "自由词");
/* v 9.5 */
define("LABEL_URL_busqueda", "搜索%s ");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "关联词表");
define("FORM_LABEL_relacion_vocabulario", "等同");
define("FORM_LABEL_nombre_vocabulario", "目标词表");
define("LABEL_vocabulario_referencia", "目标词表");
define("LABEL_NO_vocabulario_referencia", "无目标词表可形成词间关系");
define("FORM_LABEL_tipo_equivalencia", "等同类型");
define("LABEL_vocabulario_principal", "词表");
define("LABEL_tipo_vocabulario", "类型");
define("LABEL_termino_equivalente", "等同");
define("LABEL_termino_parcial_equivalente", "部分等同");
define("LABEL_termino_no_equivalente", "非等同");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "EQP"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "编目员注释");
define("LABEL_resultados_suplementarios", "补充结果");
define("LABEL_resultados_relacionados", "相关结果");
/* v 9.7 */
define("LABEL_export", "导出");
define("FORM_LABEL_format_export", "选择XML模式");
/* v 1.0 */
define("LABEL_fecha_creacion", "已创建");
define("NB_acronimo", "BN"); /* Bibliographic note */
define("NH_acronimo", "HN"); /* Historical note */
define("NA_acronimo", "SN"); /* Scope or Explanatory note */
define("NP_acronimo", "PN"); /* Private note */
define("NC_acronimo", "CN"); /* Cataloger's note */
define("LABEL_Candidato", "候选词");
define("LABEL_Aceptado", "已接受词");
define("LABEL_Rechazado", "已拒绝词");
define("LABEL_Ultimos_aceptados", "最新接受词");
define("MSG_ERROR_ESTADO", "不合法状态");
define("LABEL_Candidatos", "候选词");
define("LABEL_Aceptados", "已接受词");
define("LABEL_Rechazados", "已拒绝词");
define("LABEL_User_NoHabilitado", "禁用");
define("LABEL_User_Habilitado", "启用");

define("LABEL_CandidatearTermino", "候选词");
define("LABEL_AceptarTermino", "接受词");
define("LABEL_RechazarTermino", "拒绝词");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "你是不是要找");
/* v 1.02 */
define("LABEL_esSuperUsuario", "管理员");
define("LABEL_Cancelar", "取消");
define("LABEL_Guardar", "保存");
/* v 1.033 */
define("MENU_AgregarTEexist", "从属于一个已有词条");
define("MENU_AgregarUPexist", "关联一个已有非正式词");
define("LABEL_existAgregarUP", "为%s增加一个代位词");
define("LABEL_existAgregarTE", "为%s增加一个下位词 ");
define("MSG_minCharSerarch", "检索式<i>%s</i>仅包含<strong>%s </strong>个字符。必须多余<strong>%s </strong>个字符。");
/* v 1.04 */
define("LABEL_terminoExistente", "已有词条");
define("HELP_variosTerminos", "若要一次增加多个词条，<strong>每行一个词条</strong>。");
/* Install messages */
define("FORM", "表单") ;
define("ERROR", "错误") ;
define("LABEL_bienvenida", "欢迎来到TemaTres词表服务器") ;
// COMMON SQL
define("PARAM_SERVER", "服务器地址") ;
define("PARAM_DBName", "数据库名称") ;
define("PARAM_DBLogin", "数据库用户") ;
define("PARAM_DBPass", "数据库密码") ;
define("PARAM_DBprefix", "前缀表") ;
$install_message[101] = 'TemaTres Setup' ;
$install_message[201] = 'Can not find the file configuration for the database connection (%s).';
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
define('MSG_ERROR_CODE', "无效代码");
define('LABEL_CODE', "代码");
define('LABEL_Ver', "显示");
define('LABEL_OpcionesTermino', "词条");
define('LABEL_CambiarEstado', "更改词条状态");
define('LABEL_ClickEditar', "点击编辑");
define('LABEL_TopTerm', "有族首词");
define('LABEL_esFraseExacta', "精确短语");
define('LABEL_DesdeFecha', "创建时或创建后");
define('LABEL_ProfundidadTermino', "定位到深层级");
define('LABEL_esNoPreferido', "非正式词");
define('LABEL_BusquedaAvanzada', "高级搜索");
define('LABEL_Todos', "所有");
define('LABEL_QueBuscar', "搜索什么？");
define("LABEL_import", "导入") ;
define("IMPORT_form_legend", "从文件导入叙词表") ;
define("IMPORT_form_label", "文件") ;
define("IMPORT_file_already_exists", "txt文件已存在于该服务器") ;
define("IMPORT_file_not_exists", "尚未导入txt文件") ;
define("IMPORT_do_it", "你可以开始导入") ;
define("IMPORT_working", "导入任务进行中") ;
define("IMPORT_finish", "导入任务完成") ;
define("LABEL_reIndice", "重建索引") ;
define("LABEL_dbMantenimiento", "数据库维护");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "与远程目标词表的词条关系");
define('LABEL_vocabulario_referenciaWS', "远程目标词表（Web Services）");
define('LABEL_TargetVocabularyWS', "远程目标词表（Web Services）");
define('LABEL_tvocab_label', "参照标识");
define('LABEL_tvocab_tag', "参照标签");
define('LABEL_tvocab_uri_service', "Web Services参照URL");
define('LABEL_targetTermsforUpdate', "待更新词条");
define('LABEL_ShowTargetTermsforUpdate', "检查词条更新");
define('LABEL_enable', "启用");  /* web services status info: in use */
define('LABEL_disable', "禁用");  /* web services status info: not in use */
define('LABEL_notFound', "词条未找到");
define('LABEL_termUpdated', "词条已更新");
define('LABEL_ShowTargetTermforUpdate', "更新");
define('LABEL_relbetweenVocabularies', "词表间关系");
define('LABEL_update1_1x1_2', "更新（1.1 -> 1.3）");
define('LABEL_update1x1_2', "更新（1.0x -> 1.3）");
define('LABEL_TargetTerm', "术语映射");
define('LABEL_TargetTerms', "词条（术语映射）");
define('LABEL_seleccionar', '选择XML模式');
define('LABEL_poliBT', '多于1个上位词');
define('LABEL_FORM_simpleReport', '报告');
define('LABEL_FORM_advancedReport', '高级报告');
define('LABEL_FORM_nullValue', '没问题');
define('LABEL_FORM_haveNoteType', '有注释类型');
define('LABEL_haveEQ', '有等同关系');
define('LABEL_nohaveEQ', '无等同关系');
define('LABEL_start', '开始于');
define('LABEL_end', '结束于');
define('LABEL_equalThisWord', '精确匹配');
define('LABEL_haveWords', '包含单词');
define('LABEL_encode', '编码');
/*
v1.21
*/
define('LABEL_import_skos', 'SKOS-Core导入');
define('IMPORT_skos_file_already_exists', 'SKOS-Core来源在服务器上');
define('IMPORT_skos_form_legend', '导入SKOS-Core');
define('IMPORT_skos_form_label', 'SKOS-Core文件');
/*
v1.4
*/
define('LABEL_termsxNTterms', '下位词 x 词条');
define('LABEL_termsNoBT', '无等级关系词');
define('MSG_noTermsNoBT', '无等级关系的词条不存在');
define('LABEL_termsXcantWords', '单词数量 x 词条');
define('LABEL__USE_CODE', '根据词条代码对词条排序');
define('LABEL__SHOW_CODE', '以公开视图显示词条代码');
define('LABEL_CFG_MAX_TREE_DEEP', '在同一页面上显示的最深层级');
define('LABEL_CFG_VIEW_STATUS', '任意用户可见的状态细节');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', '启用Web Services');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', '按状态视图显示词条数');
define('LABEL_CFG_MIN_SEARCH_SIZE', '搜索提交的最小字符数');
define('LABEL__SHOW_TREE', '在主页发布层级视图');
define('LABEL__PUBLISH_SKOS', '在Web Services中启用SKOS-Core格式。这样做会公开整个词表。');
define('LABEL_update1_3x1_4', "更新（1.3x -> 1.4）");
define("FORM_LABEL_format_import", "选择格式");
define("LABEL_importTab", "表格文本");
define("LABEL_importTag", "标记文本");
define("LABEL_importSkos", "SKOS-Core");
define("LABEL_configTypeNotes", "配置注释类型");
define("LABEL_notes", "注释");
define("LABEL_saved", "保存");
define("FORM_JS_confirmDeleteTypeNote", "是否清除此注释类型？");
/*
v1.5
*/
define("LABEL_relationEditor", "关系编辑器");
define("LABEL_relationDelete", "删除关系子类型");
define('LABEL_relationSubType', "关系类型");
define('LABEL_relationSubTypeCode', "关系子类型别名");
define('LABEL_relationSubTypeLabel', "关系子类型标记");
define('LABEL_optative', "可选");
define('FORM_JS_confirmDeleteTypeRelation', '删除此关系子类型');
define("LABEL_URItypeEditor", "链接类型编辑器");
define("LABEL_URIEditor", "管理与此词条相关的链接");
define("LABEL_URItypeDelete", "删除链接类型");
define('LABEL_URItype', "链接类型");
define('LABEL_URItypeCode', "链接类型别名");
define('LABEL_URItypeLabel', "链接类型标记");
define('FORM_JS_confirmDeleteURIdefinition', '是否删除此链接类型');
define('LABEL_URI2term', '网络资源');
define('LABEL_URI2termURL', '网络资源链接');
define('LABEL_update1_4x1_5', '更新 (1.4 -> 1.5)');
define('LABEL_Contributor', '贡献者');
define('LABEL_Rights', '版权');
define('LABEL_Publisher', '发布者');
/*
v1.6
*/
define('LABEL_Prev', '上一页');
define('LABEL_Next', '下一页');
define('LABEL_PageNum', '搜索结果数 ');
define('LABEL_selectMapMethod', '选择术语映射方法');
define('LABEL_string2search', '检索式');
define('LABEL_reverseMappign', '反向映射');
define('LABEL_warningMassiverem', '此操作会大规模删除数据且不可撤销！');
define('LABEL_target_terms', '与外部词表的词条建立映射');
define('LABEL_URI2terms', '网络资源');
define('MENU_massiverem', '大规模删除数据');
define('LABEL_more', '更多');
define('LABEL_less', '更少');
define('LABEL_lastChangeDate', '最近修改日期');
define('LABEL_update1_5x1_6', '更新（1.5 -> 1.6）');
define('LABEL_login', '登录');
define('LABEL_user_recovery_password', '生成新密码');
define('LABEL_user_recovery_password1', '请输入用户名或邮箱地址，稍后会通过邮件收到一个生成新密码的链接。');
define('LABEL_mail_recoveryTitle', '密码重置');
define('LABEL_mail_recovery_pass1', '某人请求为以下账户重置密码：');
define('LABEL_mail_recovery_pass2', '用户名：%s');
define('LABEL_mail_recovery_pass3', '如果这是错误提示，请忽略此邮件，不会产生任何操作。');
define('LABEL_mail_recovery_pass4', '要重置密码，请访问以下地址：');
define('LABEL_mail_passTitle', '新密码 ');
define('LABEL_mail_pass1', '新密码 ');
define('LABEL_mail_pass2', '密码：');
define('LABEL_mail_pass3', '你可以进行修改。');
define('MSG_check_mail_link', '检查你的邮件，找到确认链接。');
define('MSG_check_mail', 'If that email address is valid, we will send you an email to reset your password.');
define('MSG_no_mail', '电子邮件未能发送。');
define('LABEL_user_lost_password', '忘记密码？');
## v1.7
define('LABEL_includeMetaTerm', '包含元词条');
define('NOTE_isMetaTerm', '是元词条');
define('NOTE_isMetaTermNote', '元词条是词条的一种。它能描述其他词条，但不能用于索引。例如：引导词条、分面、类目等。');
define('LABEL_turnOffMetaTerm', '取消元词条');
define('LABEL_turnOnMetaTerm', '设为元词条');
define('LABEL_meta_term', '元词条');
define('LABEL_meta_terms', '元词条');
define('LABEL_relatedTerms', '相关词');
define('LABEL_nonPreferedTerms', '非正式词');
define('LABEL_update1_6x1_7', '更新TemaTres（1.6 -> 2.2）');
define('LABEL_include_data', '包括');
define('LABEL_updateEndpoint', '更新SPARQL Endpoint');
define('MSG__updateEndpoint', '数据将进行更新并能通过SPARQL Endpoint进行检索。该操作需要花费几分钟时间。');
define('MSG__updatedEndpoint', 'SPARQL Endpoint已更新');
define('MSG__dateUpdatedEndpoint', 'SPARQL Endpoint最近更新');
define('LABEL__ENABLE_SPARQL', '你必须更新SPARQL Endpoint：菜单->管理->数据库维护->更新SPARQL Endpoint。');
define('MSG__disable_endpoint', 'SPARQL Endpoint已禁用。');
define('MSG__need2setup_endpoint', 'SPARQL Endpoint需要更新，请联系管理员。');
define('LABEL_SPARQLEndpoint', 'SPARQL Endpoint');
define('LABEL_AgregarRTexist', '选择要链接的词条，作为相关词');
define('MENU_selectExistTerm', '选择已有词条');
define("TT_terminos", "族首词");
## v1.72
define('MSG__warningDeleteTerm', '此词条<i>%s</i> 将被 <strong>删除</strong>');
define('MSG__warningDeleteTerm2row', '将删除<strong>所有</strong>词条的注释和关系，此操作不可撤销！');
## v1.8
define('LABEL__getForRecomendation', '词间映射');
define('LABEL__getForRecomendationFor', '词间映射 ');
define('FORM_LABEL__contactMail', '得到建议给');
define('LABEL_addMapLink', '增加词表映射');
define('LABEL_addExactLink', '增加参照链接');
define('LABEL_addSourceNote', '增加来源注释');
## v1.82
define('LABEL_FORM_mappedTermReport', '词表关系');
define('LABEL_eliminar', '删除');
##v.2
define('MSG_termsNoDeleted', 'the terms were not deleted');
define('MSG_termsDeleted', '删除词条');
define('LABEL_selectAll', '选择全部');
define('LABEL_metadatos', '元数据');
define('LABEL_totalTermsDescendants', '派生词');
define('LABEL_altTerms', '交替词');
define('LABEL_narrowerTerms', '下位词');
define('LABEL_results', '结果');
define('LABEL_showFreeTerms', '自由词列表');
define('LABEL_helpSearchFreeTerms', '仅自由词');
define('LABEL_broatherTerms', '上位词');
define('LABEL_type2filter', '根据类型筛选词条');
define('LABEL_defaultEQmap', '输入“eq”来定义等同关系');
define("MSG_repass_error", "密码不正确");
define("MSG_lengh_error", "请输入至少%d个字符");
define("MSG_errorPostData", "检测到错误，请检查此字段的数据。");
define('LABEL_preferedTerms', '正式词');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', '无注释的词条');
define('MSG_FORM_NULLnotesTermReport', '无注释类型的词条');
define('LABELnoNotes', '无注释的词条');
define('LABEL_termsXdeepLevel', '每个层级的词条');
define('LABEL_deepLevel', '层级');
define('LABEL_cantTerms', '#词条数量');
define('LINK_publicKnownVocabularies', '<a href="http://www.vocabularyserver.com/vocabularies/" title="已启用的词表清单" target="_blank">已启用的词表清单</a>');
define('LABEL_showNewsTerm', '显示最近更新');
define('LABEL_newsTerm', '最近更新');
define('MSG_contactAdmin', '联系管理员');
define('LABEL_addTargetVocabulary', '增加外部词表（术语Web Serivces）');
#v.2.1
define('LABEL_duplicatedTerm', '重复词');
define('LABEL_duplicatedTerms', '重复词');
define('MSG_duplicatedTerms', '此词表的配置不允许出现重复词条');
define('LABEL_bulkReplace', '批量编辑器（搜索和替换）');
define('LABEL_searchFor', '搜索和替换的字符串');
define('LABEL_replaceWith', '替换为');
define('LABEL_bulkNotesWillReplace', '待修改的注释');
define('LABEL_bulkNotesReplaced', '已修改的注释');
define('LABEL_bulkTermsWillReplace', '待修改的词条');
define('LABEL_bulkTermsReplaced', '已修改的词条');
define('LABEL_termMOD', '已更新的词条');
define('LABEL_noteMOD', '已更新的注释');
define('MENU_bulkEdition', '批量编辑器');
define('MSG_searchFor', '请输入搜索词（大小写敏感）');
define('MSG_replaceWith', '请输入替换词（大小写敏感）');
define('LABEL_warningBulkEditor', '该操作将修改大量操作，且无法撤销！');
define('LABEL_CFG_SUGGESTxWORD', '根据单词或短语建议词条？');
define('LABEL_ALLOW_DUPLICATED', '启用重复词条？');
define('LABEL_CFG_PUBLISH', '是否发布词表以供任何人查看？');
define('LABEL_Replace', '替换');
define('LABEL_Preview', '预览');
#v.2.2
define('LABEL_selectRelation', '选择类型关系');
define('LABEL_withSelected', '根据所选词条');
define('LABEL_rejectTerms', '拒绝词条');
define('LABEL_doMetaTerm', '转为元词条');
define('LABEL_associateFreeTerms', '关联为UF NTE 或RT');
define('MSG_associateFreeTerms', '下一步可以选择关系类型');
define('MSG_termsSuccessTask', '该过程影响到的词条');
define('LABEL_TTTerms', '族首词');
define('MSG__GLOSSincludeAltLabel', '包含交替词');
define('MSG__GLOSSdocumentationJSON', '借助<a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>使用JSON文件将词汇表添加到任意HTML内容。');
define('LABEL_configGlossary', '导出词汇表源文件');
define('MSG_includeNotes', '使用类型注释：');
define('LABEL_SHOW_RANDOM_TERM', '在首页显示一个随机选中的词条，且要显示出词条的类型。');
define('LABEL_opt_show_rando_term', '显示词条及类型注释：');
define('MSG_helpNoteEditor', '使用双括号链接词条。例如，世间唯[[爱]]能拯救世界。 ');
define('LABEL_GLOSS_NOTES', '选择某种类型注释，用于扩展双括号标记的词条[[glossary]]');
define('LABEL_bulkGlossNotes', '类型注释用于注解');
define('MSG__autoGlossInfo', '该过程会为那些出现在词表注释中的词条之间创建维基链接。例如，世间唯[[爱]]能拯救世界。这是 <strong>大小写敏感</strong>的搜索与替换操作。');
define('MSG__autoGlossDanger', '该过程不可撤销，请在操作之前创建备份。');
define('LABEL_replaceBinary', '大小写敏感');
define('MSG_notesAffected', '受影响的注释');
define('MSG_cantTermsFound', '找到的词条');
define('MENU_glossConfig', '配置自动注解'); /* Used as menu entry. Keep it short */
define('LABEL_generateAutoGlossary', '自动注解生成');
define('LABEL_AlphaPDF', '字顺方式（PDF）');
define('LABEL_SystPDF', '系统方式（PDF）');
define('LABEL_references', '参照');
define('LABEL_printData', '打印日期');
##v.3
define('MENU_bulkTranslate', '多语种编辑器');
define('LABEL_bulkTranslate', '映射与多语种编辑器');
define('LABEL_termsEQ', '包含映射');
define('LABEL_termsNoEQ', '不包含映射');
define('LABEL_close', '关闭');
define('LABEL_allTerms', '所有词条');
define('LABEL_allNotes', '所有注释');
define('LABEL_allRelations', '所有词条关系');
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
define('LABEL__getForTargetVocabularyNews', 'get for news');
define('LABEL__example', 'example');
