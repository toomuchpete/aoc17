<?php
    
    $input = trim(file_get_contents('./data/day_15.txt'));
    $input = trim("");

$a = 512;
$b = 191;
$matches = 0;
for ($i = 1; $i <= 5000000; $i++) {
    if ($i % 10000 == 0) {echo "."; }
    if ($i % 1000000 == 0) {echo "\n"; }
    $a = next_val_a($a);
    $b = next_val_b($b);

    $a_bits = get_bits($a);
    $b_bits = get_bits($b);
    if ($a_bits == $b_bits) { $matches++; }
}

echo "Matches: {$matches}\n";

function next_val_a($previous_value) {
    $value = $previous_value;
    do {
        $value = generate($value, 16807);
    } while ($value % 4 != 0);

    return $value;
}

function next_val_b($previous_value) {
    $value = $previous_value;
    do {
        $value = generate($value, 48271);
    } while ($value % 8 != 0);

    return $value;
}

function generate($previous_value, $factor) {
    return ($previous_value * $factor) % 2147483647;
}


function get_bits($number) {
    $binary = decbin($number);
    $binary = str_pad($binary, 16, 0, STR_PAD_LEFT);
    return substr($binary, -16);
}
