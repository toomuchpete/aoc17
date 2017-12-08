<?php

$input = explode("\n", trim(file_get_contents('data/day_08.txt')));

$register_data = array();
$max_seen = 0;

foreach ($input as $row) {
    $tokens = explode(' ', $row);

    $target_register = $tokens[0];
    $instruction = $tokens[1];
    $amount = $tokens[2];
    $test_register = $tokens[4];
    $test_condition = $tokens[5];
    $test_value = $tokens[6];

    echo "{$row} ";

    if (register_passes($test_register, $test_condition, $test_value)) {
        echo " PASS!\n";
        modify_register($target_register, $instruction, $amount);
    } else {
        echo " x\n";
    }
}

arsort($register_data);

print_r($register_data);

echo "Max Value: {$max_seen}\n";

function register_passes($register, $test, $value) {
    global $register_data;

    $register_value = 0;
    if (isset($register_data[$register])) {
        $register_value = $register_data[$register];
    }

    switch ($test) {
        case '>':
            return ($register_value > $value);
            break;
        case '>=':
            return ($register_value >= $value);
            # code...
            break;
        case '<':
            return ($register_value < $value);
            # code...
            break;
        case '<=':
            return ($register_value <= $value);
            # code...
            break;
        case '==':
            return ($register_value == $value);
            # code...
            break;      
        case '!=':
            return ($register_value != $value);
            # code...
            break;
        default:
            die("Unknown test: {$test}");
            break;
    }
}

function modify_register($register, $direction, $amount) {
    global $register_data, $max_seen;

    if (!isset($register_data[$register])) {
        $register_data[$register] = 0;
    }

    if ($direction == 'inc') {
        $register_data[$register] += $amount;
    }

    if ($direction == 'dec') {
        $register_data[$register] -= $amount;
    }

    if ($register_data[$register] > $max_seen) {
        $max_seen = $register_data[$register];
    }
}
