<?php

$input = trim("
set a 1
add a 2
mul a a
mod a 5
snd a
set a 0
rcv a
jgz a -1
set a 1
jgz a -2
");

$input = trim(file_get_contents('./data/day_18.txt'));

$instructions = explode("\n", $input);

$pointer = 0;
$reg = [
    ['p' => 0],
    ['p' => 1]
];

$ptr = [0, 0];

$q = [[],[]];
$proc = 0;

$send_count = [0,0];

$wait = [false, false];

while (true) {
    $move = 1;
    $ins  = explode(' ', $instructions[$ptr[$proc]]);

    $other_proc = ($proc+1) % 2;

    switch ($ins[0]) {
        case 'snd':
            $q[$other_proc][] = get_val($ins[1]);
            $send_count[$proc]++;
            break;
        case 'set':
            $reg[$proc][$ins[1]] = get_val($ins[2]);
            break;
        case 'add':
            $reg[$proc][$ins[1]] += get_val($ins[2]);
            break;
        case 'mul':
            $reg[$proc][$ins[1]] *= get_val($ins[2]);
            break;
        case 'mod':
            $reg[$proc][$ins[1]] = $reg[$proc][$ins[1]] % get_val($ins[2]);
            break;
        case 'rcv':
            $wait[$proc] = false;
            if (empty($q[$proc]) == false) {
                $reg[$proc][$ins[1]] = array_shift($q[$proc]);
            } else {
                $wait[$proc] = true;
                $move = 0;
            }
            break;
        case 'jgz':
            if (get_val($ins[1]) > 0) {
                $move = get_val($ins[2]);
            }
            break;
    }

    if ($wait[0] && $wait[1]) { break; } // Deadlocked

    $ptr[$proc] += $move;
    $proc = $other_proc;
}

print_r($send_count);

function get_val($name) {
    global $reg, $proc;

    if (is_numeric($name)) { return $name; };

    if (isset($reg[$proc][$name]) == false) { $reg[$proc][$name] = 0; }

    return $reg[$proc][$name];
}
