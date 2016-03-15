# Tematres

*TemaTres : aplicación para la gestión de vocabularios controlados*

*TemaTres : The way to manage formal representations of knowledge*

Copyright (C) 2004-2013 Diego Ferreyra tematres@r020.com.ar
Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
Este es el archivo LEAME.TXT

TemaTres se distribuye bajo licencia GNU Public License (GPL==Pública General de GNU), versión 2 (de junio de 1.991).

Para instrucciones de instalación y documentación disponible: http://r020.com.ar/tematres/manual/

For instruction, please visit: http://vocabularyserver.com/wiki/ and (in spanish) http://r020.com.ar/tematres/manual/
For examples, please visit: http://www.vocabularyserver.com/vocabularies.php

Changelog TemaTres 2.1:
- Bulk editor (search and replace) form terms and notes (only admin user)
- New configuration option for access policies: enable/disable public view of the vocabularyvocabulario
- New configuration option for quality policies: enable or do not allow duplicate terms 
- randomTerm. New API command to retrieve random terms. Supports  filtering of terms according to notes
- Now the API command "fetch" expose the code term 
- Improve some usability issues (menus, user messages, etc)


Many thanks to the feedback provided by TemaTres community :)

Some HOWTO:

How to update to Tematres 2.0 from 1.82:
- Replace the code but mantaine your db.tematres.php.

How to update to Tematres 2.0 from Tematres 1.6 (or preious version):
- Login as admin and go to: Menu -> Administration -> Database maintance -> Update 1.6 to 1.7

How to manage many vocabularies with Tematres
- Copy /vocab directory (example: vocab2/) and change the prefix tables in db.tematres.php

How to enable SPARQL endpoint:
1) Login as admin and go to Menu -> Administration -> Configuration -> Click in your vocabulary: Set as ENABLE SPARQL endpoint (by default is disable).

2) Login as admin and Goto: Menu -> Administration -> Database maintance -> Update SPARQL endpoint.


diego ferreyra
tematres@r020.com.ar
http://www.vocabularyserver.com

