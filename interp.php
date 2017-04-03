<?php
$tree = array (
    'type' => 'if',
    'condition' =>
    array (
        'type' => 'INTEGER',
        'value' => 1,
    ),
    'then' =>
    array (
        'type' => 'block',
        'statements' =>
        array (
            array (
                'type' => 'print',
                'value' =>
                array (
                    'type' => 'STRING',
                    'value' => 'Hello',
                ),
            ),
            array (
                'type' => 'print',
                'value' =>
                array (
                    'type' => 'STRING',
                    'value' => 'world',
                ),
            ),
        ),
    ),
);


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

