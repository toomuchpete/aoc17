<?php

    $route = trim(file_get_contents('data/day_11.txt'));
    $steps = explode(',', $route);


    $cube_x = 0;
    $cube_y = 0;
    $cube_z = 0;

    $max_distance = 0;

foreach ($steps as $step) {
    move($step, $cube_x, $cube_y, $cube_z);

    $current_distance = distance_to_origin($cube_x, $cube_y, $cube_z);
    $max_distance = max($max_distance, $current_distance);
}

echo "Coordinates: ({$cube_x},{$cube_y},{$cube_z})\n";

$sc = distance_to_origin($cube_x, $cube_y, $cube_z);
echo "Steps home: $sc\n";
echo "Max distance: {$max_distance}\n";

function move($direction, &$cube_x, &$cube_y, &$cube_z) {
    switch ($direction) {
        case 'n':
            $cube_y++;
            $cube_z--;
            break;
        case 's':
            $cube_y--;
            $cube_z++;
            break;
        case 'ne':
            $cube_x++;
            $cube_z--;
            break;
        case 'sw':
            $cube_x--;
            $cube_z++;
            break;
        case 'nw':
            $cube_x--;
            $cube_y++;
            break;
        case 'se':
            $cube_x++;
            $cube_y--;
            break;        
        default:
            die("Bad direction: {$step}\n");
            break;
    }    
}

function distance_to_origin($x, $y, $z) {
    $step_count = 0;
    while ($x != 0 || $y != 0 || $z != 0) {
        $step_count++;

        // Seek x==0
        if ($x > 0) { // Move West
            if ($y < 0) {
                move('nw', $x, $y, $z);
                continue;
            }

            if ($z < 0) {
                move('sw', $x, $y, $z);
                continue;
            }

            die("Error: ({$x},{$y},{$z})\n");
        }

        if ($x < 0) { // Move East
            if ($y > 0) {
                move('se', $x, $y, $z);
                continue;
            }

            if ($z > 0) {
                move('ne', $x, $y, $z);
                continue;
            }

            die("Error: ({$x},{$y},{$z})\n");
        }

        if ($y < 0) {
            move('n', $x, $y, $z);
            continue;
        }

        if ($y > 0) {
            move('s', $x, $y, $z);
            continue;
        }
    }

    return $step_count;
}
