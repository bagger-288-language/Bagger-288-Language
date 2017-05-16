<?php

function codestruct($argv)
{
    $rules = [
        [ 'function',        'FUNCTION'          ],
        [ 'if',              'IF'                ],
        [ '\(',              'LEFT_PAREN'        ],
        [ '\)',              'RIGHT_PAREN'       ],
        [ '\{',              'LEFT_BRACE'        ],
        [ '\}',              'RIGHT_BRACE'       ],
        [ '\d+',             'INTEGER'           ],
        [ '\;',              'SEMICOLON'         ],
        [ '\,',              'COLON'             ],
        [ '\"',              'DOUBLE_QUOTE'      ],
        [ '\=',              'EQUAL'             ],
        [ 'else',            'ELSE'              ],
        [ '\$[\w\d]+',       'VARIABLE'          ],
        [ 'print',           'PRINT'             ],
        [ '>=|<=|==|[<>]',   'OPERAND'           ],
        [ '\n',              'CHARIOT_RETURN'    ],
        [ '[\w\s]+',         'STRING'            ],
        [ '\+',              'OPERAND'           ],
        [ '\-',              'OPERAND'           ],
        [ '\*',              'OPERAND'           ],
        [ '\/',              'OPERAND'           ]
    ];
    $open = fopen($argv[1], "r");
    $code = fread($open, filesize($argv[1]));
    $result = [];
    $code = rtrim($code);
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
            exit('Unable to find a rule: ' . $code . '\n');
        }
    }
    return $result;
}

?>
