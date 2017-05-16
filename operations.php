<?php

function    supp($inta, $intb) {
    return $inta > $intb;
}

function    supeq($inta, $intb) {
    return $inta >= $intb;
}

function    infeq($inta, $intb) {
    return $inta <= $intb;
}

function    inf($inta, $intb) {
    return $inta < $intb;
}

function    simpeq($inta, $intb) {
    return $inta = $intb;
}

function    sum($inta, $intb) {
    return $inta + $intb;
}

function    diff($inta, $intb) {
    return $inta - $intb;
}

function    mult($inta, $intb) {
    return $inta * $intb;
}

function    div($inta, $intb) {
    return $inta / $intb;
}

function    dobeq($inta, $intb) {
    return $inta == $intb;
}


function    testoperation($inta, $operand, $intb)
{
    $i = 0;
    $tableope = [
        [ 'oper' => '>', 'func' => 'supp'   ],
        [ 'oper' => '<', 'func' => 'inf'    ],
        [ 'oper' => '<=', 'func' => 'infeq' ],
        [ 'oper' => '>=', 'func' => 'supeq' ],
        [ 'oper' => '=', 'func' => 'simpeq' ],
        [ 'oper' => '==', 'func' => 'dobeq' ],
        [ 'oper' => '+',  'func' => 'sum'   ],
        [ 'oper' => '-', 'func' => 'diff'   ],
        [ 'oper' => '*', 'func' => 'mult'   ],
        [ 'oper' => '/', 'func' => 'div'    ]
    ];

    while ($i < 10)
    {
        if ($operand == $tableope[$i]['oper']) {
            $result = $tableope[$i]['func']($inta, $intb);
            return $result;
        }
        $i++;
    }
    return 0;
}
?>