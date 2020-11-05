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


## Update to 3.2
To update from previous Tematres versions:
1. Make a backup of your data (Login as admin: Menu -> Administration -> Export: Select SQL (backup)
2. Copy the code of Tematres 3.2 in the web path directory, config the database connection credentials in db.tematres.php or maintain the previous db.tematres.php
3. Login as admin: Menu -> Administration -> Database maintenance -> Update from 2.x -> 3.2


## Changelog TemaTres 3.2:
- Support for InnoDB database type
- Add config options to config type of charset in install process
- Add support for Archival Resource Key (ARK)  persistent identifier . https://en.wikipedia.org/wiki/Archival_Resource_Key
- Add Normalized manager for reference sources: now you can reuse references and discovery global survey about them
- Add capabilities to assign reference sources for terms or notes as differentiates entities
- Add a new verb to Tematres API: fetchCentralTerms. The command retrieves the central terms of the vocabulary (relation between depth and number of descendant terms).




## Changelog TemaTres 3.1:
- Utility for importing vocabularies encoded in MARC-XML format
- Utility for the mass export of vocabulary in MARC-XML format
- New reports about global vocabulary structure
	- Distribution of terms according to depth level
	- Distribution of sum of preferred terms and the sum of alternative terms
	- Distribution of sum of hierarchical relationships and sum of associative relationships
- Report about terms with relevant degree of centrality in the vocabulary (according to prototypical conditions)
- Presentation of terms with relevant degree of centrality in each facet
- New options to config the presentation of notes: define specific types of note as prominent (the others note types will be presented in collapsed div). 
- Button for Copy to clipboard the terms with indexing value (Copy-one-click button)
- New user login scheme (login)
- Allows to config and add Google Analytics tracking code (parameter in config.tematres.php file)
- Improvements in standard exposure of metadata tags
- Inclusion of the term notation or code in the search box predictive text
- Compatibility with PHP 7.2

Thanks about the contribution to:
-  IBICT Project (https://repositorio.enap.gov.br/handle/1/4199) 
- Andreas Roussos (https://github.com/a-roussos)
- Horus68 (https://github.com/horus68)


Updates and minor bugs:
    update glozariser, 
    update TinyMCE
    update PHPmailer class
    update HTMLpurfier
    update to jquery 3.4.1 and bootstrap 3.3.7
    
    

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

