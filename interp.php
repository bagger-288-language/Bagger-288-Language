<?php
require ("parseif.php");
//require ("parsefunction.php");

if ($argc > 1) {
    $parseif = new parseif($argv);
//    $parsefunction = new parsefunction($argv);
    //$result = $parseif->lexer->parser;
//    $result1 = $parsefunction->parse_function();
    $tree = $parseif->parse_if();
    if (!$tree) {
        exit('Parse error \n');
    }
//    var_dump($result);
}


function	interif($tree){
    $condition = run($tree['condition']);
    if ($condition != 0) {
	run($tree['then']);
    }
    return $condition;
}

function	interblock($tree) {
    $value = 0;
    foreach($tree['statements'] as $statements) {
	$value = run($statements);
    }
    return $value;
}

function	interprint($tree) {
    $value = run($tree['value']);
    echo $value;
    return $value;
}

function	interint($tree) {
    return ($tree['value']);
}

function	interstr($tree) {
    return ($tree['value']);
}


function run($tree) {
  $i = 0;
  $j = 0;

  $tableaufunc = [
      [ 'node' => 'if',    'functions' => 'interif' ],
      [ 'node' => 'block', 'functions' => 'interblock' ],
      [ 'node' => 'print', 'functions' => 'interprint' ],
      [ 'node' => 'INTEGER', 'functions' => 'interint' ],
      [ 'node' => 'STRING', 'functions' => 'interstr' ]
  ];

  while ( $i < 5 ) {
    if ($tree['type'] == $tableaufunc[$i]['node']) {
	$value = $tableaufunc[$i]['functions']($tree);
	$j = 1;
	return $value;
    }
    $i++;
  }
  if ($j == 0)
    exit('Unable to find node ' . $tree['type']);
}

run($tree);

?>

