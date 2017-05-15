<?php

require "statements.php";

class parseif
{
    public $lexer;
    private $parse;

    public function __construct($lexer)
    {
        $this->parse = new statements($lexer);
        $this->lexer = $lexer;
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
        $i = 0;
        while ($i < 7) {
            if ($this->lexer->peek()['type'] == $this->parse->index[$i]) {
                return call_user_func($this->parse->parseFunctions[$this->parse->index[$i]]);
            }
            $i++;
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
        else return NULL;
    }

    public function parse_if() {
        if ($this->lexer->peek()['type'] == "IF") {
            $this->lexer->shift();
            $value = $this->parseCondition();
            $block = $this->parseBlock();
            $else = $this->parse_else();
            return array('type' => 'if', 'condition' => $value, 'then' => $block, 'else' => $else);
        }
        else return NULL;
    }
}