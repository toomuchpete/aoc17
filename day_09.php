<?php

$stream = trim(file_get_contents('data/day_09.txt'));

$pointer = 0;
$groups_open = 0;
$garbage_open = false;

$group_depth = [];

$garbage = '';

while ($pointer < strlen($stream)) {
    $char = $stream[$pointer];

    if ($garbage_open) {
        if ($char == '!') { 
            $pointer += 2; 
            continue; 
        }
        
        if ($char == '>') { 
            $garbage_open = false; 
            $pointer++;
            continue;
        }

        $garbage .= $char;

        $pointer++;
        continue;
    }

    switch ($char) {
        case '{':
            $groups_open++;
            break;
        case '}':
            $group_depth[] = $groups_open;
            $groups_open--;
            break;
        
        case '<':
            $garbage_open = true;
            break;
    }

    $pointer++;
}

echo "Group Sum: " . array_sum($group_depth) . "\n";
echo "Garbage Chars: " . strlen($garbage) . "\n";
