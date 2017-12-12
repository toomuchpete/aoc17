<?php

$input = trim(file_get_contents('data/day_12.txt'));

$program_descriptions = explode("\n", $input);

// Process Input
$program_links = [];

foreach ($program_descriptions as $desc) {
    list($ID, $links) = explode(" <-> ", $desc);
    $program_links[$ID] = explode(', ', $links);
}

$groups = [];

foreach (array_keys($program_links) as $ID) {
    // Does this exist in a group already?
    foreach ($groups as $group) {
        if (in_array($ID, $group)) {
            // Already exists
            continue 2;
        }
    }

    $groups[$ID] = find_connections_to($ID);
}

echo "Group Count: " . count($groups) . "\n";

function find_connections_to($ID) {
    global $program_links;

    $program_queue = [$ID];
    $connected_programs = [];

    while (count($program_queue) > 0) {
        $this_program = array_shift($program_queue);

        $connected_programs[] = $this_program;

        foreach($program_links[$this_program] as $linked_id) {
            if (in_array($linked_id, $connected_programs)) { continue; }
            if (in_array($linked_id, $program_queue)) { continue; }

            array_unshift($program_queue, $linked_id);
        }
    }

    return $connected_programs;
}
