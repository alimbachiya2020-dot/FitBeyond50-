<?php
// Spelling-tolerant search: edit distance and merge sort

// Returns how many letters must be inserted, deleted or replaced to turn $a into $b
function editDistance(string $a, string $b): int
{
    $lenA = strlen($a);
    $lenB = strlen($b);
    $d = [];

    for ($i = 0; $i <= $lenA; $i++) {
        $d[$i][0] = $i;
    }
    for ($j = 0; $j <= $lenB; $j++) {
        $d[0][$j] = $j;
    }

    for ($i = 1; $i <= $lenA; $i++) {
        for ($j = 1; $j <= $lenB; $j++) {
            if ($a[$i - 1] === $b[$j - 1]) {
                $cost = 0;
            } else {
                $cost = 1;
            }
            $d[$i][$j] = min($d[$i - 1][$j] + 1, $d[$i][$j - 1] + 1, $d[$i - 1][$j - 1] + $cost);
        }
    }

    return $d[$lenA][$lenB];
}

// Merge sort: puts a list of matches in order, smallest distance first
function mergeSort(array $items): array
{
    // Base case: a list with 0 or 1 items is already sorted
    if (count($items) <= 1) {
        return $items;
    }

    // Split the list into two halves
    $middle = intdiv(count($items), 2);
    $left = array_slice($items, 0, $middle);
    $right = array_slice($items, $middle);

    // Recursive case: sort each half, then merge the two sorted halves
    $left = mergeSort($left);
    $right = mergeSort($right);

    return merge($left, $right);
}

// Joins two sorted lists into one sorted list
function merge(array $left, array $right): array
{
    $result = [];
    $i = 0;
    $j = 0;

    // Compare the front item of each list and take the smaller one
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i]['distance'] <= $right[$j]['distance']) {
            $result[] = $left[$i];
            $i = $i + 1;
        } else {
            $result[] = $right[$j];
            $j = $j + 1;
        }
    }

    // One list has run out, so copy across whatever is left in the other one
    while ($i < count($left)) {
        $result[] = $left[$i];
        $i = $i + 1;
    }
    while ($j < count($right)) {
        $result[] = $right[$j];
        $j = $j + 1;
    }

    return $result;
}

