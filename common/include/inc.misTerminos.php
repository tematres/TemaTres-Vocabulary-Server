<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
# Include para actualizacion de datos propios. #

$user_id = '0';

$user_id = (($_GET[user_id])&&($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1')) ? $_GET[user_id] : $_SESSION[$_SESSION["CFGURL"]][ssuser_id];

if($_POST[actuaDatos])
	{
	$user_id = ($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]=='1') ? $_POST[actuaDatos] : $_SESSION[$_SESSION["CFGURL"]][ssuser_id];
	$user_id=admin_users("actua",secure_data($user_id,"sql"));
 	$row_resumen='<p class="success">'.MSG_ResultCambios.'</p>'."\n\r";
	};

$resumen=ARRAYresumen($_SESSION[id_tesa],"U",secure_data($user_id,"sql"));

	$row_resumen.='<div id="cajaAncha">'."\n\r";
	$row_resumen.='<strong>'.ucfirst(LABEL_Acciones).'</strong><dl class="dosCol">'."\n\r";
	$row_resumen.='<dt>'.ucfirst(LABEL_Terminos).'</dt><dd>'.$resumen[cant_total]."</dd>\n\r";
	$row_resumen.='<dt>'.ucfirst(LABEL_RelTerminos).'</dt><dd>'.$resumen[cant_rel]."</dd>\n\r";
	$row_resumen.='<dt>'.ucfirst(LABEL_TerminosUP).'</dt><dd> '.$resumen[cant_up]."</dd>\n\r";
	$row_resumen.='</dl></div>';

$dato_user=ARRAYdatosUser($user_id);
$nombre_boton=LABEL_actualizar;
?>
<div id="bodyText">
<fieldset>
    <legend><?php echo MENU_MisDatos; ?></legend>
    <?php    echo $row_resumen;  ?>
        <form name="login" action="<?php echo $PHP_SELF;?>" method="post" onsubmit="return checkrequired(this)">
	<div>
            <label for="nombre" accesskey="n"><?php echo ucfirst(LABEL_nombre);?>*</label>
                <input name="<?php echo FORM_LABEL_nombre;?>" class="campo"
                id="nombre"
                size="20" maxlength="150"
                value="<?php echo $dato_user[nombres];?>"
                />
                          </div>
                           <div >
            <label for="apellido" accesskey="a"><?php echo ucfirst(LABEL_apellido);?>*</label>
                <input  name="<?php echo FORM_LABEL_apellido;?>" class="campo"
                id="apellido"
                size="20" maxlength="150"
                value="<?php echo $dato_user[apellido];?>"
                />
                        </div>
                        <div>
            <label for="mail" accesskey="l"><?php echo ucfirst(LABEL_mail);?>*</label>
            <input name="<?php echo FORM_LABEL_mail;?>" class="campo"
                id="mail"
                size="20" maxlength="256"
                value="<?php echo $dato_user[mail];?>"
                />
                        </div>
                        <div >
            <label for="orga" accesskey="o"><?php echo ucfirst(LABEL_orga);?></label>
                <input name="<?php echo FORM_LABEL_orga;?>" class="campo"
                id="orga"
                size="20" maxlength="256"
                value="<?php echo $dato_user[orga];?>"
                />
                        </div>
                        <div>
            <label for="clave" accesskey="c"><?php echo ucfirst(LABEL_pass);?>*</label>
                <input name="<?php echo FORM_LABEL_pass;?>" 
                class="campo"
                type="password"
                id="clave"
                size="10" maxlength="10"
                value="<?php echo $dato_user[pass];?>"
                />
                        </div>
                        <div>
            <label for="reclave" accesskey="r"><?php echo ucfirst(LABEL_repass);?>*</label>
                <input name="<?php echo FORM_LABEL_repass;?>" 
                class="campo"
                type="password"
                id="reclave"
                size="10" maxlength="10"
                value="<?php echo $dato_user[pass];?>"
                />
                        </div>
                        <div>
		<input name="actuaDatos" type="hidden"
                value="<?php echo $dato_user[user_id];?>"
                />
                <input name="boton" class="boton_formulario"
                type="submit"
                value="<?php echo $nombre_boton;?>"
                />
		</div>
                  </form>
</fieldset>
</div>
