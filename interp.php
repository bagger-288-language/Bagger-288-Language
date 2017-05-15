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
}

function	interif($tree){
    $condition = run($tree['condition']);
    if ($condition != 0) {
	    run($tree['then']);
    }
    else
        run($tree['else']);
    return $condition;
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
    $inta = intval($tree['condition'][0]['value']);
    $operand = $tree['condition'][1]['value'];
    $intb = intval($tree['condition'][2]['value']);
    $test = testoperation($inta, $operand, $intb);
    if ($test == true || is_int($test))
        return 1;
    return 0;
}

function    supp($inta, $intb) {
    return $inta > $intb;
}

function    supeq($inta, $intb) {
    return $inta >= $intb;
}

function    infeq($inta, $intb) {
    return $inta <= $intb;
}

function    inf($inta, $intb) {
    return $inta < $intb;
}

function    simpeq($inta, $intb) {
    return $inta = $intb;
}

function    sum($inta, $intb) {
    return $inta + $intb;
}

function    diff($inta, $intb) {
    return $inta - $intb;
}

function    mult($inta, $intb) {
    return $inta * $intb;
}

function    div($inta, $intb) {
    return $inta / $intb;
}

function    dobeq($inta, $intb) {
    return $inta == $intb;
}


function    testoperation($inta, $operand, $intb)
{
    $i = 0;
    $tableope = [
        [ 'oper' => '>', 'func' => 'supp' ],
        [ 'oper' => '<', 'func' => 'inf' ],
        [ 'oper' => '<=', 'func' => 'infeq' ],
        [ 'oper' => '>=', 'func' => 'supeq' ],
        [ 'oper' => '=', 'func' => 'simpeq' ],
        [ 'oper' => '==', 'func' => 'dobeq' ],
        [ 'oper' => '+',  'func' => 'sum' ],
        [ 'oper' => '-', 'func' => 'diff' ],
        [ 'oper' => '*', 'func' => 'mult' ],
        [ 'oper' => '/', 'func' => 'div' ]
    ];

    while ($i < 10)
    {
       if ($operand == $tableope[$i]['oper']) {
           $result = $tableope[$i]['func']($inta, $intb);
           return $result;
       }
       $i++;
    }
    return 0;
}

function run($tree) {
  $i = 0;
  $j = 0;

  $tableaufunc = [
      [ 'node' => 'if',    'functions' => 'interif' ],
      [ 'node' => 'block', 'functions' => 'interblock' ],
      [ 'node' => 'print', 'functions' => 'interprint' ],
      [ 'node' => 'INTEGER', 'functions' => 'interint' ],
      [ 'node' => 'STRING', 'functions' => 'interstr' ],
      [ 'node' => 'condition', 'functions' => 'intercondition' ]
  ];
  while ( $i < 6 ) {
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

