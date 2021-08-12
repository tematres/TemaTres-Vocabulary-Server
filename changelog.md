# Tematres

*TemaTres : aplicación para la gestión de vocabularios controlados*

*TemaTres : The way to manage formal representations of knowledge*

Copyright (C) 2004-2020 Diego Ferreyra tematres@r020.com.ar
Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
Este es el archivo LEAME.TXT

TemaTres se distribuye bajo licencia GNU Public License (GPL==Pública General de GNU), versión 2 (de junio de 1.991).

Para instrucciones de instalación y documentación disponible: https://vocabularyserver.com/wiki/

For instruction, please visit: https://vocabularyserver.com/wiki/
For examples, please visit: https://www.vocabularyserver.com/vocabularies.php



## Changelog TemaTres 3.2:

#### Added

-  add option to look for terminological news in target vocabularies (references vocabularies via web services)
- Support for Archival Resource Key (ARK)  persistent identifier . https://en.wikipedia.org/wiki/Archival_Resource_Key
- Normalized manager for reference sources: now you can reuse references and discovery global surveys about them
- Capabilities to assign reference sources for terms or notes as differentiated entities
- New verb to Tematres API: fetchCentralTerms. The command retrieves the central terms of the vocabulary (relation between depth and number of descendant terms).
- Support for InnoDB database type
- Config options to config type of charset in install process
- Optional config value in db.tematres.php to set connection mode (use or not DSN)
-  add notation in hierarquical export for txt and pdf 
-  add notes to import procedure from MARC21-XML 



#### Update

* Tinymce

* fpdf library
* adodb library
* HTMLpurifier
* language files
* Improve php 7.x compability
* Remove bootstrap-table





## How to update to 3.2

To update from previous Tematres versions:

1. Make a backup of your data (Login as admin: Menu -> Administration -> Export: Select SQL (backup)
2. Copy the code of Tematres 3.2 in the web path directory, config the database connection credentials in db.tematres.php or maintain the previous db.tematres.php
3. Login as admin: Menu -> Administration -> Database maintenance -> Update from 2.x -> 3.2


## 


​    

Many thanks to the feedback provided by TemaTres community :)

Some HOWTO:

How to update to Tematres 3.0 from previous version (1.8x, 2.x):
- Replace the code but mantaine your db.tematres.php.

How to update to Tematres 3.0 from Tematres 1.6 (or preious version):
- Login as admin and go to: Menu -> Administration -> Database maintance -> Update 1.6 to 2.2

How to manage many vocabularies with Tematres
- Copy /vocab directory (example: vocab2/) and change the prefix tables in db.tematres.php

How to enable SPARQL endpoint:
1) Login as admin and go to Menu -> Administration -> Configuration -> Click in your vocabulary: Set as ENABLE SPARQL endpoint (by default is disable).

2) Login as admin and Goto: Menu -> Administration -> Database maintance -> Update SPARQL endpoint.


diego ferreyra
tematres@r020.com.ar
http://www.vocabularyserver.com

