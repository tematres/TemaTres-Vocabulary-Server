<?php
/*
 *      TemaTres : aplicación para la gestión de lenguajes documentales
 *
 *      Copyright (C) 2004-2008 Diego Ferreyra tematres@r020.com.ar
 *      Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
 */

define('T3_STATELESS', true);
require "config.tematres.php";

// XML tiny web services
require_once T3_ABSPATH .'common/include/fun.api.php';

$response = fetchVocabularyService(array2value("task",$_GET),array2value("arg",$_GET), array2value("output",$_GET));

// Without a session (T3_NO_SESSION) the response is the same for every client: a cache may keep it, but must
// revalidate it each time (no-cache), so a change, or a vocabulary that is no longer published, is seen at once.
// randomTerm is to give a new term each time, so it is not stored.
if (defined('T3_NO_SESSION') && in_array($_SERVER['REQUEST_METHOD'], array('GET', 'HEAD')) && (http_response_code() == 200)) {
    if (array2value("task",$_GET) === 'randomTerm') {
        header('Cache-Control: no-store');
    } else {
        $etag = '"'.md5($response).'"';
        header('Cache-Control: public, no-cache');
        header('Vary: Cookie');
        header('ETag: '.$etag);
        $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : '';
        // The header is "*" or a list of quoted tags (a tag may itself contain a comma).
        $match = ($if_none_match === '*');
        preg_match_all('/(?:W\/)?"[^"]*"/', $if_none_match, $tags);
        foreach ($tags[0] as $tag) {
            // A weak tag (W/) matches too, and mod_deflate or mod_brotli may have added "-gzip" or "-br" at its end.
            if (strpos($tag, 'W/') === 0) {
                $tag = substr($tag, 2);
            }
            if (preg_replace('/-(gzip|br)"$/', '"', $tag) === $etag) {
                $match = true;
            }
        }
        if ($match) {
            http_response_code(304);
            exit;
        }
    }
}

echo $response;
