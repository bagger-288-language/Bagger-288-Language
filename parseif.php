<?php

require "lexer2.php";

/**
 * Created by PhpStorm.
 * User: killianb
 * Date: 3/31/17
 * Time: 11:39 AM
 */
class parseif
{
    private $lexer;

    public function __construct($argv)
    {
        $this->lexer = new lexer2($argv);
    }

    public function parse_statement()
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
    }

    public function parse_block() {
        $this->lexer->expect('LEFT_BRACE');
        $statements = [];
        while ($statement = $this->parse_statement()) {
            $statements[] = $statement;
        }
        $this->lexer->expect('RIGHT_BRACE');
        return array('type' => 'block', 'statement' => $statements);
    }

    public function parse_if() {
        if ($this->lexer->peek()['type'] == "IF") {
            $this->lexer->shift();
            $this->lexer->expect("LEFT_PAREN");
            $value = $this->lexer->expect("INTEGER");
            $this->lexer->expect("RIGHT_PAREN");
            $block = $this->parse_block();
            return array('type' => 'if', 'condition' => $value, 'block' => $block);
        }
    }
}