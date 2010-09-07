<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Include para alta y modificacion de usuarios genericos.

if($_GET[user_id]=='new'){
	$nombre_boton=LABEL_Enviar;
	}else{
	$dato_user=ARRAYdatosUser($_GET[user_id]);

	$resumen=ARRAYresumen($_SESSION[id_tesa],"U","$dato_user[id]");

	$row_resumen.='<div id="cajaAncha">'."\n\r";
	$row_resumen.='  <div><strong>'.LABEL_Acciones.'</strong></div><dl class="dosCol">'."\n\r";

	if($resumen[cant_total]>0){
		$row_resumen.='<dt><a href="sobre.php?user_id='.$dato_user[id].'" title="'.LABEL_Terminos.'">'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen[cant_total].'</a>&nbsp;</dd>'."\n\r";
		}else{
		$row_resumen.='<dt>'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen[cant_total]."&nbsp;</dd>\n\r";
		};
	$row_resumen.='<dt>'.ucfirst(LABEL_RelTerminos).'</dt><dd>'.$resumen[cant_rel]."&nbsp;</dd>\n\r";
	$row_resumen.='<dt>'.ucfirst(LABEL_TerminosUP).'</dt><dd>'.$resumen[cant_up]."&nbsp;</dd>\n\r";
	$row_resumen.='</dl></div>';


if($dato_user[estado]){
	if($dato_user[estado]=='ACTIVO'){$textoEnlace=MENU_Caducar;}else{$textoEnlace=MENU_Habilitar;};
	$boton_estado='<input name="boton" type="button" value="'.$textoEnlace.'" onclick="location.href=\'admin.php?user_id=list&usestado='.$dato_user[id].'&estado='.$dato_user[estado].'\'"/>'."\n\r";
	$boton_estado.='<input name="boton" type="button" value="'.ucfirst(LABEL_Cancelar).'" onclick="location.href=\'admin.php?user_id=list\'"/>'."\n\r";
	};
     $nombre_boton=LABEL_Cambiar;
};
?>
<h1><a href="admin.php?user_id=list" title="<?php echo LABEL_AdminUser;?>"><?php echo LABEL_AdminUser;?></a></h1>
<fieldset>
    <legend> <?php echo LABEL_DatosUser;?> </legend>
        <?php echo $row_resumen;?>
                  <form name="login" action="admin.php" method="post" onsubmit="return checkrequired(this)">
                        <div>
            <label for="<?php echo LABEL_nombre;?>" accesskey="n"><?php echo LABEL_nombre;?>*</label>
                <input name="<?php echo FORM_LABEL_nombre;?>"
                id="nombre"
                size="20" maxlength="150"
                value="<?php echo $dato_user[nombres];?>"
                />
                          </div>
                           <div>
            <label for="apellido" accesskey="a"><?php echo LABEL_apellido;?>*</label>
                <input  name="<?php echo FORM_LABEL_apellido;?>"
                id="apellido"
                size="20" maxlength="150"
                value="<?php echo $dato_user[apellido];?>"
                />
                        </div>
                        <div>
            <label for="mail" accesskey="l"><?php echo LABEL_mail;?>*</label>
                <input name="<?php echo FORM_LABEL_mail;?>"
                id="mail"
                size="20" maxlength="256"
                value="<?php echo $dato_user[mail];?>"
                />
                        </div>
                        <div >
            <label for="orga" accesskey="o"><?php echo LABEL_orga;?></label>
                <input name="<?php echo FORM_LABEL_orga;?>"
                id="orga"
                size="20" maxlength="256"
                value="<?php echo $dato_user[orga];?>"
                />
                        </div>
                        <div>
            <label for="clave" accesskey="c"><?php echo LABEL_pass;?>*</label>
                <input name="<?php echo FORM_LABEL_pass;?>"
                type="password"
                id="clave"
                size="10" maxlength="10"
                value="<?php echo $dato_user[pass];?>"
                />
                        </div>
                        <div>
            <label for="reclave" accesskey="r"><?php echo LABEL_repass;?>*</label>
                <input name="<?php echo FORM_LABEL_repass;?>"
                type="password"
                id="reclave"
                value="<?php echo $dato_user[pass];?>"
                size="10" maxlength="10"
                />
                        </div>
                        
            <label for="isAdmin" accesskey="i"><?php echo ucfirst(LABEL_esSuperUsuario);?></label>
                <input type="checkbox"
                name="isAdmin"                
                id="isAdmin"
                value="1"                
                <?php echo arrayReplace(array("1","2"),array("checked",""),$dato_user[nivel])?>
                />
          		<div class="submit_form" align="center">
		<INPUT name="useactua"
                TYPE="HIDDEN"
                value="<?php echo $dato_user[id];?>"
                />
                <input name="boton"
                type="submit"
                value="<?php echo $nombre_boton;?>"
                />
		<?php echo $boton_estado;?>
		</div>
                  </form>
          </fieldset>
