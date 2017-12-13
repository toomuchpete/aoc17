<?php

$input = trim(file_get_contents('data/day_13.txt'));

$layers = explode("\n", $input);
$layer_depths = [];

foreach ($layers as $layer) {
    list($number, $depth) = explode(': ', $layer);
    $layer_depths[$number] = $depth;
    $layer_positions[$number] = 0;
}

$first_layer = min(array_keys($layer_depths));
$last_layer  = max(array_keys($layer_depths));

$severity = 0;
$delay = 0;

do {
    $caught   = false;

    foreach ($layer_depths as $layer => $depth) {
        $time = $delay + $layer;
        if ($time % (($depth-1)*2) == 0) {
            $caught = true;
            break;
        }
    }

    if ($caught) { $delay++; }
} while ($caught);

echo "Required delay: {$delay}\n";
