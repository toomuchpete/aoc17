<?php

$banks   = [10,3,15,10,5,15,5,15,9,2,5,8,5,2,3,6];
$history = [];

while (!in_array(implode('_', $banks), $history)) {
    $history[] = implode('_', $banks);

    // redistribute
    $max_value = max($banks);
    $index     = array_search($max_value, $banks);
    
    $block_count = $max_value;
    $banks[$index] = 0;
    while ($block_count > 0) {
        $index = ($index+1) % count($banks);
        $banks[$index]++;
        $block_count--;
    }
}

echo "Result: " . count($history);
