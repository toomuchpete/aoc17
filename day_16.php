<?php

    $program_positions = 'abcdefghijklmnop';
    $input = trim(file_get_contents('./data/day_16.txt'));

    $instructions = explode(',', $input);

    for ($i = 0; $i < count($instructions); $i++) {
        $ins = $instructions[$i];
        $command = $ins[0];
        $params  = explode('/', substr($ins, 1));

        $instructions[$i] = [
            'command' => $command,
            'params' => $params
        ];

        continue;
    }

    // This dance sequence loops after 24 iterations
    $iterations = 1000000000;
    $real_iterations = $iterations % 24;

    for ($i = 0; $i < $real_iterations; $i++) {
        foreach ($instructions as $ins) {
            switch ($ins['command']) {
                case 's':
                    spin($program_positions, $ins['params'][0]);
                    break;
                case 'x':
                    exchange($program_positions, $ins['params'][0], $ins['params'][1]);
                    break;
                case 'p':
                    swap($program_positions, $ins['params'][0], $ins['params'][1]);
                    break;
            }
        }
    }

    echo "Positions: {$program_positions}\n";

    function spin(&$string, $amount) {
        $length = strlen($string);
        $amount = $amount % $length;

        $string = substr($string, -$amount) . substr($string, 0, $length-$amount);
    }

    function exchange(&$string, $pos1, $pos2) {
        $val1 = $string[$pos1];
        $val2 = $string[$pos2];

        $string[$pos1] = $val2;
        $string[$pos2] = $val1;
    }

    function swap(&$string, $val1, $val2) {
        $pos1 = strpos($string, $val1);
        $pos2 = strpos($string, $val2);

        exchange($string, $pos1, $pos2);
    }