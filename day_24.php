<?php

$input = trim("
0/2
2/2
2/3
3/4
3/5
0/1
10/1
9/10
");

$input = file_get_contents('./data/day_24.txt');

$input_rows = explode("\n", $input);

// Find Ports
$comps = [];
foreach ($input_rows as $row) {
    list($p1, $p2) = explode("/", $row);

    $comps[] = [min($p1, $p2), max($p1, $p2)];
}

function find_strength($bridge) {
    global $comps;
    $str = 0;
    foreach ($bridge as $comp_index) {
        $str += array_sum($comps[$comp_index]);
    }

    return $str;
}

$strongest_bridge = [];
$longest_bridge = [];

function find_best_bridge($bridge, $avail_comps, $open_port = 0) {
    global $comps, $strongest_bridge, $longest_bridge;
    $bridge_complete = true;

    foreach ($avail_comps as $ci) {
        if (in_array($open_port, $comps[$ci])) {
            $bridge_complete = false;
            $new_bridge = array_values($bridge);
            $new_bridge[] = $ci;

            $new_comps = array_diff($avail_comps, [$ci]);

            $new_open_port = $comps[$ci][0];
            if ($new_open_port == $open_port) { $new_open_port = $comps[$ci][1]; }
            find_best_bridge($new_bridge, $new_comps, $new_open_port);
        }
    }

    if ($bridge_complete) {
        if (find_strength($bridge) > find_strength($strongest_bridge)) {
            $strongest_bridge = array_values($bridge);
        }

        if (count($bridge) > count($longest_bridge) || 
            (count($bridge) == count($longest_bridge) && find_strength($bridge) > find_strength($longest_bridge))) {
            $longest_bridge = array_values($bridge);
        }
    }
}


find_best_bridge([], array_keys($comps));

echo "STRONGEST: \n";
foreach ($strongest_bridge as $ci) {
    echo "-{$comps[$ci][0]}/{$comps[$ci][1]}-";
}   echo "\n";
    echo "Strength: " . find_strength($strongest_bridge) . "\n";

echo "LONGEST: \n";
foreach ($longest_bridge as $ci) {
    echo "-{$comps[$ci][0]}/{$comps[$ci][1]}-";
}   echo "\n";
    echo "Strength: " . find_strength($longest_bridge) . "\n";    
