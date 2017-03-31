<?php

function codestruct($argv)
{
    $rules = [
        [ 'function', 'FUNCTION' ],
        [ 'if',       'IF' ],
        [ '\(',       'LEFT_PAREN' ],
        [ '\)',       'RIGHT_PAREN' ],
        [ '\{',       'LEFT_BRACE' ],
        [ '\}',       'RIGHT_BRACE' ],
        [ '\d+',      'INTEGER' ],
        [ '\;',       'SEMICOLON' ],
        [ '\"',       'DOUBLE_QUOTE' ],
        [ 'else',     'ELSE' ],
        [ 'print',    'PRINT' ],
        [ '==',       'DOUBLE_EQUAL' ],
        [ '<',        'LT'],
        [ '>',        'GT'],
        [ '>=',       'GT_EQUAL'],
        [ '<=',       'LT_EQUAL'],
        [ '+',        'ADD'],
        [ '-',        'SOUS'],
        [ '*',        'MULTIPLE'],
        [ '\/',       'DIV'],
        [ '[\w\s\d]+',    'STRING' ],
    ];

    $open = fopen($argv[1], "r");
    $code = fread($open, filesize($argv[1]));
    $result = [];

    while ($code) {
        $code = ltrim($code);
        $valid = false;
        foreach ($rules as $rule) {
            $pattern = "/^" . $rule[0] . "/";
            $type = $rule[1];

            if (preg_match($pattern, $code, $capture)) {
                $result[] = [
                    'type' => $type,
                    'value' => $capture[0],
                ];
                $valid = true;
                $code = substr($code, strlen($capture[0]));
                break;
            }
        }
        if (!$valid) {
            var_dump($result);
            exit('Unable to find a rule: ' . $code . '\n');
        }
    }
    return $result;
}

?>
