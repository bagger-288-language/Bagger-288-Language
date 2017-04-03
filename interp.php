<?php
$tree = array [
    'type' => 'if',
    'condition' =>
    array [ 
        'type' => 'INTEGER',
        'value' => '1',
    ],
    'then' =>
    array [ 
        'type' => 'block',
        'statements' =>
        array [
            array [ 
                'type' => 'print',
                'value' => 
                array [ 
                    'type' => 'STING',
                    'value' => 'Hello',
                ],
            ],
            array [ 
                'type' => 'print',
                'value' =>
                array [ 
                    'type' => 'STING',
                    'value' => 'world',
                ],
            ],
        ],
    ],
];

function run($tree) { 
    switch ($tree['type']) { 
    case 'if':
        $condition = run($tree['condition']);
        if ($condition != 0) {
            run($tree['then']);
        }
        break;

    case 'block';
        $value = 0;
        foreach ($tree['statements'] as $statements) {
            $value = run($statement);
        }
    case 'print':
        $value = run($tree['value']);
        echo $value;
        return $value;

    case 'INTEGER':
        return ($tree['value']);

    case 'STRING':
        return $tree['value'];

    default:
        exit('Unable to handle node type' . $tree['type']);
    }
}

run($tree);

?>

