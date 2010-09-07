
<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Formulario de alta de notas #
#
  $ARRAYTermino=ARRAYverTerminoBasico($_GET[tema]);
  $hidden='<input type="hidden"  name="idTema" value="'.$ARRAYTermino[idTema].'" />';

  if($editNota){
    $arrayNota=ARRAYdatosNota($editNota);
    if($arrayNota[idNota]){//Edicion
    $hidden.='<input type="hidden" name="idNota" value="'.$arrayNota[idNota].'" />';
    $hidden.='<input type="hidden" name="modNota" value="1" />';

    $hidden.='<input type="submit"  name="guardarCambioNota" value="'.LABEL_Cambiar.'"/>';
    $hidden.=' | <input type="submit"  name="eliminarNota" value="'.LABEL_EliminarNota.'"/>';
    $hidden.=' | <input type="button"  name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYTermino[idTema].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>';
    }else{
    $hidden.='<input type="hidden" name="altaNota" value="1" />';
    $hidden.='<input type="submit"  name="boton" value="'.LABEL_Enviar.'"/>';
    $hidden.=' | <input type="button"  name="cancelar" type="button" onClick="location.href=\'index.php?tema='.$ARRAYTermino[idTema].'\'" value="'.ucfirst(LABEL_Cancelar).'"/>';
    }
  };


  $LabelNB='NB#'.LABEL_NB;
  $LabelNH='NH#'.LABEL_NH;
  $LabelNA='NA#'.LABEL_NA;
  $LabelNP='NP#'.LABEL_NP;
  $LabelNC='NC#'.LABEL_NC;

// Preparado de datos para el formulario ///
$arrayLang=array();
foreach ($idiomas_disponibles AS $key => $value) {
	array_push($arrayLang,"$value[2]#$value[0]");
	};
//idioma de la nota
$arrayNota[lang_nota] = (!$arrayNota[lang_nota]) ? $_SESSION["CFGIdioma"] : $arrayNota[lang_nota];

  ?>
<div id="bodyText">
<a class="topOfPage" href="javascript: history.go(-1);"><?php echo LABEL_Anterior;?></a>
<h1><?php echo LABEL_EditorNota ;?></h1>
  <fieldset>
    <legend>  <?php echo LABEL_EditorNotaTermino.' <a href="'.$PHP_SELF.'?tema='.$ARRAYTermino[idTema].'">'.$ARRAYTermino[titTema].'</a>';?>  </legend>
          <form class="formdiv" name="altaNota" action="index.php" method="POST">
                       <div>
                        <label for="<?php echo LABEL_tipoNota;?>" accesskey="t">
                        <?php echo LABEL_tipoNota;?>*</label>
                          <select id="tipoNota" name="<?php echo FORM_LABEL_tipoNota;?>">
                          <optgroup label="<?php echo LABEL_tipoNota;?>">
                           <?php
                           echo doSelectForm(array("$LabelNA","$LabelNH","$LabelNB","$LabelNC","$LabelNP"),$arrayNota[tipo_nota]);
                           ?>
                           </optgroup>
                           </select>
                          </div>
			<div>
			<label for="<?php echo FORM_LABEL_Idioma;?>" accesskey="l"><?php echo LABEL_Idioma;?></label>
				<select id="<?php echo FORM_LABEL_Idioma;?>" name="<?php echo FORM_LABEL_Idioma;?>">
				<optgroup label="<?php echo LABEL_Idioma;?>">
			<?php
			echo doSelectForm($arrayLang,$arrayNota[lang_nota]);
				?>
				</optgroup>
				</select>
			</div>

                          <div>
<!--                         <label for="<?php echo LABEL_nota;?>" accesskey="n"><?php echo LABEL_nota;?>*</label> -->
	<p>
			<textarea cols="60" name="<?php echo FORM_LABEL_nota;?>" rows="15" id="<?php echo LABEL_nota;?>"><?php echo $arrayNota[nota];?></textarea>
	</p>
			</div>
<div class="submit_form" align="center">
                            <?php echo $hidden;?>
</div>
                       </form>
  </fieldset>
</div>
