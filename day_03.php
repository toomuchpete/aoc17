<?php

echo "Solution: " . get_rectilinear_distance(265149);

function get_loop_number($location) {
    $loop = ceil(sqrt($location));
    $loop += (($loop+1) % 2);
    return ($loop+1)/2;
}

function get_loop_max_value($location) {
    $loop_number = get_loop_number($location);
    return pow(($loop_number*2)  - 1, 2);
}

function get_min_distance($location) {
    return get_loop_number($location) - 1;
}

function get_max_distance($location) {
    return sqrt(get_loop_max_value($location))-1;
}

function get_rectilinear_distance($location) {
    $max_value    = get_loop_max_value($location);
    $max_distance = get_max_distance($location);

    for ($i=0; $i < 5; $i++) {
        $corner_location = $max_value - (sqrt($max_value)-1)*$i;
        if ($location == $corner_location) { return $max_distance; }
        
        $distance_to_corner = abs($corner_location - $location);
        if ($distance_to_corner <= (sqrt($max_value)-1)/2) {
            return $max_distance - $distance_to_corner;
        }
    }
    return -1;    
}