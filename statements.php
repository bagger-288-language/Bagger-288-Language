<?php

require ("variable.php");
require ("operations.php");

class statements
{
    public $parseFunctions;
    public $lexer;
    public $index;
    private $vars;
    private $temp;
    private $value;
    private $operand;

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
                if ($this->lexer->peek()["type"] == 'EQUAL') {
                    $this->lexer->shift();
                    $this->value = NULL;
                    while ($this->lexer->peek()["type"] != "SEMICOLON") {
                        if (!$this->value)
                            if(!$this->vars->getValue($this->temp))
                                $this->value = $this->lexer->shift()["value"];
                            else $this->value = $this->vars->getValue($this->lexer->shift()["value"]);
                        else {
                            $this->operand = $this->lexer->expect('OPERAND')["value"];
                            if ($this->lexer->peek()["type"] == 'VARIABLE') {
                                $this->value = testoperation($this->value, $this->operand,
                                    $this->vars->getValue($this->lexer->shift()["value"]));
                            }
                            else $this->value = testoperation($this->value, $this->operand,
                                $this->lexer->shift()["value"]);
                        }
                    }
                    $this->vars->updateValue($this->temp, $this->value);
                    $this->lexer->expect('SEMICOLON');
                    return array('type' => 'VARIABLE', 'value' => $this->temp);
                } else return array('type' => 'VARIABLE', 'value' => $this->temp);
            },
            'SEMICOLON' => function () {
                return $this->lexer->shift();
            }
        );
        $this->index = array('PRINT', 'INTEGER', 'OPERAND', 'EQUAL', 'STRING', 'VARIABLE', 'SEMICOLON');
    }
}