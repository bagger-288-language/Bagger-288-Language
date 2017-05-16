<?php

require ("functions.php");

class parsefunction
{
    public $lexer;
    private $parse;
    private $function;

    public function __construct($lexer)
    {
        $this->parse = new statements($lexer);
        $this->function = new functions();
        $this->lexer = $lexer;
    }

    public function parseName()
    {
        return array('type' => 'name', 'name' => $this->lexer->expect('STRING'));
    }

    public function parseArgument()
    {
        $this->lexer->expect("LEFT_PAREN");
        $argument = [];
        while (($temp = $this->lexer->peek()["type"]) != 'RIGHT_PAREN') {
            $argument[] = $this->lexer->expect($temp);
            if ($this->lexer->peek()["type"] != 'RIGHT_PAREN')
                $this->lexer->expect('COLON');
        }
        $this->lexer->expect('RIGHT_PAREN');
        return array('type' => 'argument', 'argument' => $argument);
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

    public function parseBlock()
    {
        $this->lexer->expect('LEFT_BRACE');
        $statements = [];
        while ($statement = $this->parseStatement()) {
            $statements[] = $statement;
        }
        $this->lexer->expect('RIGHT_BRACE');
        return array('type' => 'block', 'statement' => $statements);
    }

    public function parse_function() {
        if ($this->lexer->peek()['type'] == "FUNCTION") {
            $this->lexer->shift();
            $name = $this->parseName();
            $arg = $this->parseArgument();
            $stat = $this->parseBlock();
            $this->function->setFunc($name["name"]["value"], array($arg, $stat));
            return array('type' => 'function', 'name' => $name, 'argument' => $arg, 'statement' => $stat);
        }
        else return NULL;
    }
}