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

$seen_at_step = [];
$seen_at_step[] = count($history);
$seen_at_step[] = array_search(implode('_', $banks), $history);

echo "Total Balance Steps: " . count($history) . "\n";
echo "Distance between dupes: " . ($seen_at_step[0] - $seen_at_step[1]) . "\n";
