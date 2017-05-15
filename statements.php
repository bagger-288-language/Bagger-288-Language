<?php

require ("variable.php");

class statements
{
    public $parseFunctions;
    public $lexer;
    public $index;
    private $vars;
    private $temp;

    /**
     * @param mixed $parseFunctions
     */
    public function __construct($lexer)
    {
        $this->lexer = $lexer;
        $this->vars = new variable();
        $this->parseFunctions = array(
            'PRINT' => function () {
                $this->lexer->shift();
                if ($this->lexer->peek()["type"] == 'DOUBLE_QUOTE') {
                    $this->lexer->shift();
                    $temp = $this->lexer->peek()["type"];
                    if ($temp == 'STRING')
                        $value = $this->lexer->expect('STRING');
                    else if ($temp == 'INTEGER')
                        $value = $this->lexer->expect('INTEGER');
                    $this->lexer->expect('DOUBLE_QUOTE');
                }
                elseif ($this->lexer->peek()["type"] == 'VARIABLE') {
                    $value = $this->lexer->expect('VARIABLE');
                }
                elseif ($this->lexer->peek()["type"] == 'INTEGER') {
                    $value = $this->lexer->expect('INTEGER');
                }
                $this->lexer->expect('SEMICOLON');
                return array('type' => 'PRINT', 'value' => $value);
            },
            'INTEGER' => function () {
                return $this->lexer->shift();
            },
            'OPERAND' => function () {
                return $this->lexer->shift();
            },
            'EQUAL' => function () {
                return $this->lexer->shift();
            },
            'STRING' => function () {
                return $this->lexer->shift();
            },
            'VARIABLE' => function () {
                $this->temp = $this->lexer->peek()["value"];
                $this->lexer->shift();
                $this->lexer->expect('EQUAL');
//                $value = $this->lexer->peek()["type"];
                if (!$this->vars->getValue($this->temp)) {
                    $this->vars->addVariable($this->temp, $this->lexer->peek()["value"]);
                    $this->lexer->shift();
                    return array('type' => 'VARIABLE', 'value' => $this->temp);
                }
            },
            'SEMICOLON' => function () {
                return $this->lexer->shift();
            }
        );
        $this->index = array('PRINT', 'INTEGER', 'OPERAND', 'EQUAL', 'STRING', 'VARIABLE', 'SEMICOLON');
    }
}