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
define('LABEL_i18n_TranslationAuthor', 'Traduction collaborative pour TemaTres'); /* Can be changed by translators. Do not include emails or personal details */
/* Strings to translate */
define("LANG", "fr");
define("TR_acronimo", "TA"); /* Related Term */
define("TE_acronimo", "TS"); /* Narrower term > Specific term */
define("TG_acronimo", "TG"); /* Broader term > Generic term */
define("UP_acronimo", "EP"); /* Used for > instead */
define("TR_termino", "Terme associé");
define("TE_termino", "Terme spécifique");
define("TG_termino", "Terme générique");
define("UP_termino", "Employé pour"); /* A term with this symbol is followed by non preferred terms (non descriptors) */
/* v 9.5 */
define("USE_termino", "EM"); /* A term with this symbol is followed by a preferred term (descriptor) */
define("MENU_ListaSis", "Liste thématique");
define("MENU_ListaAbc", "Liste alphabétique");
define("MENU_Sobre", "A propos de...");
define("MENU_Inicio", "Accueil");
define("MENU_MiCuenta", "Mon compte");
define("MENU_Usuarios", "Utilisateurs");
define("MENU_NuevoUsuario", "Nouvel utilisateur");
define("MENU_DatosTesauro", "Paramètres du thésaurus");
define("MENU_AgregarT", "Nouveau terme");
define("MENU_EditT", "Éditer le terme");
define("MENU_BorrarT", "Supprimer");
define("MENU_AgregarTG", "Subordonner à un terme");
define("MENU_AgregarTE", "Terme spécifique");
define("MENU_AgregarTR", "Terme associé");
define("MENU_AgregarUP", "Terme alternatif");  /* Non-descriptor */
define("MENU_MisDatos", "Mon compte");
define("MENU_Caducar", "Expirer");
define("MENU_Habilitar", "Autoriser");
define("MENU_Salir", "Déconnexion");
define("LABEL_Menu", "Menu");
define("LABEL_Opciones", "Options");
define("LABEL_Admin", "Administration");
define("LABEL_Agregar", "Ajouter");
define("LABEL_editT", "Édition du terme ");
define("LABEL_EditorTermino", "Editeur de termes");
define("LABEL_Termino", "Terme");
define("LABEL_NotaAlcance", "note d'application");
define("LABEL_EliminarTE", "Supprimer");
define("LABEL_AgregarT", "Ajout d'un ou plusieurs termes");
define("LABEL_AgregarTG", "Ajouter un terme générique à %s ");
define("LABEL_AgregarTE", "Ajouter un terme spécifique à ");
define("LABEL_AgregarUP", "Ajouter un terme non-préférentiel à ");
define("LABEL_AgregarTR", "Ajouter un terme associé à ");
define("LABEL_Detalle", "détails");
define("LABEL_Autor", "Auteur");
define("LABEL_URI", "URI");
define("LABEL_Version", "Réalisé avec");
define("LABEL_Idioma", "Langue");
define("LABEL_Fecha", "Date de création");
define("LABEL_Keywords", "Mots-clés");
define("LABEL_TipoLenguaje", "Type de vocabulaire");
define("LABEL_Cobertura", "Périmètre");
define("LABEL_Terminos", "Termes");
define("LABEL_RelTerminos", "relations entre termes");
define("LABEL_TerminosUP", "termes non-préférentiels");
define("LABEL_BuscaTermino", "Valeur");
define("LABEL_Buscar", "Chercher");
define("LABEL_Enviar", "Valider");
define("LABEL_Cambiar", "Enregistrer les modifications");
define("LABEL_Anterior", "◄ Page précédente");
define("LABEL_AdminUser", "Administration des utilisateurs");
define("LABEL_DatosUser", "Profil de l'utilisateur");
define("LABEL_Acciones", "Tâches réalisées");
define("LABEL_verEsquema", "voir le schéma");
define("LABEL_actualizar", "Mise à jour");
define("LABEL_terminosLibres", "termes libres"); /* 'Free term' usually refers to a term from the natural language, and thus not controlled. This is not exactly what 'termino libre' means in TemaTres. Note: 'orphan' is not good either as it means 'not preferred' */
define("LABEL_busqueda", "Recherche");
define("LABEL_borraRelacion", "Supprimer la relation");
define("MSG_ResultBusca", "terme(s) trouvé(s) lors de la recherche");
define("MSG_ResultLetra", "Lettre");
define("MSG_ResultCambios", "Modifications réussies.");
define("MSG_noUser", "Utilisateur non enregistré");
define("FORM_JS_check", "S'il vous plaît, vérifiez les données de ");
define("FORM_JS_confirm", "Êtes-vous sûr de vouloir supprimer le terme ou la relation ?");
define("FORM_JS_pass", "_mot_de_passe");
define("FORM_JS_confirmPass", "_confirmer_mot_de_passe");
define("FORM_LABEL_termino", "_terme");
define("FORM_LABEL_buscar", "_expression_de_recherche");
define("FORM_LABEL_buscarTermino", "_terme_associe");
define("FORM_LABEL_nombre", "_prenom");
define("FORM_LABEL_apellido", "_nom");
define("FORM_LABEL_mail", "_courrier_electronique");
define("FORM_LABEL_pass", "_mot_de_passe");
define("FORM_LABEL_repass", "_confirmer_mot_de_passe");
define("FORM_LABEL_orga", "orga");
define("LABEL_nombre", "prénom");
define("LABEL_apellido", "nom");
define("LABEL_mail", "adresse électronique");
define("LABEL_pass", "mot de passe");
define("LABEL_repass", "confirmez le mot de passe");
define("LABEL_orga", "organisation");
define("LABEL_lcConfig", "config. vocabulaire");
define("LABEL_lcDatos", "Information sur le thésaurus");
define("LABEL_Titulo", "Titre");
define("FORM_LABEL_Titulo", "_titre");
define("FORM_LABEL_Autor", "_auteur");
define("FORM_LABEL_URI", "_URI");
define("FORM_LABEL_Idioma", "Langue");
define("FORM_LABEL_FechaDia", "jour");
define("FORM_LABEL_FechaMes", "mois");
define("FORM_LABEL_FechaAno", "annee");
define("FORM_LABEL_Keywords", "mots_cles");
define("FORM_LABEL_TipoLenguaje", "langage_type");
define("FORM_LABEL_Cobertura", "domaine");
define("FORM_LABEL_Terminos", "termes");
define("FORM_LABEL_RelTerminos", "relations entre les termes");
define("FORM_LABEL_TerminosUP", "termes exclus");
define("FORM_LABEL_Guardar", "Sauvegarder");
define("LABEL_verDetalle", "voir les détails de ");
define("LABEL_verTerminosLetra", "voir les termes commençant par ");
define("LABEL_NB", "Note bibliographique");
define("LABEL_NH", "Note historique");
define("LABEL_NA", "Note d'application");   /* version 0.9.1 */
define("LABEL_NP", "Note privée"); /* version 0.9.1 */
define("LABEL_EditorNota", "Éditer une note ");
define("LABEL_EditorNotaTermino", "Note du terme ");
define("LABEL_tipoNota", "type");
define("FORM_LABEL_tipoNota", "type_note");
define("LABEL_nota", "note");
define("FORM_LABEL_nota", "_note");
define("LABEL_EditarNota", "Éditer");
define("LABEL_EliminarNota", "Supprimer la note");
define("LABEL_OptimizarTablas", "Optimiser les tables");
define("LABEL_TotalZthesLine", "Thésaurus complet en Zthes");
/* v 9.2 */
define("LABEL_negrita", "gras");
define("LABEL_italica", "italique");
define("LABEL_subrayado", "souligné");
define("LABEL_textarea", "espace de notes");
define("MSGL_relacionIlegal", "Relation non autorisée entre les termes");
/* v 9.3 */
define("LABEL_fecha_modificacion", "modification");
define("LABEL_TotalUsuarios", "Nombre total d'utilisateurs");
define("LABEL_TotalTerminos", "Nombre total de termes");
define("LABEL_ordenar", "ranger par");
define("LABEL_auditoria", "audit du thésaurus");
define("LABEL_dia", "jour");
define("LABEL_mes", "mois");
define("LABEL_ano", "année");
define("LABEL_terminosRepetidos", "termes en doublon");
define("MSG_noTerminosLibres", "Il n'existe pas de termes libres");
define("MSG_noTerminosRepetidos", "Il n'y a pas de termes en doublon");
define("LABEL_TotalSkosLine", "Thésaurus complet en Skos-Core");
$MONTHS=array("01"=>"Jan",
              "02"=>"Fév",
              "03"=>"Mars",
              "04"=>"Avr",
              "05"=>"Mai",
              "06"=>"Juin",
              "07"=>"Juil",
              "08"=>"Août",
              "09"=>"Sept",
              "10"=>"Oct",
              "11"=>"Nov",
              "12"=>"Déc"
              );
/* v 9.4 */
define("LABEL_SI", "OUI");
define("LABEL_NO", "NON");
define("FORM_LABEL_jeraquico", "polyhiérarchie");
define("LABEL_jeraquico", "Polyhiérarchie"); /* Polyhierarchical relationship */
define("LABEL_terminoLibre", "terme libre");
/* v 9.5 */
define("LABEL_URL_busqueda", "Rechercher %s en: ");
/* v 9.6 */
define("LABEL_relacion_vocabulario", "relation avec un autre vocabulaire");
define("FORM_LABEL_relacion_vocabulario", "équivalence");
define("FORM_LABEL_nombre_vocabulario", "vocabulaire cible");
define("LABEL_vocabulario_referencia", "vocabulaire cible");
define("LABEL_NO_vocabulario_referencia", "il n'existe pas de vocabulaire cible pour établir une relation terminologique");
define("FORM_LABEL_tipo_equivalencia", "type d'équivalence");
define("LABEL_vocabulario_principal", "vocabulaire");
define("LABEL_tipo_vocabulario", "type de vocabulaire");
define("LABEL_termino_equivalente", "équivalent");
define("LABEL_termino_parcial_equivalente", "partiellement équivalent");
define("LABEL_termino_no_equivalente", "non équivalent");
define("EQ_acronimo", "EQ"); /* Exact equivalence > inter-language synonymy */
define("EQP_acronimo", "PEQ"); /* Partial equivalence > inter-language quasi-synonymy with a difference in specificity*/
define("NEQ_acronimo", "NEQ"); /*  Non-equivalence */
define("LABEL_NC", "Note du catalogueur");
define("LABEL_resultados_suplementarios", "résultats supplémentaires");
define("LABEL_resultados_relacionados", "résultats associés");
/* v 9.7 */
define("LABEL_export", "export / Publication");
define("FORM_LABEL_format_export", "Format du fichier");
/* v 1.0 */
define("LABEL_fecha_creacion", "created");
define("NB_acronimo", "NB"); /* Bibliographic note */
define("NH_acronimo", "NH"); /* Historical note */
define("NA_acronimo", "NE"); /* Scope or Explanatory note */
define("NP_acronimo", "NP"); /* Private note */
define("NC_acronimo", "NC"); /* Cataloger's note */
define("LABEL_Candidato", "terme candidat");
define("LABEL_Aceptado", "terme accepté");
define("LABEL_Rechazado", "terme rejeté");
define("LABEL_Ultimos_aceptados", "last accepted terms");
define("MSG_ERROR_ESTADO", "non autorisée status");
define("LABEL_Candidatos", "termes candidats");
define("LABEL_Aceptados", "termes acceptés");
define("LABEL_Rechazados", "termes rejetés");
define("LABEL_User_NoHabilitado", "inactif");
define("LABEL_User_Habilitado", "actif");

define("LABEL_CandidatearTermino", "Proposer le terme comme candidat");
define("LABEL_AceptarTermino", "Accepter le terme");
define("LABEL_RechazarTermino", "Rejeter le terme");
/* v 1.01 */
define("LABEL_TERMINO_SUGERIDO", "essayez avec cette orthographe:");
/* v 1.02 */
define("LABEL_esSuperUsuario", "Droits administrateur");
define("LABEL_Cancelar", "Annuler");
define("LABEL_Guardar", "Enregistrer");
/* v 1.033 */
define("MENU_AgregarTEexist", "Subordonner un terme libre");
define("MENU_AgregarUPexist", "Associer un terme non-préférentiel existant");
define("LABEL_existAgregarUP", "Ajouter un terme EP à %s");
define("LABEL_existAgregarTE", "Ajouter un terme spécifique à %s ");
define("MSG_minCharSerarch", "Le texte à rechercher <i>%s</i> n'a que <strong>%s </strong> caractères. Il en faut plus que <strong>%s</strong>");
/* v 1.04 */
define("LABEL_terminoExistente", "terme existant");
define("HELP_variosTerminos", "Saisissez chaque nouveau terme <strong>sur une ligne distincte</strong>.");
/* Install messages */
define("FORM", "Formulaire") ;
define("ERROR", "Erreur") ;
define("LABEL_bienvenida", "Bienvenue sur TemaTres Vocabulary Server") ;
// COMMON SQL
define("PARAM_SERVER", "Adresse du serveur") ;
define("PARAM_DBName", "Nom de la base de données") ;
define("PARAM_DBLogin", "Nom d'utilisateur pour la base de données") ;
define("PARAM_DBPass", "Mot de passe pour la base de données") ;
define("PARAM_DBprefix", "Préfixe pour les tables") ;
$install_message[101] = 'Installation de TemaTres' ;
$install_message[201] = 'Configuration du fichier pour la connection à la base de données introuvable (%s) !';
$install_message[202] = 'Configuration du fichier pour la connection à la base de donnée détectée !';
$install_message[203] = 'Connexion au serveur de bases de données <em>%s</em> impossible avec l\'utilisateur <em>%s</em> ! Veuillez vérifier la configuration du fichier pour la connection à la base de données (%s).';
$install_message[204] = 'Connexion au serveur <em>%s</em> réussie !';
$install_message[205] = 'Connection à la base de données <em>%s</em> du serveur <em>%s</em> impossible ! Veuillez vérifier la configuration du fichier pour la connection à la base de données (%s).';
$install_message[206] = 'Connection à la base de données <em>%s</em> du serveur <em>%s</em> réussie !' ;
$install_message[301] = 'Grrr... Il y a déjà une instance Tematres pour cette configuration. Veuillez vérifier la configuration du fichier pour la connexion à la base de données (%s) ou <a href="index.php">Accéder à votre serveur Tematres</a>' ;
$install_message[305] = 'Verification du mot de passe de sécurité en cours.' ;
$install_message[306] = 'Installation terminée ! <a href="index.php">Accéder à votre serveur Tematres</a>' ;
/* end Install messages */
/* v 1.1 */
define('MSG_ERROR_CODE', "code invalide");
define('LABEL_CODE', "code");
define('LABEL_Ver', "Afficher");
define('LABEL_OpcionesTermino', "terme");
define('LABEL_CambiarEstado', "Changer le statut");
define('LABEL_ClickEditar', "Cliquez pour éditer...");
define('LABEL_TopTerm', "Terme de tête");
define('LABEL_esFraseExacta', "expression exacte");
define('LABEL_DesdeFecha', "créé en ... ou après");
define('LABEL_ProfundidadTermino', "est situé au niveau");
define('LABEL_esNoPreferido', "Terme non-préférentiel");
define('LABEL_BusquedaAvanzada', "recherche avancée");
define('LABEL_Todos', "- - - -");
define('LABEL_QueBuscar', "Critère de recherche");
define("LABEL_import", "Importer") ;
define("IMPORT_form_legend", "Importer un thésaurus à partir d'un fichier") ;
define("IMPORT_form_label", "Fichier") ;
define("IMPORT_file_already_exists", "Un fichier txt est déjà présent sur le serveur") ;
define("IMPORT_file_not_exists", "Aucun fichier à importer pour le moment") ;
define("IMPORT_do_it", "Vous pouvez lancer l'import") ;
define("IMPORT_working", "suite automatique en cours") ;
define("IMPORT_finish", "Fin de l'insertion") ;
define("LABEL_reIndice", "recréer les index") ;
define("LABEL_dbMantenimiento", "base de données");  /* Used as menu entry. Keep it short */
/*
v 1.2
*/
define('LABEL_relacion_vocabularioWebService', "Lier à un terme d\\'un vocabulaire distant");
define('LABEL_vocabulario_referenciaWS', "vocabulaire distant (service web)");
define('LABEL_TargetVocabularyWS', "vocabulaire distant (services web)");
define('LABEL_tvocab_label', "intitulé de la référence");
define('LABEL_tvocab_tag', "étiquette p");
define('LABEL_tvocab_uri_service', "URL du service web");
define('LABEL_targetTermsforUpdate', "termes à Mise à jour");
define('LABEL_ShowTargetTermsforUpdate', "vérifier les mises à jour");
define('LABEL_enable', "actif");  /* web services status info: in use */
define('LABEL_disable', "inactif");  /* web services status info: not in use */
define('LABEL_notFound', "terme non trouvé");
define('LABEL_termUpdated', "terme mis à jour");
define('LABEL_ShowTargetTermforUpdate', "Mise à jour");
define('LABEL_relbetweenVocabularies', "relations entre vocabulaires");
define('LABEL_update1_1x1_2', "Mise à jour 1.1 -> 1.3");
define('LABEL_update1x1_2', "Mise à jour 1.0 -> 1.3");
define('LABEL_TargetTerm', "terme correspondant)");
define('LABEL_TargetTerms', "termes (correspondants)");
define('LABEL_seleccionar', 'choisir');
define('LABEL_poliBT', 'Termes appartenant à plusieurs termes génériques');
define('LABEL_FORM_simpleReport', 'Rapports');
define('LABEL_FORM_advancedReport', 'rapports avancés');
define('LABEL_FORM_nullValue', 'pas de filtrage');
define('LABEL_FORM_haveNoteType', 'ayant une note de type');
define('LABEL_haveEQ', 'ayant un équivalent');
define('LABEL_nohaveEQ', 'sans équivalent');
define('LABEL_start', 'commençant par');
define('LABEL_end', 'finissant par');
define('LABEL_equalThisWord', 'correspondance exacte');
define('LABEL_haveWords', 'contenant les mots');
define('LABEL_encode', 'encodage');
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
define('LABEL_termsxNTterms', 'nombre de termes spécifiques de chaque terme');
define('LABEL_termsNoBT', 'Termes sans relations hiérarchiques');
define('MSG_noTermsNoBT', 'Il n\'y a pas de termes sans relations hiérarchiques');
define('LABEL_termsXcantWords', 'nombre de mots de chaque terme');
define('LABEL__USE_CODE', 'Toujours utiliser les codes pour ordonner les termes');
define('LABEL__SHOW_CODE', 'Montrer les codes des termes aux utilisateurs non connectés');
define('LABEL_CFG_MAX_TREE_DEEP', 'Nombre maximum de niveaux hiérarchiques pouvant être affichés sur la même page');
define('LABEL_CFG_VIEW_STATUS', 'Montrer les statuts aux utilisateurs non connectés');
define('LABEL_CFG_SIMPLE_WEB_SERVICE', 'activer les services web');
define('LABEL_CFG_NUM_SHOW_TERMSxSTATUS', 'Nombre de termes à afficher dans la vue par statut');
define('LABEL_CFG_MIN_SEARCH_SIZE', 'Nombre minimal de caractères pour la recherche');
define('LABEL__SHOW_TREE', 'Afficher la vue hiérarchique sur la page d\'accueil');
define('LABEL__PUBLISH_SKOS', 'activer le format de service web SKOS Core (ceci ouvre potentiellement l\'accès à tout votre vocabulaire).');
define('LABEL_update1_3x1_4', "Mise à jour 1.3 -> 1.4");
define("FORM_LABEL_format_import", "Choisissez le format");
define("LABEL_importTab", "texte tabulé");
define("LABEL_importTag", "texte étiqueté");
define("LABEL_importSkos", "Skos-core");
define("LABEL_configTypeNotes", "config. des types de notes");
define("LABEL_notes", "notes");
define("LABEL_saved", "Votre modification a bien été prise en compte");
define("FORM_JS_confirmDeleteTypeNote", "eliminate this type of note?");
/*
v1.5
*/
define("LABEL_relationEditor", "Config. des sous-types de relations");
define("LABEL_relationDelete", "Supprimer ce sous-type");
define('LABEL_relationSubType', "Type de relation");
define('LABEL_relationSubTypeCode', "Alias");
define('LABEL_relationSubTypeLabel', "Intitulé du sous-type");
define('LABEL_optative', "facultatif");
define('FORM_JS_confirmDeleteTypeRelation', 'Supprimer ce sous-type de relation ?');
define("LABEL_URItypeEditor", "Config. des types de liens");
define("LABEL_URIEditor", "gérer les liens associés au terme");
define("LABEL_URItypeDelete", "supprimer ce type de lien");
define('LABEL_URItype', "type de lien");
define('LABEL_URItypeCode', "alias");
define('LABEL_URItypeLabel', "intitulé du type de lien");
define('FORM_JS_confirmDeleteURIdefinition', 'supprimer ce type de lien ?');
define('LABEL_URI2term', 'ressource web');
define('LABEL_URI2termURL', 'URL de la ressource web');
define('LABEL_update1_4x1_5', 'Mise à jour 1.4 -> 1.5');
define('LABEL_Contributor', 'Contributeur');
define('LABEL_Rights', 'Droits');
define('LABEL_Publisher', 'Éditeur');
/*
v1.6
*/
define('LABEL_Prev', 'précédent');
define('LABEL_Next', 'suivant');
define('LABEL_PageNum', 'nombre de page(s) de résultats ');
define('LABEL_selectMapMethod', 'choisissez une méthode pour mettre en correspondance les termes');
define('LABEL_string2search', 'expression à rechercher');
define('LABEL_reverseMappign', 'correspondance inverse');
define('LABEL_warningMassiverem', 'Vous êtes sur le point de supprimer des données en masse. Cette action est irréversible !');
define('LABEL_target_terms', 'termes correspondants dans les vocabulaires distants');
define('LABEL_URI2terms', 'ressources web');
define('MENU_massiverem', 'Supprimer en masse');
define('LABEL_more', 'plus');
define('LABEL_less', 'moins');
define('LABEL_lastChangeDate', 'Date de modification');
define('LABEL_update1_5x1_6', 'Mise à jour 1.5 -> 1.6');
define('LABEL_login', 'connexion');
define('LABEL_user_recovery_password', 'Demander un nouveau mot de passe');
define('LABEL_user_recovery_password1', 'Veuillez saisir votre nom d\'utilisateur ou votre adresse électronique afin que nous puissions vous envoyer un lien pour réinitialiser votre mot de passe.');
define('LABEL_mail_recoveryTitle', 'Réinitialisation du mot de passe');
define('LABEL_mail_recovery_pass1', 'Une demande de réinitialisation du mot de passe a été effectuée pour le compte suivant :');
define('LABEL_mail_recovery_pass2', 'Nom d\'utilisateur : %s');
define('LABEL_mail_recovery_pass3', 'Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez sans risque ignorer ce message.');
define('LABEL_mail_recovery_pass4', 'Pour procéder à la réinitialisation du mot de passe, veuillez cliquer sur le lien ci-dessous : ');
define('LABEL_mail_passTitle', 'Nouveau mot de passe ');
define('LABEL_mail_pass1', 'Nouveau mot de passe pour ');
define('LABEL_mail_pass2', 'Mot de passe : ');
define('LABEL_mail_pass3', 'Il peut être changé.');
define('MSG_check_mail_link', 'Un lien permettant de confirmer votre adresse électronique vous a été envoyé. Veuillez vérifier votre boîte de réception.');
define('MSG_check_mail', 'If that email address is valid, we will send you an email to reset your password.');
define('MSG_no_mail', 'L\'envoi du courrier électronique a échoué.');
define('LABEL_user_lost_password', 'Mot de passe oublié ?');
## v1.7
define('LABEL_includeMetaTerm', 'Inclure les métatermes');
define('NOTE_isMetaTerm', 'Métaterme.');
define('NOTE_isMetaTermNote', 'Un métaterme est un terme ne servant pas à l\'indexation mais à la description des autres termes : termes structurants, facettes, catégories, etc.');
define('LABEL_turnOffMetaTerm', 'Enlever le marquage métaterme');
define('LABEL_turnOnMetaTerm', 'Marquer comme métaterme');
define('LABEL_meta_term', 'métaterme');
define('LABEL_meta_terms', 'métatermes');
define('LABEL_relatedTerms', 'termes associés');
define('LABEL_nonPreferedTerms', 'termes non-préférentiels');
define('LABEL_update1_6x1_7', 'Mise à jour 1.6 -> 2.2');
define('LABEL_include_data', 'inclure');
define('LABEL_updateEndpoint', 'MAJ serveur SPARQL');
define('MSG__updateEndpoint', 'Les données vont être mises à jour et rendues disponibles via le serveur SPARQL. Cette opération peut prendre plusieurs minutes.');
define('MSG__updatedEndpoint', 'Le serveur SPARQL a été mis à jour.');
define('MSG__dateUpdatedEndpoint', 'Dernière Mise à jour du serveur SPARQL');
define('LABEL__ENABLE_SPARQL', 'Activer SPARQL. Pour la mise à jour du serveur, visitez la page Menu -> Administration -> Base de données -> MAJ serveur SPARQL.');
define('MSG__disable_endpoint', 'Le serveur SPARQL est désactivé.');
define('MSG__need2setup_endpoint', 'Le serveur SPARQL doit être mis à jour. Veuillez contacter l\'administrateur.');
define('LABEL_SPARQLEndpoint', 'serveur SPARQL');
define('LABEL_AgregarRTexist', 'Rechercher le terme à associer à ');
define('MENU_selectExistTerm', 'Terme existant');
define("TT_terminos", "termes de tête");
## v1.72
define('MSG__warningDeleteTerm', 'Le terme <i>%s</i> va être définitivement <strong>SUPPRIMÉ</strong>.');
define('MSG__warningDeleteTerm2row', '<strong>Toutes</strong> les notes et relations seront également supprimées. Ces actions sont irréversibles !');
## v1.8
define('LABEL__getForRecomendation', 'rechercher des suggestions');
define('LABEL__getForRecomendationFor', 'rechercher des suggestions pour ');
define('FORM_LABEL__contactMail', 'Adresse électronique de contact');
define('LABEL_addMapLink', 'add mapping between vocabularies');
define('LABEL_addExactLink', 'add reference link');
define('LABEL_addSourceNote', 'add source note');
## v1.82
define('LABEL_FORM_mappedTermReport', 'Relations entre vocabulaires');
define('LABEL_eliminar', 'Supprimer');
##v.2
define('MSG_termsNoDeleted', 'le terme n\'a pas été effacé');
define('MSG_termsDeleted', 'terme(s) supprimé(s)');
define('LABEL_selectAll', 'Sélectionner tout');
define('LABEL_metadatos', 'métadonnées');
define('LABEL_totalTermsDescendants', 'termes descendants');
define('LABEL_altTerms', 'termes non-préférentiels');
define('LABEL_narrowerTerms', 'termes spécifiques');
define('LABEL_results', 'résultats');
define('LABEL_showFreeTerms', 'liste des termes libres');
define('LABEL_helpSearchFreeTerms', 'La recherche ne portera que sur les termes libres.');
define('LABEL_broatherTerms', 'termes génériques');
define('LABEL_type2filter', 'filtrer la liste');
define('LABEL_defaultEQmap', 'Taper "eq" pour définir une relation d\'équivalence');
define("MSG_repass_error", "les deux mots de passe ne correspondent pas");
define("MSG_lengh_error", "%d caractères minimum");
define("MSG_errorPostData", "A mistake was detected, Please review the data to the field ");
define('LABEL_preferedTerms', 'termes préférentiels');   /* Descriptor */
define('LABEL_FORM_NULLnotesTermReport', 'termes sans notes');
define('MSG_FORM_NULLnotesTermReport', 'termes sans note de type');
define('LABELnoNotes', 'termes sans aucune note');
define('LABEL_termsXdeepLevel', 'nombre de termes par niveau');
define('LABEL_deepLevel', 'niveau');
define('LABEL_cantTerms', 'Nb de termes');
define('LINK_publicKnownVocabularies', '<a href="http://www.vocabularyserver.com/vocabularies/" title="Liste des vocabulaires contrôlés connus" target="_blank">Liste des vocabulaires contrôlés connus</a>');
define('LABEL_showNewsTerm', 'afficher les modifications récentes');
define('LABEL_newsTerm', 'modifications récentes');
define('MSG_contactAdmin', 'contacter l\'administrateur');
define('LABEL_addTargetVocabulary', 'ajouter un vocabulaire distant (service web)');
#v.2.1
define('LABEL_duplicatedTerm', 'terme en doublon');
define('LABEL_duplicatedTerms', 'termes en doublon');
define('MSG_duplicatedTerms', 'La configuration du vocabulaire interdit de créer des doublons.');
define('LABEL_bulkReplace', 'Édition en masse');
define('LABEL_searchFor', 'texte à rechercher');
define('LABEL_replaceWith', 'Remplacer par');
define('LABEL_bulkNotesWillReplace', 'notes vont être modifiées');
define('LABEL_bulkNotesReplaced', 'notes ont été modifiées');
define('LABEL_bulkTermsWillReplace', 'termes vont être modifiés');
define('LABEL_bulkTermsReplaced', 'termes ont été modifiés');
define('LABEL_termMOD', 'terme après modification');
define('LABEL_noteMOD', 'note après modification');
define('MENU_bulkEdition', 'Édition en masse');
define('MSG_searchFor', 'La recherche est sensible à la casse');
define('MSG_replaceWith', 'Texte à mettre à la place (sensible à la casse)');
define('LABEL_warningBulkEditor', 'Vous êtes sur le point de modifier des données en masse. Cette action est irréversible !');
define('LABEL_CFG_SUGGESTxWORD', 'suggérer les terms par mots ou expressions?');
define('LABEL_ALLOW_DUPLICATED', 'Autoriser les termes en doublon?');
define('LABEL_CFG_PUBLISH', 'Montrer le vocabulaire aux utilisateurs non connectés?');
define('LABEL_Replace', 'remplacer');
define('LABEL_Preview', 'visualiser');
#v.2.2
define('LABEL_selectRelation', 'sélectionner le type de relation');
define('LABEL_withSelected', 'Traitement sur les termes sélectionnés :');
define('LABEL_rejectTerms', 'rejeter les termes');
define('LABEL_doMetaTerm', 'marquer comme metatermes');
define('LABEL_associateFreeTerms', 'Associer comme EP, TS ou TA');
define('MSG_associateFreeTerms', 'Recherchez d\'abord le terme à associer, puis choisissez le type de relation.');
define('MSG_termsSuccessTask', 'termes ont été traités');
define('LABEL_TTTerms', 'Termes de tête');
define('MSG__GLOSSincludeAltLabel', 'inclure les termes non-préférentiels');
define('MSG__GLOSSdocumentationJSON', 'Avec ce fichier JSON et <a href="https://github.com/PebbleRoad/glossarizer" target="_blank" title="Glossarizer">Glossarizer</a>, vous pouvez intégrer votre glossaire à n\'importe quelle page web');
define('LABEL_configGlossary', 'Télécharger le glossaire');
define('MSG_includeNotes', 'types de notes contenant les définitions à inclure dans le glossaire:');
define('LABEL_SHOW_RANDOM_TERM', 'afficher sur la page d\'accueil un terme choisi au hasard.');
define('LABEL_opt_show_rando_term', 'montrer des termes ayant une note de type:');
define('MSG_helpNoteEditor', 'Utilisez une double paire de crochets pour faire un lien vers d\'autres termes. Exemple : L\'argent est [[roi]]');
define('LABEL_GLOSS_NOTES', 'Type des notes utilisées pour définir les [[termes placés entre une double paire de crochets]]');
define('LABEL_bulkGlossNotes', 'notes à wikifier');
define('MSG__autoGlossInfo', 'Les termes du vocabulaire apparaissant dans les notes vont être transformés en [[hyperliens]] pointant vers la fiche du terme en question. Note : la recherche est <strong>sensible</strong> à la casse.');
define('MSG__autoGlossDanger', 'Cette opération étant irréversible, il est conseillé de faire une sauvegarde AVANT!');
define('LABEL_replaceBinary', 'sensible à la casse');
define('MSG_notesAffected', 'notes modifiées');
define('MSG_cantTermsFound', 'termes trouvés');
define('MENU_glossConfig', 'Glossaire'); /* Used as menu entry. Keep it short */
define('LABEL_generateAutoGlossary', 'Ajouter des liens dans les notes');
define('LABEL_AlphaPDF', 'alphabétique (PDF)');
define('LABEL_SystPDF', 'systématique (PDF)');
define('LABEL_references', 'références');
define('LABEL_printData', 'date d\'impression');
##v.3
define('MENU_bulkTranslate', 'éditeur multilingue');
define('LABEL_bulkTranslate', 'concordants et éditeur multilingue');
define('LABEL_termsEQ', 'avec concordants');
define('LABEL_termsNoEQ', 'sans concordants');
define('LABEL_close', 'fermer');
define('LABEL_allTerms', 'tous les termes');
define('LABEL_allNotes', 'Tous les notes');
define('LABEL_allRelations', 'toutes les relations entre termes');
#v.3.1
define('LABEL_noResults', 'Désolé, aucun résultat trouvé');
define('LABEL_globalOrganization', 'organisation générale du vocabulaire');
define('LABEL_rel_associative', 'relations associatives');
define('LABEL_rel_hierarchical', 'relations hiérarchiques');
define('LABEL_rel_synonymy', 'relations synonymiques');
define('LABEL_prototypeTerms', 'termes centraux');
define('LABEL_copy_click', 'copier le terme dans le presse-papier');
define('LABEL__ENABLE_COPY_CLICK', 'Activer le bouton de copie des termes dans le presse-papier.');
#v.3.2
define('LABEL_order', 'ordre');
define('LABEL_alias', 'alias');
define('LEGEND_alias', 'saisissez un alias court');
define('LABEL_src_note', 'source');
define('LEGEND_src_note', 'Saisissez la référence bibliographique');
define('LABEL_source', 'sources d\'autorité normalisées');
define('LABEL_source4term', 'sources de référence pour les termes');
define('LABEL_add_new', 'Ajouter');
define('LABEL_sources4vocab', 'sources de référence');
define('LABEL_update2_2x3_2', 'mise à jour 2.x -> 3.2');
define('LABEL__getForTargetVocabularyNews', 'get for news');
define('LABEL__example', 'example');
