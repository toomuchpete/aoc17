<?php

$map = [];

$input = trim("
..#
#..
...
");

$input = trim(file_get_contents('./data/day_22.txt'));

// Load Map

$map_rows = explode("\n", $input);
$width  = strlen($map_rows[0]);
$extent = ($width-1)/2;

foreach ($map_rows as $row_index => $row) {
    for ($i = 0; $i < $width; $i++) {
        $coord_y = $extent - $row_index;
        $coord_x = $i - $extent;

        $coord_key = get_key($coord_x, $coord_y);
        $map[$coord_key] = $row[$i];
    }
}

$pos_x  = 0;
$pos_y  = 0;
$facing = 'up';

$infection_count = 0;

for ($burst = 0; $burst < 10000; $burst++) {
    $key = get_key($pos_x,$pos_y);
    if ($map[$key] == '#') {
        turn_right();
        $map[$key] = '.';
    } else {
        turn_left();
        $map[$key] = '#';
        $infection_count++;
    }

    switch ($facing) {
        case 'up':
            $pos_y++;
            break;
        case 'down':
            $pos_y--;
            break;
        case 'left':
            $pos_x--;
            break;
        case 'right':
            $pos_x++;
            break;     
    }

    $extent = max($extent, abs($pos_x), abs($pos_y));

    if (isset($map[get_key($pos_x,$pos_y)]) == false) {
        $map[get_key($pos_x,$pos_y)] = '.';
    }
}

// display($map, $extent);
echo "Infections: {$infection_count}\n";

function get_key($x, $y) {
    return "{$x}|{$y}";
}

function display($map, $extent) {
    for ($row = $extent; $row >= -$extent; $row--) {
        for ($col = -$extent; $col <= $extent; $col++) {
            if (isset($map[get_key($col,$row)]) == false) {
                echo ' . ';
                continue;
            }

            echo ' ' . $map[get_key($col,$row)] . ' ';
        }
        echo "\n";
    }
}

function turn_right() {
    global $facing;

    switch ($facing) {
        case 'up':
            $facing = 'right';
            break;
        case 'right':
            $facing = 'down';
            break;
        case 'down':
            $facing = 'left';
            break;
        case 'left':
            $facing = 'up';
            break;
    }
}

function turn_left() {
    global $facing;

    switch ($facing) {
        case 'up':
            $facing = 'left';
            break;
        case 'left':
            $facing = 'down';
            break;
        case 'down':
            $facing = 'right';
            break;
        case 'right':
            $facing = 'up';
            break;
    }    
}
