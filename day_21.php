<?php
ini_set('memory_limit','4096M');
$pattern = '.#./..#/###';

$input = trim("
../.# => ##./#../...
.#./..#/### => #..#/..../..../#..#
");

$input = trim(file_get_contents('./data/day_21.txt'));

// Process Rules

$input_lines = explode("\n", $input);
$rules = [];

foreach ($input_lines as $line) {
    list($p_in, $p_out) = explode(' => ', trim($line));

    $expansions = get_equivalent_patterns($p_in);

    foreach ($expansions as $exp) {
        $rules[$exp] = $p_out;
    }
}

for ($step = 0; $step < 18; $step++) {
    $pattern = enlarge_pattern($pattern);
}

echo "Pixels On: " . substr_count($pattern, '#') . "\n";

function get_equivalent_patterns($p) {
    $equivalents = [$p];

    // 2x2
    if (strlen($p) == 5) {
        // Rotations
        $equivalents[] = $p[3] . $p[0] . '/' . $p[4] . $p[1];
        $equivalents[] = $p[4] . $p[3] . '/' . $p[1] . $p[0];
        $equivalents[] = $p[1] . $p[4] . '/' . $p[0] . $p[3];
    }


    // 3x3
    if (strlen($p) == 11) {
        // Rotations
        $equivalents[] = $p[8] . $p[4] . $p[0] . '/' . $p[9] . $p[5] . $p[1] . '/' . $p[10] . $p[6] . $p[2];
        $equivalents[] = $p[10] . $p[9] . $p[8] . '/' . $p[6] . $p[5] . $p[4] . '/' . $p[2] . $p[1] . $p[0];
        $equivalents[] = $p[2] . $p[6] . $p[10] . '/' . $p[1] . $p[5] . $p[9] . '/' . $p[0] . $p[4] . $p[8];
    }


    $flipped_equivalents = [];
    foreach ($equivalents as $eq) {
        $flipped_equivalents = array_merge($flipped_equivalents, get_flipped_patterns($eq));
    }

    foreach ($flipped_equivalents as $feq) {
        if (in_array($feq, $equivalents) == false) {
            $equivalents[] = $feq;
        }
    }

    return $equivalents;
}

function get_flipped_patterns($p) {
    if (strlen($p) == 5) {
        $equivalents[] = $p[1] . $p[0] . '/' . $p[4] . $p[3];
        $equivalents[] = $p[3] . $p[4] . '/' . $p[0] . $p[1];
    }

    if (strlen($p) == 11) {
        $equivalents[] = $p[8] . $p[9] . $p[10] . '/' . $p[4] . $p[5] . $p[6] . '/' . $p[0] . $p[1] . $p[2];
        $equivalents[] = $p[2] . $p[1] . $p[0] . '/' . $p[6] . $p[5] . $p[4] . '/' . $p[10] . $p[9] . $p[8];
    }

    return $equivalents;
}

function get_size($pattern) {
    return substr_count($pattern, '/')+1;
}

function enlarge_pattern($pattern) {
    global $rules;

    $sub_patterns = subdivide_pattern($pattern);

    for ($i=0; $i < count($sub_patterns); $i++) {
        $sub_patterns[$i] = $rules[$sub_patterns[$i]];
    }

    return combine_sub_patterns($sub_patterns);
}

function combine_sub_patterns($sub_patterns) {
    if (count($sub_patterns) == 1) { return $sub_patterns[0]; }

    $major_grid_size = sqrt(count($sub_patterns));
    $minor_grid_size = get_size($sub_patterns[0]);

    $new_grid_size = $major_grid_size * $minor_grid_size;

    for ($i = 0; $i < count($sub_patterns); $i++) {
        $sub_patterns[$i] = explode('/', $sub_patterns[$i]);
    }

    $final_pattern = '';

    for ($maj_row = 0; $maj_row < $major_grid_size; $maj_row++) {
        for ($min_row = 0; $min_row < $minor_grid_size; $min_row++) {
            if ($final_pattern != '') { $final_pattern .= '/'; }

            for ($maj_col = 0; $maj_col < $major_grid_size; $maj_col++) {
                $i = ($maj_row * $major_grid_size) + $maj_col; 
                $final_pattern .= $sub_patterns[$i][$min_row];   
            }
        }
    }

    return $final_pattern;
}

function subdivide_pattern($pattern) {
    $size = get_size($pattern);
    if ($size <= 3) {
        return [$pattern];
    }

    $patterns = [];

    if ($size % 2 == 0) {
        for ($row = 0; $row < $size/2; $row++) {
            for ($col = 0; $col < $size/2; $col++) {
                $sub_row_1 = ($row * ($size+1) * 2) + ($col * 2);
                $sub_row_2 = $sub_row_1 + $size+1;
                $patterns[] = substr($pattern, $sub_row_1, 2) . '/' . substr($pattern, $sub_row_2, 2);
            }
        }

        return ($patterns);
    }

    if ($size % 3 == 0) {
        for ($row = 0; $row < $size/3; $row++) {
            for ($col = 0; $col < $size/3; $col++) {
                $sub_row_1 = ($row * ($size+1) * 3) + ($col * 3);
                $sub_row_2 = $sub_row_1 + $size+1;
                $sub_row_3 = $sub_row_2 + $size+1;

                $patterns[] = substr($pattern, $sub_row_1, 3) . '/' . substr($pattern, $sub_row_2, 3) . '/' . substr($pattern, $sub_row_3, 3);
            }
        }

        return $patterns;
    }  
}
