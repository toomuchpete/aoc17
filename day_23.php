<?php

$reg = [
    'a' => 1, 
    'b' => 0, 
    'c' => 0,
    'd' => 0,
    'e' => 0,
    'f' => 0,
    'g' => 0,
    'h' => 0,
];

$input = trim(file_get_contents('./data/day_23.txt'));

$instructions = explode("\n", $input);

$ptr = 0;

$mul_count = 0;
while (true) {
    $move = 1;
    $ins  = explode(' ', $instructions[$ptr]);

    switch ($ins[0]) {
        case 'set':
            $reg[$ins[1]] = get_val($ins[2]);
            break;
        case 'sub':
            $reg[$ins[1]] -= get_val($ins[2]);
            break;
        case 'mul':
            $reg[$ins[1]] *= get_val($ins[2]);
            $mul_count++;
            break;
        case 'mod':
            $reg[$proc][$ins[1]] = $reg[$proc][$ins[1]] % get_val($ins[2]);
            break;
        case 'jnz':
            if (get_val($ins[1]) != 0) {
                $move = get_val($ins[2]);
            }
            break;
        case 'jgz':
            if (get_val($ins[1]) > 0) {
                $move = get_val($ins[2]);
            }
            break;
    }

    $ptr += $move;
    if (isset($instructions[$ptr]) == false) {break;}
}

function get_val($name) {
    global $reg;

    if (is_numeric($name)) { return $name; };

    if (isset($reg[$name]) == false) { $reg[$name] = 0; }

    return $reg[$name];
}
