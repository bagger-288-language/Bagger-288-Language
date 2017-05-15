<?php

require "lexer2.php";

class parseif
{
    public $lexer;

    public function __construct($argv)
    {
        $this->lexer = new lexer2($argv);
    }

    public function parseCondition()
    {
        $this->lexer->expect("LEFT_PAREN");
        $conditions = [];
        while (($temp = $this->lexer->peek()["type"]) != 'RIGHT_PAREN') {
            $conditions[] = $this->lexer->expect($temp);
        }
        $this->lexer->expect('RIGHT_PAREN');
        return array('type' => 'condition', 'condition' => $conditions);
    }

    public function parseStatement()
    {
        if ($this->lexer->peek()['type'] == 'PRINT') {
            $this->lexer->shift();
            $this->lexer->expect('DOUBLE_QUOTE');
            $temp = $this->lexer->peek()["type"];
            if ($temp == 'STRING')
                $value = $this->lexer->expect('STRING');
            else if ($temp == 'INTEGER')
                $value = $this->lexer->expect('INTEGER');
            $this->lexer->expect('DOUBLE_QUOTE');
            $this->lexer->expect('SEMICOLON');
            return array('type' => 'print', 'value' => $value);
        }
        else if ($this->lexer->peek()['type'] == "INTEGER") {
            $this->lexer->shift();
            return array('type' => 'integer');
        }
        else if ($this->lexer->peek()['type'] == "SEMICOLON") {
            $this->lexer->shift();
        }
        else if ($this->lexer->peek()['type'] == "OPERAND") {
            $this->lexer->shift();
            return array('type' => 'equal');
        }
        else if ($this->lexer->peek()['type'] == "STRING") {
            $this->lexer->shift();
            return array('type' => 'string');
        }
        else if ($this->lexer->peek()['type'] == "VARIABLE") {
            $this->lexer->shift();
            return array('type' => 'variable');
        }
    }

    public function parseBlock() {
        $this->lexer->expect('LEFT_BRACE');
        $statements = [];
        while ($statement = $this->parseStatement()) {
            $statements[] = $statement;
        }
        $this->lexer->expect('RIGHT_BRACE');
        return array('type' => 'block', 'statement' => $statements);
    }

    public function parse_else() {
        if ($this->lexer->peek()['type'] == "ELSE") {
            $this->lexer->shift();
            $block = $this->parseBlock();
            return $block;
        }
    }

    public function parse_if() {
        if ($this->lexer->peek()['type'] == "IF") {
            $this->lexer->shift();
            $value = $this->parseCondition();
            $block = $this->parseBlock();
            $else = $this->parse_else();
            return array('type' => 'if', 'condition' => $value, 'then' => $block, 'else' => $else);
        }
    }
}