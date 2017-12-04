<?php

$phrase_list = explode("\n", trim(file_get_contents('data/day_04.txt')));
$invalid_count = 0;

foreach ($phrase_list as $phrase) {
    $phrase_words = [];
    foreach (explode(' ', $phrase) as $word) {
        if (isset($phrase_words[$word])) {
            $invalid_count++;
            break;
        }

        $phrase_words[$word] = true;
    }
}

echo "Result: " . (count($phrase_list) - $invalid_count);
