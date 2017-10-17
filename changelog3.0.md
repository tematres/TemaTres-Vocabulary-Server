# Tematres

*TemaTres : aplicación para la gestión de vocabularios controlados*

*TemaTres : The way to manage formal representations of knowledge*

Copyright (C) 2004-2013 Diego Ferreyra tematres@r020.com.ar
Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
Este es el archivo LEAME.TXT

TemaTres se distribuye bajo licencia GNU Public License (GPL==Pública General de GNU), versión 2 (de junio de 1.991).

Para instrucciones de instalación y documentación disponible: http://vocabularyserver.com/wiki/

For instruction, please visit: http://vocabularyserver.com/wiki/ and (in spanish) http://r020.com.ar/tematres/manual/
For examples, please visit: http://www.vocabularyserver.com/vocabularies.php

Changelog TemaTres 3.0:
- Add Bulk Editor for multiligual vocabularies
- Add admin reports (all terms, all relations, all notes)
- Add 2 new commands to web API: termsSince (terms created/mod since date) and relationsSince (relations affected since date)
- Add modal preview for term provided by external vocabularies
- Add modal view to list terms
- Add config options in config.tematres.php to enable or disable HTML data in web services
- Add config options in config.tematres.php to define tag separator in import txt file
- Add name of editor in notes metadata
- Full revision of French texts

Updates and minor bugs:
    update glozariser
    update to TinyMCE 4.6
    update PHPmailer class
    update HTMLpurfier to HTML Purifier 4.9.3
    fix potential XSS vulnerability
    fix bug in import Skos-core files
    

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

