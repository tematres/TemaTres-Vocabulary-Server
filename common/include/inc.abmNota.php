<?php
if ((stristr($_SERVER['REQUEST_URI'], "session.php")) || (!defined('T3_ABSPATH'))) {
    die("no access");
}
// TemaTres : aplicación para la gestión de lenguajes documentales
// Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2

// Inicializa array para evitar errores si $editNota es falso
$arrayNota = [];

// SEND_KEY para prevenir duplicados (CSRF)
session_start();
$_SESSION['SEND_KEY'] = bin2hex(random_bytes(32)); // Reemplaza rand() obsoleto

$hidden  = '<input type="hidden" name="idTema" value="' . htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8') . '" />';
$hidden .= '<input type="hidden" name="ks" id="ks" value="' . htmlspecialchars($_SESSION["SEND_KEY"], ENT_QUOTES, 'UTF-8') . '"/>';

$buttons = '';
$cancelLabel = ucfirst(LABEL_Cancelar);

if ($editNota) {
    $arrayNota = ARRAYdatosNota($editNota);

    if ($arrayNota["idNota"]) {
        // Modo edición
        $hidden .= '<input type="hidden" name="idNota" value="' . htmlspecialchars($arrayNota["idNota"], ENT_QUOTES, 'UTF-8') . '" />';
        $hidden .= '<input type="hidden" name="taskNota" value="edit" />';

        $buttons .= '<button type="button" class="btn btn-default" name="cancelar" onClick="location.href=\'index.php?tema=' . htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8') . '\'" value="' . $cancelLabel . '">' . $cancelLabel . '</button>';
        $buttons .= '<a href="index.php?tema=' . htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8') . '&amp;idTema=' . htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8') . '&amp;idNota=' . htmlspecialchars($arrayNota["idNota"], ENT_QUOTES, 'UTF-8') . '&amp;taskNota=rem" role="button" class="btn btn-danger" name="eliminarNota" title="' . LABEL_EliminarNota . '">' . ucfirst(LABEL_EliminarNota) . '</a>';
        $buttons .= '<button type="submit" class="btn btn-primary" name="guardarCambioNota" value="' . LABEL_Cambiar . '">' . ucfirst(LABEL_Cambiar) . '</button>';
    } else {
        // Modo alta
        $hidden .= '<input type="hidden" name="taskNota" value="alta" />';

        $buttons .= '<button type="button" class="btn btn-default" name="cancelar" onClick="location.href=\'index.php?tema=' . htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8') . '\'" value="' . $cancelLabel . '">' . $cancelLabel . '</button>';
        $buttons .= '<button type="submit" class="btn btn-primary" name="LABEL_Enviar" value="' . LABEL_Enviar . '">' . ucfirst(LABEL_Enviar) . '</button>';
    }
}

// Preparación de tipos de nota (mapeo explícito y legible)
$LabelNB = 'NB#' . LABEL_NB;
$LabelNH = 'NH#' . LABEL_NH;
$LabelNA = 'NA#' . LABEL_NA;
$LabelNP = 'NP#' . LABEL_NP;
$LabelNC = 'NC#' . LABEL_NC;

$noteTypeMap = [
    8  => $LabelNA,
    9  => $LabelNH,
    10 => $LabelNB,
    11 => $LabelNP,
    15 => $LabelNC,
];

$sqlNoteType = SQLcantNotas();
$arrayNoteType = [];
while ($array = $sqlNoteType->FetchRow()) {
    $varNoteType = isset($noteTypeMap[$array["value_id"]])
        ? $noteTypeMap[$array["value_id"]]
        : $array["value_code"] . '#' . $array["value"];
    $arrayNoteType[] = $varNoteType;
}

// Fuentes de notas
$sqlNoteSrc = SQLlistSources(1);
$arrayNoteSrc = ["''#SELECCIONAR"];
while ($array_srcs = $sqlNoteSrc->FetchRow()) {
    $arrayNoteSrc[] = $array_srcs["src_id"] . '#' . $array_srcs["src_alias"];
}

// Preparación de idiomas
$arrayLang = [];
foreach ($CFG["ISO639-1"] as $langs) {
    $arrayLang[] = $langs[0] . '#' . $langs[1];
}

// Valores por defecto (usando null coalescing para evitar undefined)
$arrayNota['lang_nota'] = $arrayNota['lang_nota'] ?? ($_SESSION['CFGIdioma'] ?? 'es');
$type_note = $arrayNota['tipo_nota'] ?? ($_SESSION[$_SESSION['CFGURL']]['_GLOSS_NOTES'] ?? 'NA');

// Variables de seguridad para escape en HTML
$temaIdEsc = htmlspecialchars($metadata["arraydata"]["tema_id"] ?? '', ENT_QUOTES, 'UTF-8');
$titTemaEsc = htmlspecialchars($metadata["arraydata"]["titTema"] ?? '', ENT_QUOTES, 'UTF-8');
$notaEsc = htmlspecialchars($arrayNota["nota"] ?? '', ENT_QUOTES, 'UTF-8');

?>
<div class="container" id="bodyText">
    <a class="topOfPage" href="<?php echo URL_BASE; ?>index.php?tema=<?php echo $temaIdEsc; ?>" title="<?php echo LABEL_Anterior; ?>"><?php echo LABEL_Anterior; ?></a>
    <h3><?php echo LABEL_EditorNota; ?></h3>

    <form class="" role="form" name="altaNota" id="altaNota" action="index.php" method="post">
        <div class="row">
            <div class="col-sm-12">
                <legend><?php echo LABEL_EditorNotaTermino; ?> <a href="index.php?tema=<?php echo $temaIdEsc; ?>"><?php echo $titTemaEsc; ?></a></legend>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal">

                        <!-- Tipo de nota -->
                        <div class="form-group">
                            <label for="tipoNota" class="col-sm-2 control-label"><?php echo ucfirst(LABEL_tipoNota); ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="tipoNota" name="<?php echo FORM_LABEL_tipoNota; ?>">
                                    <?php echo doSelectForm($arrayNoteType, $type_note); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Idioma -->
                        <div class="form-group">
                            <label for="idioma" class="col-sm-2 control-label"><?php echo ucfirst(LABEL_Idioma); ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="idioma" name="<?php echo FORM_LABEL_Idioma; ?>">
                                    <?php echo doSelectForm($arrayLang, $arrayNota["lang_nota"]); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Nota (editor) -->
                        <div class="form-group">
                            <label for="<?php echo LABEL_nota; ?>" class="col-sm-2 control-label"><?php echo ucfirst(LABEL_nota); ?></label>
                            <div class="col-sm-10">
                                <span class="help-block"><?php echo MSG_helpNoteEditor; ?></span>
                                <textarea name="<?php echo FORM_LABEL_nota; ?>" rows="20" id="<?php echo LABEL_nota; ?>"><?php echo $notaEsc; ?></textarea>
                            </div>
                        </div>

                        <!-- Fuente (opcional) -->
                        <?php if (count($arrayNoteSrc) > 1) : ?>
                        <div class="form-group">
                            <label for="src_note_id" class="col-sm-2 control-label"><?php echo ucfirst(LABEL_src_note); ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="src_note_id" name="src_note_id">
                                    <?php echo doSelectForm($arrayNoteSrc, $arrayNota["src_id"] ?? null); ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Botones -->
                        <div class="form-group" role="group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <?php echo $buttons; ?>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col-lg-11 -->

            <?php echo $hidden; ?>
        </div><!-- /.row -->
    </form>
</div>