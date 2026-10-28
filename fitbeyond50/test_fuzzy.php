<?php
// Test page: compares my editDistance() with PHP's built-in levenshtein()
require_once __DIR__ . '/includes/fuzzy.php';

$pairs = [
    ['dal', 'daal'],
    ['khichri', 'khichdi'],
    ['panir', 'paneer'],
    ['rotlee', 'rotli'],
    ['kitten', 'sitting'],
    ['', 'abc'],
    ['rice', 'rice'],
];

foreach ($pairs as $pair) {
    $mine = editDistance($pair[0], $pair[1]);
    $builtIn = levenshtein($pair[0], $pair[1]);
    echo $pair[0] . ' → ' . $pair[1] . ': mine = ' . $mine . ', built-in = ' . $builtIn;
    if ($mine === $builtIn) {
        echo ' ✅';
    } else {
        echo ' ❌';
    }
    echo '<br>';
}