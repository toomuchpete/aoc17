<?php

    $circle   = range(0,255);
    $lengths  = array(76,1,88,148,166,217,130,0,128,254,16,2,130,71,255,229);
    $position = 0;
    $skip_amt = 0;

foreach($lengths as $length) {
    // Reverse
    reverse_slice($position, $length);

    // Move Pointer
    $position += $length + $skip_amt;
    $position = $position % count($circle);

    // Increment Skip Amount
    $skip_amt++;
}

print_r($circle);

function reverse_slice($start, $length) {
    $slice = [];

    // Get Slice
    for ($i=$start; $i < $start+$length; $i++) {
        $slice[] = get_circle_value($i);
    }

    // Reverse it
    $slice = array_reverse($slice);

    // Write it back
    for ($i=0; $i < $length; $i++) {
        set_circle_value($start+$i, $slice[$i]);
    }
}

function get_circle_value($index) {
    global $circle;

    return $circle[$index % count($circle)];
}

function set_circle_value($index, $value) {
    global $circle;

    $circle[$index % count($circle)] = $value;
}
