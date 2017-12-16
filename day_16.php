<?php

    $program_positions = str_split('abcdefghijklmnop');
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

    $start_time = microtime(true);
    for ($i = 0; $i < 1000; $i++) {
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
    $end_time = microtime(true);
    $length = $end_time - $start_time;
    $dps = $i / $length;

    echo "\n";
    echo "Positions: " . implode('', $program_positions) . "\n";
    echo "Dance Length: {$length}s ($dps per sec)\n";

    function spin(&$array, $amount) {
        $original_values = $array;

        foreach ($original_values as $old_pos => $value) {
            $new_pos = ($old_pos + $amount) % count($array);
            $array[$new_pos] = $value;
        }
    }

    function exchange(&$array, $pos1, $pos2) {
        $val1 = $array[$pos1];
        $val2 = $array[$pos2];

        $array[$pos1] = $val2;
        $array[$pos2] = $val1;
    }

    function swap(&$array, $val1, $val2) {
        $pos1 = array_search($val1, $array);
        $pos2 = array_search($val2, $array);

        exchange($array, $pos1, $pos2);
    }