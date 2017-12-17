<?php

$step_distance = 382;

$focus_position = 1;
$focus_value    = -1;

$position = 0;
$list_count = 1;

for ($i = 1; $i <= 50000000; $i++) {
    $position += $step_distance;
    $position = ($position % $list_count)+1;
    $list_count++;

    if ($position == $focus_position) {
        $focus_value = $i;
    }
}

echo "Value at {$focus_position}: {$focus_value}\n";
