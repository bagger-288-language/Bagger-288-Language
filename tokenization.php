<?php

$rules = [
    [ 'if',   'IF' ],
    [ '\(',   'LEFT_PAREN' ],
    [ '\)',   'RIGHT_PAREN' ],
    [ '\{',   'LEFT_BRACE' ],
    [ '\}',   'RIGHT_BRACE' ],
    [ '\d+',  'INTEGER' ],
    [ '\;',   'END'],
    [ '\"',   'DOUBLE_QUOTE' ],
    [ 'else', 'ELSE' ],
    [ 'print', 'PRINT' ],
];

$code = ' if (1) {}';
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
    if (!valid) {
        var_dump($result);
        exit('Unable to find a rule: ' . $code);
    }
}
var_dump($result);
?>