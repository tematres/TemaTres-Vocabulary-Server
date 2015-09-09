<?php
if ((stristr( $_SERVER['REQUEST_URI'], "session.php") ) || ( !defined('T3_ABSPATH') )) die("no access");
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#
###############################################################################################################
# Formulario de alta de notas #
#
 //SEND_KEY to prevent duplicated
  session_start();
  $_SESSION['SEND_KEY']=md5(uniqid(rand(), true));

  $hidden='<input type="hidden"  name="idTema" value="'.$metadata["arraydata"]["tema_id"].'" />';
  $hidden.='<input type="hidden"  name="ks" id="ks" value="'.$_SESSION["SEND_KEY"].'"/>';

  if($editNota){
    $arrayNota=ARRAYdatosNota($editNota);

    if($arrayNota[idNota]){//Edicion
		$hidden.='<input type="hidden" name="idNota" value="'.$arrayNota["idNota"].'" />';
		$hidden.='<input type="hidden" name="taskNota" value="edit" />';

    $buttons.='<button type="submit" class="btn btn-primary" name="guardarCambioNota" value="'.LABEL_Cambiar.'"/>'.ucfirst(LABEL_Cambiar).'</button>';
    $buttons.='<a href="index.php?tema='.$metadata["arraydata"]["tema_id"].'&amp;idTema='.$metadata["arraydata"]["tema_id"].'&amp;idNota='.$arrayNota["idNota"].'&amp;taskNota=rem" role="button" class="btn btn-danger" name="eliminarNota" title="'.LABEL_EliminarNota.'"/>'.ucfirst(LABEL_EliminarNota).'</a>';
    $buttons.='<button type="button" class="btn btn-default"  name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$metadata["arraydata"]["tema_id"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>';

    }else{
		$hidden.='<input type="hidden" name="taskNota" value="alta" />';
    $buttons.='<button type="submit" class="btn btn-primary" name="LABEL_Enviar" value="'.LABEL_Enviar.'"/>'.ucfirst(LABEL_Enviar).'</button>';
    $buttons.='<button type="button" class="btn btn-default"  name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$metadata["arraydata"]["tema_id"].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>'.ucfirst(LABEL_Cancelar).'</button>';

    }
  };

  $LabelNB='NB#'.LABEL_NB;
  $LabelNH='NH#'.LABEL_NH;
  $LabelNA='NA#'.LABEL_NA;
  $LabelNP='NP#'.LABEL_NP;
  $LabelNC='NC#'.LABEL_NC;

  $sqlNoteType=SQLcantNotas();
  $arrayNoteType=array();

  while ($array=$sqlNoteType->FetchRow()){
  		 $varNoteType=(in_array($array["value_id"],array(8,9,10,11,15))) ? arrayReplace(array(8,9,10,11,15),array($LabelNA,$LabelNH,$LabelNB,$LabelNP,$LabelNC),$array["value_id"]) : $array["value_code"].'#'.$array["value"];
    	 array_push($arrayNoteType, $varNoteType);
  };

// Preparado de datos para el formulario ///
$arrayLang=array();
foreach ($CFG["ISO639-1"] as $langs) {
	array_push($arrayLang,"$langs[0]#$langs[1]");
	};
//idioma de la nota
$arrayNota[lang_nota] = (!$arrayNota[lang_nota]) ? $_SESSION["CFGIdioma"] : $arrayNota[lang_nota];
?>
<div class="container" id="bodyText">
<a class="topOfPage" href="index.php?tema=<?php echo $metadata["arraydata"]["tema_id"];?>" title="<?php echo LABEL_Anterior;?>"><?php echo LABEL_Anterior;?></a>
<h3><?php echo LABEL_EditorNota ;?></h3>
<form class="" role="form" name="altaNota" id="altaNota" action="index.php" method="post">
	<div class="row">
    <div class="col-sm-12">
        <legend> <?php echo LABEL_EditorNotaTermino.' <a href="index.php?tema='.$metadata["arraydata"]["tema_id"].'">'.$metadata["arraydata"]["titTema"].'</a>';?></legend>
    </div>
    <!-- panel  -->

    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-body form-horizontal">

            <div class="form-group">
            <label for="<?php echo LABEL_tipoNota;?>" class="col-sm-3 control-label"><?php echo ucfirst(LABEL_tipoNota);?></label>
                <div class="col-sm-9">
                    <select class="form-control" id="tipoNota" name="<?php echo FORM_LABEL_tipoNota;?>">
                      <?php echo doSelectForm($arrayNoteType,$arrayNota["tipo_nota"]);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
            <label for="<?php echo FORM_LABEL_Idioma;?>" class="col-sm-3 control-label"><?php echo ucfirst(LABEL_Idioma);?></label>
                <div class="col-sm-9">
                    <select class="form-control" id="<?php echo FORM_LABEL_Idioma;?>" name="<?php echo FORM_LABEL_Idioma;?>">
                      <?php echo doSelectForm($arrayLang,$arrayNota["lang_nota"]);?>
                    </select>
                </div>
            </div>
                <div class="form-group">
                    <label for=""<?php echo LABEL_nota;?>" class="col-sm-3 control-label"><?php echo ucfirst(LABEL_nota);?></label>
                    <div class="col-sm-9">
                      <textarea style="width:100%" cols="60" name="<?php echo FORM_LABEL_nota;?>" rows="15" id="<?php echo LABEL_nota;?>"><?php echo $arrayNota["nota"];?></textarea>
                    </div>
                </div>
                <div class="form-group" role="group" >
                    <div class="col-sm-12 text-right">
                      <div class="btn-group">
                      <?php echo $buttons;?>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / panel  -->
<?php echo $hidden;?>
</form>

</div>
