<?php

$input = "
p=< 3,0,0>, v=< 2,0,0>, a=<-1,0,0>
p=< 4,0,0>, v=< 0,0,0>, a=<-2,0,0>
";

$input = trim(file_get_contents('./data/day_20.txt'));


$particles = explode("\n", trim($input));
for ($i = 0; $i < count($particles); $i++) {
    $particles[$i] = parse_particle($particles[$i]);
}

// STAR ONE:

$test_time = 1000;

$closest_particle = -1;
$closest_distance = -1;

foreach ($particles as $index => $particle) {
    $distance = distance(position_at_step($particle, $test_time));

    if ($distance < $closest_distance || $closest_distance == -1) {
        $closest_distance = $distance;
        $closest_particle = $index;
    }
}

echo "Closest Particle: {$closest_particle}\n";


// STAR TWO:
$destroyed_particles = 0;
for ($time = 1; $time < 500; $time++) {
    $collision_finder = [];

    // Find Collisions
    for ($i = 0; $i < count($particles); $i++) {
        if ($particles[$i] == false) {continue;}
        $pos = implode(',', position_at_step($particles[$i], $time));

        if (isset($collision_finder[$pos]) == false) {
            $collision_finder[$pos] = [];
        }

        $collision_finder[$pos][] = $i;
    }

    foreach ($collision_finder as $colliders) {
        if (count($colliders) <= 1) { continue; }

        foreach ($colliders as $index) {
            $destroyed_particles++;
            $particles[$index] = false;
        }
    }
}

echo "Total Particles: " . count($particles) . "\n";
echo "Destroyed Particles: {$destroyed_particles}\n";


function parse_particle($string) {
    $string = trim($string);
    $pos_pos = 3;
    $vel_pos = strpos($string, 'v=<')+3;
    $acc_pos = strpos($string, 'a=<')+3;

    return [
        'pos' => explode(',', substr($string, $pos_pos, $vel_pos-$pos_pos-6)),
        'vel' => explode(',', substr($string, $vel_pos, $acc_pos-$vel_pos-6)),
        'acc' => explode(',', substr($string, $acc_pos, -1))
    ];
}

function position_at_step($particle, $step) {
    $pos = $particle['pos'];
    $vel = $particle['vel'];
    $acc = $particle['acc'];


    $x = calculate_new_position($pos[0], $vel[0], $acc[0], $step);
    $y = calculate_new_position($pos[1], $vel[1], $acc[1], $step);
    $z = calculate_new_position($pos[2], $vel[2], $acc[2], $step);

    return [$x,$y,$z];
}

function distance($position) {
    return abs($position[0]) + abs($position[1]) + abs($position[2]);
}

function calculate_new_position($start_pos, $start_vel, $acceleration, $time) {
    $new_pos  = $start_pos;
    $new_pos += $start_vel * $time;
    $new_pos += ($acceleration * ($time+1) * $time) / 2;

    return $new_pos;
}

// function collision_time($p1, $p2)