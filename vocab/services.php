<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

require "config.tematres.php";

// XML tiny web services
require_once T3_ABSPATH .'common/include/fun.api.php';

echo fetchVocabularyService(array2value("task",$_GET),array2value("arg",$_GET), array2value("output",$_GET));
