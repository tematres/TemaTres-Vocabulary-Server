# Tematres

*TemaTres : aplicación para la gestión de vocabularios controlados*

*TemaTres : The way to manage formal representations of knowledge*

Copyright (C) 2004-2022 Diego Ferreyra tematres@r020.com.ar
Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
Este es el archivo LEAME.TXT

TemaTres se distribuye bajo licencia GNU Public License (GPL==Pública General de GNU), versión 2 (de junio de 1.991).


* For instruction, please visit: https://vocabularyserver.com/wiki/
* For manuals and tutorials, please visit: https://vocabularyserver.com/web/items/browse?collection=3
* For examples, please visit: https://vocabularyserver.com/vocabularies/
* For demo and sandbox, please visit: https://r020.com.ar/tematres/demo/




## Changelog TemaTres 3.4:

#### Added


* Add option in advaced reports to filter terms 'Modified on or after'#78
* Normalize type of KOS in config option, use list of value defined in https://nkos.dublincore.org/nkos-type.html
* Add feature: if is possible merge terms when add BT, NT or UF
* Improve support to xx-XX lang codes: support for xxx-XXX code lang.
* Add en-PH English (Republic of the Philippines) and tl-PH Tagalog (Philippines)
* Improve support lang code to 4 (xx-XX) in import SKOS-core procedure
* Add XML Dspace Taxonomy format as export option
* Add config option in common/include/config.tematres.php to enable or diable CDN for external libraries ([USE_CDN]). False by default



#### Update


* update to ADOdb-5.21.4
* update to PHPMailer to v6.6
* update clipboard.js library

New Contributors

    @T1loc made their first contribution in #54
    @AlanNFreitas made their first contribution in #62






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

