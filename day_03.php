<?php

$memory = [0,1];
$target_value = 265149;

$neighbor_offsets = [
    ["v" =>  1, "h" =>  1],
    ["v" =>  1, "h" =>  0],
    ["v" =>  1, "h" => -1],
    ["v" =>  0, "h" => 1],
    ["v" =>  0, "h" => -1],
    ["v" => -1, "h" => 1],
    ["v" => -1, "h" => 0],
    ["v" => -1, "h" => -1],
];

$i = 1;
while(true) {
    $i++;    
    $loc = get_location_from_address($i);
    $memory[$i] = 0;

    foreach ($neighbor_offsets as $offset) {
        $addr = get_address_from_location($loc["v"]+$offset["v"], $loc["h"]+$offset["h"]);
        if (isset($memory[$addr])) {
            $memory[$i] += $memory[$addr];
        }
    }

    if ($memory[$i] > $target_value) {
        echo "Bigger value found: {$i} => {$memory[$i]}\n";
        exit();
    }
}

echo "Complete\n";

function get_loop_number($address) {
    $loop = ceil(sqrt($address));
    $loop += (($loop+1) % 2);
    return ($loop+1)/2;
}

function get_loop_max_value($loop_number) {
    return pow(($loop_number*2)  - 1, 2);
}

function get_min_distance($address) {
    return get_loop_number($address) - 1;
}

function get_max_distance($address) {
    return sqrt(get_loop_max_value(get_loop_number($address)))-1;
}

function get_loop_corner_addresses($loop_number) {
    $corners = [];

    $max_value = get_loop_max_value($loop_number);
    $side_length = sqrt($max_value);

    for ($i=0; $i < 4; $i++) {
        $corners[$i] = $max_value - (($side_length-1)*$i);
    }

    return $corners;
}

function get_rectilinear_distance($address) {
    $loop_number  = get_loop_number($address);
    $max_value    = get_loop_max_value($loop_number);
    $max_distance = get_max_distance($address);

    for ($i=0; $i < 5; $i++) {
        $corner_address = $max_value - (sqrt($max_value)-1)*$i;
        if ($address == $corner_address) { return $max_distance; }
        
        $distance_to_corner = abs($corner_address - $address);
        if ($distance_to_corner <= (sqrt($max_value)-1)/2) {
            return $max_distance - $distance_to_corner;
        }
    }
    return -1;    
}

function get_address_from_location($vertical_index, $horizontal_index) {
    if ($vertical_index == 0 && $horizontal_index == 0) { return 1;}

    $loop_number = max(abs($vertical_index), abs($horizontal_index))+1;

    $corner_addresses   = get_loop_corner_addresses($loop_number);
    $distance_to_center = ($loop_number-1);

    // Top Side
    if ($vertical_index == $loop_number-1) {
        $center_address = $corner_addresses[2] - $distance_to_center;
        return $center_address - $horizontal_index;
    }

    // Bottom Side
    if ($vertical_index == -($loop_number-1)) {
        $center_address = $corner_addresses[0] - $distance_to_center;
        return $center_address + $horizontal_index;
    }

    // Left Side
    if ($horizontal_index == -($loop_number-1)) {
        $center_address = $corner_addresses[1] - $distance_to_center;
        return $center_address - $vertical_index;
    }

    // Right Side
    if ($horizontal_index == $loop_number-1) {
        $center_address = $corner_addresses[3] - $distance_to_center;
        return $center_address + $vertical_index;
    }
}

function get_location_from_address($address) {
    $loop_number      = get_loop_number($address);
    $corner_addresses = get_loop_corner_addresses($loop_number);

    // Right Side
    if ($address <= $corner_addresses[3]) {
        $distance_to_corner = $corner_addresses[3] - $address;
        return [
            "v" => ($loop_number-1) - $distance_to_corner,
            "h" => $loop_number-1
        ];
    }

    // Top Side
    if ($address <= $corner_addresses[2]) {
        $distance_to_corner = $corner_addresses[2] - $address;
        return [
            "v" => $loop_number-1,
            "h" => -($loop_number-1) + $distance_to_corner
        ];
    }

    // Left Side
    if ($address <= $corner_addresses[1]) {
        $distance_to_corner = $corner_addresses[1] - $address;
        return [
            "v" => -($loop_number-1) + $distance_to_corner,
            "h" => -($loop_number-1)
        ];
    }

    // Bottom Side
    if ($address <= $corner_addresses[0]) {
        $distance_to_corner = $corner_addresses[0] - $address;
        return [
            "v" => -($loop_number-1),
            "h" => ($loop_number-1) - $distance_to_corner
        ];
    }
}
