<?php

$jump_list = explode("\n", trim(file_get_contents('data/day_05.txt')));

$pointer = 0;
$jump_count = 0;

while ($pointer < count($jump_list)) {
    $distance = $jump_list[$pointer];

    if ($distance >= 3) {
        $jump_list[$pointer]--;
    } else {
        $jump_list[$pointer]++;
    }
    
    $pointer += $distance;
    $jump_count++;
}

print "Final Jump Count: {$jump_count}";
