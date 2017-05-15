<?php

require "tokenization.php";

class lexer2
{
    public $parser;

    public function __construct($argv)
    {
        $this->parser = codestruct($argv);
    }

    public function peek()
    {
        if ($this->parser)
        return $this->parser[0];
        else return NULL;
    }

    public function shift()
    {
        return array_shift($this->parser);
    }

    public function expect($type)
    {
        $token = $this->shift();
        if ($type != $token['type']) {
            throw new Exception('Undefined type : ' . $token['type'] . ' wanted : ' . $type);
        }
        return $token;
    }
}