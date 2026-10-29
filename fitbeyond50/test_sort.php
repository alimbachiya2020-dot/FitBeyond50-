<?php
require_once __DIR__ . '/includes/fuzzy.php';

// Turns a list of matches into text like "Daal (1), Rotli (2)" so it is easy to check
function matchesAsText(array $items): string
{
    $parts = [];
    foreach ($items as $item) {
        $parts[] = $item['name'] . ' (' . $item['distance'] . ')';
    }
    return implode(', ', $parts);
}

// Each test: [description, input list, expected output as text]
$tests = [
    ['Empty list', [], ''],
    ['One item', [
        ['name' => 'Daal', 'distance' => 1],
    ], 'Daal (1)'],
    ['Already sorted', [
        ['name' => 'Daal', 'distance' => 0],
        ['name' => 'Rotli', 'distance' => 1],
        ['name' => 'Bhaat', 'distance' => 2],
    ], 'Daal (0), Rotli (1), Bhaat (2)'],
    ['Reverse order', [
        ['name' => 'Thepla', 'distance' => 3],
        ['name' => 'Bhaat', 'distance' => 2],
        ['name' => 'Rotli', 'distance' => 1],
        ['name' => 'Daal', 'distance' => 0],
    ], 'Daal (0), Rotli (1), Bhaat (2), Thepla (3)'],
    ['Odd number, mixed up', [
        ['name' => 'Khichdi', 'distance' => 2],
        ['name' => 'Daal', 'distance' => 0],
        ['name' => 'Paneer', 'distance' => 3],
        ['name' => 'Rotli', 'distance' => 1],
        ['name' => 'Dhokla', 'distance' => 2],
    ], 'Daal (0), Rotli (1), Khichdi (2), Dhokla (2), Paneer (3)'],
    ['Ties keep original order', [
        ['name' => 'Rotli', 'distance' => 2],
        ['name' => 'Daal', 'distance' => 1],
        ['name' => 'Bhaat', 'distance' => 2],
        ['name' => 'Dhokla', 'distance' => 1],
    ], 'Daal (1), Dhokla (1), Rotli (2), Bhaat (2)'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Merge sort tests - FitBeyond50</title>
</head>
<body>
    <h1>Merge sort tests</h1>
    <table border="1" cellpadding="6">
        <tr>
            <th>Test</th>
            <th>Expected</th>
            <th>Actual</th>
            <th>Pass?</th>
        </tr>
        <?php foreach ($tests as $test): ?>
            <?php
            $description = $test[0];
            $input = $test[1];
            $expected = $test[2];
            $actual = matchesAsText(mergeSort($input));
            ?>
            <tr>
                <td><?= htmlspecialchars($description) ?></td>
                <td><?= htmlspecialchars($expected) ?></td>
                <td><?= htmlspecialchars($actual) ?></td>
                <td><?= $actual === $expected ? '✅' : '❌' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>