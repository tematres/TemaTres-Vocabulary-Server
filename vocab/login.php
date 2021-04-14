<?php
/* TemaTres : aplicación para la gestión de lenguajes documentales #       #
Copyright (C) 2004-2021 Diego Ferreyra tematres@r020.com.ar
 Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
*/
require "config.tematres.php";
$metadata=do_meta_tag();

if (($_GET["action"]=='rp') && ($_GET["key"])) {
    $chek_key=check_password_reset_key($_GET["key"], urldecode($_GET["login"]));

    if ($chek_key["user_id"]>0) {
        $task_result=reset_password($chek_key);
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
    <?php echo HTMLheader($metadata);?>
<style type="text/css">

.navbar-form {
    overflow: auto;
}
.navbar-form .form-control {
    display: inline-block;
    width: 80%;
    vertical-align: middle;
}
.navbar-form .form-group {
    display: inline;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.forgot-password {
    text-decoration: underline;
    color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
    text-decoration: underline;
    color: #666;
}

</style>
</head>

    <!-- HTML code from Bootply.com editor -->

 <body>

    <?php echo HTMLnavHeader(); ?>

<div class="container">

<?php
if ($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"]) {
           include_once T3_ABSPATH . 'common/include/inc.misTerminos.php';
} else {
    if ($_POST["task"]=='user_recovery') {
        $task_result=recovery($_POST["id_correo_electronico_recovery"]);
    }


    if ((@$_GET["task"])&&($_GET["task"]=='recovery')) {
        echo HTMLformRecoveryPassword();
    } else {
        if (($_POST["task"]=='login') && (!$_SESSION[$_SESSION["CFGURL"]]["ssuser_id"])) {
            $task_result=array("msg"=>t3_messages('no_user'));
        }
        echo HTMLformLogin($task_result);
    };
}// if session
?>
</div><!-- /.container -->

<!-- ###### Footer ###### -->

<div id="footer" class="footer">
          <div class="container">
                <?php
                if (!@$_GET["letra"]) {
                    echo HTMLlistaAlfabeticaUnica();
                }
                ?>

            <p class="navbar-text pull-left">
                <?php
                //are enable SPARQL
                if (CFG_ENABLE_SPARQL==1) {
                    echo '<a class="label label-info" href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
                }

                if (CFG_SIMPLE_WEB_SERVICE==1) {
                    echo '  <a class="label label-info" href="'.URL_BASE.'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
                }

                    echo '  <a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
                    echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
                ?>
            </p>
                <?php echo doMenuLang($metadata["arraydata"]["tema_id"]); ?>
          </div>

</div>
<?php echo HTMLjsInclude();?>
    </body>
</html>
<?php
/**
 * * From WordPress !!!
 *
 * Retrieves a user row based on password reset key and login
 *
 * @uses $wpdb WordPress Database object
 *
 * @param  string $key   Hash to validate sending user's password
 * @param  string $login The user login
 * @return object|WP_Error User's database row on success, error object for invalid keys
 */
function check_password_reset_key($key, $login)
{

    $key = preg_replace('/[^a-z0-9]/i', '', $key);

    if (empty($key) || !is_string($key)) {
        return t3_messages('invalid_key');
    }

    if (empty($login) || !is_string($login)) {
        return t3_messages('invalid_key');
    }

    $ARRAYuser = ARRAYdatosUserXkey($login, $key);

    if (empty($ARRAYuser)) {
        return t3_messages('invalid_key');
    }

    return $ARRAYuser;
}


function recovery($user_login)
{

    global $DBCFG;

    $ARRAYuser=array();
    $ARRAYuser=ARRAYdatosUserXmail($user_login);


    //El usuario no existe
    if (!$ARRAYuser["user_id"]) {
        return array("result"=>false, "msg"=>t3_messages("recovery_mail_send"));
    }

    if (empty($ARRAYuser["user_activation_key"])) {
        // Generate something random for a key...
        $ARRAYuser["user_activation_key"] = wp_generate_password(20, false);

        // Now insert the new md5 key into the db
        $sql_update_key=SQL("update", "$DBCFG[DBprefix]usuario set user_activation_key='$ARRAYuser[user_activation_key]' where id='$ARRAYuser[user_id]'");
    }


    $message = LABEL_mail_recovery_pass1. "\r\n\r\n";
    $message .= $_SESSION["CFGURL"]. "\r\n\r\n";
    $message .= sprintf(LABEL_mail_recovery_pass2, $ARRAYuser["mail"]) . "\r\n\r\n";
    $message .= LABEL_mail_recovery_pass3. "\r\n\r\n";
    $message .= LABEL_mail_recovery_pass4. "\r\n\r\n";
    $message .= currentBasePage($_SESSION["CFGURL"]).'login.php?action=rp&key='.$ARRAYuser["user_activation_key"].'&login='.rawurlencode($ARRAYuser["mail"])."\r\n";

    $title = sprintf('[%s] '.LABEL_mail_recoveryTitle, $_SESSION["CFGTitulo"]);

    $sendMail=sendMail($ARRAYuser["mail"], $title, $message);

    if ($sendMail) {
        return array("result"=>true, "msg"=>t3_messages("mailOK"));
    } else {
        array("result"=>false, "msg"=>t3_messages("mailFail"));
    };

    return;
};


function reset_password($ARRAYuser)
{

    $string_pass = wp_generate_password(12, false);

    //set password
    setPassword($ARRAYuser["user_id"], $string_pass, CFG_HASH_PASS);

    $message = LABEL_mail_pass1.' '.$ARRAYuser["mail"] . "\r\n\r\n";
    $message .= LABEL_mail_pass2.' '.$string_pass. "\r\n\r\n";
    $message .= LABEL_mail_pass3."\r\n\r\n";
    $message .= currentBasePage($_SESSION["CFGURL"]).'login.php'."\r\n";

    $title = sprintf('[%s] '.LABEL_mail_passTitle, $_SESSION["CFGTitulo"]);

    $sendMail=sendMail($ARRAYuser["mail"], $title, $message);

    if ($sendMail) {
        return array("result"=>true, "msg"=>t3_messages("mailOK"));
    } else {
        return array("result"=>false, "msg"=>t3_messages("mailFail"));
    };
};


/**
 * * From WordPress !!!
 *
 * Generates a random password drawn from the defined set of characters.
 *
 * @since 2.5
 *
 * @param  int  $length              The length of password to generate
 * @param  bool $special_chars       Whether to include standard special characters. Default true.
 * @param  bool $extra_special_chars Whether to include other special characters. Used when
 *                                   generating secret keys and salts. Default false.
 * @return string The random password
 **/
function wp_generate_password($length = 12, $special_chars = true, $extra_special_chars = false)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    if ($special_chars) {
        $chars .= '!@#$%^&*()';
    }
    if ($extra_special_chars) {
        $chars .= '-_ []{}<>~`+=,.;:/?|';
    }

    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
    }

    return $password;
}


 /**
  * From WordPress !!!
  * Generates a random number
  *
  * @since 2.6.2
  *
  * @param  int $min Lower limit for the generated number (optional, default is 0)
  * @param  int $max Upper limit for the generated number (optional, default is 4294967295)
  * @return int A random number between min and max
  */
function wp_rand($min = 0, $max = 0)
{

    //sustitución de un valor global
    $rnd_value==3;

    // Reset $rnd_value after 14 uses
    // 32(md5) + 40(sha1) + 40(sha1) / 8 = 14 random numbers from $rnd_value
    if (strlen($rnd_value) < 8) {
        $seed = srand();
        $rnd_value = md5(uniqid(microtime() . mt_rand(), true) . $seed);
        $rnd_value .= sha1($rnd_value);
        $rnd_value .= sha1($rnd_value . $seed);
        $seed = md5($seed . $rnd_value);
    }

    // Take the first 8 digits for our value
    $value = substr($rnd_value, 0, 8);

    // Strip the first eight, leaving the remainder for the next call to wp_rand().
    $rnd_value = substr($rnd_value, 8);

    $value = abs(hexdec($value));

    // Reduce the value to be within the min - max range
    // 4294967295 = 0xffffffff = max random number
    if ($max != 0) {
        $value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));
    }

    return abs(intval($value));
}
