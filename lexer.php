<?php

require ("parseif.php");

$parseif = new parseif($argv);

$result = $parseif->parse_if();
if (!$result) {
    exit('Parse error \n');
}
var_dump($result);