<?php

$buffer = new SplDoublyLinkedList();

$buffer->push(0);

$step_distance = 382;
$position = 0;

for ($i = 1; $i <= 2017; $i++) {
    $position += $step_distance;
    $position = ($position % $buffer->count())+1;
    $buffer->add($position, $i);
}

echo "\n";
echo "Position:   {$position}\n";
echo "Value:      {$buffer[$position]}\n";
echo "Next Value: {$buffer[$position+1]}\n";


