<?php

$input = trim(file_get_contents('./data/day_25.txt'));

$cursor = 0;
$state = 'A';
$tape = [0];


for ($step = 0; $step < 12667664; $step++) {
    if ($state == 'A') {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 1;
            move_right();
            $state = 'B';
        } else {
            $tape[$cursor] = 0;
            move_left();
            $state = 'C';
        }
    } elseif ($state == 'B') {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 1;
            move_left();
            $state = 'A';
        } else {
            $tape[$cursor] = 1;
            move_right();
            $state = 'D';
        }
    } elseif ($state == 'C') {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 0;
            move_left();
            $state = 'B';
        } else {
            $tape[$cursor] = 0;
            move_left();
            $state = 'E';
        }
    } elseif ($state == 'D') {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 1;
            move_right();
            $state = 'A';
        } else {
            $tape[$cursor] = 0;
            move_right();
            $state = 'B';
        }
    } elseif ($state == 'E') {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 1;
            move_left();
            $state = 'F';
        } else {
            $tape[$cursor] = 1;
            move_left();
            $state = 'C';
        }    
    } else {
        if ($tape[$cursor] == 0) {
            $tape[$cursor] = 1;
            move_right();
            $state = 'D';
        } else {
            $tape[$cursor] = 1;
            move_right();
            $state = 'A';
        }
    }
    if ($step % 10000 == 0) { echo "Step: {$step}\n"; }
}

echo "Checksum: " . checksum() . "\n";

function move_left() { move(-1); }
function move_right() { move(1); }

function move($dir) {
    global $cursor, $tape;

    $cursor += $dir;

    if (!isset($tape[$cursor])) {
        $tape[$cursor] = 0;
    }
}

function checksum() {
    global $tape;
    return array_sum($tape);
}