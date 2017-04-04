<?php
require "lexer2.php";

class parsefunction
    {
    public $lexer;

    public function __construct($argv)
    {
        $this->lexer = new lexer2($argv);
    }

    public function parseName()
    {

    }

    public function parseArgument()
    {
        $this->lexer->expect("LEFT_PAREN");
        $argument = [];
        while (($temp = $this->lexer->peek()["type"]) != 'RIGHT_PAREN') {
            $argument[] = $this->lexer->expect($temp);
        }
        $this->lexer->expect('RIGHT_PAREN');
        return array('type' => 'argument', 'argument' => $argument);
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