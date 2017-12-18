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
$reg     = [];
$sounds  = [];

while ($pointer < count($instructions)) {
    $move = 1;
    $ins  = explode(' ', $instructions[$pointer]);

    echo "> {$instructions[$pointer]}\n";

    
    switch ($ins[0]) {
        case 'snd':
            $freq = get_val($ins[1]);
            $sounds[] = $freq;
            echo " - Sound Played: {$freq}\n";
            break;
        case 'set':
            $reg[$ins[1]] = get_val($ins[2]);
            break;
        case 'add':
            $reg[$ins[1]] += get_val($ins[2]);
            break;
        case 'mul':
            $reg[$ins[1]] *= get_val($ins[2]);
            break;
        case 'mod':
            $reg[$ins[1]] = $reg[$ins[1]] % get_val($ins[2]);
            break;
        case 'rcv':
            if (get_val($ins[1]) != 0) {
                echo " - Sound Recovered: " . end($sounds) . "\n";
                break 2;
            }
            break;
        case 'jgz':
            if (get_val($ins[1]) > 0) {
                $move = $ins[2];
            }
            break;
    }

    $pointer += $move;
}

print_r($sounds);

function get_val($name) {
    global $reg;

    if (is_numeric($name)) { return $name; };

    if (isset($reg[$name]) == false) { $reg[$name] = 0; }

    return $reg[$name];
}
