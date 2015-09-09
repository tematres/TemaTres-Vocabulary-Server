<?php
#   TemaTres : aplicación para la gestión de lenguajes documentales #       #
#                                                                        #
#   Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
#   Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
#  
###############################################################################################################
#
include("config.tematres.php");
$metadata=do_meta_tag();

if(CFG_ENABLE_SPARQL==1)
    {
      /* Include ARC2 classes. */
      require_once(T3_ABSPATH . 'common/arc2/ARC2.php');
      /* ARC2 static class inclusion */

      /* config enalbes SPARQL commands */
        $array_endpoint_features=($_SESSION[$_SESSION["CFGURL"]][ssuser_nivel]>0) ? array('select', 'construct', 'ask', 'describe','load','insert') : array('select', 'construct', 'ask', 'describe');

      /* MySQL and endpoint configuration */
      $config = array(
        /* db */
        'db_host' => $DBCFG["Server"] , /* optional, default is localhost */
        'db_name' => $DBCFG["DBName"] ,
        'db_user' => $DBCFG["DBLogin"],
        'db_pwd' => $DBCFG["DBPass"],
        'store_name' => $DBCFG["DBprefix"],  /* store name */

        /* endpoint   */  
        'endpoint_features' => $array_endpoint_features,
        'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
        'endpoint_read_key' => '', /* optional */
        'endpoint_write_key' => '', /* optional, but without one, everyone can write! */
        'endpoint_max_limit' => 250, /* optional */
      );

      //check if there are data in sparql endpoint

          /* instantiation */
          $ep = ARC2::getStoreEndpoint($config);

          $ep->go("0");  
    }
    else
    {
      echo MSG__disable_endpoint;
    }

?>