<?php
require ("tokenization.php");

$parser = codestruct($argv);


function peek() {
    global $parser;
    return $parser[0];
}

function shift() {
    global $parser;
    return array_shift($parser);
}

function expect($type)
{
    $token = shift();
    if ($type != $token['type']) {
        throw new Exception('Undefined type : ' . $token['type'] . ' wanted : ' . $type);
    }
    return $token;
}

function parse_statement() {
    if (peek()['type'] == 'PRINT') {
        shift();
        expect('DOUBLE_QUOTE');
        $value = expect('STRING');
        expect('DOUBLE_QUOTE');
        expect('SEMICOLON');
        return array('type' => 'print', 'value' => $value);
    }
}

function parse_block() {
    expect('LEFT_BRACE');
    $statements = [];
    while ($statement = parse_statement()) {
        $statements[] = $statement;
    }
    expect('RIGHT_BRACE');
    return array('type' => 'block', 'statement' => $statements);
}

function parse_if() {
    if (peek()['type'] == "IF") {
        shift();
        expect("LEFT_PAREN");
        $value = expect("INTEGER");
        expect("RIGHT_PAREN");
        $block = parse_block();
        return array('type' => 'if', 'condition' => $value, 'block' => $block);
    }
}

var_dump($parser);
$result = parse_if();
if (!$result) {
    exit('Parse error \n');
}
var_dump($result);