<?php

$input = explode("\n", trim(file_get_contents('data/day_07.txt')));

$tree_data = [];

$kids_list = [];

foreach ($input as $program_data) {
    $parts = explode(' -> ', $program_data);
    $self  = array_shift($parts);

    $children = [];
    if (count($parts) > 0) {
        $children = explode(", ", array_shift($parts));    
    }
    
    $self = trim(str_replace(')', '', $self));
    list($name,$size) = explode(' (', $self);

    $tree_data[$name] = [
        'name' => $name,
        'size' => $size,
        'kids' => $children
    ];

    foreach ($children as $kid) {
        $kids_list[$kid] = true;
    }
}

$root = '';

foreach (array_keys($tree_data) as $name) {
    if (!isset($kids_list[$name])) {
        $root = $name;
    }
}

calculate_sizes($root);

$pointer = $root;
while (true) {
    $program = $tree_data[$pointer];

    $odd_size = 0;
    $good_size = 0;
    $size_counts = array_count_values($program['kid_sizes']);
    foreach($size_counts as $size => $count) {
        if ($count == 1) {
            $odd_size = $size;
        } else {
            $good_size = $size;
        }
    }

    $odd_node = null;
    foreach ($program['kid_sizes'] as $kid_name => $size) {
        if ($size == $odd_size) {
            $odd_node = $kid_name;
        }
    }

    echo "Node: {$pointer}\n";
    echo "\tSelf: {$program['size']}\n";
    echo "\tKids: " . implode(', ', $program['kid_sizes']) . "\n";
    if ($odd_node) {
        echo "Unbalanced node: {$odd_node}. Size: {$odd_size} (Should be: {$good_size})\n";
    }
    echo "\n";

    if ($odd_size == 0) {
        echo "Done";
        break;
    }

    $pointer = $odd_node;
}


function calculate_sizes($name) {
    global $tree_data;

    $program = $tree_data[$name];

    if (empty($program['kids'])) {
        return $program['size'];
    }

    $kid_sizes = [];

    foreach ($program['kids'] as $kid_name) {
        $kid = $tree_data[$kid_name];

        $kid_sizes[$kid_name] = calculate_sizes($kid_name);
    }

    $tree_data[$name]['kid_sizes'] = $kid_sizes;

    return $program['size'] + array_sum($kid_sizes);
}
