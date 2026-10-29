<?php
// Spelling-tolerant search: edit distance and merge sort

// Returns how many letters must be inserted, deleted or replaced to turn $a into $b
function editDistance(string $a, string $b): int
// the function: take 2 strings and gives back number
{
    $lenA = strlen($a); //strlen- string length in word a
    $lenB = strlen($b);//string length of word b stored here
    $d = []; // an empty array cuz we don't know how big the table needs to be until we know the word lengths
    // this will become a 2D table- as the answer depends on how of the first word you have used and how much of the second word you have used.

// so, rows=how many letter of the first word have been used
// and columns= how many letters of the second word have been used
// and each box= number of changes needed to turn that much of word 1 into that much of word 2

    // row changing for $lenA

    for ($i = 0; $i <= $lenA; $i=$i+1 ) {
        //start, keep going if, after each loop
        // start - when $i (counter) is set to 0
        // keep going - if $i is less than or equal to $lenA
        // after each loop- add 1 to $i
        $d[$i][0] = $i; //
        // table [which row][which column] puts the value of $i there
    }

    //column changing for lenB

    for ($j = 0; $j <= $lenB; $j=$j+1) {
        //start= $j(new counter)=0
        // keep going while $j is less than or equal to $lenB
        // after each loop- add 1 to $j
        $d[0][$j] = $j;
        // in row 0 , column $j, put number $j
    }

    for ($i = 1; $i <= $lenA; $i=$i+1) {
        //now go through every row except row 0
        for ($j = 1; $j <= $lenB; $j=$j+1) { //nested loop , so every cell gets filled
            //now go through every column except column 0.
            if ($a[$i - 1] === $b[$j - 1]) { 
                // string's first letter is at position 0 , but row 1 means first leffter. so row i looks at letter at position i-1
                $cost = 0;
                // the letters are the same, so keeping it costs nothing
            } else {
                $cost = 1;
                // the letters are different, so replacing it costs 1
            }
            $d[$i][$j] = min($d[$i - 1][$j] + 1,             //in row i , column j box, put this-> smallest of : one row up ,same column, plus 1 to number in box
             $d[$i][$j - 1] + 1,  //same row, one column right 1 , plus 1
             $d[$i - 1][$j - 1] + $cost); // one row down, one column left, add $cost
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

