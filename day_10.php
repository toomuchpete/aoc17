<?php

    $circle   = range(0,255);
    $string   = "76,1,88,148,166,217,130,0,128,254,16,2,130,71,255,229";
    $position = 0;
    $skip_amt = 0;

$lengths = [];

// Convert ASCII to Array of digits
for ($i=0; $i < strlen($string); $i++) {
    $lengths[] = ord($string[$i]);
}

// Add Suffix
$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

// Run the hash 64 times
for ($round=0; $round < 64; $round++) {
    foreach($lengths as $length) {
        // Reverse
        reverse_slice($position, $length);

        // Move Pointer
        $position += $length + $skip_amt;
        $position = $position % count($circle);

        // Increment Skip Amount
        $skip_amt++;
    }    
}

echo "Hash: " . calculate_hash() . "\n";

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

function calculate_hash() {
    global $circle;

    $hash = [];

    $circle_chunks = array_chunk($circle, 16);

    foreach ($circle_chunks as $hash_pieces) {
        $value = array_shift($hash_pieces);

        while (count($hash_pieces) > 0) {
            $new_bits = array_shift($hash_pieces);
            $value = $value ^ $new_bits;
        }

        $hash[] = $value;
    }

    $hash_string = '';

    foreach ($hash as $hash_digit) {
        $hash_string .= str_pad(dechex($hash_digit), 2, '0', STR_PAD_LEFT);
    }

    return $hash_string;
}
