<?php

$phrase_list = explode("\n", trim(file_get_contents('data/day_04.txt')));
$invalid_count = 0;

foreach ($phrase_list as $phrase) {
    $word_list = explode(' ', $phrase);

    while (count($word_list) > 0) {
        $current_word = array_pop($word_list);
        foreach ($word_list as $test_word) {
            if (is_anagram($current_word, $test_word)) {
                $invalid_count++;
                break 2;
            }
        }
    }
}

print "Result: " . (count($phrase_list) - $invalid_count) . "\n";

function is_anagram($word1, $word2) {
    if (strlen($word1) != strlen($word2)) { return false; }

    $word1 = str_split($word1);
    asort($word1);
    $word1 = implode('', $word1);

    $word2 = str_split($word2);
    asort($word2);
    $word2 = implode('', $word2);

    return ($word1 == $word2);
}
