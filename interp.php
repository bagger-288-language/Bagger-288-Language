<?php

require ("parseif.php");
require ("parsefunction.php");
require ("lexer2.php");

if ($argc == 2) {
    $lexer = new lexer2($argv);
    $parseif = new parseif($lexer);
    $parsefunc = new parsefunction($lexer);
    $tree = array();

    while ($lexer->parser) {
        if (!array_push($tree, $parseif->parse_if()) || $parseif->parse_if() == NULL)
            array_push($tree, $parsefunc->parse_function());
   }
}
else {
    echo "Veuillez ajouter un nom de fichier";
}

function	interif($tree){
    $condition = run($tree['condition']);
    if ($condition != 0) {
	    run($tree['then']);
    } else if (isset($tree['else'])) run($tree['else']);
    return $condition;
}

function    interfunctions($tree) {
    return 0;
}

function	interblock($tree) {
    $value = 0;
    foreach($tree['statement'] as $statements) {
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

function    intercondition($tree) {
    if (isset($tree['condition'][1])) {
        $inta = intval($tree['condition'][0]['value']);
        $operand = $tree['condition'][1]['value'];
        $intb = intval($tree['condition'][2]['value']);
        $test = testoperation($inta, $operand, $intb);
        if ($test == true || is_int($test))
            return 1;
    } else {
        if ($tree['condition'][0]['value'] != 0) return 1;
    }
    return 0;
}

function    intervar($tree) {
    if (isset(variable::$vars[$tree['value']]))
        return (variable::$vars[$tree['value']]);
    else {
        echo 'Undefined variable '.$tree['value'];
    }
}

function    interoper($tree) {
    return ($tree['value']);
}

function    intereq($tree) {
    return ($tree['value']);
}

function    intersemco($tree) {
    return 0;
}

function run($tree) {
  $i = 0;
  $j = 0;

  $tableaufunc = [
      [ 'node' => 'if',         'functions' => 'interif'        ],
      [ 'node' => 'function',   'functions' => 'interfunctions' ],
      [ 'node' => 'block',      'functions' => 'interblock'     ],
      [ 'node' => 'PRINT',      'functions' => 'interprint'     ],
      [ 'node' => 'INTEGER',    'functions' => 'interint'       ],
      [ 'node' => 'STRING',     'functions' => 'interstr'       ],
      [ 'node' => 'condition',  'functions' => 'intercondition' ],
      [ 'node' => 'VARIABLE',   'functions' => 'intervar'       ],
      [ 'node' => 'OPERAND',    'functions' => 'interoper'      ],
      [ 'node' => 'EQUAL',      'functions' => 'intereq'        ],
      [ 'node' => 'SEMICOLON',  'functions' => 'intersemco'     ]
  ];
  while ( $i < 11 ) {
    if ($tree['type'] == $tableaufunc[$i]['node']) {
	$value = $tableaufunc[$i]['functions']($tree);
	$j = 1;
	return $value;
    }
    $i++;
  }
  if ($j == 0) {
      exit('Unable to find node ' . $tree['type'] . ' ' . $tree['value']);
  }
}

$k = 0;
while (isset($tree[$k])) {
    run($tree[$k]);
    $k++;
}
