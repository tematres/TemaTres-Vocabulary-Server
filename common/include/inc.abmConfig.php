<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
#

// Preparado de datos para el formulario ///
$arrayLang=array();
foreach ($idiomas_disponibles AS $key => $value) {
	array_push($arrayLang,"$value[2]#$value[0]");
	};
$si=LABEL_SI;
$no=LABEL_NO;

if($_GET[vocabulario_id]>0){
	$sql_vocabulario=SQLdatosVocabulario($_GET[vocabulario_id]);
	$array_vocabulario=mysqli_fetch_array($sql_vocabulario[datos]);
	$fecha_crea=do_fecha($array_vocabulario[cuando]);
	}else{
	$array_vocabulario[vocabulario_id]='NEW';
	}

if($array_vocabulario[vocabulario_id]==1){
	$titulo_formulario=LABEL_vocabulario_principal;
	}else{
	$titulo_formulario=LABEL_vocabulario_referencia;
	}

$array_ano=do_intervalDate("1998",date(Y),FORM_LABEL_FechaAno);
$array_dia=do_intervalDate("1","31",FORM_LABEL_FechaDia);
$array_mes=do_intervalDate("1","12",FORM_LABEL_FechaMes);
?>
<h1><?php echo ucfirst(LABEL_lcConfig).' '.$titulo_formulario;?></h1>

<fieldset>
  <legend><?php echo ucfirst(LABEL_lcConfig).' '.$titulo_formulario;?></legend>
    <form name="abm_config" action="<?php echo $PHP_SELF;?>" method="post" onsubmit="return checkrequired(this)">
<div>
        <label for="titulo" accesskey="t"><?php echo LABEL_Titulo;?></label>
        <input id="titulo"
    name="<?php echo FORM_LABEL_Titulo;?>"
    size="40"
    maxlength="150"
    value="<?php echo $array_vocabulario[titulo];?>"
    />
    </div>
<div>
       <label for="autor" accesskey="a"><?php echo LABEL_Autor;?></label>
        <input id="autor"
    name="<?php echo FORM_LABEL_Autor;?>"
    size="40"
    maxlength="150"
    value="<?php echo $array_vocabulario[autor];?>"
    />
</div>
<div>
     <label for="<?php echo FORM_LABEL_Idioma;?>" accesskey="l"><?php echo LABEL_Idioma;?></label>
        <select id="<?php echo FORM_LABEL_Idioma;?>" name="<?php echo FORM_LABEL_Idioma;?>">
         <optgroup label="<?php echo LABEL_Idioma;?>">
    <?php
    echo doSelectForm($arrayLang,$array_vocabulario[idioma]);
        ?>
        </optgroup>
        </select>
</div>
<div>

     <label for="dia" accesskey="f"><?php echo LABEL_Fecha;?></label>
    <select name="<?php echo FORM_LABEL_FechaDia;?>"
     id="dia">
	<optgroup label="<?php echo LABEL_dia;?>">
         <?php
          echo doSelectForm($array_dia,"$fecha_crea[dia]");
          ?>
        </optgroup>
     </select>
        /
         <select name="<?php echo FORM_LABEL_FechaMes;?>"
     id="mes">
	<optgroup label="<?php echo LABEL_mes;?>">
         <?php
          echo doSelectForm($array_mes,"$fecha_crea[mes]");
          ?>
        </optgroup>
     </select>
        /
    <select name="<?php echo FORM_LABEL_FechaAno;?>"
     id="ano">
	<optgroup label="<?php echo LABEL_ano;?>">
         <?php
          echo doSelectForm($array_ano,"$fecha_crea[ano]");
          ?>
        </optgroup>
     </select>
   </div>
<div>

     <label for="keywords" accesskey="k"><?php echo LABEL_Keywords;?></label>
        <input id="keywords"
    name="<?php echo FORM_LABEL_Keywords;?>"
    size="40"
    maxlength="256"
    value="<?php echo $array_vocabulario[keywords];?>"
    />
</div>

 <div>
     <label for="tipo_lang" accesskey="l"><?php echo LABEL_TipoLenguaje;?></label>
        <input id="tipo_lang"
    name="<?php echo FORM_LABEL_TipoLenguaje;?>"
    size="40"
    maxlength="150"
    value="<?php echo $array_vocabulario[tipo];?>"
    />
</div>
<div>

     <label for="<?php echo FORM_LABEL_jeraquico;?>" accesskey="j"><?php echo LABEL_jeraquico;?></label>
        <select id="<?php echo FORM_LABEL_jeraquico;?>" name="<?php echo FORM_LABEL_jeraquico;?>">
         <optgroup label="<?php echo FORM_LABEL_jeraquico;?>">
    <?php
    echo doSelectForm(array("1#$si","2#$no"),$array_vocabulario[polijerarquia]);
        ?>
        </optgroup>
        </select>

</div>
<div>
        <label for="URIt" accesskey="u"><?php echo LABEL_URI;?></label>
        <input id="URIt"
    name="<?php echo FORM_LABEL_URI;?>"
    size="40" maxlength="256"
    value="<?php echo $array_vocabulario[url_base];?>"
    />
</div>
 <div>
        <label for="cobertura" accesskey="d"><?php echo LABEL_Cobertura;?></label>
        <TEXTAREA id="cobertura"
    name="<?php echo FORM_LABEL_Cobertura;?>" rows="5"
    virtual cols="38"><?php echo $array_vocabulario[cobertura];?></TEXTAREA>
</div>
 <div>
        <input type="hidden" 
        name="vocabulario_id" 
        id="vocabulario_id"
		value="<?php echo $array_vocabulario[vocabulario_id];?>"
		/>
		
		<div class="submit_form" align="center">
        <label for="boton_enviar"  accesskey="e">
        <input id="boton_enviar"
    	name="boton_config"
		type="submit"
		value="<?php echo FORM_LABEL_Guardar;?>"
		/>
		</label>
		
        <label for="boton_cancelar"  accesskey="c">		
		<input type="button"  
		name="cancelar" 
		id="boton_cancelar" 
		type="button" 
		onClick="location.href='admin.php?vocabulario_id=list'" 
		value="<?php echo ucfirst(LABEL_Cancelar);?>"
		/>		
        </label>
        </div>
</div>
</form>
</fieldset>
