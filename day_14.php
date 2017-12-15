<?php

$prefix = 'ljoxqyyw';

$disk_map = [];

$total_used = 0;

for ($i = 0; $i < 128; $i++) {
    $hex_value = knot_hash("{$prefix}-{$i}");
    $bin_value = '';
    for ($c = 0; $c < strlen($hex_value); $c++) {
        $bin_value .= str_pad(base_convert($hex_value[$c], 16, 2), 4, '0', STR_PAD_LEFT);
    }

    $bin_value = str_replace('0', '.', $bin_value);
    $bin_value = str_replace('1', '#', $bin_value);

    $disk_map[] = str_split($bin_value);

    $total_used += strlen(str_replace('.', '', $bin_value));
}

$group_number = 0;
for ($x = 0; $x < 128; $x++) {
    for ($y = 0; $y < 128; $y++) {
        if ($disk_map[$x][$y] == '#') {
            $group_number++;
            flood_fill($disk_map, $x, $y, '#', str_pad($group_number, 4, '0', STR_PAD_LEFT));
        }
    }
}

echo "Used: $total_used\n";
echo "Groups: {$group_number}\n";

function flood_fill(&$array, $x, $y, $target, $replacement) {
    if ($x < 0 || $x > 127) { return; }
    if ($y < 0 || $y > 127) { return; }

    if ($array[$x][$y] != $target) { return; }

    $array[$x][$y] = $replacement;

    flood_fill($array, $x-1, $y, $target, $replacement);
    flood_fill($array, $x+1, $y, $target, $replacement);
    flood_fill($array, $x, $y-1, $target, $replacement);
    flood_fill($array, $x, $y+1, $target, $replacement);
}

function knot_hash($input) {
    $circle  = range(0,255);
    $lengths = [];

    // Convert ASCII to Array of digits
    for ($i=0; $i < strlen($input); $i++) {
        $lengths[] = ord($input[$i]);
    }

    // Add Suffix
    $lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

    $position = 0;
    $skip_amt = 0;

    // Run the hash 64 times
    for ($round=0; $round < 64; $round++) {
        foreach($lengths as $length) {
            // Reverse
            reverse_slice($circle, $position, $length);

            // Move Pointer
            $position += $length + $skip_amt;
            $position = $position % count($circle);

            // Increment Skip Amount
            $skip_amt++;
        }
    }

    return calculate_hash($circle);
}

function reverse_slice(&$circle, $start, $length) {
    $slice = [];

    // Get Slice
    for ($i=$start; $i < $start+$length; $i++) {
        $slice[] = get_circle_value($circle, $i);
    }

    // Reverse it
    $slice = array_reverse($slice);

    // Write it back
    for ($i=0; $i < $length; $i++) {
        set_circle_value($circle, $start+$i, $slice[$i]);
    }

    return $circle;
}

function get_circle_value($circle, $index) {
    return $circle[$index % count($circle)];
}

function set_circle_value(&$circle, $index, $value) {
    $circle[$index % count($circle)] = $value;
}

function calculate_hash($circle) {
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
