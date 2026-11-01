<?php
/* TemaTres : aplicación para la gestión de lenguajes documentales #       #

 Copyright (C) 2004-2024 Diego Ferreyra tematres@r020.com.ar
 Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
*/
 require "config.tematres.php";
$metadata=do_meta_tag();
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
    <?php echo HTMLheader($metadata);?>        
        <?php
        echo '<link rel="stylesheet" type="text/css" href="'.T3_WEBPATH.'jq/chartist-js/chartist.min.css">';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist.min.js"></script>';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist-plugin-axistitle.min.js"></script>';
        ?>
        <style>
            #ct-deep  {
                height: 300px;
                width: 100%;
            }
            #ct-lexical {
                height: 400px;
                width: 100%;

            }
            #ct-logic {
                height: 400px;
                width: 100%;
            }
            .ct-label{
                fill: rgba(0,0,0,.8);
                color: rgba(0,0,0,.8);
                font-size: 1em;
                line-height: 2;
            }
        </style>        
  </head>
 <body>   
    <?php echo HTMLnavHeader(); ?>
<div class="container">
<div class="container sobre " id="bodyText">
    
    <?php

    echo HTMLsummary();

    if (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0) {

        $_GET["ord"]=array2value("ord", $_GET);
        $_GET["y"]=array2value("y", $_GET);
        $_GET["user_id"]=array2value("user_id", $_GET);
        //es admin y quiere ver un usuario
        if (($_GET["user_id"])    &&    (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])==1)) {
            echo doBrowseTermsFromUser(secure_data($_GET["user_id"], $_GET["ord"]));
        } elseif ($_GET["user_id"]) {//no es admin y quiere verse a si mismo
            echo doBrowseTermsFromUser(secure_data($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"], "sql"), secure_data($_GET["ord"], "sql"));
        } elseif ($_GET["y"]) {//quiere ver un año
            echo doBrowseTermsFromDate(secure_data($_GET["m"], "sql"), secure_data($_GET["y"], "sql"), secure_data($_GET["ord"], "sql"));
        } else {//ver lista agregada
            echo doBrowseTermsByDate();
        }
    };
    ?>
      </div><!-- /#bodyText -->
</div><!-- /.container -->
<!-- ###### Footer ###### -->

<?php echo HTMLfooter(array("letra"=>"","term_id"=>""));?>
<?php echo HTMLjsInclude();?>
</body>
</html>
