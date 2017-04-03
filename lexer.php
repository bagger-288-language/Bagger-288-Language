<?php

require ("parseif.php");

if ($argc > 1) {
    $parseif = new parseif($argv);

    $result = $parseif->lexer->parser;
//$result = $parseif->parse_if();
//if (!$result) {
//    exit('Parse error \n');
//}
    var_dump($result);
}