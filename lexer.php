<?php

require ("parseif.php");

$parseif = new parseif($argv);

$result = $parseif->lexer->parser;
//$result = $parseif->parse_if();
//if (!$result) {
//    exit('Parse error \n');
//}
var_dump($result);