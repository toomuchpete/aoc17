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
$position = -1;

for ($time = 0 ; $time <= $last_layer; $time++) {
    // Move the packet
    $position++;

    // Check for caught
    if (isset($layer_depths[$position]) && ($layer_positions[$position] == 0)) {
        $severity += $position * $layer_depths[$position];
        echo "Caught at {$position}\n";
    }

    // Move the scanner
    foreach($layer_positions as $layer => $scanner_position) {
        $depth = $layer_depths[$layer];
        $new_pos = ($scanner_position+1) % (($depth-1)*2);
        $layer_positions[$layer] = $new_pos;
    }
}

echo "Severity: {$severity}\n";
