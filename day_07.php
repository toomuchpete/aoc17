<?php

$input = explode("\n", trim(file_get_contents('data/day_07.txt')));

$tree_data = [];

$kids_list = [];

foreach ($input as $program_data) {
    $parts = explode(' -> ', $program_data);
    $self  = array_shift($parts);
    $children = explode(", ", array_shift($parts));

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

echo "Root Program: {$root}\n";
