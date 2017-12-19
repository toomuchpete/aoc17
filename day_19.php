<?php

$input = "
     |          
     |  +--+    
     A  |  C    
 F---|----E|--+ 
     |  |  |  D 
     +B-+  +--+
";

$input = file_get_contents('./data/day_19.txt');

$map = [];

// Parse Map
$rows = explode("\n", $input);
foreach ($rows as $row) {
    if (empty($row)) { continue; }
    $map[] = str_split($row);
}

// Find Start
$row = 0;
$col = strpos(implode('', $map[0]), '|');

$h_dir = 0;
$v_dir = 1;

$signposts = [];
$steps = 0;

while (true) {
    if (isset($map[$row][$col]) == false) {
        break; // off the edge
    }
    
    $path = $map[$row][$col];

    if ($path == ' ') {
        break; // Trail ends
    }

    while ($path != '+') {
        if (preg_match("/^[a-z]$/i", $path)) {
           $signposts[] = $path;
        }

        if ($path == ' ') {
            break 2; 
        }

        move();

        if (isset($map[$row][$col]) == false) { break 2; }

        $path = $map[$row][$col];
    }

    // Turn!
    if ($h_dir == 0) {
        if (isset($map[$row][$col-1]) && $map[$row][$col-1] != ' ') {
            $h_dir = -1; 
            $v_dir = 0; 
        } else {
            $h_dir = 1;
            $v_dir = 0;
        }
    } elseif ($v_dir == 0) {
        if (isset($map[$row-1][$col]) && $map[$row-1][$col] != ' ') {
            $h_dir = 0;
            $v_dir = -1;
        } else {
            $h_dir = 0; 
            $v_dir = 1;
        }
    }

    move();
}

echo "Signposts: " . implode('', $signposts) . "\n";
echo "Steps:     {$steps}\n";

function move() {
    global $row, $col, $v_dir, $h_dir, $steps;

    $steps++;
    $row += $v_dir;
    $col += $h_dir;
}
