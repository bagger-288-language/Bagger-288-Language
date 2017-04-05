<?php

require ("parseif.php");
//require ("parsefunction.php");

if ($argc > 1) {
    $parseif = new parseif($argv);
//    $parsefunction = new parsefunction($argv);
    //$result = $parseif->lexer->parser;
//    $result1 = $parsefunction->parse_function();
    $result = $parseif->parse_if();
    if (!$result) {
        exit('Parse error \n');
    }
    var_dump($result);
}